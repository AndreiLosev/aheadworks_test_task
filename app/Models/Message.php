<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;


/**
 * @property int $id
 * @property Role $author
 * @property Ticket $tiket
 * @property Collection<ServerCredentials>|null $serverCredentials
 * @property string $content
 */
class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    const id = 'id';
    const ticket_id = 'ticket_id';
    const author_id = 'author_id';
    const content = 'content';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    public function author()
    {
        return $this->belongsTo(Role::class, self::author_id, Role::id);
    }

    public function tiket()
    {
        return $this->belongsTo(Role::class, self::ticket_id, Role::id);
    }

    public function serverCredentials()
    {
        return $this->hasMany(serverCredentials::class, serverCredentials::message_id, self::id);
    }
}
