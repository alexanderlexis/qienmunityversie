@extends('layouts.app')

@section('content')
    <div class="row">
        <a href="/nieuwsposts" class="btn btn-default">< Ga terug</a><br/><br/>

        @if(auth()->user()->id == $post->user_id)
            <a href ="/nieuwsposts/{{$post->id}}/edit" class="btn btn-sm btn-primary"> Wijzig Nieuwspost</a>
        @endif
    </div>
        <div class="row">
            
            <div class="col-md-12 col-md-offset-0">
                <div class="card" id="showNewsPost">
                    
                    <div class="card-header" id="qien--background-colour">
                        <h3>Nieuws: {{$post->title}}</h3>
                    
                    </div>
                    <div class="col-md-12 col-md-offset-0">
                    @if (Storage::disk('local')->has($post->title . '' . $post->user_id . 'news.jpg'))
                        <img class="img-responsive img-thumbnail" src="{{route('news.image', ['filename' => $post->image]) }}" alt="">
                        <br>
                        <h2>Content</h2>
                    @endif
                    </div>
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card-body">
                            <p class="card-text-nieuws" id="card-text-nieuws">{!!$post->content!!}</p>
                            <small>Geschreven op {{$post->created_at}} door <a href='/profiles/{{$post->user->profile->id}}'>{{$post->user->name}}</a></small>
                        </div>
                    </div>
                </div>
            </div>

            <h2>Comments</h2>
    
            @foreach($post->comments as $comment)
                <div class="well">
                    <div class="accordion" id="accordion">

                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  {{$comment->user->name}}
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <p>{{$comment->content}}</p>
                            </div>


                            @if (auth()->user()->rol == 0||(auth()->user()->id == $comment->user_id))
                                {{ Form::open(['route' => ['nieuwscomment.destroy', $comment->id], 'method' => 'POST', 'class' => 'pull-right']) }}
                                    {{Form::hidden('_method', 'DELETE')}}
                                    {{Form::submit('Comment verwijderen', ['class' => 'btn btn-danger'])}}
                                {{Form::close()}}  
                            @endif


                            <small>Geschreven door <a href='/profiles/{{$comment->user->profile->id}}'>{{$comment->user->name}}</a></small>
                            <hr>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    <div class="row">
        {{ Form::open(['route' => ['nieuwscomment.store', $post->id], 'method' => 'POST']) }}

            <div class="row">
                <div class="col-lg-12">
                    {{ Form::label('comments', "Comment:") }}
                    {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}
                    {{ Form::submit('Add Comment', ['class' => 'btn btn-success', 'style' => 'margin-top:15px;']) }}
                </div>
            </div>

        {{ Form::close() }}


    </div>

@endsection