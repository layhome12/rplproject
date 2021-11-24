<?php
namespace App\Libraries;

class SelectBuilder {
	
	function __construct($data=[]) {
		$str = '';
		$db      = \Config\Database::connect();
		$builder = $db->table($data['table']);

		if(@$data['select']) 
			$builder = $builder->select($data['select']);

		if(@$data['val_id'] && @$data['val_text']) 
			$builder = $builder->select("$data[val_id] as id, $data[val_text] as text");

		if(@$data['where']) 
			$builder = $builder->where($data['where']);

		foreach ($builder->get()->getResult() ?: [] as $key => $value) {
			$selected = ($value->id == @$data['id']) ? 'selected=""' : '';
			$str .= "<option ".$selected." value=\"".$value->id."\">".$value->text."</option>".PHP_EOL;
		}

		echo $str;
	}

}