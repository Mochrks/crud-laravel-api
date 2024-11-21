<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'user_id',
        'order_date',
        'total_item',
        'total_order_price',
        'created_by',
        'created_time',
        'modified_by',
        'modified_time',
    ];

    protected $casts = [
        'order_date' => 'date',
        'created_time' => 'datetime',
        'modified_time' => 'datetime',
    ];

    // Relasi dengan tabel Users
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }
}
