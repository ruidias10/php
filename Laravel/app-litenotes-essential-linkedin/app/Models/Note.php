<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Note extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $fillable = ['title', 'text', 'user_id'];

    // guarded = campos que não podem ser preenchidos
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function user()
    {
        // relacionamento N:1
        return $this->belongsTo(User::class);
    }
}
