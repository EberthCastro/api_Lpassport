<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'tech',
        'cover',
        'url_deploy',
        'url_github', 
        'user_id'       
    ];
}
