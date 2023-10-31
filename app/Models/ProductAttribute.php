<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';

    protected $fillable = ['product_id', 'attribute_id', 'value', 'quantity', 'price'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function attributesValues()
    {
        return $this->belongsToMany(AttributeValue::class);
    }
}
