<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
	protected $fillable = [
		'activity',
		'activity_detail',
		'status',
		'income',
		'outcome',
		'user_id',
	];

}
