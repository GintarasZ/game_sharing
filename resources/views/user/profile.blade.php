@extends('layouts.app')

<?php
use App\Models\Cities;
?>

@section('content')
    <div class="container profile_page">
        <div class="row justify-content-center">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        @if(isset($users))
                            @if(count($users)>0)
                                @foreach($users as $user)
                        <strong>Vartotojo <?php echo $user->name ?> profilis</strong>
                                @endforeach
                            @else

                            @endif
                        @endif
                    </div>
                    <div class="card-body">
                        <div id="myTabContent" class="tab-content">
                            <div id="home">
                                <h1 class="h1_padding" id="selCatMsg"></h1>
                                <form class="form-horizontal form_padding_left" enctype="multipart/form-data" method="post" action="{{url('/updateProfile')}}">
                                    {{csrf_field()}}


                                    <div class="row">
                                        <div class="col-lg-6">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><strong>Vartotojo vardas</strong></label>
                                                <input type="text" class="form-control" name="name"  value="<?php echo $user->name ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><strong>El. paštas</strong></label>
                                                <input type="text" class="form-control" name="email"  value="<?php echo $user->email ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <?php
                                        $cities = Cities::all();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Miestas</strong></label>
                                            <select id="city" type="text" class="form-control" name="city" required="true">
                                                <option value="<?php echo $user->city ?>">Pasirinkite</option>
                                                @if(count($cities)>0)
                                                    @foreach($cities as $city)
                                                        <option value={{$city->cityName}}>{{$city->cityName}}</option>
                                                    @endforeach
                                                @else

                                                @endif
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><strong>Telefono numeris</strong></label>
                                                <input type="text" class="form-control" name="mobile" value="<?php echo $user->mobile ?>" required="true">
                                            </div>
                                            <label></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Slaptažodis</strong></label>
                                                <input type="password" class="form-control" name="password" placeholder="Įveskite naują slaptažodį arba palikite tuščią, jei nenorite jo keisti" value="">
                                            </div>
                                            <label></label>
                                        </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
