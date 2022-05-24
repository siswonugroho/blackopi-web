<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RealTimeNotification extends Notification implements ShouldBroadcast
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  private $content;
  public function __construct($content)
  {
    $this->content = $content;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['broadcast', 'database'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  // public function toMail($notifiable)
  // {
  //     return (new MailMessage)
  //                 ->line('The introduction to the notification.')
  //                 ->action('Notification Action', url('/'))
  //                 ->line('Thank you for using our application!');
  // }

  // public function toBroadcast($notifiable)
  // {
  //   return new BroadcastMessage();
  // }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      'message' => $this->content['message'],
      'url' => $this->content['url'],
      'icon' => $this->content['icon']
    ];
  }
}
