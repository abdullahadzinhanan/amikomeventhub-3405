<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'category_id', 'title', 'description', 'date',
        'location', 'price', 'stock', 'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Menandakan atribut: 1 Event harus terpaut pada satu wujud Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
