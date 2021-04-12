<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class CommentsController extends Controller
{
    function saveComment(Request $request, $id) {
        $this->validate($request, [
            'comment'=>'required'
        ]);
        $comment = new Comments;
        $comment->userId = Auth::user()->getId();
        $comment->postId = $id;
        $comment->comment = $request-> input('comment');
        $comment->save();
        return redirect('/product/view/' .$id)->with('success','Komentaras buvo paskelbtas.');

    }

    public function deleteComment($id) {
        $userid = Auth::user()->getId();
        $comments = Comments::find($id);
        $comments->delete();
        return redirect('/product/view/'.$comments->postId)->with('success','Komentaras buvo paskelbtas.');
    }

    public function viewFeedbackPage($id) {
        $feedback = DB::table('feedback')
            -> where(['userId' => $id])
            -> get();
        $user = DB::table('users')
            -> where(['id' => $id])
            -> get();
        $commentUser = DB::table('users')
            ->select('users.id', 'users.name')
            ->join('feedback', 'feedback.commenterId', '=', 'users.id')
            ->get();
        return view('user.feedback', ['feedback'=>$feedback, 'user'=>$user, 'commentUser'=>$commentUser]);
    }

    function commentOnPerson(Request $request, $id) {
        $this->validate($request, [
            'feedback'=>'required'
        ]);
        $feedback = new Feedback;
        $feedback->commenterId = Auth::user()->getId();
        $feedback->userId = $id;
        $feedback->feedback = $request-> input('feedback');
        $feedback->save();
        return redirect('/feedback/' .$id)->with('success','Atsiliepimas buvo paskelbtas.');
    }

    public function deleteFeedback($id) {
        $feedback = Feedback::find($id);
        $userid = $feedback->userId;
        $feedback->delete();
        return redirect('/feedback/'.$userid)->with('success','Atsiliepimas buvo ištrintas.');
    }
}
