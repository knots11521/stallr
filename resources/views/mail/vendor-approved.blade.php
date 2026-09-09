@component('mail::message')
# Vendor Application Approved

Hello {{ $notifiable->name }},

Congratulations! Your vendor application has been approved.

**Store Name:** {{ $vendor->store_name }}

You can now access the vendor dashboard and start managing your products.

[Go to Vendor Dashboard]({{ url('/vendor') }})

Thank you for joining {{ config('app.name') }}!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
