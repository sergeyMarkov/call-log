<?php

namespace MyApp\Models;

class CallModel
{
	public static function getAll($filter_by_name = '', $filter_by_value = '')
	{
		$sql_select_from = <<<SELECTFROM
			SELECT * FROM v_calls
		SELECTFROM;
		$sql_where = '';
		switch ($filter_by_name) {
			case "call_id":
				$sql_where = " id = " . $filter_by_value;
				break;
			case "user_name":
				$sql_where = " user_name = '" . $filter_by_value . "'";
				break;
			case "date":
				$sql_where = " date_formated = '" . $filter_by_value . "'";
				break;
		}
		$sql = $sql_select_from . ($sql_where ? ' WHERE ' . $sql_where : '');
		return $sql;
	}

	public static function get($id)
	{
		$sql = <<<SQL
			SELECT 
				h.id,
				h.it_person, 
				h.user_name, 
				h.subject,
				h.details as header_details,
				DATE_FORMAT(SEC_TO_TIME(SUM(d.hours*60 + d.minutes)*60), '%H') as total_hours,
				DATE_FORMAT(SEC_TO_TIME(SUM(d.hours*60 + d.minutes)*60), '%i') as total_minutes,
				DATE_FORMAT(h.date, '%Y-%m-%d') as date_formated,
				h.status
			FROM call_headers h
			LEFT JOIN call_details d on h.id = d.call_id
			WHERE h.id = $id
		SQL;
		return $sql;
	}

	public static function deleteById($id)
	{
		$sql = <<<SQL
			DELETE
			FROM call_headers
			WHERE id = $id
		SQL;
		return $sql;
	}

	public static function generateNewId()
	{
		$sql = <<<SQL
			SELECT COALESCE(ch1.id, 0)+1 as id
			FROM call_headers ch1
			LEFT JOIN call_headers ch2 on ch2.id = ch1.id +1
			WHERE ch2.id IS NULL
			ORDER BY ch1.id 
			LIMIT 1
		SQL;
		return $sql;
	}

	public static function storeNew($data)
	{
		list("id" => $id, "it_person" => $it_person, "user_name" => $user_name, "subject" => $subject, "details" => $details) = $data;
		$date = date('Y-m-d H:i:s');
		$sql = <<<SQL
			INSERT INTO call_headers(`id`, `date`, `it_person`, `user_name`, `subject`, `details`)
			VALUES("$id", "$date", "$it_person", "$user_name", "$subject", "$details")
		SQL;
		return $sql;
	}

	public static function updateStatus($data)
	{
		list("call_id" => $call_id, "status" => $status) = $data;
		$sql = <<<SQL
		UPDATE call_headers 
		SET status = "$status"
		WHERE id = $call_id
		SQL;
		return $sql;
	}
}
