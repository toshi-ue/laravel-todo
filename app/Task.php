<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // [Laravel 9 投稿CRUD 機能を作成 〜 投稿を保存 | logsuke](https://logsuke.com/web/programming/laravel/laravel-post-save)
    protected $guarded = ['id', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
