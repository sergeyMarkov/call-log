<?php

namespace MyApp\Models;

class CallDetailsModel
{
	public static function get($callId)
	{
		$sql = <<<SQL
			SELECT id, details, hours, minutes, DATE_FORMAT(h.date, '%Y-%m-%d') as date_formated
			FROM call_details h 
			WHERE h.call_id = $callId
		SQL;
		return $sql;
	}

	public static function storeNew($data)
	{
		list("call_id" => $call_id, "details" => $details, "hours" => $hours, "minutes" => $minutes) = $data;
		$date = date('Y-m-d H:i:s');

		$sql = <<<SQL
			INSERT INTO call_details(`call_id`, `date`, `details`, `hours`, `minutes`)
			VALUES("$call_id", "$date", "$details", "$hours", "$minutes")
		SQL;
		return $sql;
	}
}
