<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }else{
            return response()->json([
                'status' => 'success',
                'data' => $user
            ], 200);
        }
    }

    public function store(Request $request)
    {

        $validator = FacadesValidator::make($request->all(),[
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',

        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }else{
            $user = User::create([
                'f_name' => $request['f_name'],
                'l_name' => $request['l_name'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'type' => 1,
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'User Created Successfully.',
                'data' => $user
            ], 201);
        }

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = FacadesValidator::make($request->all(),[
            'f_name' => 'sometimes|string|max:255',
            'l_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes',
            // 'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->email,
            // 'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }else{
            $user->update([
                'f_name' => $request['f_name'],
                'l_name' => $request['l_name'],
                'phone' => $request['phone'],
            ]);
            return response()->json([
                'status' => 'Success',
                'message' => 'User Updated Successfully.',
                // 'data' => $user
            ], 201);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }else{
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully'
            ], 204);
        }

    }
}
