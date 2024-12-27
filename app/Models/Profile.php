<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'phone', 'address', 'date_of_birth', 'bio'];
    //    protected $guarded =['user_id']; not allowed

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
