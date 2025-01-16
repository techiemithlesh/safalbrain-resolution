<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'footer_logo',
        'address',
        'email',
        'email_2',
        'phone',
        'video_link',
        'price',
        'razor_pay_key',
        'razor_pay_secret',
        'whatsapp_link',
        'webinar_link'
    ];
}
