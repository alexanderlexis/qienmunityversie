@extends('layouts.app')

@section('content')
@if (auth()->user()->id == $post->user_id||auth()->user()->rol == 0)


        <h1>Nieuws Post Bewerken</h1>
        <h3>{{$post->user->name}}</h3>
        <a href="/nieuwsposts" class="btn btn-default">< Ga terug</a><br/><br/>
        {!! Form::open(['action' => ['NieuwsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files' => true])!!}
            <div class='form-group'>
                {{Form::label('titel', 'Titel')}}
                {{Form::text('titel', $post->title ,['class'=>'form-control', 'placeholder'=>$post->title])}}
            </div>
            <div class='form-group'>
                {{Form::label('content', 'Content')}}
                {{Form::textarea('content', $post->content ,['id'=>'article-ckeditor', 'class'=>'form-control', 'placeholder'=> $post->content])}}
            </div>
            <div class='form-group'>
                   {{Form::label('image', 'Foto bewerken')}}
                {{Form::file('image',['class'=>'form-control'])}}
            </div>

            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Wijzig post >', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
            
@else
    
<h1>Leuk geprobeerd, dit is niet jouw post</h1>
<a href="/myprofile" class="btn btn-default">< Terug naar nieuwspagina</a>

@endif

@endsection
