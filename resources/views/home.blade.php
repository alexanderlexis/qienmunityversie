@extends('layouts.app')

@section('content')

<h1>Dashboard</h1>

<h4>Welkom bij jouw Qienmunity, {{auth()->user()->name}}!</h4>

<div class="container">
    <div class="row">
        <!--Nieuwposts tonen-->
            <div class="col-lg-6">   
                
                <a href='/nieuwsposts'><h2>Nieuws</h2></a>
                       <div class="well" style="box-shadow: 0 7px 7px 3px #aaaaaa;">
                            @foreach($nieuwspost as $post)
                            <div>      
                                    <h3 class="card-title" ><a href="/nieuwsposts/{{$post->id}}">{{$post->title}}</a></h3>
                                    <p>{!!str_limit($post->content, 300)!!}</p>
                                    <small>Geschreven op {{$post->updated_at}} door <a href='/profiles/{{$post->user->profile->id}}'>{{$post->user->name}}</a></small>
                                    <hr>
                            </div>
                            @endforeach
                            <a href="/nieuwsposts">Bekijk alle nieuwsposts ></a>
                       </div>
                
            </div>
        
                
                <!--Toon 3 nieuwste gebruikers-->
        
        <div class="col-lg-6">
            <a href='/profiles'><h2>Nieuwste gebruikers</h2></a>
                   <div class="well" style="box-shadow: 0 7px 7px 3px #aaaaaa;">
                @foreach($profiles as $profile)
                        <a href="/profiles/{{$profile->id}}"><img style="vertical-align: middle;" class="img-circle" height=50px width=50px src="{{ route('profile.image', ['filename' => $profile->username . '-' . $profile->user_id . '.jpg']) }}" alt="" class="img-responsive"></a>
                        <h3 style="display: inline-block; padding-left: 20px;"><a href="/profiles/{{$profile->id}}">{{$profile->username}}</a></h3>
                        <br>
                        <p style="display: inline-block; padding-left: 75px;">{!!str_limit($profile->position, 100)!!}</p>
                        <hr>
                @endforeach
                <a href="/profiles">Bekijk alle profielen ></a>
            </div>
        </div>
        
    </div>
    <div class="row">
                <!--Communitypost tonen-->
        
        <div class="col-lg-6">
            <a href='/communitypost'><h2>Community</h2></a>
            <div class="well" style="box-shadow: 0 7px 7px 3px #aaaaaa;">
                @foreach($commpost as $post)

                        <h3><a href="/communitypost/{{$post->id}}">{{$post->title}}</a></h3>
                        <p>{!!str_limit($post->content, 300)!!}</p>
                        <small>Geschreven op {{$post->updated_at}} door <a href='/profiles/{{$post->user->profile->id}}'>{{$post->user->name}}</a></small>
                        <hr>
                @endforeach
                <a href="/communitypost">Bekijk alle communityposts ></a>
          </div>
        </div>
                
        <!--Video-->
        
        <div class="col-lg-6">
            <h2>Featured video</h2>
            <div class="well" style="box-shadow: 0 7px 7px 3px #aaaaaa;">
                <div class="videoWrapper">   
                {!!$videolink!!}
                </div>
            </div>
            @if(auth()->user()->rol == 0)
                <h4>Vervang video</h4>
                {!! Form::open(['action'=>'HomeController@updatevideo', 'method'=>'POST']) !!}
                <div class='form-group'>
                    {{Form::text('video_embed_code', '', ['class'=>'form-control', 'placeholder'=>'YouTube embed link, beginnend met de iframe tag'])}}
                </div>
                    {{Form::hidden('_method','PUT')}}
                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
            @endif
        </div>
     
    </div>
</div>

@endsection
