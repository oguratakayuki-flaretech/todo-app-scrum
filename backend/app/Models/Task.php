<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ★1. この行があるか確認（無ければ追加）
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory; // ★2. クラスの中にこの1行を追加します！
    
    // データベースの「title」という項目をプログラムから自動で書き換えることを許可します
    protected $fillable = ['title'];
}