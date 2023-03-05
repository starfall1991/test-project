<?php

use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductCreatedNotification;
use Illuminate\Support\Facades\Notification;

it('sends a broadcast notification when a product is created', function () {
    Notification::fake();

    $user = User::factory()->create();
    $product = Product::factory()->create();

    Notification::assertSentTo(
        $user,
        ProductCreatedNotification::class,
        function ($notification, $channels) use ($product) {
            return $notification->product->id === $product->id && in_array('broadcast', $channels);
        }
    );
});
