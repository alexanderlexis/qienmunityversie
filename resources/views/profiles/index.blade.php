@extends('layouts.app')

@section('content')
    <h1>Profielen</h1>
    <table class="table">
        <thead>
          <tr>
            @if(auth()->user()->rol == 0)
                <th scope="col">Id</th>
            @endif
            <th scope="col">Naam</th>            
            <th scope="col">Geboortedatum</th>
            <th scope="col">Toegevoegd op</th>
          </tr>
        </thead>
        <tbody>
            @if(count($profiles)>0)

                    @foreach($profiles as $profile)

                            <tr class>
                              @if(auth()->user()->rol == 0)
                                <th scope="row">{{$profile->id}}</th>
                              @endif
                              <td><a href='/profiles/{{$profile->id}}'>{{$profile->username}}</a></td>                              
                              <td>{{$profile->dateofbirth}}</td>
                              <td>{{$profile->created_at}}</td>
                              @if(auth()->user()->rol == 0)
                              <td><a href ="/profiles/{{$profile->id}}/edit" class="btn btn-sm btn-default">Profiel bewerken ></a></td>
                              @endif
                            </tr>
 
                    @endforeach
                        {{$profiles->links()}}
            @else
                <p>Geen profielen gevonden</p>

            @endif
        </tbody>
    </table>
        
@endsection