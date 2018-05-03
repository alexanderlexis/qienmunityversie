<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\gebruikerModel;
use App\Nieuwspost;
use App\Communitypost;
use App\Profile;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $commpost = Communitypost::orderBy('id','desc')->paginate(2);
        $pinnedpost = Nieuwspost::orderBy('id','desc')->where('pinned', 1)->paginate(2);
        $nieuwspost = Nieuwspost::orderBy('id','desc')->where('pinned', 0)->paginate(2);
        $profiles = Profile::orderBy('id', 'desc')->paginate(3);
        $videolink = DB::table('dashboard')->where('id', '1')->value('video_embed_code');
        return view('home')->with('commpost',$commpost)->with('pinnedpost',$pinnedpost)->with('nieuwspost',$nieuwspost)->with('profiles',$profiles)->with('videolink', $videolink);
    }
    
    public function updatevideo(Request $request)
    {   
        $this->validate($request, [
            'video_embed_code' => 'required'
        ]);
        
        DB::table('dashboard')->where('id', '1')->update(['video_embed_code' => $request->input('video_embed_code')]);
        
        return redirect('/home')->with('success', 'Video succesvol aangepast');
    }
}
