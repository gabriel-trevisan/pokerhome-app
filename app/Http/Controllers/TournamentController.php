<?php

namespace App\Http\Controllers;

use App\DataTables\TournamentsDataTable;
use App\Models\Player;
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
                TournamentStructure::create([
                    "tournament_id" => $tournament->id,
                    "structure_id" => $structure['id'],
                    "value" => $structure['value']
                ]);
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
                            ->select('structures.id', 'structures.name', 'tournament_structures.value')
                            ->where('tournament_id', $id)
                            ->get();

        $players = Player::all();

        return view("tournament.show", [ 
            "structures" => $structures,
            "tournament" => $tournament,
            "players" => $players
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
