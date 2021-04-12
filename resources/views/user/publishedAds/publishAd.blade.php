@extends('layouts.app')

@section('content')
    <div class="container login_page">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <strong>Kategorijos</strong>
                    </div>
                    <div class="card-body card-categories">
                        <ul class="user_category fa-ul">
                            @if(isset($categories))
                                @if(count($categories)>0)
                                    @foreach($categories as $category)
                                        <li id="post-ad_categories">
                                            <a href="{{url('/post-classified-ads/'.preg_replace('/\s+/','',$category->mainCategory).'/'.$category->id)}}">{!! html_entity_decode($category->icons) !!}{{$category->mainCategory}}</a>
                                            <?php $categoryunique[] = $category->mainCategory; ?>
                                        </li>
                                    @endforeach
                                @else
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <?php
                        $url = $_SERVER['REQUEST_URI'];
                        $id = basename($url);
                        ?>
                        <strong><?php echo  $categoryunique[$id-1] ?></strong>
                    </div>
                    <div class="card-body">
                        <div id="myTabContent" class="tab-content">
                            <div id="home"></div>
                        </div>
                        <div id="myTabContent" class="tab-content">
                            <div id="home">
                                <h1 class="h1_padding" id="selCatMsg"></h1>
                                <form class="form-horizontal form_padding_left" enctype="multipart/form-data" method="post" action="{{url('/postPlaystation3')}}" autocomplete="off">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-lg-6"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="hidden" name="mainCategoryId" value={{Request::segment(3)}}>
                                                <label><strong>Žaidimas</strong></label>
                                                    <input type="text" name="gameId" id="gameId" class="form-control" placeholder="Įveskite žaidimą" required="true" autocomplete="off">
                                                <div id="gameList"></div>
                                            </div>
                                        </div>
                                        <label></label>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Nerandate savo žaidimo sąraše? <a href="mailto:admin@gmail.com?subject=Dėl žaidimo pridėjimo" target="_blank">Susisiekite su mumis</a> ir pasistengsime kuo greičiau jį įkelti!</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Žaidimo pavadinimas</strong></label>
                                                <input type="text" class="form-control" name="productName" placeholder="Pavadinimas" required="true">
                                            </div>
                                            <label></label>
                                            @if($errors->has('productName'))
                                                <span class="alert alert-danger alert_padding">{{$errors->first('productName')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Žaidimo aprašymas</strong></label>
                                                <input type="text" class="form-control" name="productDescription" placeholder="Aprašymas" required="true">
                                            </div>
                                        </div>
                                        <label></label>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label><strong>Žaidimo vertė</strong></label>
                                                        <input type="text" class="form-control" name="productValue" placeholder="" required="true">
                                                    </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><strong>Depozitas</strong></label>
                                                    <input type="text" class="form-control" name="deposit" placeholder="" required="true">
                                                </div>
                                            <label></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label><strong>Kaina už dieną</strong></label>
                                                        <input type="text" class="form-control" name="priceForDay" placeholder="" required="true">
                                                    </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label><strong>Kaina už tris dienas</strong></label>
                                                    <input type="text" class="form-control" name="priceForThreeDays" placeholder="" required="true">
                                                </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label><strong>Kaina už savaitę</strong></label>
                                                    <input type="text" class="form-control" name="priceForWeek" placeholder="" required="true">
                                                </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label><strong>Kaina už mėnesį</strong></label>
                                                    <input type="text" class="form-control" name="priceForMonth" placeholder="" required="true">
                                                </div>
                                            <label></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Miestas</strong></label>
                                                <select type="text" class="form-control" name="city" required="true">
                                                    <option value="">Pasirinkite</option>
                                                    @if(count($cities)>0)
                                                        @foreach($cities as $city)
                                                            <option value={{$city->cityName}}>{{$city->cityName}}</option>
                                                        @endforeach
                                                    @else
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <label></label>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Žaidimo nuotraukos</strong></label>
                                                <input type="file" class="form-control" name="photos[]" multiple="true" required="true">
                                            </div>
                                        </div>
                                        <label></label>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group display_ad_card">
                                                <button type="submit" class="btn btn-primary">Įkelti</button>
                                            </div>
                                        </div>
                                        <label></label>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
