<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $name = trim($request->input("name"));

                $player = Player::create([
                    "name" => $name
                ]);

                DB::commit();

                return response()->json([
                    "name" => $player->name
                ]);

            } catch (\Throwable $th) {
                DB::rollBack();

                return response()->json(["msg" => $th->getMessage()], 500); 
            }
        }
    }
}
