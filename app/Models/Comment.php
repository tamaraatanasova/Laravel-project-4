<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id', 'discussion_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function discussion() {
        return $this->belongsTo(Discussion::class);
    }
}
