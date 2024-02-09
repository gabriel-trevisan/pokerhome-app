<?php

namespace App\Http\Controllers;

use App\DataTables\TournamentsDataTable;
use App\Models\Structure;
use App\Models\Tournament;
use Illuminate\Http\Request;

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

        try {
            $tournament = Tournament::create([
                "name" => $name,
                "date" => $date,
                "hour" => $hour
            ]);

            $message = "O torneio '$tournament->name' foi inserida com sucesso!";
            $typeMessage = "success";

        } catch (\Throwable $th) {
            $typeMessage = "error";
            $message = $th->getMessage();
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
        //
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
