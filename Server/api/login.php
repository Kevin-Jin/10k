<?php
require_once '../database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die('Not authorized');
}

function getResult() {
	$data = json_decode(file_get_contents('php://input'), true);

	if (empty($data['username']) || empty($data['password'])) {
		return json_encode([
			'error' => 'Invalid request'
		]);
	} else {
		$con = makeDatabaseConnection();
		$ps = $con->prepare("SELECT `id`,`password`,`firstname`,`lastname` FROM `user` WHERE `username` = ?");
		$ps->bind_param('s', $data["username"]);
		if (!$ps->execute()) {
			return json_encode([
				'error' => 'Invalid username or password'
			]);
		}
		$rs = $ps->get_result();
		if (!($array = $rs->fetch_array())) {
			return json_encode([
				'error' => 'Invalid username or password'
			]);
		}
		if (crypt($data['password'], 'rl') !== $array[1]) {
			return json_encode([
				'error' => 'Invalid username or password'
			]);
		}
		$firstName = $array[2];
		$lastName = $array[3];
		$ps->close();
		$ps = $con->prepare("SELECT `software`, `time`, `clicks`, `keystrokes` FROM `info` WHERE `userid` = ?");
		$ps->bind_param('s', $array[0]);
		$points = [ ];
		if ($ps->execute()) {
			$rs = $ps->get_result();
			while ($array = $rs->fetch_array()) {
				$points[$array[0]] = ['time' => $array[1], 'clicks' => $array[2], 'keystrokes' => $array[3]];
			}
		}
		$ps->close();
		$con->close();
		return json_encode([
			'user' => $data['username'],
			'firstname' => $firstName,
			'lastname' => $lastName,
			'points' => $points
		]);
	}
}

header('Content-type: application/json');
echo getResult();
?>