@extends('layouts.app')

@section('content')
    <h1>Community: {{$post->title}}</h1><br>
    <a href="/communitypost" class="btn btn-default">< Ga terug</a><br/><br/>
       
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="card" id="showNewsPost">
                <div class="card-header" id="qien--background-colour">
                    <h3>{{$post->title}}</h3>
                </div>
                <div class="col-md-12 col-md-offset-0">
                    @if (Storage::disk('local')->has($post->title . '' . $post->user_id . 'commu.jpg'))
                        <img src="{{route('community.image', ['filename' => $post->image]) }}" alt="" class="img-responsive img-thumbnail">
                        <h2>Content</h2>
                    @endif
                </div>
                <div class="col-md-12 col-md-offset-0">
                    <div class="card-body">
                        <p class="card-text-nieuws" id="card-text-nieuws">{!!$post->content!!}</p>
                        <small>Geschreven op {{$post->created_at}} door <a href='/profiles/{{$post->user->profile->id}}'>{{$post->user->name}}</a></small>
                    </div>
                </div>
                <div class="col-md-12 col-md-offset-0">
                    <div class="card-body">
                        @if (auth()->user()->id == $post->user_id)
                            <a href ='/communitypost/{{$post->id}}/edit' class='btn btn-default'>Bericht bewerken ></a>
                        @endif
                        @if (auth()->user()->rol == 0||(auth()->user()->id == $post->user_id))
                            {!!Form::open(['action' => ['CommunityController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Post verwijderen', ['class' => 'btn btn-danger'])}}
                            {!!Form::close()!!}
                        @endif
                        <br>
                    </div>
                </div>
            </div>
        </div>

        <h2>Comments</h2>

        @foreach($post->comments as $comment)
            <div class="well">
                <div class="accordion" id="accordion">


                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body" id="card-body--comment">
                          <p>{{$comment->content}}</p>
                        </div>
                        <div>
                            @if (auth()->user()->rol == 0||(auth()->user()->id == $comment->user_id))
                                {{Form::open(['route' => ['communitycomment.destroy', $comment->id], 'method' => 'POST', 'class' => 'pull-right']) }}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Comment verwijderen', ['class' => 'btn btn-sm btn-danger pull-right'])}}
                                {{Form::close()}}  
                            @endif   

                            <small>Geschreven door <a href='/profiles/{{$comment->user->profile->id}}'>{{$comment->user->name}}</a></small>
                        </div>     
                        <br>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
        
    <div class="row">
        {{ Form::open(['route' => ['communitycomment.store', $post->id], 'method' => 'POST']) }}
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