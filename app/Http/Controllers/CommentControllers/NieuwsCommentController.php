<?php

namespace App\Http\Controllers\CommentControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Comment;
use App\Nieuwspost;

use App\Http\Requests;

class NieuwsCommentController extends Controller
{
     public function store(Request $request, $post_id)
    {
        $this->validate($request, array(
            'comment'   =>  'required|min:5|max:2000'
            ));
        
        $post = Nieuwspost::find($post_id);
       
        $comment = new Comment();
        $comment->content = $request->comment;
        $comment->user_id = auth()->user()->id;
        $comment->communitypost_id = NULL;
        $comment->nieuwspost()->associate($post);
        $comment->save();
        
        
        return redirect('/nieuwsposts/'.$post_id)->with('post', $post)->with('success', 'Comment geplaatst');
    }
    
       public function destroy($id)
    {
        $comment = Comment::find($id);
        $npid = $comment->nieuwspost_id;
        $comment->delete();
        return redirect('/nieuwsposts/'.$npid)->with('success', 'Comment succesvol verwijderd');
    }
    
}