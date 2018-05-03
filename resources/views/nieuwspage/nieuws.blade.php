@extends('layouts.app')

@section('content')
 
        <h1>Nieuws</h1>
             
            <div class='row'>
                <div class="col-lg-4">
                <a href="/nieuwsposts/create" class="btn btn-default">Nieuw bericht ></a>
                </div>
                <div class="col-lg-offset-7">
                    <input id="zoek" type="text" name='search' onkeyup="zoeken()" data-token="{{ csrf_token() }}" data-link="{{ url('/zoek') }}" class="form-control" placeholder="zoek">
                </div>
            </div>
            
            <br/>

            <div id="tabelZoekResultaat"></div>
            <div id='tabelZoek'>

            <h2>Gepind Nieuws</h2>   
        @if(count($pinned) >= 1)
    
        <div class="card-group">
   
                @foreach($pinned as $post)
                    <div class="card">

                        <img class="card-img-top" id="card-img-top" src="{{ URL::asset('css/images/qien-color.jpg') }}" alt="Card image cap">
                        <div class="card-body">
                            <a href="/nieuwsposts/{{$post->id}}"><h3 class="card-title" id="qien--colour">{{$post->title}}</h3></a>
                              <p class="card-text">{!!str_limit($post->content, 300)!!}</p>
                              <p class="card-text"><small class="text-muted">Gepost op: {{$post->created_at}} door {{$post->user->name}} </small></p>
                              <a href="/nieuwsposts/{{$post->id}}" class="btn btn-default">Lees Verder</a>
                            <div class="row">
                                @if(auth()->user()->rol == 0)
                                    <div class=" col-lg-12 col-lg-offset-0">
                                        <hr> 
                                    </div>
                                    <div class="col-lg-6">
                                             
                                            {!! Form::open(['action' => ['NieuwsController@update', $post->id], 'method' => 'POST'])!!}
                                                {{Form::hidden('_method', 'PUT')}}
                                                {{Form::hidden('unpin', 'unpin')}}
                                                {{Form::submit('Unpin', ['class' => 'btn btn-default'])}}
                                            {!!Form::close()!!}  

                                    </div>
                                @endif
                                <div class="col-lg-6">
                                    @if (auth()->user()->rol == 0||(auth()->user()->id == $post->id))


                                            {!!Form::open(['action' => ['NieuwsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                            {!!Form::close()!!}  
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                
                @endforeach
                   
                </div>

            @else
                <p> Geen Pinned Posts</p>
            @endif

            <hr>

            <h2>Nieuwsposts</h2>
            
            @if(count($nieuws) >= 1)
                @foreach($nieuws as $post)
                    <div class='well'>
                   
                        <h3><a href="/nieuwsposts/{{$post->id}}" id="qien--colour">{{$post->title}}</a></h3>
                        <div><h4>{!!str_limit($post->content, 300)!!}</h4></div><br>
                        <div><h5>Gepost op: {{$post->created_at}} door {{$post->user->name}}</h5></div>
                        <div class="row">
                            
                            @if (auth()->user()->rol == 0)
                            <hr>
                                <div class="col-lg-4">
                                    <div class="col" id="pin">                                
                                            {!! Form::open(['action' => ['NieuwsController@update', $post->id], 'method' => 'POST'])!!}
                                                {{Form::hidden('_method', 'PUT')}}
                                                {{Form::hidden('pinned', 'pinned')}}
                                                {{Form::submit('Pin', ['class' => 'btn btn-primary'])}}
                                            {!!Form::close()!!} 
                                    </div>
                                </div>
                            @endif
                            @if (auth()->user()->rol == 0||(auth()->user()->id == $post->id))
                                
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4" id="delete-news">

                                    {!!Form::open(['action' => ['NieuwsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                    {!!Form::close()!!}  
                                </div>
                            @endif
                            
                            
                        </div>
                    </div>              
                @endforeach
            @else
                <p> Geen Nieuws Posts</p>
            @endif
</div>            
@endsection