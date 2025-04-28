<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class userController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile_no' => 'required|digits:11',
            'password' => 'required',
            'type' => 'required',
        ]);
        if (User::where('mobile_no', $request->mobile_no)->first()) {
            return response([
                'message' => 'Number already exists',
                'status' => 'failed'
            ], 200);
        }
        $uniqueCode = null;
        do {
            $uniqueCode = Str::random(6);
        } while (User::where('code', $uniqueCode)->exists());

        $user = User::create([
            'name'      => $request->name,
            'mobile_no' => $request->mobile_no,
            'type'      => $request->type,
            'password'  => Hash::make($request->password),
            'code'      => $uniqueCode,
            'secret_pin'      => $request->secretPin,
            'coin_balance' => 0.00,
        ]);

        $token = $user->createToken($request->mobile_no)->plainTextToken;

        return response([
            'user' => 'Registration success',
            'status' => 'success',
            'token' => $token,
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'code' => $uniqueCode,
            'id' => $user->id,
        ], 201);
    }

    public function login(Request $request)
    {

        $request->validate([
            // 'name' => 'required',
            // 'mobile_no' => 'required|digits:11',
            'password' => 'required',
        ]);

        $user = User::where('mobile_no', $request->mobile_no)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        $token = $user->createToken($request->mobile_no)->plainTextToken;

        return response([
            'user' => 'login success',
            'status' => 'success',
            'token' => $token,
            'name' => $user->name,
            'mobile_no' => $request->mobile_no,
            'id' => $user->id,
            'code' => $user->code,
        ], 200);
    }
public function addCoins(Request $request)
    {
        $userId = $request->userId;
    
        // Fetch the user from the database
        $user = User::whereId($userId)->first();
        if ($user == null) {
            return response()->json([
                'message' => "User not found",
            ]);
        }
    
        // Validate the 'coins' parameter
        $request->validate([
            'coins' => 'required|numeric',
        ]);
    
        // Calculate 95% of the coins to be added to the user's balance
        $coinsToAdd = ceil($request->coins * 0.95); // 95% to the user
        $coinsForAdmin = ceil($request->coins * 0.05); // 5% to admin (id = 3)
    
        // Update the user's coin balance (95%)
        $user->coin_balance += $coinsToAdd;
        $user->save();
    
        // Check if the user is not the admin (id = 3)
        if ($userId != 3) {
            // Add 5% to the admin's coin balance (id = 3)
            $admin = User::find(1); // Get the admin user
            if ($admin) {
                $admin->coin_balance += $coinsForAdmin;
                $admin->save();
            }
        }
    
        return response()->json([
            'message' => "Successfully added coins",
            'coin_balance' => $user->coin_balance, // Return updated balance for the user
        ]);
    }
      public function deductCoins(Request $request)
    {
        $userId = $request->userId;
    
        // Fetch the user from the database
        $user = User::whereId($userId)->first();
        if ($user == null) {
            return response()->json([
                'message' => "User not found",
            ]);
        }
    
        // Validate the 'coins' parameter
        $request->validate([
            'coins' => 'required|numeric',
        ]);
    
        // // Calculate 95% of the coins to be added to the user's balance
        // $coinsToAdd = ceil($request->coins * 0.95); // 95% to the user
        // $coinsForAdmin = ceil($request->coins * 0.05); // 5% to admin (id = 3)
    
        // Update the user's coin balance (95%)
        // $user->coin_balance += $coinsToAdd;
        $user->coin_balance -= $request->coins;
        $user->save();
    
    
        return response()->json([
            'message' => "Successfully added coins",
            'coin_balance' => $user->coin_balance, // Return updated balance for the user
        ]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Succefully Logged Out !!',
            'status' => 'success'
        ], 200);
    }
    public function logged_user()
    {
        $loggeduser = auth()->user();
        return response([
            'user' => $loggeduser,
            'message' => 'Logged User Data',
            'status' => 'success'
        ], 200);
    }

    public function checkBalance(Request $request)
    {
        $userId = $request->userId;
        $user = User::whereId($userId)->first();

        if ($user == null) {
            return response()->json([
                'message' => "User not found",
            ]);
        }

        return response()->json([
            'coin_balance' => $user->coin_balance,
        ]);
    }

    public function getAllUsers(Request $request)
    {
        if ($request->count != "yes") {
            // $userId = $request->userId;
            $user = User::whereNotIn('id', [1])->get();

            // if ($user == null) {
            //     return response()->json([
            //         'message' => "User not found",
            //     ]);
            // }

            return response()->json([
                'users' => $user,
            ]);
        } else {
            $user = User::whereNotIn('id', [1])->count();

            return response()->json([
                'users' => $user,
            ]);
        }
    }

    public function addAdminCoins(Request $request)
    {
        $request->validate([
            'admin_id' => 'required',
            'coins' => 'required'
        ]);

        if ($request->admin_id != 1) {
            return response()->json([
                'message' => 'not admin'
            ]);
        }

        $admin = User::whereId($request->admin_id)->first();
        $coins = (int) $admin->coin_balance + (int) $request->coins;

        User::whereId($request->admin_id)->update([
            'coin_balance' => $coins,
        ]);

        return response()->json([
            'message' => 'coins updated for admin',
            'coin_balance' => $coins,
            'user' => $admin
        ]);
    }

    public function setPasswordForUser(Request $request)
    {
        $mobileNumber = $request->mobile_no;
        $newPassword = $request->password;

        $user = User::where('mobile_no', $mobileNumber)->first();

        if (!$user) {
            return response()->json([
                'message' => "User not found",
            ], 404);
        }

        if ($user->type == 0) {
            $user->password = Hash::make($newPassword);
            $user->save();

            return response()->json([
                'message' => "Password updated successfully",
            ]);
        } else {
            return response()->json([
                'message' => "User is not of type admin",
            ], 400);
        }
    }

    public function forgetPassword(Request $request)
    {
        $secretPin      = $request->secretPin;
        $mobileNumber   = $request->mobileNumber;
        $newPassword    = $request->newPassword;

        $user = User::where('mobile_no', $mobileNumber)->first();

        if (!$user) {
            return response()->json([
                'message' => "User not found",
                'status' => 0,

            ], 404);
        }

        if ($user->secret_pin !== $secretPin) {
            return response()->json([
                'message' => "Invalid secret pin",
                'status' => 0,

            ], 401);
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json([
            'message' => "Password updated successfully",
            'user' => $user,
            'status' => 1,
        ]);
    }
}
