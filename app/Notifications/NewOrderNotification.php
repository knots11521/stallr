<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\VendorOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public VendorOrder $vendorOrder
    ) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $this->order->load('user');
        $this->vendorOrder->load('items');

        $itemCount = $this->vendorOrder->items->sum('quantity');
        $itemNames = $this->vendorOrder->items->pluck('product_name')->join(', ');

        return (new MailMessage)
            ->subject('New Order Received - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have received a new order.')
            ->line('Order Number: ' . $this->order->order_number)
            ->line('Customer: ' . ($this->order->user->name ?? 'N/A'))
            ->line('Items: ' . $itemCount . ' item(s) - ' . $itemNames)
            ->line('Order Total: ₱' . number_format((float) $this->vendorOrder->total, 2))
            ->action('View Order', url('/vendor'))
            ->line('Please log in to your vendor dashboard to manage this order.');
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'vendor_order_id' => $this->vendorOrder->id,
            'total' => $this->vendorOrder->total,
            'item_count' => $this->vendorOrder->items->sum('quantity'),
        ];
    }
}
