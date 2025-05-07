<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('user_id')) {
            $withdrawals = Withdraw::with('user')->where('user_id', $request->user_id)->get();
        } else {
            $withdrawals = Withdraw::with('user')->get();
        }

        return $withdrawals;
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_type' => 'required|string',
            'account_title' => 'required|string',
            'account_no' => 'required|string',
            'no_of_coins' => 'required|integer',
            'user_id' => 'required|integer',
        ]);
        $withdraw = Withdraw::create($validatedData);
        $withdraw->save();
        $withdraw->load('user');
        return $withdraw;
    }

    public function show(Withdraw $withdraw)
    {
        $withdraw->load('user');

        return $withdraw;
    }

    public function update(Request $request, Withdraw $withdraw)
    {
        $validatedData = $request->validate([
            'account_type'  => 'sometimes|string',
            'account_title' => 'sometimes|string',
            'account_no'    => 'sometimes|integer',
            'no_of_coins'   => 'sometimes|integer',
            'user_id'       => 'sometimes|integer',
            'status'        => 'sometimes|integer',
        ]);

        $withdraw->update($validatedData);

        $withdraw->load('user');

        return $withdraw;
    }


    public function destroy(Withdraw $withdraw)
    {
        $withdraw->delete();
        return response()->json(null, 204);
    }

    public function updateWithdrawStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:withdraws,id',
        ]);

        $withdraw = Withdraw::find($request->id);

        if ($withdraw) {
            $withdraw->withdrawstatus = 0;
            $withdraw->save();

            return response()->json([
                'status' => true,
                'message' => 'withdraw status updated successfully',
                'deposit' => $withdraw
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Withdraw not found',
        ], 404);
    }
}
