<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    public function uploadGamePage() {
        $categories = DB::table('main_categories')
            ->select('main_categories.id','main_categories.mainCategory','icons.icons')
            ->join('icons','icons.id', '=', 'main_categories.id')
            ->get();
        $subcategories = DB::table('sub_categories')
            ->select('*')
            ->get();
        return view('user.uploadGame', ['categories'=>$categories, 'subcategories'=>$subcategories]);
    }

    public function uploadGame (Request $request) {
        $this->validate($request, [
            'sub_CategoryId' => 'required',
            'gameName' => 'required',
            'gameDescription' => 'required',
            'video'=>'required'
        ]);
        $game = new Game();
        $game->sub_CategoryId = $request -> input('sub_CategoryId');
        $game->gameName = $request -> input('gameName');
        $game->gameDescription = $request -> input('gameDescription');
        $game->video = $request -> input('video');

        $game->save();
        return redirect('/')->with('info', 'Žaidimas sėkmingai įkeltas į sistemą!');
    }
}
