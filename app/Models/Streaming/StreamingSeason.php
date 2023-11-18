<?php

namespace App\Models\Streaming;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StreamingSeason extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "streaming_id",
        "title",
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

    function episodes() {
        return $this->hasMany(StreamingEpisode::class);
    }

    function episode_actives() {
        return $this->hasMany(StreamingEpisode::class)->where("state",1);
    }
}
