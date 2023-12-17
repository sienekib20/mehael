<?php

namespace Sienekib\Mehael\Http\Json;

trait Jsonable
{
	public function get_contents()
	{
		$contents = file_get_contents('php://input');

		return json_decode($contents);
	}
}