<?php

namespace App\Http\Controllers\Streaming;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcription\Subcription;
use App\Http\Controllers\Admin\Helper\PaypalSubcription;

class ProfileClienteController extends Controller
{
    public $paypalSubcription;
    public function __construct(PaypalSubcription $paypalSubcription) {
        $this->paypalSubcription = $paypalSubcription;
    }
    
    function get_profile_client(){
        $user = auth("api")->user();

        return response()->json([
            "user" => [
                "name" => $user->name,
                "surname" => $user->surname,
                "email" => $user->email,
                "date_birth" => $user->date_birth ? Carbon::parse($user->date_birth)->format("Y-m-d") : NULL,
            ]
        ]);
    }
    function profile_client(Request $request){
        try {
            $user = User::findOrFail(auth("api")->user()->id);
            $user->update($request->all());
            $subcription = $user->isActiveSubscription();
    
            return response()->json([
                "user" => [
                    "full_name" =>  $user->name.' '.$user->surname,
                    "email" => $user->email,
                    "date_birth" => $user->date_birth,
                    "subcription" => [
                        "id" =>  $subcription->id,
                        "name_plan" => $subcription->plan_paypal_del->name,
                    ],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    function cancel_subcription(Request $request){

        $subcription = Subcription::where("id",$request->subcription_id)->first();
        
        if($subcription){

            $cancelled = $this->paypalSubcription->cancelSubcription($subcription->subcription_paypal_id,[
                "reason" => $request->reason,
            ]);
    
            error_log(json_encode($cancelled));
    
            date_default_timezone_set("America/Lima");

            $subcription->update([
                "renewal_cancelled" => 0,//(1,0) 1 es activo y 0 es inactivo
                "renewal_cancelled_at" => now(),
            ]);
            
            return response()->json(["message" => 200]);
        }else{
            return response()->json(["message" => 403]);
        }

    }
}
