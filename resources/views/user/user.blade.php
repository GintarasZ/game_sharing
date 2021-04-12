@extends('layouts.app')

@section('content')
    <div class="container">
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
                                        <li>
                                            @if($category->id == '1')
                                                <a href="{{url('/')}}">{!! html_entity_decode($category->icons) !!}{{$category->mainCategory}}</a>
                                            @endif
                                        </li>
                                        <li>
                                            <a href="{{url('/viewAds/'.preg_replace('/\s+/','',$category->mainCategory).'/'.$category->id)}}">{!! html_entity_decode($category->icons) !!}{{$category->mainCategory}}</a>
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
                        <strong>Skelbimai</strong>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            @if(session('info'))
                                <div class="alert alert-success top_margin">
                                    {{session('info')}}
                                </div>
                            @endif
                        </div>
                        <div class="row ads_row" id="Advertisements">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
