<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'content',
        'status',
    ];

    /**
     * 一対多のリレーション設定
     * (一)Users.id <=> (多)Tasks.user_id
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
