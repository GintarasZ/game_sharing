<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;

class GameController extends Controller
{
    public function fetchGame(Request $request) {
        if($request->get('games')) {
            $query = $request->get('games');
            $data = DB::table('games') -> where('gameName', 'like', '%' .$query. '%') ->get();
            $output = '<ul class="dropdown-menu game_dropdown">';
            if($data->count()>0) {
                foreach ($data as $row) {
                    $output .= '<li class="searchCity" id="search2" value='.$row->id.'>' .$row -> gameName. '</li>';
                }
                $output .= '</ul>';
                echo $output;
            } else {
                $output .= '<li>Žaidimas nerastas</li>';
                echo $output;
            }
        }
    }

    public function viewMyGames() {
        $allGames = DB::table('games')
            -> get();
        return view('admin.allGames', ['allGames'=>$allGames]);
    }

    public function editGame($id) {
        $games = DB::table('games')
            ->where(['id'=>$id])
            ->get();
        return view('admin.editGame', ['games'=>$games]);
    }

    public function updateGame(Request $request, $id) {
        $this->validate($request, [
            'sub_CategoryId' => 'required',
            'gameName' => 'required',
            'gameDescription' => 'required',
            'video' => 'required',
        ]);
        $games = Game::find($id);

        $games->update([
            $games->sub_CategoryId = $request->input('sub_CategoryId'),
            $games->gameName = $request->input('gameName'),
            $games->gameDescription = $request->input('gameDescription'),
            $games->video = $request->input('video'),
            $games->save()
            ]);

        return redirect('/myGames')->with('info', 'Žaidimo informacija atnaujinta sėkmingai!');
    }

    public function deleteGame($id) {
        $games = Game::find($id);
        $games->delete();
        return redirect('/myGames')->with('info', 'Žaidimas ištrintas sėkmingai!');
    }
}
