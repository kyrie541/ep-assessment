<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    //
    protected $fillable = ['title', 'description', 'required_skills'];
    protected $casts = ['required_skills' => 'array'];
}
