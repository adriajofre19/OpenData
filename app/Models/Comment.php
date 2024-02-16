<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idequipament',
        'content',
        'assessment',
        'id_user',
    ];

    /**
     * Get the users associated with the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get comments by equipment ID.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCommentsById($id) {
        return self::where('idequipament', $id)
        ->join('users', 'comments.id_user', '=', 'users.id')
        ->select('comments.*', 'users.name')
        ->get();
    }

    /**
     * Get comments by user ID.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getCommentsByIdUser($id) {
        return Comment::where('id_user', $id)->get();
    }

    /**
     * Add a new comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Comment
     */
    public static function addComment($request) {
        $userId = auth()->id();

        return Comment::create([
            'idequipament' => $request->idequipament,
            'id_user' => $userId,
            'content' => $request->content,
            'assessment' => $request->assessment,
        ]);
    }
}