@extends('layouts.app')

@section('content')
    <div class="container profile_page">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <strong>Jūsų įkelti skelbimai</strong>
                    </div>
                    <div class="card-body">
                        @if(session('info'))
                            <div class="alert alert-success top_margin">
                                {{session('info')}}
                            </div>
                        @endif
                        <div class="row ads_row">
                            @if(count($myAds)>0)
                                @foreach($myAds as $row)
                                    <div class="col-md-3 ad_block">
                                        <div class="productCard">
                                            <a href='{{url("/product/view/{$row->id}")}}'>
                                                <img src=<?php echo strtok($row->photos, ',') ?> class="user_ads_display"/>
                                            </a>
                                            <div class="display_ad_card">
                                                <h6 class="card_h6">{{$row->productName}}</h6>
                                                <p class="display_ad_price">Nuo {{$row->priceForDay}}€</p>
                                                <p>{{$row->city}}</p>
                                                <p><a class="view_ads_link_myAds" href='{{url("/product/view/{$row->id}")}}'>Peržiūrėti</a><a class="view_ads_link_myAds" href='{{url("/editAd/{$row->id}")}}'>Redaguoti</a></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Jūs neturite įkėlę jokių skelbimų.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <strong>Šiuo metu nuomojami žaidimai</strong>
                    </div>
                    <div class="card-body">
                        <div class="row ads_row">
                            @if(count($myAdsRent)>0)
                                @foreach($myAdsRent as $row)
                                    @if($row->buyerId != null)
                                        @if(count($myAds)>0)
                                            @foreach($myAds as $my)
                                                @if($my->id == $row->advertisementId)
                                                    <div class="col-md-3 ad_block">
                                                        <div class="productCard">
                                                            <img src=<?php echo strtok($row->photos, ',') ?> class="user_ads_display"/>
                                                            <div class="display_ad_card">
                                                                <h6>{{$row->gameId}}</h6>
                                                                <p class="small_font">
                                                                    <span>{{$row->start_date}}</span> —
                                                                    <span>{{$row->end_date}}</span>
                                                                    @if(count($users)>0)
                                                                        @foreach($users as $user)
                                                                            @if($user->id == $row->buyerId)
                                                                                <span>{{$user->name}}</span>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </p>
                                                                <p><a class="view_ads_link_myAds" href='{{url("/product/view/{$row->id}")}}'>Peržiūrėti</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <strong>Šiuo metu jūs nuomojatės</strong>
                    </div>
                    <div class="card-body">
                        <div class="row ads_row">
                            @if(count($myAdsRent)>0)
                                @foreach($myAdsRent as $row)
                                    @if(($row->buyerId == Auth::user()->getId()) && ($row->status == 'Priimta'))
                                        <div class="col-md-3 ad_block">
                                            <div class="productCard">
                                                <img src=<?php echo strtok($row->photos, ',') ?> class="user_ads_display"/>
                                                <div class="display_ad_card">
                                                    <h6 class="card_h6">{{$row->gameId}}</h6>
                                                    <p>
                                                        <span>{{$row->start_date}}</span> —
                                                        <span>{{$row->end_date}}</span>
                                                    </p>
                                                    <p><a class="view_ads_link_myAds" href='{{url("/product/view/{$row->id}")}}'>Peržiūrėti</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
