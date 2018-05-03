@extends('layouts.app')

@section('content')

        <h1>Contact</h1>
        
        <h4>Heb je vragen, opmerkingen of tips voor het QienMunity platform?</h4>
        <p>Neem via onderstaand formulier contact op met Paul Veen van Qien. Je wordt dan zo spoedig mogelijk teruggemaild.</p>

<form>
  <div class="form-group" id="mailSucces">
    <label for="exampleFormControlInput1">Onderwerp</label>
    <input type="text" class="form-control" id="subject" placeholder="Onderwerp" name="contactName">
  </div>

  <div class="form-group">
    <label for="exampleFormControlTextarea1">Jouw bericht</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="contactText" placeholder="Beste Paul van Qien,"></textarea>
  </div>
    <input type="button" onclick="contactPost()" class="btn btn-primary" value="Verzend">
</form>


@endsection

