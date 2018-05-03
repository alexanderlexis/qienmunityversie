<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Communitypost;
use App\Http\Requests;
use App\User;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $post = Communitypost::orderBy('id','desc')->paginate(10);
         
        return view('community.newsfeed')->with('nieuws',$post);
                                         
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('community.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        ==========-----DATA VALIDATION================
        $this->validate($request,[
            'titel' => 'required',
            'content' =>  'required',
            'image' => 'mimes:jpeg,jpg,bmp,png',
        ]);
//        ==========-----FOTO UPLOAD================
        $file = $request->file('image');
        $title = trim($request->input('titel'));
        $filename = $title.''.auth()->user()->id.'commu.jpg';
        $update = false;
        
        if (Storage::disk('local')->exists($filename)) {
            $old_file = Storage::disk('local')->get($filename);
            Storage::delete($old_file);
            Storage::disk('local')->put($filename, File::get($file));
            $update = true;
        }
        else if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        
//        ==========-----DATABASE SAVING================               
        $post = new Communitypost;
        $post->title = $request->input('titel');
        $post->content = $request->input('content');
        $post->user_id = auth()->user()->id;
        $post->image = $filename;
        $post->save();
//        ==========-----NOTIFY MAIL================               
        $afzenderControl = "communitypost";
        ContactController::notifyMail($post->user_id, $afzenderControl); //voor notificatie mail van aanmaak nieuwe post
//        ==========-----VIEW================
        return redirect('/communitypost')->with('success', 'Nieuwe post aangemaakt');
    }
    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getPost = Communitypost::find($id);
        $userPost = $getPost->user;
                
        return view('community.show',['user' => auth()->user()])->with('post', $getPost);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Communitypost::find($id);
        return view('community.edit')->with('post', $post);
    }

    
    public function update(Request $request, $id)
    {
//      ==========-----DATA VALIDATION================
        $this->validate($request,[
            'titel' => 'required',
            'content' =>  'required',
            'image' => 'mimes:jpeg,jpg,bmp,png',
        ]);
        
//      ==========-----FOTO UPDATE================
        $file = $request->file('image');
       
        $title = trim($request->input('titel'));
     
        $filename = $title.''.auth()->user()->id.'commu.jpg';
        
        $update = false;
        
        if (Storage::disk('local')->exists($filename)) {

            Storage::disk('local')->put($filename, File::get($file));
            $update = true;
        }
        
//        ==========-----DATABASE SAVING================               
        $post = Communitypost::find($id);
        $post->title = $request->input('titel');
        $post->content = $request->input('content');
        $post->user_id = auth()->user()->id;
        
        $post->image = $filename;
        
        $post->save();
        
//        ==========-----VIEW================
        return redirect('/communitypost/'.$post->id)->with('success', 'Post succesvol gewijzigd');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Communitypost::find($id);
        $post->delete();
        return redirect('/communitypost')->with('success', 'Post succesvol gewijzigd');
    }
    
    public function searchComm(Request $request){
        $data = $request->json()->all();  
        if(!empty($data["term"])){
            if($data["diff"] == 1){
                $postqueryUserId = User::where('name', 'like', '%'.$data["term"].'%')->select('id')->get();
                $postquery = Communitypost::whereIn('user_id', $postqueryUserId)->get();
            }else{
                $postquery = Communitypost::where('title', 'like', '%'.$data["term"].'%')->get();
            }
            return new Response($postquery, 200);  
        } 
    }       
}