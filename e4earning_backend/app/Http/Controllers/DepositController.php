<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('user_id')) {

            $deposits = Deposit::with('user')->where('user_id', $request->user_id)->get();
        } else {
            $deposits = Deposit::with('user')->get();
        }
        
        return $deposits;
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif', 
            'user_id' => 'required|integer',
        ]);

        $media = $request->file('screenshot');
        $imageName = rand() . time() . '.' . $media->extension();
        $media->move(public_path('uploads/deposit_screenshots'), $imageName);

        $deposit = Deposit::create([
            'screenshot' => $imageName,
            'user_id' => $request->user_id,
        ]);

        $deposit->load('user');

        return $deposit;
    }

    public function show(Deposit $deposit)
    {
        $deposit->load('user');
        return $deposit;
    }

    public function update(Request $request, Deposit $deposit)
    {
        $request->validate([
            'screenshot' => 'sometimes|image|mimes:jpeg,png,jpg,gif', 
            'user_id' => 'sometimes|integer',
            'status' => 'sometimes|integer',
        ]);

        if ($request->hasFile('screenshot')) {
            $media = $request->file('screenshot');
            $imageName = rand() . time() . '.' . $media->extension();
            $media->move(public_path('uploads/deposit_screenshots'), $imageName);

            if ($deposit->screenshot && file_exists(public_path('uploads/deposit_screenshots/' . $deposit->screenshot))) {
                unlink(public_path('uploads/deposit_screenshots/' . $deposit->screenshot));
            }

            $deposit->screenshot = $imageName;
        }

        if ($request->has('user_id')) {
            $deposit->user_id = $request->user_id;
        }

        if ($request->has('status')) {
            $deposit->user_id = $request->user_id;
        }

        $deposit->save();

        $deposit->load('user');
        
        return $deposit;
    }

    public function destroy(Deposit $deposit)
    {
        $deposit->delete();
        return response()->json(null, 204);
    }
}
