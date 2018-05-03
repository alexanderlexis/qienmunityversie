@extends('layouts.app')

@section('content')
        <h1>Create Post</h1><br>
<a href="/nieuwsposts" class="btn btn-default">< Ga terug</a><br/><br/>
        
        {!! Form::open(['action' => ['NieuwsController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files' => true])!!}
            {{Form::Label('titel')}}
                {{Form::text('titel','',['class'=>'form-control', 'placeholder' => 'Titel'])}}
                <div class='form-group'>
                   {{Form::label('image', 'Foto bewerken')}}
                {{Form::file('image',['class'=>'form-control'])}}
                </div>
                <br>
                {{Form::textarea('content','',['id'=>'article-ckeditor', 'class'=>'form-control', 'placeholder' => 'Content'])}}
                {{Form::submit('Post versturen >', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}

@endsection
    