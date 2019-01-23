<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'name', 'description', 'photos', 'nb_servings', 'price', 'categories', 'is_visible',
  ];
}
