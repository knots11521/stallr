<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Product $product
    ) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Low Stock Alert - ' . $this->product->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your product "' . $this->product->name . '" is running low on stock.')
            ->line('Current stock: ' . $this->product->stock)
            ->line('Low stock threshold: ' . $this->product->low_stock_threshold)
            ->line('SKU: ' . $this->product->sku)
            ->action('Manage Inventory', url('/vendor'))
            ->line('Please restock this product to avoid missed sales.');
    }

    public function toArray($notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'stock' => $this->product->stock,
            'low_stock_threshold' => $this->product->low_stock_threshold,
            'sku' => $this->product->sku,
        ];
    }
}
