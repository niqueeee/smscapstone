<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class School extends Model
{
	public $timestamps = false;
	public static $storeRule = [
	'strSchoDesc' => 'required|unique:schools,description|max:100',
	'abbreviation' => 'required|max:10',
	'intSystID' => 'exists:gradings,id',
	];
	public static function updateRule($id)
	{
		return $rules = [
		'strSchoDesc' => 'required|unique:schools,description,'.$id.'|max:100',
		'abbreviation' => 'required|max:10',
		'intSystID' => 'exists:gradings,id',
		];
	} 
}
