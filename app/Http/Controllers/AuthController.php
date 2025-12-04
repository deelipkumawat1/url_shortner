<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.exists' => 'No account found with these email address',
        ]);


        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }


        try {
            $user = User::where('email', $request->email)->first();

            if(!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'No account found with these email address',
                    'redirect' => route('login.index'),
                ]);
            }

            // check password manually.
            if(!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'credential' => true,
                    'message' => 'Email and password does not match',
                    'redirect' => route('login.index'),
                ]);
            }

            if(strtolower($user->role) === 'admin') {
                Auth::guard('admin')->login($user);

                return response()->json([
                    'status' => true,
                    'message' => 'welcome to the admin dashboard',
                    'redirect' => route('admin.dashboard'),
                ]);
            }
            elseif(strtolower($user->role) === 'member') {

            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
