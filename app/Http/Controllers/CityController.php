<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;


class CityController extends Controller
{
    public function fetch(Request $request) {
        if($request->get('cities')) {
            $query = $request->get('cities');
            $data = DB::table('cities') -> where('cityName', 'like', '%' .$query. '%') ->get();
            $output = '<ul class="dropdown-menu city_dropdown">';
            if($data->count()>0) {
                foreach ($data as $row) {
                    $output .= '<li class="searchCity" id="search" value='.$row->id.'>' .$row -> cityName. '</li>';
                }
                $output .= '</ul>';
                echo $output;
            } else {
                $output .= '<li>Miestas nerastas</li>';
                echo $output;
            }
        }
    }

    public function searchAdvertisements(Request $request) {
        if($request->get('cities') && $request->get('categories')) {
            $city = $request->get('cities');
            $categoriess = $request->get('categories');
            $search = DB::table('main_categories')
                ->where(['id' => $categoriess])
                ->get();
            if($categoriess == 1) {
                $data = DB::table('advertisements')
                    ->where(['city' => $city])
                    ->get();
            } else {
                $data = DB::table('advertisements')
                    ->where(['city' => $city, 'mainCategoryId' => $categoriess])
                    ->get();
            }
            $categories = DB::table('main_categories')
                ->select('main_categories.id','main_categories.mainCategory','icons.icons')
                ->join('icons','icons.id', '=', 'main_categories.id')
                ->get();
            return view('user.categories.searchOnLocationAndCategories', ['categories'=>$categories, 'data'=>$data, 'city'=>$city, 'search'=>$search]);
        }
    }
}
