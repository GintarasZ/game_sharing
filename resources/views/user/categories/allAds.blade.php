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
                        @if(count($ads)>0)
                            @foreach($categories as $category)
                                @foreach($ads as $row)
                                    @if(($row->mainCategoryId)==($category->id))
                                        <?php $categoryunique[] = $category->mainCategory;
                                        $categoryunique = array_unique($categoryunique);
                                        ?>
                                    @endif
                                @endforeach
                            @endforeach
                            <strong><?php echo $categoryunique[0] ?></strong>
                        @else
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row ads_row">
                            @if(count($ads)>0)
                                @foreach($ads as $row)
                                    <div class="col-md-3 ad_block">
                                        <div class="productCard">
                                            <a href='{{url("/product/view/{$row->id}")}}'>
                                                <img src=<?php echo strtok($row->photos, ',') ?> class="user_ads_display" />
                                            </a>
                                            <div class="display_ad_card">
                                                <h6 class="card_h6">{{$row->productName}}</h6>
                                                <p class="display_ad_price">Nuo {{$row->priceForDay}}€</p>
                                                <p>{{$row->city}}</p>
                                                <p><a class="view_ads_link" href='{{url("/product/view/{$row->id}")}}'>Peržiūrėti</a></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
