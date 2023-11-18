<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPaypal extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "type",
        "category",
        "description",
        "id_product_paypal"
    ];

    function setCreatedAtAttribute($value) {
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]= Carbon::now();
    }

    function setUpdatedAtAttribute($value) {
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();
    }

}
