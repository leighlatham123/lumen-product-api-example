<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translation extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $hidden = [
        'language_id',
        'product_id'
    ];

    /**
     * Get the translated version of the product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
