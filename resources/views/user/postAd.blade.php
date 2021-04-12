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
                        <div id="myTabContent" class="tab-content">
                            <div id="home">
                                <h2 class="choose_bategory_h"><i class="fas fa-arrow-left arrow_margin"></i>Pasirinkite kategoriją</h2>
                                <p class="choose_bategory_h">Pasirinkite teisingai, nes galimybės pakeisti pagrindinę kategoriją nebus! </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
