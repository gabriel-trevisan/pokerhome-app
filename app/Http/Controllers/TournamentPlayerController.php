<?php

namespace App\Http\Controllers;

use App\Models\TournamentPlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TournamentPlayerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $players = $request->input('players');

                foreach ($players as $playerId) {
                    TournamentPlayer::create([
                        "tournament_id" => $id,
                        "player_id" => $playerId
                    ]);
                }

                DB::commit();

                return response()->json([
                    "msg" => "successo"
                ]);

            } catch (\Throwable $th) {
                DB::rollBack();

                return response()->json(["msg" => $th->getMessage()], 500); 
            }
        }
    }
}
