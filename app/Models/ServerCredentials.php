<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property Message $message
 * @property string $ftp_login
 * @property string $ftp_password
 */
class ServerCredentials extends Model
{
    use HasFactory;

    protected $table = 'server_credentials';
    public $timestamps = false;

    const id = 'id';
    const message_id = 'message_id';
    const ftp_login = 'ftp_login';
    const ftp_password = 'ftp_password';

    public function message()
    {
        return $this->belongsTo(Message::class, self::message_id, Message::id);
    }
}
