<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Kurir;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class RegionController extends Controller
{
  public function get_provinsi()
  {
    # code...
    $provinsi = Provinsi::all(['province_id', 'province_name']);
    return response()->json($provinsi);
  }

  public function get_kota(Provinsi $item)
  {
    return response()->json($item->kota()->get(['city_id', 'city_name']));
  }

  public function get_kecamatan(Kota $item)
  {
    return response()->json($item->kecamatan()->get(['subdistrict_id', 'subdistrict_name']));
  }

  public function get_ongkir($city_id, $weight)
  {
    $courier_list = Kurir::all();
    // return response()->json($courier_list); die;
    $post_data_ongkir = [
      'origin' => '179',
      'destination' => '',
      'weight' => '',
      'courier' => ''
    ];
    foreach ($courier_list as $key => $value) {
      $post_data_ongkir['destination'] = $city_id;
      $post_data_ongkir['weight'] = $weight;
      $post_data_ongkir['courier'] = $value->nama_kurir;
      $data_ongkir = $this->fetchdata_curl(
        'POST',
        'https://api.rajaongkir.com/starter/cost',
        [
          "Accept: application/json",
          "content-type: application/x-www-form-urlencoded",
          "key:" . config('app.rajaongkir_key')
        ],
        http_build_query($post_data_ongkir)
      );
      foreach ($data_ongkir->rajaongkir->results[0]->costs as $service_value) {
        if ($value->nama_service == $service_value->service) {
          $value->ongkir = $service_value->cost[0]->value;
        } else {
          $value->ongkir = 'unavailable';
        }
      }
    }
    return response()->json($courier_list);
  }

  private function fetchdata_curl($method, $url, array $headers, $post_data = "")
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_POSTFIELDS => $post_data,
      CURLOPT_HTTPHEADER => $headers
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return "cURL Error #:" . $err;
    } else {
      return json_decode($response);
    }
  }
}
