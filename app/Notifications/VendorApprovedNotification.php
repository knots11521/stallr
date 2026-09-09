<?php

namespace App\Notifications;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Vendor $vendor
    ) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Vendor Application Approved - ' . $this->vendor->store_name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Congratulations! Your vendor application has been approved.')
            ->line('Store Name: ' . $this->vendor->store_name)
            ->line('You can now access the vendor dashboard and start managing your products.')
            ->action('Go to Vendor Dashboard', url('/vendor'))
            ->line('Thank you for joining Stallr!');
    }

    public function toArray($notifiable): array
    {
        return [
            'vendor_id' => $this->vendor->id,
            'store_name' => $this->vendor->store_name,
        ];
    }
}
