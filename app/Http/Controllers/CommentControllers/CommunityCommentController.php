<?php

namespace App\Http\Controllers\CommentControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Comment;
use App\Communitypost;

use App\Http\Requests;

class CommunityCommentController extends Controller
{
     public function store(Request $request, $post_id)
    {
        $this->validate($request, array(
            'comment'   =>  'required|min:5|max:2000'
            ));
        
        $post = Communitypost::find($post_id);
       
        $comment = new Comment();
        $comment->content = $request->comment;
        $comment->user_id = auth()->user()->id;
        $comment->nieuwspost_id = NULL;
        $comment->communitypost()->associate($post);
        $comment->save();
        
        
        return redirect('/communitypost/'.$post_id)->with('post', $post)->with('success', 'Comment geplaatst');
    }
    
       public function destroy($id)
    {
        $comment = Comment::find($id);
        $cpid = $comment->communitypost_id;
        $comment->delete();
        return redirect('/communitypost/'.$cpid)->with('success', 'Comment succesvol verwijderd');
    }
    
}