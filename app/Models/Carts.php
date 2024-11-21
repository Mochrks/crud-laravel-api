<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'cart_id';

    public $timestamps = false;

    protected $fillable = [
        'cart_id',
        'food_id',
        'user_id',
        'qty',
        'is_deleted',
        'created_by',
        'created_time',
        'modified_by',
        'modified_time',
    ];

    protected $casts = [
        'qty' => 'integer',
        'is_deleted' => 'boolean',
        'created_time' => 'datetime',
        'modified_time' => 'datetime',
    ];

    // Relasi dengan tabel Foods
    public function food()
    {
        return $this->belongsTo(Foods::class, 'food_id', 'food_id');
    }

    // Relasi dengan tabel Users
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }
}