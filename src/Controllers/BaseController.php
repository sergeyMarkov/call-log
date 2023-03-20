<?php

namespace MyApp\Controllers;

class BaseController implements IDbConnection
{
	const INI_FILE = 'myapp.ini';

	public $db;

	public function __construct()
	{
		$this->db_open_connection();
	}

	public function db_open_connection()
	{
		if (!file_exists($this::INI_FILE)) {
			die('myapp.ini file not found');
		}
		// read ini file with the db credentials
		$conf = parse_ini_file($this::INI_FILE);
		$db = new \mysqli($conf['DB_HOST'], $conf['DB_USERNAME'], $conf['DB_PASSWORD'], $conf['DB_DATABASE']);
		if ($db->connect_errno) {
			die($db->connect_error);
		} else {
			$this->db = $db;
		}
	}


	public function show($templateFile, $_data = null)
	{
		require __DIR__ . '/../resources/templates/' . $templateFile . '.php';
	}


	public function db_query($sql)
	{
		$result = [];
		try {
			if ($queryResult = $this->db->query($sql)) {
				while ($row = $queryResult->fetch_object()) {
					$result[$row->id] = $row;
				}
			} else {
				throw new \Exception($this->db->error);
			}
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
		return $result;
	}

	public function db_execute_query($sql)
	{
		return $this->db->query($sql);
	}

	public function db_close_connection()
	{
		$this->db->close();
	}

	function __destruct()
	{
		$this->db_close_connection();
	}
}
