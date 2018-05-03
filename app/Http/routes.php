<?php

use Illuminate\Http\Request;
use App\Http\Controllers;
use App\User;
use App\Profile;

Route::auth();
Route::get('/', 'HomeController@index');

Route::group(['middleware' => 'auth'], function () {

    //Standaard views routes
    
    Route::get('/community', function () {
        return view('community');
    });

    Route::get('/contact', function () {
        return view('contact');
    });

    Route::get('/nieuws', function () {
        return view('nieuws');
    });

    Route::get('/resources', function () {
        return view('resources');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/nieuwegebruiker', function () {
        return view('auth/register');
    });
    
    Route::get('/myprofile',[
    'uses'=>'ProfileController@myProfile'] );

    
    //Resource routes
    
    Route::resource('nieuwsposts','NieuwsController');

    Route::resource('profiles', 'ProfileController');
    
    Route::resource('post','PostIdController');

    Route::resource('communitypost','CommunityController');

    Route::resource('profiles', 'ProfileController');
    
    
    //Methode routes
    
    Route::put('/videoupdate', 'HomeController@updatevideo');
    
    Route::get('/profileimage/{filename}', ['uses' => 'ProfileController@getUserImage', 'as' => 'profile.image']);

    Route::post('/zoek', 'NieuwsController@search');
    
    Route::post('/zoekComm', 'CommunityController@searchComm');
    
    Route::get('/munityimage/{filename}', ['uses' => 'CommunityController@getUserImage', 'as' => 'community.image']);
    
    Route::get('/newsimage/{filename}', ['uses' => 'NieuwsController@getUserImage', 'as' => 'news.image']);
    
    Route::post('/contactMail', 'ContactController@sendContact');

    Route::get('/home','HomeController@index');
   
    Route::post('bookmark/{post_id}', ['uses' => 'NieuwsController@bookmark', 'as' => 'nieuws.bookmark']);
    
    Route::get('testauth', 'testController@auth');  

    Route::get('/myprofile','ProfileController@myProfile' );

    Route::get('/auth/success', ['uses' => 'Auth\AuthController@success', 'as'   => 'auth.success']);
                
    Route::get('/unsign/{mail}', 'Auth\AuthController@notify' );  
    
   
 
    //Comments plaatsen en deleten op Nieuws en Communitypagina vanuit namespace CommentControllers
    
    Route::group(['namespace'=>'CommentControllers', 'prefix'=>'CommentControllers'], function(){
        
        Route::post('nieuwscomment/{post_id}', ['uses' => 'NieuwsCommentController@store', 'as' => 'nieuwscomment.store']);

        Route::delete('nieuwscommentdelete/{comment_id}', ['uses' => 'NieuwsCommentController@destroy', 'as' => 'nieuwscomment.destroy']);

        Route::post('communitycomment/{post_id}', ['uses' => 'CommunityCommentController@store', 'as' => 'communitycomment.store']);

        Route::delete('communitycommentdelete/{comment_id}', ['uses' => 'CommunityCommentController@destroy', 'as' => 'communitycomment.destroy']);

    });   
   
});