<?php

namespace App\Models\Subcription;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Plan\PlanPaypal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcription extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "user_id",
        "subcription_paypal_id",
        "plan_paypal_id",
        "paypal_plan_id",
        "type_plan",
        "start_date",
        "end_date",
        "price",
        "renewal_cancelled",//(1,0) 1 es activo y 0 es inactivo
        "renewal_cancelled_at"
    ];

    function setCreatedAtAttribute($value) {
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]= Carbon::now();
    }

    function setUpdatedAtAttribute($value) {
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();
    }

    function plan_paypal() {
        return $this->belongsTo(PlanPaypal::class,"plan_paypal_id");
    }

    function plan_paypal_del() {
        return $this->belongsTo(PlanPaypal::class,"plan_paypal_id")->withTrashed();
    }

    function user() {
        return $this->belongsTo(User::class,"user_id");
    }

    function userForConfigAll() {
        return $this->belongsTo(User::class, "user_id")->where('type_user', 2);
    }
    
    function scopefilterSubcriptions($query,$search,$state) {
        if($state){
            $query->where("state",$state);
        }
        if($search){
            $query->where("title","like","%".$search."%");
        }
        return $query;
    }
}
