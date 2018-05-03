<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Nieuwspost;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class NieuwsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $pinned = Nieuwspost::orderBy('id','asc')->where('pinned', 1)->take(3)->paginate(3);
        $post = Nieuwspost::orderBy('id','desc')->where('pinned', 0)->paginate(10);
        return view('nieuwspage/nieuws')->with('nieuws', $post)->with('pinned', $pinned);                                     

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nieuwspage.create');
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
        $filename = $title.''.auth()->user()->id.'news.jpg';
        $update = false;
        
        if (Storage::disk('local')->exists($filename)) {
            $old_file = Storage::disk('local')->get($filename);
            
            Storage::disk('local')->put($filename, File::get($file));
            $update = true;
        }
        else if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        
        $post = new Nieuwspost;
        $post->user_id = auth()->user()->id;
        $post->image = $filename;
        $post->title = $request->input('titel');
        $post->content = $request->input('content');
        $post->save();
//        ==========-----NOTIFY MAIL================               
        $afzenderControl = "nieuwsposts";
        ContactController::notifyMail($post->user_id, $afzenderControl); //voor notificatie mail van aanmaak nieuwe post
//        ==========-----VIEW================
        return redirect('/nieuwsposts')->with('success', 'Nieuwspost succesvol gemaakt');
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
            $post = Nieuwspost::find($id);
            return view('nieuwspage.show')->with('post', $post);                     
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id)
    {
        $post = Nieuwspost::find($id);
        return view('nieuwspage.edit')->with('post', $post); 
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  

    public function update(Request $request, $id)
    {
        if((!$request->pinned) && (!$request->unpin)){
            $this->validate($request,[
                'titel' => 'required',
                'content' =>  'required',
                'image' => 'mimes:jpeg,jpg,bmp,png',
            ]);
//        ==========-----FOTO UPDATE================
        $file = $request->file('image');
       
        $title = trim($request->input('titel'));
     
        $filename = $title.''.auth()->user()->id.'news.jpg';
        
        
        if (Storage::disk('local')->exists($filename)) {

            Storage::disk('local')->put($filename, File::get($file));
  
        }
        
            $post = Nieuwspost::find($id);
            $post->image = $filename;
            $post->title = $request->input('titel');
            $post->content = $request->input('content');
        }elseif(!$request->unpin){
            $pinned = Nieuwspost::all()->where('pinned', 1);
            if(count($pinned)<3){
            $post = Nieuwspost::find($id);
            $post->pinned = 1;
            }else{
                return redirect('/nieuwsposts')->with('error', 'Er kunnen maximaal 3 post worden gepind');
            }
        }else{
            $post = Nieuwspost::find($id);
            $post->pinned = 0;
        }
            
        $post->save();
       
        return redirect('/nieuwsposts');

        if(!$request->pinned){
            return redirect('/nieuwsposts')->with('success', 'Post succesvol gewijzigd');
        }else{
             return redirect('/nieuwsposts')->with('success', 'Post succesvol vastgepint');
        }

    }

    public function destroy($id)
    {
        $post = Nieuwspost::find($id);
        $post->delete();
        return redirect('/nieuwsposts')->with('success', 'Post is verwijderd');
    }

    
    public function search(Request $request){
            $query = $request->json()->all()["term"];  
            if(!empty($query)){
                $postquery = Nieuwspost::where('title', 'like', '%'.$query.'%')                                               
                                               ->get();

                return new Response($postquery, 200);
            }
    }
}



