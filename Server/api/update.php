<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die('Not authorized');
}

$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: application/json');

if (empty($data['clicks']) && empty($data['keystrokes'])) {
	echo json_encode([
		'error' => 'Invalid request'
	]);
} else {
	echo json_encode([
		'clicks' => $data['clicks'],
		'keystrokes' => $data['keystrokes']
	]);
}
?>