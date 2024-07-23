<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Picture extends Model
{
    protected $fillable = ['name','user_id','path','extension'];

    protected $appends = ['full_path'];

    public function getFullPathAttribute(): \Illuminate\Foundation\Application|string|\Illuminate\Contracts\Routing\UrlGenerator|\Illuminate\Contracts\Foundation\Application
    {
        return url(Storage::url($this->path));
    }

    public function user(){

        return $this->belongsTo(User::class);
    }
}
