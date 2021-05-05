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

                                        <?php
                                        //Nuoma///////////////////////////////////////////////////////////////////////////////
                                        ?>
                                        <div class="card border-secondary wb-3">
                                            @if(is_null(Auth::user()))
                                                <div class="card-header">Nuomos informacija</div>
                                                <div class="card-body">
                                                    <p>Norėdami nuomotis žaidimą, prisijunkite</p>
                                                </div>
                                            @elseif(Auth::user()->id == 13)
                                            @else
                                                <div class="card-header">Nuomos informacija</div>
                                                <div class="card-body">
                                                    @if(isset($rent_dates))
                                                        @if(count($rent_dates)>0)
                                                            @foreach($rent_dates as $rent_date)
                                                                @if(($rent_date->advertisementId)==($ad->id))
                                                                    @if(($rent_date->buyerId == Auth::user()->getId()) && ($rent_date->status == 'Priimta'))
                                                                        <h6>Jūs nuomojatės žaidimą nuo: <span title="xtra large">{{$rent_date->start_date}} iki: {{$rent_date->end_date}}</span></h6>
                                                                        <hr>
                                                                    @elseif(($rent_date->buyerId == Auth::user()->getId()) && ($rent_date->status == 'Rezervuota'))
                                                                        <h6>Jūsų užklausa dėl žaidimo nuomos nuo: <span title="xtra large">{{$rent_date->start_date}} iki: {{$rent_date->end_date}} išsiųsta.</span></h6>
                                                                        <hr>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                    <?php $items = []; ?>
                                                    @if(isset($rent_dates))
                                                        @if(count($rent_dates)>0)
                                                            @foreach($rent_dates as $rent_date)
                                                                @if(($rent_date->advertisementId)==($ad->id))
                                                                    <?php $items[] = $rent_date->buyerId; ?>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                    @if($ad->sellerId != Auth::user()->getId() && !(in_array(Auth::user()->getId(), $items)))
                                                        <h6>Nuomotis žaidimą</h6>
                                                        <form method="post" action="{{url('rentForAMonth/product/view/' .$ad->id)}}">
                                                            @csrf
                                                            <input class="forAMonthStart" type="date" id="forAMonthStart" name="forAMonthStart" max="">
                                                            <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis mėnesiui</button>
                                                        </form>
                                                        <form method="post" action="{{url('rentForAWeek/product/view/' .$ad->id)}}">
                                                            @csrf
                                                            <input class="forAWeekStart" type="date" id="forAWeekStart" name="forAWeekStart" max="">
                                                            <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis savaitei</button>
                                                        </form>
                                                        <form method="post" action="{{url('rentForThreeDays/product/view/' .$ad->id)}}">
                                                            @csrf
                                                            <input class="forThreeDaysStart" type="date" id="forThreeDaysStart" name="forThreeDaysStart" max="">
                                                            <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis trims dienoms</button>
                                                        </form>
                                                        <form method="post" action="{{url('rentForADay/product/view/' .$ad->id)}}">
                                                            @csrf
                                                            <input class="forADayStart" type="date" id="forADayStart" name="forADayStart" max="">
                                                            <button type="submit" class="btn btn-primary rent_button half_width">Nuomotis dienai</button>
                                                        </form>
                                                    @endif
                                                    @if(($ad->sellerId != Auth::user()->getId()))
                                                            @if(isset($rent_dates))
                                                                @if(count($rent_dates)>0)
                                                                    @foreach($rent_dates as $rent_date)
                                                                        @if(($rent_date->advertisementId)==($ad->id) && ($rent_date->buyerId != Auth::user()->getId()) && ($rent_date->status == 'Priimta'))
                                                                            <hr>
                                                                            <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$rent_date->start_date}} iki: {{$rent_date->end_date}}</span></h6>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                    @elseif($ad->sellerId == Auth::user()->getId())
                                                        @if(isset($rent_dates))
                                                            @if(count($rent_dates)>0)
                                                                @foreach($rent_dates as $rent_date)
                                                                    @if((($rent_date->advertisementId)==($ad->id)) && ($rent_date->status == 'Priimta'))
                                                                        <h6>Žaidimas užimtas nuo: <span title="xtra large">{{$rent_date->start_date}} iki: {{$rent_date->end_date}}</span></h6>
                                                                        <hr>
                                                                        @if($rent_date->end_date != null && date("Y-m-d") > $rent_date->end_date)
                                                                            <form method="post" action="{{url('endRent/product/view/' .$rent_date->id . '/' . $ad->id)}}">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-primary">Baigti nuomą</button>
                                                                            </form>
                                                                            <hr>
                                                                        @endif
                                                                    @elseif((($rent_date->advertisementId)==($ad->id)) && ($rent_date->status == 'Rezervuota'))
                                                                            @if(isset($spec_user))
                                                                                @if(count($spec_user)>0)
                                                                                    @foreach($spec_user as $row)
                                                                                        @if($row->id == $rent_date->buyerId)
                                                                                            <a href="{{url('/feedback/'.$row->id)}}"><h6>{{$row->name}}</h6></a>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            @endif
                                                                        <h6>nori išsinuomoti žaidimą nuo: <span title="xtra large">{{$rent_date->start_date}} iki: {{$rent_date->end_date}}</span></h6>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <form method="post" action="{{url('acceptRent/product/view/' .$rent_date->id . '/' . $ad->id)}}">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-primary">Išnuomoti žaidimą</button>
                                                                                </form>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <form method="post" action="{{url('endRent/product/view/' .$rent_date->id . '/' . $ad->id)}}">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-primary">Atšaukti rezervaciją</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                    @endif
                                                                @endforeach
                                                            @endif
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
                                    @elseif(Auth::user()->id == 13)

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
