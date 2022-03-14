<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property string $uid
 * @property string $subject
 * @property string $user_name
 * @property string $user_email
 * @property Message $message
 */
class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    const id = 'id';
    const login = 'uid';
    const password = 'subject';
    const token = 'user_name';
    const user_email = 'user_email';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    public function message()
    {
        return $this->hasMany(Message::class, Message::ticket_id, self::id);
    }
}
