<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'cms_orders';
    public $timestamps = true;
    protected $fillable = ['output_code','customer_id', 'store_id','order_status','created'];
    use HasFactory;
}
