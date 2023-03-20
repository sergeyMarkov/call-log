<?php

namespace MyApp\Controllers;

use MyApp\Models\CallDetailsModel;
use MyApp\Models\CallModel;

class CallController extends BaseController
{
	public function index()
	{
		$this->show('list', $this->db_query(CallModel::getAll()));
	}

	public function filterBy($field, $value)
	{
		$calls = $this->db_query(CallModel::getAll($field, $value));
		foreach ($calls as $idx => $call) {
			$calls[$idx]->details = $this->db_query(CallDetailsModel::get($idx));
		}
		$this->show('view_details', [
			'calls' => $calls,
		]);
	}

	public function deletebyId($id)
	{
		$this->db_query(CallModel::deleteById($id));
	}

	public function newCallHeader()
	{
		$this->show('new_call_header');
	}

	public function storeNewHeader($data)
	{
		$r = $this->db_query(CallModel::generateNewId());
		$data['id'] = $r ? reset($r)->id : 0;
		$this->db_execute_query(CallModel::storeNew($data));
	}

	public function storeNewDetails($data)
	{
		$this->db_execute_query(CallDetailsModel::storeNew($data));
		$this->db_execute_query(CallModel::updateStatus($data));
	}
}
