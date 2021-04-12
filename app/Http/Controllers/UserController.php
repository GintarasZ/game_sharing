<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\Advertisement;
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
            $ads->buyerId = null;
            $ads->start_date = null;
            $ads->end_date = null;
            $ads->buyerId2 = null;
            $ads->start_date2 = null;
            $ads->end_date2 = null;
            $ads->buyerId3 = null;
            $ads->start_date3 = null;
            $ads->end_date3 = null;
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

    public function viewAds($id) {
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
        return view('user.productView', ['product'=>$product, 'user'=>$user, 'subcategory'=>$subcategory, 'games'=>$games, 'comments'=>$comments, 'commentUser'=>$commentUser]);
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
        $ads = DB::table('advertisements')
            -> get();
        $users = DB::table('users')
            ->select('users.id','users.name','advertisements.buyerId')
            ->join('advertisements','advertisements.buyerId', '=', 'users.id')
            ->get();
        $users2 = DB::table('users')
            ->select('users.id','users.name','advertisements.buyerId2')
            ->join('advertisements','advertisements.buyerId2', '=', 'users.id')
            ->get();
        $users3 = DB::table('users')
            ->select('users.id','users.name','advertisements.buyerId3')
            ->join('advertisements','advertisements.buyerId3', '=', 'users.id')
            ->get();
        return view('user.myAds', ['myAds'=>$myAds, 'ads'=>$ads, 'users'=>$users, 'users2'=>$users2, 'users3'=>$users3]);
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
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId = $userid,
            $ads->start_date = $request->input('forADayStart'),
            $ads->end_date = date('Y-m-d', strtotime($ads->start_date . ' +1 day')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą dienai!');
    }

    public function rentForADay2(Request $request, $id) {
        $this->validate($request, [
            'forADayStart2' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId2 = $userid,
            $ads->start_date2 = $request->input('forADayStart2'),
            $ads->end_date2 = date('Y-m-d', strtotime($ads->start_date2 . ' +1 day')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą dienai!');
    }

    public function rentForADay3(Request $request, $id) {
        $this->validate($request, [
            'forADayStart3' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId3 = $userid,
            $ads->start_date3 = $request->input('forADayStart3'),
            $ads->end_date3 = date('Y-m-d', strtotime($ads->start_date3 . ' +1 day')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą dienai!');
    }

    public function rentForThreeDays(Request $request, $id) {
        $this->validate($request, [
            'forThreeDaysStart' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId = $userid,
            $ads->start_date = $request->input('forThreeDaysStart'),
            $ads->end_date = date('Y-m-d', strtotime($ads->start_date . ' +3 days')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą trims dienoms!');
    }

    public function rentForThreeDays2(Request $request, $id) {
        $this->validate($request, [
            'forThreeDaysStart2' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId2 = $userid,
            $ads->start_date2 = $request->input('forThreeDaysStart2'),
            $ads->end_date2 = date('Y-m-d', strtotime($ads->start_date2 . ' +3 days')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą trims dienoms!');
    }

    public function rentForThreeDays3(Request $request, $id) {
        $this->validate($request, [
            'forThreeDaysStart3' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId3 = $userid,
            $ads->start_date3 = $request->input('forThreeDaysStart3'),
            $ads->end_date3 = date('Y-m-d', strtotime($ads->start_date3 . ' +3 days')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą trims dienoms!');
    }

    public function rentForAWeek(Request $request, $id) {
        $this->validate($request, [
            'forAWeekStart' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId = $userid,
            $ads->start_date = $request->input('forAWeekStart'),
            $ads->end_date = date('Y-m-d', strtotime($ads->start_date . ' +7 days')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą savaitei!');
    }

    public function rentForAWeek2(Request $request, $id) {
        $this->validate($request, [
            'forAWeekStart2' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId2 = $userid,
            $ads->start_date2 = $request->input('forAWeekStart2'),
            $ads->end_date2 = date('Y-m-d', strtotime($ads->start_date2 . ' +7 days')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą savaitei!');
    }

    public function rentForAWeek3(Request $request, $id) {
        $this->validate($request, [
            'forAWeekStart3' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId3 = $userid,
            $ads->start_date3 = $request->input('forAWeekStart3'),
            $ads->end_date3 = date('Y-m-d', strtotime($ads->start_date3 . ' +7 days')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą savaitei!');
    }

    public function rentForAMonth(Request $request, $id) {
        $this->validate($request, [
            'forAMonthStart' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId = $userid,
            $ads->start_date = $request->input('forAMonthStart'),
            $ads->end_date = date('Y-m-d', strtotime($ads->start_date . ' +30 days')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą mėnesiui!');
    }

    public function rentForAMonth2(Request $request, $id) {
        $this->validate($request, [
            'forAMonthStart2' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId2 = $userid,
            $ads->start_date2 = $request->input('forAMonthStart2'),
            $ads->end_date2 = date('Y-m-d', strtotime($ads->start_date2 . ' +30 days')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą mėnesiui!');
    }

    public function rentForAMonth3(Request $request, $id) {
        $this->validate($request, [
            'forAMonthStart3' => 'required',
        ]);
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId3 = $userid,
            $ads->start_date3 = $request->input('forAMonthStart3'),
            $ads->end_date3 = date('Y-m-d', strtotime($ads->start_date3 . ' +30 days')),
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Išsinuomavote žaidimą mėnesiui!');
    }

    public function endRent($id) {
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId = null,
            $ads->start_date = null,
            $ads->end_date = null,
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Nuoma baigta');
    }

    public function endRent2($id) {
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId2 = null,
            $ads->start_date2 = null,
            $ads->end_date2 = null,
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Nuoma baigta');
    }

    public function endRent3($id) {
        $userid = Auth::user()->getId();
        $ads = Advertisement::find($id);
        $ads->update([
            $ads->buyerId3 = null,
            $ads->start_date3 = null,
            $ads->end_date3 = null,
            $ads->save()
        ]);
        return redirect('/product/view/' .$id)->with('success','Nuoma baigta');
    }
}

