<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';

    protected $primaryKey = 'order_detail_id';

    public $timestamps = false;
    protected $fillable = [
        'order_detail_id',
        'food_id',
        'order_id',
        'qty',
        'total_price',
        'created_by',
        'created_time',
        'modified_by',
        'modified_time',
    ];

    protected $casts = [
        'qty' => 'integer',
        'total_price' => 'integer',
        'created_time' => 'datetime',
        'modified_time' => 'datetime',
    ];

    // Relasi dengan tabel Foods
    public function food()
    {
        return $this->belongsTo(Foods::class, 'food_id', 'food_id');
    }

    // Relasi dengan tabel Orders
    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}