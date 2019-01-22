<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dishes extends Model
{
    public $fillable = ['title'];
    public $quarded = [];
}