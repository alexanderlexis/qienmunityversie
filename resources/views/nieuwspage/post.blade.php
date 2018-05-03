@extends('layouts.app')

@section('content')
    <table class="table table-striped">
        <tr>
            <th>Titel:</th>
            <th>Naam:</th>
            <th>Gepost op:</th>
        </tr>
     

    </table>
    @if(count($post)>0)
        @foreach($post as $nieuws)
                <div class='well'>
                    <h3><a href="/nieuwsposts/{{$nieuws->id}}">{{$nieuws->title}}</a></h3>
                    <div><h4>{{str_limit($nieuws->content, 50)}}</h4></div><br>
                    <div><h5>Gepost op: {{$nieuws->created_at}}</h5></div>
                </div>  
        @endforeach
    @endif
@endsection