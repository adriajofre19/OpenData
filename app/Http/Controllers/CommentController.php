<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Retrieve comments by their ID.
     *
     * @param  int  $id
     * @return mixed
     */
    public function getCommentsById($id) {
        $comment = new Comment();
        return $comment->getCommentsById($id);
    }

    /**
     * Add a new comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function addComment(Request $request) {
        $addComment = Comment::addComment($request);
    }
}