<?php

namespace App\Http\Controllers;

use App\Models\TournamentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TournamentPlayerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $idTournament
     * @param int $idPlayer
     */
    public function index(Request $request, int $idTournament, int $idPlayer)
    {
        if ($request->ajax()) {
            $transactions = DB::table('tournament_transactions')
                                ->select(
                                    'tournament_transactions.id', 
                                    'structures.name', 
                                    'tournament_transactions.quantity', 
                                    'tournament_structures.value'
                                )
                                ->join('tournament_structures', 'tournament_structures.id', '=', 'tournament_transactions.tournament_structure_id')
                                ->join('structures', 'structures.id', '=', 'tournament_structures.structure_id')
                                    ->where('tournament_transactions.tournament_id', $idTournament)
                                    ->where('tournament_transactions.player_id', $idPlayer)
                                    ->get();

            return response()->json([
                "transactions" => $transactions
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $idTournament, int $idPlayer)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $transactions = $request->input('transactions');

                foreach ($transactions as $transaction) {
                    if (isset($transaction['quantity']) && $transaction['quantity'] != 0) {
                        TournamentTransaction::create([
                            "tournament_id" => $idTournament,
                            "player_id" => $idPlayer,
                            "tournament_structure_id" => $transaction['id'],
                            "quantity" => $transaction['quantity']
                        ]);
                    }
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

    /**
     * Delete transaction
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $idTournament,  int $idPlayer, int $idTransaction)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $transaction = TournamentTransaction::find($idTransaction);
                $transaction->delete();

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
