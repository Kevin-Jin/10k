<?php
require_once 'database.php';

function getResult() {
	$con = makeDatabaseConnection();
	$ps = $con->prepare("SELECT 1 FROM `user` WHERE `username` = ?");
	$ps->bind_param('s', $_POST["username"]);
	if ($ps->execute() && !$ps->get_result()->fetch_array()) {
		$ps = $con->prepare("INSERT INTO `user` (`username`,`password`) VALUES (?, ?)");
		$passhash = crypt($_POST['password'], 'rl');
		$ps->bind_param('ss', $_POST["username"], $passhash);
		if ($ps->execute()) {
			return "1";
		}
	}
	return "0";
}

echo getResult();
?>