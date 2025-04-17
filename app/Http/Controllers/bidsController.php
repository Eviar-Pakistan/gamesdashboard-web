<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bids;
use App\Models\Races;
use App\Models\User;

class bidsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'horse_id' => 'required',
            'amount' => 'required',
            'user_id' => 'required',
            'race_id' => 'required',
        ]);
    
        if ($request->has('isMulti') && $request->isMulti) {
            $bidsData = $request->horse_id;
            $bids = [];
    
            foreach ($bidsData ?? [] as $horseId => $amount) {

                $bid = bids::create([
                    'horse_no'  => $horseId,
                    'amount'    => $amount,
                    'user_id'   => $request->user_id,
                    'race_id'   => $request->race_id,
                ]);
    
                $bids[] = $bid;
            }
    
            return $bids;
        } else {

            $bid = bids::create([
                'horse_no'  => $request->horse_id,
                'amount'    => $request->amount,
                'user_id'   => $request->user_id,
                'race_id'   => $request->race_id,
            ]);
    
            return $bid;
        }
    }


    public function bidWinner(Request $request)
    {
        $users = User::get();
    
        foreach ($users as $user) {
            $bids = bids::where('user_id', $user->id)->get();
            $hasWinner = false;
            $totalBidsAmount = 0;
    
            foreach ($bids as $bid) {
                $race = Races::where('id', $bid->race_id)
                    ->where('winner_horse_no', $bid->horse_no)
                    ->first();
    
                if ($race) {
                    $hasWinner = true;
                    $user->coin_balance += $bid->amount * 2;
                } else {
                    $totalBidsAmount += $bid->amount; 
                }
            }
    
            if ($hasWinner) {
                $user->coin_balance += $totalBidsAmount; 
            }
    
            $user->save();
        }
    
        return response()->json([
            'status' => true,
            'message' => "updated"
        ]);
    }

    // ASAD FOR YOUR REFERENCE
    
    // CURRENT CASE
    // {
    //     "horse_id": "1",
    //     "amount": "100",
    //     "user_id": "123",
    //     "race_id": "456",
    //     "isMulti": false
    //   }

    // MULTI HORSE CASE => horse_id parameter would be an array in which key would be horse_id and value the amount
    // {
    //     "horse_id": {
    //       "1": "100",
    //       "2": "200",
    //       "3": "300"
    //     },
    //     "user_id": "123",
    //     "race_id": "456",
    //     "isMulti": true
    //   }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkUser(Request $request)
    {
        $bids = bids::where('user_id', $request->user_id)->get();
        $bidsCount = bids::where('user_id', $request->user_id)->count();
        
        return response()->json([
            'bids' => $bids, 
            'status' => $bidsCount ? true : false
        ]);
    }

}