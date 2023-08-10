<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debts extends Model
{
    protected $table = 'cms_debts';
    public $timestamps = false;
    protected $fillable = ['output_code','customer_id', 'paiddate','paid','unpaid','expdate'];
    use HasFactory;
}
