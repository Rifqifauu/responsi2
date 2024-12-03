<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balapan extends Model
{
    use HasFactory;

    protected $table = 'balapan';
    protected $fillable = ['nama_balapan', 'deskripsi'];
}