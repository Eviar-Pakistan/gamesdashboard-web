<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SettingsController extends Controller
{
    public function update(Request $request, $key)
    {
        $request->validate([
            'value' => 'required',
            'user_id' => 'required',
        ]);

        $user = User::where('id', $request->user_id)->where('type', 0)->first();

        if (!$user) {
            return response()->json([
                'error' => "User not authorized to perform this action",
            ], 403);
        }

        Settings::updateOrCreate(
            ['key' => $key],
            ['value' => $request->value]
        );

        return response()->json([
            'message' => "Setting $key updated successfully",
        ]);
    }

    public function retrieve(Request $request, $key)
    {
        $request->validate([
            'user_id' => 'required',
            'key' => 'required',
        ]);
        
        $setting = Settings::where('key', $key)->first();

        if ($setting) {
            return response()->json([
                'value' => $setting->value,
            ]);
        } else {
            return response()->json([
                'message' => "Setting $key not found",
            ], 404);
        }
    }

}
