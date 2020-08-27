<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function story()
    {
    	return $this->hasMany(Story::class);
    }
}
