<?php

namespace App\Http\Controllers;

use App\DataTables\TournamentsDataTable;
use App\Models\Structure;
use App\Models\Tournament;
use App\Models\TournamentStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TournamentsDataTable $dataTable)
    {
        return $dataTable->render("tournament.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $structures = Structure::all();

        return view("tournament.create", [ 
           "structures" => $structures
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = trim($request->input("tournament"));
        $date = trim($request->input("date"));
        $hour = trim($request->input("hour"));
        $structures = $request->input("structure");

        DB::beginTransaction();
        
        try {

            $tournament = Tournament::create([
                "name" => $name,
                "date" => $date,
                "hour" => $hour
            ]);

            foreach ($structures as $structure) {
                if (isset($structure['id'])) {
                    TournamentStructure::create([
                        "tournament_id" => $tournament->id,
                        "structure_id" => $structure['id'],
                        "value" => $structure['value']
                    ]);
                }
            }

            $message = "O torneio '$tournament->name' foi inserida com sucesso!";
            $typeMessage = "success";

            DB::commit();

        } catch (\Throwable $th) {
            $typeMessage = "error";
            $message = $th->getMessage();

            DB::rollBack();
        }

        return redirect()->route("tournaments.create")->with(
            $typeMessage, $message
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tournament = Tournament::where('id', $id)->first();

        $structures = DB::table('tournament_structures')
                            ->join('structures', 'structures.id', '=', 'tournament_structures.structure_id')
                            ->select('tournament_structures.id', 'structures.name', 'tournament_structures.value')
                            ->where('tournament_id', $id)
                            ->get();

        $playersNotSelected = DB::table('players')
                        ->select('players.id', 'players.name')
                        // ->leftJoin('tournament_players', 'tournament_players.player_id', '=', 'players.id')
                        // ->whereNull('tournament_players.tournament_id')
                        ->get();
        
        $playersSelected = DB::table('players')
                        ->select('players.id', 'players.name')
                        ->leftJoin('tournament_players', 'tournament_players.player_id', '=', 'players.id')
                        ->whereNotNull('tournament_players.tournament_id')
                        ->where('tournament_id', $id)
                        ->get();
        
        DB::enableQueryLog();
                        
        $result = DB::table('tournaments')
                    ->selectRaw(
                        'tournaments.id,
                        IFNULL(sum(tournament_structures.value), 0) as total'
                    )
                    ->leftJoin('tournament_transactions', 'tournament_transactions.tournament_id', '=', 'tournaments.id')
                    ->leftJoin('tournament_structures', 'tournament_structures.id', '=', 'tournament_transactions.tournament_structure_id')
                        ->where('tournaments.id', $id)
                        ->groupBy('tournaments.id')
                        ->first();

        return view("tournament.show", [
            "structures" => $structures,
            "tournament" => $tournament,
            "playersNotSelected" => $playersNotSelected,
            "playersSelected" => $playersSelected,
            "result" => $result
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
