<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupChat extends Model
{
    use HasFactory;

    protected $table = 'groupchats';

    protected $fillable = [
        'user_id',
        'message',
        'image',
        'sent_at',
    ];

    /**
     * Relationship with User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with ListGroupChat model.
     */
    public function listGroupChats()
    {
        return $this->hasMany(ListGroupChat::class);
    }
}
