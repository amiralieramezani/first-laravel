<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status_code' => 400, 'massage' => 'Bad Request']);
        }
        $admin = new Admin();
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->password = bcrypt($req->password);
        $admin->save();
        return response()->json(['status_code' => 200, 'message' => 'Admin created successfully!']);
    }

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status_code' => 400, 'massage' => 'Bad Request']);
        }


        $admin = Admin::where([['email', $req->email]])->first();

        if (empty($admin)) {
            return response()->json(['status_code' => 500, 'message' => 'Email not found!']);
        }

        if (!Hash::check($req->password, $admin->password)) {
            return response()->json(['status_code' => 500, 'message' => 'Password is wrong!']);
        }

        $tokenResult = $admin->createToken('authToken')->plainTextToken;

        return response()->json(['status_code' => 200, 'token' => $tokenResult]);
    }

    public function logout(Request $req)
    {
        $req->admin()->currentAccessToken()->delete();
        return response()->json(['status_code' => 200, 'massage' => 'Token deleted successfully!']);
    }
}
