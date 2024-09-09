<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //**Function to Create User  */
    public function createUser(Request $request)
    {


        //**Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            $result = array(['status' => false, 'message' => "Validation Error Occure", 'error_Msg' => $validator->errors()]);
            return response()->json($result, 400);
        }
        //**Validation End

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);


        if ($user->id) {
            $result = array(['status' => true, 'message' => "created successfully", 'data' => $user]);
            $responseRequest = 200;
        } else {
            $result = array([
                'status' => false,
                'message' => "Failed to create user",
                'data' => $user
            ]);
            $responseRequest = 400;
        }
        return response()->json($result, $responseRequest);

        // return response()->json(['status' =>true,'message'=>'hello bhai api','data' =>$request->all()]);
    }

    //**Function To Get-User
    public function getUser()
    {
        $user = User::all();
        $response = array(
            'status' => true,
            'message' => count($user) . ':Data  Found',
            'data' => $user
        );
        return response()->json($response, 200);
    }

    //**Function to Get User-by-id*/
    public function getUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            $response = array(
                'status' => false,
                'message' => "User Not found",
                'data' => [],
                $responsecode = 404,
            );
        } else {
            $response = array(
                'status' => true,
                'message' => 'User Found',
                'data' => $user,
                $responsecode = 200,
            );
        }
        return response()->json($response, $responsecode);
    }
    //**Function to Update User*/
    public function updateUserById($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            $response = array(
                'status' => false,
                'message' => "User Not found",
                'data' => [],
                $responsecode = 404,
            );
        } else {
            //**validate
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'message' => "Validation Error",
                    'data' => $validator->errors(),
                    $responsecode = 422,
                );
            } else {
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->password = bcrypt($request->input('password'));
                $user->save();
                $response = array(
                    'status' => true,
                    'message' => 'User Updated',
                    'data' => $user,
                    $responsecode = 200,
                );
            }
        }
        return response()->json($response, $responsecode);
    }


    //**Function to Delete User*/
    public function deleteUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            $response = array(
                'status' => false,
                'message' => "User Not found",
                $responsecode = 404,
            );
        } else {
            $user->delete();
            $response = array(
                'status' => true,
                'message' => 'User Deleted',
                $responsecode = 200,
            );
        }
        return response()->json($response, $responsecode);
    }
}
