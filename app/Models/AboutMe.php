<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMe extends Model
{
    use HasFactory;

    protected $table = 'about_me'; // Specify the correct table name

    protected $fillable = ['content', 'status']; // Include any fillable fields
}
