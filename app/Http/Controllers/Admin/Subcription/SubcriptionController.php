<?php

namespace App\Http\Controllers\Admin\Subcription;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcription\Subcription;
use App\Models\User;

class SubcriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get("search");
        $state = $request->get("state");

        $subcriptions = Subcription::filterSubcriptions($search, $state)->orderBy("id", "desc")->get();
        $users = User::where("type_user", 2)->orderBy("id", "desc")->get();
        return response()->json([
            "subscriptions" => $subcriptions,
            "users" => $users,
        ]);
    }
    public function config_all()
    {
        try {
            $subcriptions = Subcription::with('userForConfigAll')->orderBy("id", "desc")->get();
    
            $users = User::where("type_user", 2)->orderBy("id", "desc")->get();
    
            return response()->json([
                "subscriptions" => $subcriptions->map(function ($subscription) {
                    $user = $subscription->userForConfigAll;
    
                    $user_name = $user ? $user->name : 'Nombre no encontrado';
                    $user_surname = $user ? $user->surname : 'Apellido no encontrado';
                    $full_name = $user_name . ' ' . $user_surname;
    
                    return [
                        "id" => $subscription->id,
                        "user_name" => $full_name,
                        "type_plan" => $subscription->type_plan,
                        "start_date" => $subscription->start_date,
                        "end_date" => $subscription->end_date,
                        "price" => $subscription->price
                    ];
                }),
                "users" => $users->map(function ($user) {
                    return [
                        "id" => $user->id,
                        "name" => $user->name,
                        "surname" => $user->surname,
                        "type_user" => $user->type_user
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // error_log(json_encode($request->all()));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $streaming = Subcription::find($id);
        if (!$streaming) {
            return response()->json([
                "message" => 404,
                "message_text" => "EL STREAMING NO EXISTE",
            ]);
        };
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $streaming = Subcription::findOrFail($id);
        $streaming->delete();
        return response()->json(["message" => 200]);
    }
}
