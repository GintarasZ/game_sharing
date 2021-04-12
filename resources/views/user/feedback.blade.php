@extends('layouts.app')

@section('content')
    <div class="container profile_page">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="card">
                        @if(isset($user))
                            @if(count($user)>0)
                                @foreach($user as $us)
                                    <div class="card-header">
                                        <strong>Atsiliepimai apie vartotoją <?php echo $us->name ?></strong>
                                    </div>
                                    <div class="card-body">
                                        <h6>El. paštas: <?php echo $us->email ?></h6>
                                        <h6>Miestas: <?php echo $us->city ?></h6>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    <div>
                        @if(session('info'))
                            <div class="alert alert-success top_margin">
                                {{session('info')}}
                            </div>
                        @endif
                        @if(is_null(Auth::user()))
                            <div class="col-lg-12">
                                <div class="card-header"><strong>Palikti atsiliepimą</strong></div>
                                <div class="card-body">
                                    <p>Norėdami rašyti atsiliepimą, prisijunkite</p>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12 write_comment_margin">
                                <div class="card-header"><strong>Palikti atsiliepimą</strong></div>
                                <div class="card-body">
                                    <form method="post" action="{{url('commentOnPerson/product/view/' . basename($_SERVER['REQUEST_URI']))}}">
                                        @csrf
                                        <textarea name="feedback" class="form-control"></textarea>
                                        <button type="submit" class="btn btn-default comment_button">Rašyti</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <div class="card-header"><strong>Atsiliepimai</strong></div>
                        <div class="card-body">
                            <?php $z = 0; ?>
                            @foreach($feedback as $row)
                                @if(($row->userId)==(basename($_SERVER['REQUEST_URI'])))
                                    <blockquote class="blockquote">
                                        <p class="comment_box">{{$row->feedback}}</p>
                                        <div class="after_comment">
                                            @foreach($commentUser as $comm)
                                                @if(($row->commenterId)==($comm->id) && $z == 0)
                                                    <a href="{{url('/feedback/'.$row->commenterId)}}"><footer class="blockquote-footer">{{$comm->name}}</footer></a>
                                                    <?php $z++; ?>
                                                @else
                                                @endif
                                            @endforeach
                                            <?php $z = 0; ?>
                                            <footer class="blockquote-footer">{{$row->created_at}}</footer>
                                            @if(is_null(Auth::user()))
                                            @elseif(($row->commenterId)==(Auth::user()->getId()))
                                                <form class="form-horizontal" method="post" action="{{url('/deleteFeedback'.$row->id)}}">
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
@endsection
