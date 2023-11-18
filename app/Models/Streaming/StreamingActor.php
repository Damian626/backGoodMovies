<?php

namespace App\Models\Streaming;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StreamingActor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "streaming_id",
        "actor_id",
        "state",
    ];

    function setCreatedAtAttribute($value) {
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]= Carbon::now();
    }

    function setUpdatedAtAttribute($value) {
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();
    }

    function streaming() {
        return $this->belongsTo(Streaming::class);
    }

    function actor() {
        return $this->belongsTo(Actor::class);
    }
}
