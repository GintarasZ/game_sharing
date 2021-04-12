@extends('layouts.app')

@section('content')
    <div class="container login_page">
        <div class="row justify-content-center">
            @if(isset($product))
                @if(count($product)>0)
                    @foreach($product as $ad)
                        <div class="col-md-12">
                            @if(Session::has('success'))
                                <p class="text-success">{{session('success')}}</p>
                            @endif
                            <div class="card">
                                <div class="card-header"><strong>{{$ad->productName}}</strong></div>
                                <?php $counter = 0; ?>
                                @if(isset($games))
                                    @if(count($games)>0)
                                        @foreach($games as $game)
                                            @if(($game->gameName)==($ad->gameId) && $counter == 0)
                                                <div _ngcontent-two-c409="" class="hero ng-star-inserted">
                                                    <div _ngcontent-two-c409="" class="videoWrapper"><video _ngcontent-two-c409="" loop="" muted="" autoplay="" style="display: block; width: 100%; height: auto;">
                                                            <source _ngcontent-two-c409="" type="video/mp4" src="{{$game->video}}"></video>
                                                    </div>
                                                </div>
                                                <?php $counter++ ?>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif

                                <div class="card-body productView_info">
                                    <?php
                                    $img = [];
                                    $img = explode(",", $ad->photos);
                                    ?>
                                    <div class="row row_negative_margin">
                                        <div class="col-lg-6">
                                            <div class="row featured" id="featured-image">
                                                <img class="productView_main" src="{{$img[0]}}"/>
                                                <p class="productView_more-photos">
                                                    @if(isset($img[0]))
                                                        <img class="productView_small" src="{{$img[0]}}" width="100px" height="100px"/>
                                                    @endif
                                                    @if(isset($img[1]))
                                                        <img class="productView_small" src="{{$img[1]}}" width="100px" height="100px"/>
                                                    @endif
                                                    @if(isset($img[2]))
                                                        <img class="productView_small" src="{{$img[2]}}" width="100px" height="100px"/>
                                                    @endif
                                                    @if(isset($img[3]))
                                                        <img class="productView_small" src="{{$img[3]}}" width="100px" height="100px"/>
                                                    @endif
                                                </p>
                                            </div>
                                            <?php $counter = 0; ?>
                                            @if(isset($games))
                                                @if(count($games)>0)
                                                    @foreach($games as $game)
                                                        @if(($game->gameName)==($ad->gameId) && $counter == 0)
                                                            <div class="row featured game_info">
                                                                <div class="card border-secondary wb-3">
                                                                    <div class="card-header">Žaidimo informacija</div>
                                                                    <div class="card-body">
                                                                        <h6>Pavadinimas: <span title="xtra large">{{$game->gameName}}</span></h6>
                                                                        <hr>
                                                                        <h6>Aprašymas: <span title="xtra large">{{$game->gameDescription}}</span></h6>
                                                                        <hr>
                                                                        @if(isset($subcategory))
                                                                            @if(count($subcategory)>0)
                                                                                @foreach($subcategory as $sub)
                                                                                    @if(($game->sub_CategoryId)==($sub->id))
                                                                                       <?php $subcategoryunique[] = $sub->subCategory;
                                                                                        $subcategoryunique = array_unique($subcategoryunique);
                                                                                       ?>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        @endif
                                                                        <h6>Žanras: <span title="xtra large"><?php echo $subcategoryunique[0]?></span></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php $counter++ ?>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="card border-secondary wb-3">
                                                <div class="card-header">Produkto informacija</div>
                                                <div class="card-body">
                                                    <h6>Aprašymas: <span title="xtra large">{{$ad->productDescription}}</span></h6>
                                                </div>
                                            </div>

                                            <div class="card border-secondary wb-3">
                                                <div class="card-header">Kainų informacija</div>
                                                <div class="card-body">
                                                    <h6>Žaidimo vertė: <span title="xtra large">{{$ad->productValue}}€</span></h6>
                                                    <hr>
                                                    <h6>Depozitas: <span title="xtra large">{{$ad->deposit}}€</span></h6>
                                                    <hr>
                                                    <h6>Kaina už dieną: <span title="xtra large">{{$ad->priceForDay}}€</span></h6>
                                                    <hr>
                                                    <h6>Kaina už tris dienas: <span title="xtra large">{{$ad->priceForThreeDays}}€</span></h6>
                                                    <hr>
                                                    <h6>Kaina už savaitę: <span title="xtra large">{{$ad->priceForWeek}}€</span></h6>
                                                    <hr>
                                                    <h6>Kaina už mėnesį: <span title="xtra large">{{$ad->priceForMonth}}€</span></h6>
                                                </div>
                                            </div>

                                            @if(isset($user))
                                                @if(count($user)>0)
                                                    @foreach($user as $row)
                                                        @if(($row->id)==($ad->sellerId))
                                                            <?php
                                                            $sellerId[] = $row -> id;
                                                            $sellerName[] = $row->name;
                                                            $sellerCity[] = $row->city;
                                                            $sellerEmail[] = $row->email;
                                                            $sellerId =array_unique($sellerId);
                                                            $sellerName =array_unique($sellerName);
                                                            $sellerCity = array_unique($sellerCity);
                                                            $sellerEmail = array_unique($sellerEmail);
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                            <div class="card border-secondary wb-3">
                                                <div class="card-header">Pardavėjo informacija</div>
                                                <div class="card-body">
                                                    <h6>Žaidimą galima atsiimti: <span title="xtra large">{{$ad->city}}</span></h6>
                                                    <hr>
                                                    <h6>Pardavėjo vardas: <span title="xtra large"><a href="{{url('/feedback/'.$sellerId[0])}}"><?php echo $sellerName[0]?></a></span></h6>
                                                    <hr>
                                                    <h6>Pardavėjo miestas: <span title="xtra large"><?php echo $sellerCity[0]?></span></h6>
                                                    @if(is_null(Auth::user()))
                                                    @elseif($ad->sellerId == Auth::user()->getId())
                                                    @else
                                                        <hr>
                                                        <a href="mailto:<?php echo $sellerEmail[0]?>?subject=Dėl {{$ad->productName}} nuomos" target="_blank">Susisiekti su pardavėju</a>
                                                    @endif
                                                </div>
                                            </div>
                                        <div class="card border-secondary wb-3">
                                            @if(is_null(Auth::user()))
                                                <div class="card-header">Nuomos informacija</div>
                                                <div class="card-body">
                                                    <p>Norėdami nuomotis žaidimą, prisijunkite</p>
                                                </div>
                                            @else
                                                @if(($ad->start_date) == null && ($ad->end_date) == null && ($ad->sellerId != Auth::user()->getId()))
                                                    @if(($ad->buyerId3) != null && $ad->buyerId2 != null)
                                                        <div class="card-header">Nuomos informacija</div>
                                                        <div class="card-body">
                                                            <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date2}}, iki: {{$ad->end_date2}}</span></h6>
                                                            <hr>
                                                            <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date3}}, iki: {{$ad->end_date3}}</span></h6>
                                                    @elseif(($ad->buyerId3) != null && ($ad->buyerId3) != Auth::user()->getId() && ($ad->buyerId2) != Auth::user()->getId())
                                                        <?php $start = $ad->start_date3?>
                                                            <div class="card-header">Nuomos informacija</div>
                                                            <div class="card-body">
                                                            <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date3}}, iki: {{$ad->end_date3}}</span></h6>
                                                            <hr>
                                                        @if(date("Y-m-d", strtotime(date("Y-m-d").'+ 30 days')) <= $ad->start_date3)
                                                            <h6>Nuomotis iki kitos nuomos pradžios</h6>
                                                            <form method="post" action="{{url('rentForAMonth2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forAMonthStart2" type="date" id="forAMonthStart2_1" name="forAMonthStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 30 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis mėnesiui</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForAWeek2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forAWeekStart2" type="date" id="forAWeekStart2_1" name="forAWeekStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 7 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis savaitei</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForThreeDays2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forThreeDaysStart2" type="date" id="forThreeDaysStart2_1" name="forThreeDaysStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 3 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis trims dienoms</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForADay2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forADayStart2" type="date" id="forADayStart2_1" name="forADayStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 1 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                            </form>
                                                        @elseif(date("Y-m-d", strtotime(date("Y-m-d").'+ 7 days')) <= $ad->start_date3)
                                                            <h6>Nuomotis iki kitos nuomos pradžios</h6>
                                                            <form method="post" action="{{url('rentForAWeek2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forAWeekStart2" type="date" id="forAWeekStart2_2" name="forAWeekStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 7 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis savaitei</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForThreeDays2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forThreeDaysStart2" type="date" id="forThreeDaysStart2_2" name="forThreeDaysStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 3 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis trims dienoms</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForADay2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forADayStart2" type="date" id="forADayStart2_2" name="forADayStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 1 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                            </form>
                                                        @elseif(date("Y-m-d", strtotime(date("Y-m-d").'+ 3 days')) <= $ad->start_date3)
                                                            <h6>Nuomotis iki kitos nuomos pradžios</h6>
                                                            <form method="post" action="{{url('rentForThreeDays2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forThreeDaysStart2" type="date" id="forThreeDaysStart2_3" name="forThreeDaysStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 3 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis trims dienoms</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForADay2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forADayStart2" type="date" id="forADayStart2_3" name="forADayStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 1 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                            </form>
                                                        @elseif(date("Y-m-d", strtotime(date("Y-m-d").'+ 1 days')) <= $ad->start_date3)
                                                            <h6>Nuomotis iki kitos nuomos pradžios</h6>
                                                            <form method="post" action="{{url('rentForADay2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forADayStart2" type="date" id="forADayStart2_4" name="forADayStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 1 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                            </form>
                                                        @endif
                                                    @else
                                                <div class="card-header">Nuomos informacija</div>
                                                <div class="card-body">
                                                    <form method="post" action="{{url('rentForADay/product/view/' .$ad->id)}}">
                                                        @csrf
                                                        <input class="forADayStart" type="date" id="forADayStart" name="forADayStart">
                                                        <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                    </form>
                                                    <form method="post" action="{{url('rentForThreeDays/product/view/' .$ad->id)}}">
                                                        @csrf
                                                        <input class="forThreeDaysStart" type="date" id="forThreeDaysStart" name="forThreeDaysStart">
                                                        <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis trims dienoms</button>
                                                    </form>
                                                    <form method="post" action="{{url('rentForAWeek/product/view/' .$ad->id)}}">
                                                        @csrf
                                                        <input class="forAWeekStart" type="date" id="forAWeekStart" name="forAWeekStart">
                                                        <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis savaitei</button>
                                                    </form>
                                                    <form method="post" action="{{url('rentForAMonth/product/view/' .$ad->id)}}">
                                                        @csrf
                                                        <input class="forAMonthStart" type="date" id="forAMonthStart" name="forAMonthStart">
                                                        <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis mėnesiui</button>
                                                    </form>
                                                    @endif
                                                @elseif($ad->sellerId == Auth::user()->getId())
                                                    @if(($ad->start_date) == null && ($ad->start_date2) == null && ($ad->start_date3) == null)
                                                        <div class="card-header">Nuomos informacija</div>
                                                        <div class="card-body">
                                                            <h6>Žaidimas šiuo metu nenuomuojamas
                                                            </h6>
                                                            <hr>
                                                    @elseif(($ad->start_date) != null && ($ad->start_date2) != null && ($ad->start_date3) != null)
                                                        <div class="card-header">Nuomos informacija</div>
                                                        <div class="card-body">
                                                            @if($ad->buyerId != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date}}, iki: {{$ad->end_date}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date != null && date("Y-m-d") > $ad->end_date)
                                                                <form method="post" action="{{url('endRent/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                                <hr>
                                                            @endif
                                                            @if($ad->buyerId2 != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date2}}, iki: {{$ad->end_date2}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date2 != null && date("Y-m-d") > $ad->end_date2)
                                                                <form method="post" action="{{url('endRent2/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                                <hr>
                                                            @endif
                                                            @if($ad->buyerId3 != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date3}}, iki: {{$ad->end_date3}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date3 != null && date("Y-m-d") > $ad->end_date3)
                                                                <form method="post" action="{{url('endRent3/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                            @endif
                                                    @elseif(($ad->start_date2) != null && ($ad->start_date3) != null)
                                                        <div class="card-header">Nuomos informacija</div>
                                                        <div class="card-body">
                                                            @if($ad->buyerId2 != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date2}}, iki: {{$ad->end_date2}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date2 != null && date("Y-m-d") > $ad->end_date2)
                                                                <form method="post" action="{{url('endRent2/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                                <hr>
                                                            @endif
                                                            @if($ad->buyerId3 != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date3}}, iki: {{$ad->end_date3}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date3 != null && date("Y-m-d") > $ad->end_date3)
                                                                <form method="post" action="{{url('endRent3/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                            @endif
                                                    @elseif(($ad->start_date2) == null)
                                                        <div class="card-header">Nuomos informacija</div>
                                                        <div class="card-body">
                                                            @if($ad->buyerId != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date}}, iki: {{$ad->end_date}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date != null && date("Y-m-d") > $ad->end_date)
                                                                <form method="post" action="{{url('endRent/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                                <hr>
                                                            @endif
                                                            @if($ad->buyerId3 != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date3}}, iki: {{$ad->end_date3}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date3 != null && date("Y-m-d") > $ad->end_date3)
                                                                <form method="post" action="{{url('endRent3/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                            @endif
                                                    @elseif(($ad->start_date3) != null)
                                                        <div class="card-header">Nuomos informacija</div>
                                                        <div class="card-body">
                                                            @if($ad->buyerId3 != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date3}}, iki: {{$ad->end_date3}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date3 != null && date("Y-m-d") > $ad->end_date3)
                                                                <form method="post" action="{{url('endRent3/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                            @endif
                                                    @else
                                                        <div class="card-header">Nuomos informacija</div>
                                                        <div class="card-body">
                                                            <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date}}, iki: {{$ad->end_date}}</span></h6>
                                                            <hr>
                                                            @if(date("Y-m-d") > $ad->end_date)
                                                                <form method="post" action="{{url('endRent/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                                <hr>
                                                            @endif
                                                            @if($ad->buyerId2 != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date2}}, iki: {{$ad->end_date2}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date2 != null && date("Y-m-d") > $ad->end_date2)
                                                                <form method="post" action="{{url('endRent2/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                                <hr>
                                                            @endif
                                                            @if($ad->buyerId3 != null)
                                                                <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date3}}, iki: {{$ad->end_date3}}</span></h6>
                                                                <hr>
                                                            @endif
                                                            @if($ad->end_date3 != null && date("Y-m-d") > $ad->end_date3)
                                                                <form method="post" action="{{url('endRent3/product/view/' .$ad->id)}}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                </form>
                                                            @endif
                                                    @endif
                                                @else
                                                <div class="card-header">Nuomos informacija</div>
                                                <div class="card-body">
                                                        <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date}}, iki: {{$ad->end_date}}</span></h6>
                                                        <hr>
                                                    @if($ad->buyerId2 != null)
                                                        <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date2}}, iki: {{$ad->end_date2}}</span></h6>
                                                        <hr>
                                                    @endif
                                                    @if($ad->buyerId3 != null)
                                                        <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$ad->start_date3}}, iki: {{$ad->end_date3}}</span></h6>
                                                        <hr>
                                                    @endif

                                                    @if($ad->buyerId2 == null && $ad->buyerId != Auth::user()->getId() && $ad->buyerId3 != Auth::user()->getId())
                                                        <?php $start = $ad->start_date?>
                                                        @if(date("Y-m-d", strtotime(date("Y-m-d").'+ 30 days')) <= $ad->start_date)
                                                            <h6>Nuomotis iki kitos nuomos pradžios</h6>
                                                            <form method="post" action="{{url('rentForAMonth2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forAMonthStart2" type="date" id="forAMonthStart2_1" name="forAMonthStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 30 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis mėnesiui</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForAWeek2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forAWeekStart2" type="date" id="forAWeekStart2_1" name="forAWeekStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 7 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis savaitei</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForThreeDays2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forThreeDaysStart2" type="date" id="forThreeDaysStart2_1" name="forThreeDaysStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 3 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis trims dienoms</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForADay2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forADayStart2" type="date" id="forADayStart2_1" name="forADayStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 1 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                            </form>
                                                        @elseif(date("Y-m-d", strtotime(date("Y-m-d").'+ 7 days')) <= $ad->start_date)
                                                            <h6>Nuomotis iki kitos nuomos pradžios</h6>
                                                            <form method="post" action="{{url('rentForAWeek2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forAWeekStart2" type="date" id="forAWeekStart2_2" name="forAWeekStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 7 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis savaitei</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForThreeDays2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forThreeDaysStart2" type="date" id="forThreeDaysStart2_2" name="forThreeDaysStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 3 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis trims dienoms</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForADay2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forADayStart2" type="date" id="forADayStart2_2" name="forADayStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 1 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                            </form>
                                                        @elseif(date("Y-m-d", strtotime(date("Y-m-d").'+ 3 days')) <= $ad->start_date)
                                                            <h6>Nuomotis iki kitos nuomos pradžios</h6>
                                                            <form method="post" action="{{url('rentForThreeDays2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forThreeDaysStart2" type="date" id="forThreeDaysStart2_3" name="forThreeDaysStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 3 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis trims dienoms</button>
                                                            </form>
                                                            <form method="post" action="{{url('rentForADay2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forADayStart2" type="date" id="forADayStart2_3" name="forADayStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 1 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                            </form>
                                                        @elseif(date("Y-m-d", strtotime(date("Y-m-d").'+ 1 days')) <= $ad->start_date)
                                                            <h6>Nuomotis iki kitos nuomos pradžios</h6>
                                                            <form method="post" action="{{url('rentForADay2/product/view/' .$ad->id)}}">
                                                                @csrf
                                                                <input class="forADayStart2" type="date" id="forADayStart2_4" name="forADayStart2" max="<?php echo date('Y-m-d', strtotime($start. ' - 1 days')) ?>">
                                                                <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                            </form>
                                                        @endif
                                                    @endif

                                                    @if($ad->buyerId3 == null && $ad->buyerId != Auth::user()->getId() && $ad->buyerId2 != Auth::user()->getId())
                                                        <h6>Nuomotis po kitos nuomos pabaigos</h6>
                                                        <form method="post" action="{{url('rentForAMonth3/product/view/' .$ad->id)}}">
                                                            @csrf
                                                            <input class="forAMonthStart3" type="date" id="forAMonthStart3_1" name="forAMonthStart3" min="<?php echo $ad->end_date ?>">
                                                            <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis mėnesiui</button>
                                                        </form>
                                                        <form method="post" action="{{url('rentForAWeek3/product/view/' .$ad->id)}}">
                                                            @csrf
                                                            <input class="forAWeekStart3" type="date" id="forAWeekStart3_1" name="forAWeekStart3" min="<?php echo $ad->end_date ?>">
                                                            <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis savaitei</button>
                                                        </form>
                                                        <form method="post" action="{{url('rentForThreeDays3/product/view/' .$ad->id)}}">
                                                            @csrf
                                                            <input class="forThreeDaysStart3" type="date" id="forThreeDaysStart3_1" name="forThreeDaysStart3" min="<?php echo $ad->end_date ?>">
                                                            <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis trims dienoms</button>
                                                        </form>
                                                        <form method="post" action="{{url('rentForADay3/product/view/' .$ad->id)}}">
                                                            @csrf
                                                            <input class="forADayStart3" type="date" id="forADayStart3_1" name="forADayStart3" min="<?php echo $ad->end_date ?>">
                                                            <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                        </form>
                                                    @endif

                                                @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if(is_null(Auth::user()))
                                    <div class="col-lg-12">
                                        <div class="card-header"><strong>Pridėti komentarą</strong></div>
                                        <div class="card-body">
                                            <p>Norėdami rašyti komentarą, prisijunkite</p>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-lg-12 write_comment_margin">
                                        <div class="card-header"><strong>Pridėti komentarą</strong></div>
                                        <div class="card-body">
                                            <form method="post" action="{{url('save-comment/product/view/' .$ad->id)}}">
                                                @csrf
                                                <textarea name="comment" class="form-control"></textarea>
                                                <button type="submit" class="btn btn-default comment_button">Rašyti</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-lg-12">
                                        <div class="card-header"><strong>Komentarai</strong></div>
                                        <div class="card-body">
                                            <?php $z = 0; ?>
                                            @foreach($comments as $comment)
                                                @if(($comment->postId)==($ad->id))
                                                    <blockquote class="blockquote">
                                                        <p class="comment_box">{{$comment->comment}}</p>
                                                        <div class="after_comment">
                                                            @foreach($commentUser as $comm)
                                                                @if(($comment->userId)==($comm->id) && $z == 0)
                                                                    @if(($comment->userId) == 13)
                                                                        <footer class="blockquote-footer">{{$comm->name}}</footer>
                                                                    @else
                                                                        <a href="{{url('/feedback/'.$comment->userId)}}"><footer class="blockquote-footer">{{$comm->name}}</footer></a>
                                                                    @endif
                                                                    <?php $z++; ?>
                                                                @else
                                                                @endif
                                                            @endforeach
                                                            <?php $z = 0; ?>
                                                            <footer class="blockquote-footer">{{$comment->created_at}}</footer>

                                                        @if(is_null(Auth::user()))
                                                        @elseif(($comment->userId)==(Auth::user()->getId()))
                                                            <form class="form-horizontal" method="post" action="{{url('/deleteComment'.$comment->id)}}">
                                                                {{ csrf_field() }}
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <button type="w" class="btn btn-danger">Ištrinti</button>
                                                                        </div>
                                                                    </div>
                                                                    <label></label>
                                                                </div>
                                                            </form>


                                                        @endif
                                                        </div>
                                                    </blockquote>
                                                    <hr/>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </div>
@endsection
