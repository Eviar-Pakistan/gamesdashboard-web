<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Races;
use Carbon\Carbon;
use App\Models\bids;

class RacesController extends Controller
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
            'start_time' => 'required|date_format:h:i A',
            'winner_horse_no' => 'required',
        ]);

        $proposedStartTime = \Carbon\Carbon::createFromFormat('h:i A', $request->start_time);

        $existingSlots = Races::whereDate('created_at', '=', now()->format('Y-m-d'))->count();

        if ($existingSlots > 0) {

            $existingSlot = Races::whereDate('created_at', '=', now()->format('Y-m-d'))
                ->where('start_time', $proposedStartTime->format('h:i A'))
                ->exists();

            if ($existingSlot) {
                return response()->json([
                    'error' => 'Cannot book slot. Another slot is already booked at the proposed start time.'
                ], 422);
            }

            $existingSlotTimes = Races::whereDate('created_at', '=', now()->format('Y-m-d'))
                ->pluck('start_time')->map(function ($time) {
                    return \Carbon\Carbon::createFromFormat('h:i A', $time);
                });

            $validSlot = $existingSlotTimes->contains(function ($time) use ($proposedStartTime) {
                return $time->diffInMinutes($proposedStartTime) === 60;
            });

            if (!$validSlot) {
                return response()->json([
                    'error' => 'Cannot book slot. The slot should be exactly 1 hour before or 1 hour after an existing slot.'
                ], 422);
            }
        }

        $bids = Races::create([
            'start_time'      => $proposedStartTime->format('h:i A'),
            'winner_horse_no' => $request->winner_horse_no,
        ]);

        return response()->json([
            'bids' => $bids
        ], 201);
    }

     public function removePrevBids(Request $request)
    {
        bids::truncate();
        return response()->json(['status' => true]);
    }

    public function fetchBids(Request $request)
    {
        // Retrieve all the start_time values from the Races model
        $raceTimes = Races::select(['id', 'start_time', 'winner_horse_no'])->orderBy('id', 'ASC')->get();

        $raceArray = [];
        foreach ($raceTimes as $race) {

            $horses = [];
            for ($i = 1; $i <= 9; $i++) {
                
                $horses[$i] = [
                    'horse_no' => $i,
                    'bids' => bids::where([['horse_no', $i],['race_id', $race->id]])->sum('amount'),
                    'no_of_users' => bids::where([['horse_no', $i],['race_id', $race->id]])->distinct('user_id')->count(),
                    'is_winner_horse' => Races::where('winner_horse_no', $i)->where('start_time', $race->start_time)->first() != null ? true : false,
                    
                ];
            }
            $raceArray[$race->start_time] = $horses;
        }

        return response()->json(['time_wise_bids' => $raceArray]);
    }

    public function updateHorseId(Request $request)
    {
        $request->validate([
            'start_time' => 'required',
            'winner_horse_no' => 'required',
        ]);

        Races::where('start_time', $request->start_time)->update([
            'winner_horse_no' => $request->winner_horse_no
        ]);

        return response()->json([
            'race' => Races::where('start_time', $request->start_time)->first()
        ]);
    }


    // public function checkRaceAvailability(Request $request)
    // {
    //     $request->validate([
    //         'datetime' => 'required|string',
    //     ]);

    //     $requestedDatetime = Carbon::parse($request->datetime);

    //     $requestedTime = $requestedDatetime->format('h:i A');

    //     // $existingRace = Races::whereDate('created_at', '=', $requestedDatetime->format('Y-m-d'))
    //     //     ->where(function ($query) use ($requestedTime) {
    //     //         $query->whereBetween('start_time', [
    //     //             Carbon::parse($requestedTime)->subMinutes(5)->format('h:i A'),
    //     //             Carbon::parse($requestedTime)->addMinutes(5)->format('h:i A'),
    //     //         ])->orWhere('start_time', $requestedTime);
    //     //     })->first();

    //     // // dd()
    //     // if ($existingRace) {
    //     //     return response()->json([
    //     //         'message' => 'Race is available on the specified time.',
    //     //         'winner_horse_no' => $existingRace->winner_horse_no,
    //     //     ]);
    //     // }

    //     // return response()->json([
    //     //     'message' => 'No race available on the specified time within the next 5 minutes.',
    //     //     'winner_horse_no' => null,
    //     //     'id' => "4",
    //     // ]);
        
    //     $existingRace = Races::whereBetween('start_time', [
    //                 Carbon::parse($requestedTime)->subMinutes(5)->format('h:i A'),
    //                 Carbon::parse($requestedTime)->addMinutes(5)->format('h:i A'),
    //             ])->orWhere('start_time', $requestedTime)->first();

    //     // dd()
    //     if ($existingRace) {
    //         return response()->json([
    //             'message' => 'Race is available on the specified time.',
    //             'winner_horse_no' => $existingRace->winner_horse_no,
    //         ]);
    //     }

    //     return response()->json([
    //         'message' => 'No race available on the specified time within the next 5 minutes.',
    //         'winner_horse_no' => null,
    //         'id' => "4",
    //     ]);
    // }
        public function checkRaceAvailability(Request $request)
    {
        $request->validate([
            'datetime' => 'required|string',
        ]);
    
        $requestedDatetime = Carbon::parse($request->datetime);
        $requestedTime = $requestedDatetime->format('h:i A');
    
        $existingRace = Races::whereBetween('start_time', [
            Carbon::parse($requestedTime)->subMinutes(5)->format('h:i A'),
            Carbon::parse($requestedTime)->addMinutes(5)->format('h:i A'),
        ])->orWhere('start_time', $requestedTime)->first();

        // Fetch the previous race
        $previousRace = Races::where('start_time', '<', $requestedTime)
        ->orderByDesc('start_time')
        ->first();

        // Initialize the winner horse number to null
        $winnerHorseNo = null;

        if ($previousRace) {
            $winnerHorseNo = $previousRace->winner_horse_no;
        }

    
        if ($existingRace) {
            return response()->json([
                'message' => 'Race is available on the specified time.',
                'winner_horse_no' => $existingRace->winner_horse_no,
                'prev_winner_horse_no' => $winnerHorseNo,
            ]);
        }


    
        $nextRace = Races::where('start_time', '>', $requestedTime)
            ->orderBy('start_time')
            ->first();
    
        if ($nextRace) {
            return response()->json([
                'message' => 'No race available on the specified time within the next 5 minutes. Here is the next upcoming race.',
                'id' => $nextRace->id,
                'time' => $nextRace->start_time,
                'prev_winner_horse_no' => $winnerHorseNo,
            ]);
        }
    
    }



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
}
