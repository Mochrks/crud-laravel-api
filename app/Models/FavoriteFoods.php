<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteFoods extends Model
{
    protected $table = 'favorite_foods';
    protected $primaryKey = 'food_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'food_id',
        'user_id',
        'is_favorite',
        'created_by',
        'created_time',
        'modified_by',
        'modified_time',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
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
