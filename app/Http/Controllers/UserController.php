<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\Advertisement;
use App\Models\RentDates;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $categories = DB::table('main_categories')
                        ->select('main_categories.id','main_categories.mainCategory','icons.icons')
                        ->join('icons','icons.id', '=', 'main_categories.id')
                        ->get();
        return view('user.user', ['categories'=>$categories]);
    }

    public function postAd() {
        $categories = DB::table('main_categories')
                        ->select('main_categories.id','main_categories.mainCategory','icons.icons')
                        ->join('icons','icons.id', '=', 'main_categories.id')
                        ->get();
        return view('user.postAd', ['categories'=>$categories]);
    }

    public function postPlaystation3(Request $request) {
        $this->validate($request, [
            'gameId' => 'required',
            'productName' => 'required',
            'productValue' => 'required',
            'deposit' => 'required',
            'priceForDay' => 'required',
            'priceForThreeDays' => 'required',
            'priceForWeek' => 'required',
            'priceForMonth' => 'required',
            'city' => 'required',
            'photos' => 'required',
            'photos.*' => 'image | mimes:jpg, png, jpeg, gif, svg | max:2048'
        ]);
        $userid = Auth::user()->getId();
        $ads = new Advertisement;
        $images = $request->file('photos');
        $count = 0;
        if ($request->file('photos')) {
            foreach ($images as $item) {
                if ($count < 4) {
                    $var = date_create();
                    $date = date_format($var, 'Ymd');
                    $imageName = $date.'_'.$item->getClientOriginalName();
                    $item->move(public_path().'/uploads/',$imageName);
                    $url = URL::to('/').'/uploads/'.$imageName;
                    $arr[] = $url;
                    $count++;
                }
            }
            $image = implode(',', $arr);
            $ads->mainCategoryId = $request -> input('mainCategoryId');
            $ads->gameId = $request -> input('gameId');
            $ads->productDescription = $request -> input('productDescription');
            $ads->productName = $request -> input('productName');
            $ads->productValue = $request -> input('productValue');
            $ads->deposit = $request -> input('deposit');
            $ads->priceForDay = $request -> input('priceForDay');
            $ads->priceForThreeDays = $request -> input('priceForThreeDays');
            $ads->priceForWeek = $request -> input('priceForWeek');
            $ads->priceForMonth = $request -> input('priceForMonth');
            $ads->city = $request -> input('city');
            $ads->sellerId = $userid;
            $ads->photos = $image;

            $ads->save();
            return redirect('/')->with('info', 'Jūsų skelbimas įkeltas sėkmingai!');
        }
    }

    public function getAds() {
        $ads = DB::table('Advertisements')->get();
        $output = '';
        if ($ads->count()>0) {
            foreach ($ads as $row) {
                $output.='<div class="col-md-3 ad_block">
                              <div>
                                    <a href='.$_SERVER['HTTP_REFERER'].'product/view/'.$row->id.'>
                                        <img src='.strtok($row->photos, ',').' class="user_ads_display"/>
                                    </a>
                                    <div class="display_ad_card">
                                        <h6 class="card_h6">'.$row->productName.'</h6>
                                        <p class="display_ad_price">Nuo '.$row->priceForDay. '€'. '</p>
                                        <p>'.$row->city.'</p>
                                        <a class="view_ads_link" href='.$_SERVER['HTTP_REFERER'].'product/view/'.$row->id.'>Peržiūrėti</a>
                                    </div>
                               </div>
                           </div>';
            }
            $output.='';
            echo $output;
        } else {
            $output.="<p>Skelbimų nėra!</p>";
            echo $output;
        }
    }

    public function viewAds($mainCategory, $id) {
        $categories = DB::table('main_categories')
            ->select('main_categories.id','main_categories.mainCategory','icons.icons')
            ->join('icons','icons.id', '=', 'main_categories.id')
            ->get();
        $ads = DB::table('advertisements')
            -> where(['mainCategoryId' => $id])
            -> get();
        return view('user.categories.allAds', ['categories'=>$categories, 'ads'=>$ads]);
    }

    public function searchProduct(Request $request) {
        if($request->get('searchproduct')) {
            $query = $request->get('searchproduct');
            $categories = DB::table('main_categories')
                ->select('main_categories.id','main_categories.mainCategory','icons.icons')
                ->join('icons','icons.id', '=', 'main_categories.id')
                ->get();
            $data = DB::table('advertisements')
                    ->where('productName', 'like', '%'.$query.'%')
                    ->get();
            return view('user.categories.searchOnProduct', ['categories'=>$categories, 'data'=>$data, 'query'=>$query]);
        }
    }

    public function viewProduct($id) {
        $product = DB::table('advertisements')
                    ->where(['id'=>$id])
                    ->get();
        $user = DB::table('users')
                    ->select('users.id', 'users.name', 'users.email', 'users.city', 'advertisements.sellerId')
                    ->join('advertisements','advertisements.sellerId', '=', 'users.id')
                    ->get();
        $spec_user = DB::table('users')
                    ->get();
        $subcategory = DB::table('sub_categories')
                    ->select('sub_categories.id', 'sub_categories.subCategory', 'games.sub_CategoryId')
                    ->join('games','games.sub_CategoryId', '=', 'sub_categories.id')
                    ->get();
        $games = DB::table('games')
                    ->select('games.gameName', 'games.gameDescription', 'games.sub_CategoryId', 'games.video', 'advertisements.gameId')
                    ->join('advertisements','advertisements.gameId', '=', 'games.gameName')
                    ->get();
        $comments = DB::table('comments')
                    ->select('comments.id', 'comments.userId', 'comments.postId', 'comments.comment', 'comments.created_at')
                    ->join('advertisements', 'advertisements.id', '=', 'comments.postId')
                    ->get();
        $commentUser = DB::table('users')
                    ->select('users.id', 'users.name')
                    ->join('comments', 'comments.userId', '=', 'users.id')
                    ->get();
        $rent_dates = DB::table('rent_dates')
                    ->select('rent_dates.id', 'rent_dates.advertisementId', 'rent_dates.buyerId', 'rent_dates.start_date', 'rent_dates.end_date', 'rent_dates.status')
                    ->join('advertisements', 'advertisements.id', '=', 'rent_dates.advertisementId')
                    ->get();
        return view('user.productView', ['product'=>$product, 'user'=>$user, 'subcategory'=>$subcategory, 'games'=>$games, 'comments'=>$comments, 'commentUser'=>$commentUser, 'rent_dates'=>$rent_dates, 'spec_user'=>$spec_user]);
    }

    public function profile($id) {
        $users = DB::table('users')
                    ->where(['id'=>$id])
                    ->get();
        return view('user.profile', ['users'=>$users]);
    }

    public function updateProfile(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'city' => 'required',
            'mobile' => 'required',
        ]);
        $user = auth()->user();
        $password = $request -> input('password');
        $hashed = Hash::make($password);
        if(empty($request -> input('password'))) {
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'city' => $request->input('city'),
                'mobile' => $request->input('mobile'),
                'password' => $user->password
            ]);
        }
        else {
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'city' => $request->input('city'),
                'mobile' => $request->input('mobile'),
                'password' => $hashed
            ]);
        }
        return redirect('/')->with('info', 'Jūsų informacija atnaujinta');
    }

    public function viewMyAds($id) {
        $myAds = DB::table('advertisements')
            -> where(['sellerId' => $id])
            -> get();
        $myAdsRent = DB::table('advertisements')
            ->select('advertisements.id','advertisements.photos','advertisements.sellerId','advertisements.gameId','rent_dates.buyerId','rent_dates.advertisementId','rent_dates.start_date','rent_dates.end_date', 'rent_dates.status')
            ->join('rent_dates','rent_dates.advertisementId', '=', 'advertisements.id')
            ->get();
        $users = DB::table('users')
            ->select('users.id','users.name','rent_dates.buyerId')
            ->join('rent_dates','rent_dates.buyerId', '=', 'users.id')
            ->get();
        return view('user.myAds', ['myAds'=>$myAds, 'myAdsRent'=>$myAdsRent, 'users'=>$users]);
    }

    public function editAd($id) {
        $ads = DB::table('advertisements')
            ->where(['id'=>$id])
            ->get();
        return view('user.editAd', ['ads'=>$ads]);
    }

    public function updateAd(Request $request, $id) {
        $this->validate($request, [
            'productName' => 'required',
            'productDescription' => 'required',
            'productValue' => 'required',
            'deposit' => 'required',
            'priceForDay' => 'required',
            'priceForThreeDays' => 'required',
            'priceForWeek' => 'required',
            'priceForMonth' => 'required',
            'city' => 'required',
            'photos.*' => 'image | mimes:jpg, png, jpeg, gif, svg | max:2048'
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $old_photos = $ads->photos;

        if(empty($request -> file('photos'))) {
            $ads->update([
                $ads-> mainCategoryId => $ads-> mainCategoryId,
                $ads-> gameId => $ads-> gameId,
                $ads->productName = $request->input('productName'),
                $ads->productDescription = $request->input('productDescription'),
                $ads->productValue = $request->input('productValue'),
                $ads->deposit = $request->input('deposit'),
                $ads->priceForDay = $request->input('priceForDay'),
                $ads->priceForThreeDays = $request->input('priceForThreeDays'),
                $ads->priceForWeek = $request->input('priceForWeek'),
                $ads->priceForMonth = $request->input('priceForMonth'),
                $ads->city = $request->input('city'),
                $ads->sellerId = $userid,
                $ads->photos = $old_photos,
                $ads->save()
            ]);
        } else {
            $images = $request->file('photos');
            $count = 0;
            if ($request->file('photos')) {
                foreach ($images as $item) {
                    if ($count < 4) {
                        $var = date_create();
                        $date = date_format($var, 'Ymd');
                        $imageName = $date . '_' . $item->getClientOriginalName();
                        $item->move(public_path() . '/uploads/', $imageName);
                        $url = URL::to('/') . '/uploads/' . $imageName;
                        $arr[] = $url;
                        $count++;
                    }
                }
            }
            $ads->update([
                $image = implode(',', $arr),
                $ads-> mainCategoryId => $ads-> mainCategoryId,
                $ads-> gameId => $ads-> gameId,
                $ads->productName = $request->input('productName'),
                $ads->productValue = $request->input('productValue'),
                $ads->deposit = $request->input('deposit'),
                $ads->priceForDay = $request->input('priceForDay'),
                $ads->priceForThreeDays = $request->input('priceForThreeDays'),
                $ads->priceForWeek = $request->input('priceForWeek'),
                $ads->priceForMonth = $request->input('priceForMonth'),
                $ads->city = $request->input('city'),
                $ads->sellerId = $userid,
                $ads->photos = $image,
                $ads->save()
            ]);
        }
        return redirect('/myAds/'.$userid)->with('info', 'Jūsų žaidimo informacija atnaujinta sėkmingai!');
    }

    public function deleteAd($id) {
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->delete();
        return redirect('/myAds/'.$userid)->with('info', 'Jūsų skelbimas ištrintas sėkmingai!');
    }

    public function rentForADay(Request $request, $id) {
        $this->validate($request, [
            'forADayStart' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $rent_dates = new RentDates;
        $rent_dates->advertisementId = $id;
        $rent_dates->buyerId = $userid;
        $rent_dates->start_date = $request->input('forADayStart');
        $rent_dates->end_date = date('Y-m-d', strtotime($rent_dates->start_date . ' +1 day'));
        $rent_dates->status = 'Rezervuota';
        $rent_dates->save();
        return redirect('/product/view/' .$id)->with('success','Išsiuntėte užklausą dėl žaidimo nuomos dienai!');
    }

    public function rentForThreeDays(Request $request, $id) {
        $this->validate($request, [
            'forThreeDaysStart' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $rent_dates = new RentDates;
        $rent_dates->advertisementId = $id;
        $rent_dates->buyerId = $userid;
        $rent_dates->start_date = $request->input('forThreeDaysStart');
        $rent_dates->end_date = date('Y-m-d', strtotime($rent_dates->start_date . ' +3 days'));
        $rent_dates->status = 'Rezervuota';
        $rent_dates->save();
        return redirect('/product/view/' .$id)->with('success','Išsiuntėte užklausą dėl žaidimo nuomos trims dienoms!');
    }

    public function rentForAWeek(Request $request, $id) {
        $this->validate($request, [
            'forAWeekStart' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $rent_dates = new RentDates;
        $rent_dates->advertisementId = $id;
        $rent_dates->buyerId = $userid;
        $rent_dates->start_date = $request->input('forAWeekStart');
        $rent_dates->end_date = date('Y-m-d', strtotime($rent_dates->start_date . ' +7 days'));
        $rent_dates->status = 'Rezervuota';
        $rent_dates->save();
        return redirect('/product/view/' .$id)->with('success','Išsiuntėte užklausą dėl žaidimo nuomos savaitei!');
    }

    public function rentForAMonth(Request $request, $id) {
        $this->validate($request, [
            'forAMonthStart' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $rent_dates = new RentDates;
        $rent_dates->advertisementId = $id;
        $rent_dates->buyerId = $userid;
        $rent_dates->start_date = $request->input('forAMonthStart');
        $rent_dates->end_date = date('Y-m-d', strtotime($rent_dates->start_date . ' +30 days'));
        $rent_dates->status = 'Rezervuota';
        $rent_dates->save();
        return redirect('/product/view/' .$id)->with('success','Išsiuntėte užklausą dėl žaidimo nuomos mėnesiui!');
    }

    public function acceptRent($id, $adId) {
        $rent_dates = RentDates::find($id);
        $rent_dates->status = 'Priimta';
        $rent_dates->save();
        return redirect('/product/view/' .$adId)->with('success','Žaidimas išnuomotas');
    }

    public function endRent($id, $adId) {
        $userid = Auth::user()->getId();
        $rent_dates = RentDates::find($id);
        $rent_dates->delete();
        return redirect('/product/view/' .$adId)->with('success','Nuoma atšaukta');
    }
}

