<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    protected $table = 'foods';

    protected $primaryKey = 'food_id';

    public $timestamps = false;
    protected $fillable = [
        'food_id',
        'category_id',
        'food_name',
        'image_filename',
        'price',
        'ingredient',
        'created_by',
        'created_time',
        'modified_by',
        'modified_time',
        'is_deleted',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_deleted' => 'boolean',
        'created_time' => 'datetime',
        'modified_time' => 'datetime',
    ];

    // Relasi dengan tabel Categories
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'category_id');
    }
}