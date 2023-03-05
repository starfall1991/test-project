<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ProductCreatedNotification extends Notification implements ShouldBroadcast
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public Product $product)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast'];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'product_id' => $this->product->id,
        ]);
    }
}
