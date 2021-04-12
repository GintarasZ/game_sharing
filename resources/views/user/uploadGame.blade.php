@extends('layouts.app')

@section('content')
    <div class="container profile_page">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Įkelkite žaidimą</strong>
                    </div>
                    <div class="card-body">
                        <div id="myTabContent" class="tab-content">
                            <div id="home">

                            </div>
                        </div>
                        <div id="myTabContent" class="tab-content">
                            <div id="home">
                                <h1 class="h1_padding" id="selCatMsg"></h1>
                                <form class="form-horizontal form_padding_left" enctype="multipart/form-data" method="post" action="{{url('/uploadGame')}}" autocomplete="off">
                                    {{csrf_field()}}

                                    <div class="row">
                                        <div class="col-lg-6">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><strong>Pasirinkite subkategoriją</strong></label>
                                                <select class="form-control" name="sub_CategoryId" required="true">
                                                    <option value="">Pasirinkite</option>
                                                    @if(count($subcategories)>0)
                                                        @foreach($subcategories as $subcategory)
                                                            <option value={{$subcategory->id}}>{{$subcategory->subCategory}}</option>
                                                        @endforeach
                                                    @else

                                                    @endif
                                                </select>
                                            </div>
                                            <label></label>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><strong>Žaidimo pavadinimas</strong></label>
                                                <input type="text" class="form-control" name="gameName" placeholder="Pavadinimas" required="true">
                                            </div>
                                            <label></label>
                                            @if($errors->has('gameName'))
                                                <span class="alert alert-danger alert_padding">{{$errors->first('gameName')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Žaidimo aprašymas</strong></label>
                                                <input type="text" class="form-control" name="gameDescription" placeholder="Aprašymas" required="true">
                                            </div>
                                        </div>
                                        <label></label>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong>Žaidimo filmukas</strong></label>
                                                <input type="text" class="form-control" name="video" placeholder="Video" required="true">
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
