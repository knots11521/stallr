<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorApplication extends Model
{

    protected $fillable = [
        'user_id',
        'store_name',
        'description',
        'status',
        'admin_notes',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
