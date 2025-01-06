<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'phone', 'city', 'price', 'r_payment_id', 'r_order_id', 'status'];
    
        protected $dates = ['deleted_at'];

}
