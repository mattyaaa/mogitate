<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
    ];

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }
    
    //検索スコープ
    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where('name', 'LIKE', '%' . $term . '%')
                  ->orWhere('description', 'LIKE', '%' . $term . '%');
        }
        return $query;
    }

    //並び替えスコープ
    public function scopeSortByPrice($query, $sort)
    {
        if ($sort) {
            if ($sort == 'high') {
                return $query->orderBy('price', 'desc');
            } else if ($sort == 'low') {
                return $query->orderBy('price', 'asc');
            }
        }
        return $query;
    }
}
