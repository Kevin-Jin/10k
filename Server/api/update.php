<?php
require_once '../database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die('Not authorized');
}

$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: application/json');

$con = makeDatabaseConnection();
$ps = $con->prepare("INSERT INTO `info` (`userid`,`software`,`time`,`clicks`,`keystrokes`) SELECT `id`,?,?,?,? FROM `user` WHERE `username` = ? ON DUPLICATE KEY UPDATE `time` = `time` + ?, `clicks` = `clicks` + ?, `keystrokes` = `keystrokes` + ?");
foreach ($data as $app=>$stats) {
	if ($app == 'user') continue;
	$ps->bind_param('siiisiii', $app, $stats['times'], $stats['clicks'], $stats['keys'], $data['user'], $stats['times'], $stats['clicks'], $stats['keys']);
	$ps->execute();
}
$ps->close();
$con->close();

echo json_encode([
	'success' => true
]);
?>