<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $token
 * @property Role $role
 */

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    const id = 'id';
    const login = 'login';
    const password = 'password';
    const token = 'token';
    const created_at = 'created_at';
    const updated_at = 'updated_at';
    const role_id = 'role_id';

    public function role()
    {
        return $this->belongsTo(Role::class, self::role_id, Role::id);
    }

    public function verify(string $token): bool
    {
        $result = self::where(self::token, $token)->exists();

        return $result;
    }
}
