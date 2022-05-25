<?php

namespace App\Http\Controllers;

use App\Events\RealTimeNotif;
use App\Models\Admin;
use App\Models\Reseller;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
  public function index(Request $request)
  {
    if (Auth::guard('admin')->check()) {
      return redirect('/');
    }
    $key = 'login.' . $request->ip();
    return view('login', [
      'title' => 'Login Admin',
      'key' => $key,
      'retries' => RateLimiter::retriesLeft($key, 5),
      'seconds' => RateLimiter::availableIn($key)
    ]);
  }

  public function goLogin(Request $request)
  {
    $rules = [
      'email' => ['required', 'email'],
      'password' => 'required'
    ];

    $data = $request->validate($rules);
    $user = Admin::where('email', $data['email'])->first(['email', 'nama_admin', 'id']);

    if (Auth::guard('admin')->attempt($data)) {
      RateLimiter::clear('login.' . $request->ip());
      $request->session()->regenerate();
      return redirect()->intended('home');
    }
    return back()->withErrors(['wronglogin' => 'Username atau password salah.']);
  }

  public function api_register(Request $request)
  {
    $form = $request->validate([
      'nama_admin' => 'required|string',
      'email' => 'required|email|unique:admin,email',
      'password' => 'required|string|confirmed',
    ]);

    $admin = Admin::create([
      'nama_admin' => $form['nama_admin'],
      'email' => $form['email'],
      'password' => bcrypt($form['password'])
    ]);

    $token = $admin->createToken('webtoken')->plainTextToken;
    $response = [
      'user' => $admin,
      'token' => $token,
    ];
    return response($response, 201);
  }

  public function api_login_reseller(Request $request)
  {
    $input = [
      'username' => $request->input('username'),
      'password' => $request->input('password'),
    ];

    $validateWithEmail = Validator::make($input, [
      'username' => 'required|email',
      'password' => 'required'
    ]);
    $validateWithPhoneNumber = Validator::make($input, [
      'username' => 'required|numeric',
      'password' => 'required'
    ]);

    if (!$validateWithEmail->fails()) {
      $data['email'] = $validateWithEmail->safe()->only(['username'])['username'];
      $data['password'] = $validateWithEmail->safe()->only(['password'])['password'];
      $user = Reseller::where('email', $data['email'])->first(['id', 'nama_reseller', 'email', 'telp']);
    } else if (!$validateWithPhoneNumber->fails()) {
      $data['telp'] = $validateWithPhoneNumber->safe()->only(['username'])['username'];
      $data['password'] = $validateWithPhoneNumber->safe()->only(['password'])['password'];
      $user = Reseller::where('telp', $data['telp'])->first(['id', 'nama_reseller', 'email', 'telp']);
    } else {
      return response()->json([
        'success' => 0,
        'message' => 'Email atau nomor telepon tidak valid'
      ], 422);
    }
    
    if (Auth::guard('reseller')->attempt($data)) {
      $token = $user->createToken('apitoken')->plainTextToken;
      $response = [
        'success' => 1,
        'user' => $user,
        'token' => $token,
      ];
      return response($response, 201);
    }
    return response([
      'success' => 0,
      'message' => 'Email, telepon atau password salah'
    ], 401);
  }

  public function api_register_reseller(Request $request)
  {
    $form = [
      'nama_reseller' => $request->input('nama_reseller'),
      'email' => $request->input('email'),
      'password' => $request->input('password'),
      'password_confirmation' => $request->input('password_confirmation'),
      'telp' => $request->input('telp')
    ];
    $validator = Validator::make($form, [
      'nama_reseller' => 'required|string',
      'email' => 'required|email|unique:reseller,email',
      'password' => 'required|string|confirmed',
      'telp' => 'required|string|unique:reseller,telp',
    ]);

    if ($validator->fails()) {
      $response = [
        'success' => 0,
        'message' => $validator->errors()
      ];
    } else {
      $reseller = Reseller::create($form);
      $response = [
        'success' => 1,
        'message' => 'Registrasi berhasil',
        'user' => $reseller,
      ];
    }
    return response($response, 201);

    
  }

  public function logout_admin(Request $request)
  {
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('login');
  }

  public function logout_reseller(Request $request)
  {
    $request->user()->currentAccessToken()->delete();
    return response([
      "message" => "User ID " . $request->user()->getAuthIdentifier() . " logged out"
    ]);
  }
}
