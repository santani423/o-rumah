<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListGroupChat extends Model
{
    use HasFactory;

    protected $table = 'listgroupchats';

    protected $fillable = [
        'groupchat_id',
        'user_id',
        'ads_id',
        'chat_id',
    ];

    /**
     * Relationship with GroupChat model.
     */
    public function groupChat()
    {
        return $this->belongsTo(GroupChat::class);
    }

    /**
     * Relationship with User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
