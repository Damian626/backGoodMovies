<?php

namespace App\Models\Streaming;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Actor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "full_name",
        "imagen",
        "type",
        "state",
        "profesion",
    ];

    function setCreatedAtAttribute($value) {
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]= Carbon::now();
    }

    function setUpdatedAtAttribute($value) {
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();
    }

    function scopefilterActors($query,$search,$state) {
        if($state){
            $query->where("state",$state);
        }
        if($search){
            $query->where("full_name","like","%".$search."%");
        }
        return $query;
    }
}
