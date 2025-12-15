<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','price','quantity','is_active'];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive($query) { return $query->where('is_active', true); }

    public function getFormattedPriceAttribute(): string
    { return number_format($this->price, 2, '.', ' ') . ' Р С–РЎР‚Р Р…'; }
}

