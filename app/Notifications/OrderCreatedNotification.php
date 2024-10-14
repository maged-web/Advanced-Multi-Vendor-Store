<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;
    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        //
        $this->order=$order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail','database','broadcast'];

    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $addr=$this->order->billingAddress;
        return (new MailMessage)
                    ->subject("New Order #{$this->order->number}")
                    ->greeting("Hi {$notifiable->name},")
                    ->line("A new order (#{$this->order->number}) created by {$addr->name} from {$addr->countryName}.")
                    ->action('View Order', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        $addr=$this->order->billingAddress;

        return[
        'body'=>"A new order (#{$this->order->number}) created by {$addr->name} from {$addr->countryName}.",
        'icon'=>'fas fa-file',
        'url'=>url('/dashboard'),
        'order_id'=>$this->order->id,
        ];
    }
    public function toBroadcast($notifiable)
    {
        $addr=$this->order->billingAddress;

        return new BroadcastMessage([
        'body'=>"A new order (#{$this->order->number}) created by {$addr->name} from {$addr->countryName}.",
        'icon'=>'fas fa-file',
        'url'=>url('/dashboard'),
        'order_id'=>$this->order->id,
        ]);
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
