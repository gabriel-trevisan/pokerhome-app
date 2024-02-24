<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class TournamentTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $idTournament
     */
    public function index(int $idTournament)
    {
        $players = DB::table('tournament_players')
                    ->select(
                        'players.id',
                        'players.name'
                    )
                    ->join('players', 'players.id', '=', 'tournament_players.player_id')
                        ->where('tournament_players.tournament_id', $idTournament)
                        ->get();

        $transactions = DB::table('tournament_transactions')
                            ->select(
                                'tournament_structures.id', 
                                'structures.name as structure', 
                                'tournament_transactions.quantity', 
                                'tournament_structures.value',
                                'tournament_transactions.player_id',
                                'players.name',
                                'players.id',
                            )
                            ->join('tournament_structures', 'tournament_structures.id', '=', 'tournament_transactions.tournament_structure_id')
                            ->join('structures', 'structures.id', '=', 'tournament_structures.structure_id')
                            ->join('players', 'players.id', '=', 'tournament_transactions.player_id')
                                ->where('tournament_transactions.tournament_id', $idTournament)
                                ->get();

        $players->transform(function ($item, $key) {
            $item->transactions = [];
            return $item;
        });

        foreach ($players as $player) {
            foreach ($transactions as $transaction) {
                if ($transaction->player_id == $player->id) {
                    array_push($player->transactions, [
                        $transaction->structure,
                        $transaction->quantity,
                        $transaction->value,
                    ]);
                }
            } 
        }

        $pdf = App::make('dompdf.wrapper');

        $html = "<!doctype html>";
        $html .= "<html>";
        $html .= "<head>";
        $html .= "   <meta charset='utf-8'>";
        $html .= "   <meta name='viewport' content='width=device-width, initial-scale=1'>";
        $html .= "   <title>Relatório transações torneio</title>";
        $html .= "</head>";

        $html .= "<body>";

        foreach ($players as $player) {

            $total = 0;

            $html .= '<h2>'.$player->name.'</h2>';

            $html .= '<table class="table">';
            $html .=   '<thead>';
            $html .=   '    <tr>';
            $html .=   '       <th scope="col">Estrutura</th>';
            $html .=   '       <th scope="col">Quantidade</th>';
            $html .=   '       <th scope="col">Valor</th>';
            $html .=   '    </tr>';
            $html .=   '</thead>';
            $html .=   '<tbody>';
                
            foreach ($player->transactions as $transaction) {
                $html .= '<tr>';
                $html .=     '<td>'.$transaction[0].'</td>';
                $html .=     '<td>'.$transaction[1].'</td>';
                $html .=    '<td>'.$transaction[2].'</td>';
                $html .= '</tr>';

                $total += $transaction[2];
            }

            $html .=   '<tr>';
            $html .=       '<th></th>';
            $html .=       '<td></td>';
            $html .=       '<td>Total</td>';
            $html .=       '<td>'.$total.'</td>';
            $html .=   '</tr>';

            $html .=   '</tbody>';
            $html .= '</table>';

            $html .= '<hr>';
            $html .= '<br>';

        }

        $html .= "</body>";
        $html .= "</html>";

        $pdf->loadHTML($html);
        
        return $pdf->stream();
    }
}
