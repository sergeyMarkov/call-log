<?php

namespace MyApp;

use MyApp\Controllers\CallController;

class Router
{
	public $routes = [];

	public function __construct()
	{
		$uri = explode('/', $_SERVER['REQUEST_URI']);
		$uri_part1 = (count($uri) > 1) ? $uri[1] : '';
		$uri_part2 = (count($uri) > 2) ? $uri[2] : '';
		$uri_part3 = (count($uri) > 3) ? $uri[3] : '';

		$callController = new CallController();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($_POST['new_call_header'] == 1) {
				$data = [
					'id' => isset($_POST['id']) ? filter_var($_POST['id']) : '0',
					'it_person' => isset($_POST['it_person']) ? filter_var($_POST['it_person']) : '',
					'user_name' => isset($_POST['user_name']) ? filter_var($_POST['user_name']) : '',
					'subject' => isset($_POST['subject']) ? filter_var($_POST['subject']) : '',
					'details' => isset($_POST['details']) ? filter_var($_POST['details']) : ''
				];
				$callController->storeNewHeader($data);
			}
			if ($_POST['new_call_details'] == 1) {
				$data = [
					'call_id' => isset($_POST['call_id']) ? filter_var($_POST['call_id']) : '0',
					'details' => isset($_POST['details']) ? filter_var($_POST['details']) : '',
					'hours' => isset($_POST['hours']) ? filter_var($_POST['hours']) : 0,
					'minutes' => isset($_POST['minutes']) ? filter_var($_POST['minutes']) : 0,
					'status' => isset($_POST['status']) ? filter_var($_POST['status']) : 'In Progress'
				];
				$callController->storeNewDetails($data);
			}
		}

		// routing
		switch ($uri_part1) {
			case "":
				echo $callController->index();
				break;
			case "add-call-header":
				echo $callController->newCallHeader();
				break;
			case "delete":
				echo $callController->deletebyId($uri_part2);
				break;
			case "filter":
				echo $callController->filterBy($uri_part2, $uri_part3);
				break;
			default:
				Header("Location: /");
				break;
		}
	}
}
