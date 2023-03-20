<?php

namespace MyApp\Controllers;

interface IDbConnection
{
	public function db_open_connection();
	public function db_query($sql);
	public function db_execute_query($sql);
	public function db_close_connection();
}
