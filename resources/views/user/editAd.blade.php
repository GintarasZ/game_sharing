@extends('layouts.app')

<?php
use App\Models\Cities;
use App\Models\SubCategory;
?>

@section('content')
    <div class="container profile_page">
        <div class="row justify-content-center">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        @if(isset($ads))
                            @if(count($ads)>0)
                                @foreach($ads as $row)
                                    <strong>Žaidimo <?php echo $row->productName ?> informacija</strong>
                                @endforeach
                            @else
                            @endif
                        @endif
                    </div>
                    <div class="card-body">
                        <div id="myTabContent" class="tab-content">
                            <div id="home">
                                <h1 class="h1_padding" id="selCatMsg"></h1>
                                <form class="form-horizontal form_padding_left" enctype="multipart/form-data" method="post" action="{{url('/updateAd'.$row->id)}}" autocomplete="off">
                                    {{csrf_field()}}


                                    <div class="row">
                                        <div class="col-lg-6"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Žaidimo pavadinimas</strong></label>
                                                <input type="text" class="form-control" name="productName"  value="<?php echo $row->productName ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Žaidimo aprašymas</strong></label>
                                                <input type="text" class="form-control" name="productDescription" value="<?php echo $row->productDescription ?>" required="true">
                                            </div>
                                        </div>
                                        <label></label>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><strong>Žaidimo vertė</strong></label>
                                                <input type="text" class="form-control" name="productValue" value="<?php echo $row->productValue ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><strong>Depozitas</strong></label>
                                                <input type="text" class="form-control" name="deposit" value="<?php echo $row->deposit ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label><strong>Kaina už dieną</strong></label>
                                                <input type="text" class="form-control" name="priceForDay" value="<?php echo $row->priceForDay ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label><strong>Kaina už tris dienas</strong></label>
                                                <input type="text" class="form-control" name="priceForThreeDays" value="<?php echo $row->priceForThreeDays ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label><strong>Kaina už savaitę</strong></label>
                                                <input type="text" class="form-control" name="priceForWeek" value="<?php echo $row->priceForWeek ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label><strong>Kaina už mėnesį</strong></label>
                                                <input type="text" class="form-control" name="priceForMonth" value="<?php echo $row->priceForMonth ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <?php
                                        $cities = Cities::all();
                                        ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Miestas</strong></label>
                                                <select id="city" type="text" class="form-control" name="city" required="true">
                                                    <option value="<?php echo $row->city ?>">Pasirinkite</option>
                                                    @if(count($cities)>0)
                                                        @foreach($cities as $city)
                                                            <option value={{$city->cityName}}>{{$city->cityName}}</option>
                                                        @endforeach
                                                    @else
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Žaidimo nuotraukos</strong></label>
                                                <input type="file" class="form-control" name="photos[]" multiple="true" value="<?php echo $row->photos ?>">
                                            </div>
                                        </div>
                                        <label></label>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group display_ad_card">
                                                <button type="submit" class="btn btn-primary">Atnaujinti informaciją</button>
                                            </div>
                                        </div>
                                        <label></label>
                                    </div>

                                </form>
                                <form class="form-horizontal form_padding_left" method="post" action="{{url('/deleteAd'.$row->id)}}">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group display_ad_card">
                                                <button type="w" class="btn btn-danger" onclick="return confirm('Ar tikrai norite ištrinti skelbimą?');">Ištrinti</button>
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
