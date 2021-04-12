<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;

class MainCategoryController extends Controller
{
    public function retrieve() {
        $data = DB::table('main_categories') -> get();
        $output = '';
        if($data->count()>0) {
            foreach ($data as $row) {
                $output .= '<option value='.$row->id.'>' .$row -> mainCategory. '</option>';
            }
            $output .= '';
            echo $output;
        }
    }

    public function categories() {
        $categories = DB::table('main_categories')
            ->select('main_categories.id','main_categories.mainCategory','icons.icons')
            ->join('icons','icons.id', '=', 'main_categories.id')
            ->get();
        $subcategories = DB::table('sub_categories')
            ->select('*')
            ->get();
        $games = DB::table('games')
            ->select('*')
            ->get();
        $cities = Cities::all();
        return view('user.publishedAds.publishAd', ['categories'=>$categories, 'subcategories'=>$subcategories, 'games'=>$games, 'cities'=>$cities]);
    }
}
