@extends('layouts.app')

@section('content')
    <div class="container profile_page">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <strong>Visi žaidimai</strong>
                    </div>
                    <div class="card-body">
                        @if(session('info'))
                            <div class="alert alert-success top_margin">
                                {{session('info')}}
                            </div>
                        @endif
                        <div class="row">
                            @if(count($allGames)>0)
                                <ul class="list-group full_width">
                                    @foreach($allGames as $row)
                                        <li class="list-group-item">{{$row->gameName}} <a class="view_games_link_myGames" href='{{url("/editGame/{$row->id}")}}'>Redaguoti</a></li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Nėra jokių žaidimų.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
