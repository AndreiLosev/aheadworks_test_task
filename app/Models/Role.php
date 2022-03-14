<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $value
 */

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    public $timestamps = false;

    const id = 'id';
    const value = 'value';

    public function users()
    {
        return $this->hasMany(User::class, User::role_id, self::id);
    }
}
