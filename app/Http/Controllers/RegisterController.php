<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ReqisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @param  \App\Http\Requests\Auth\ReqisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(ReqisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json($success);
    }
}
