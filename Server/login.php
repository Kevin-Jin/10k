<?php
require_once 'database.php';

function getResult() {
	$con = makeDatabaseConnection();
	$ps = $con->prepare("SELECT `password` FROM `user` WHERE `username` = ?");
	$ps->bind_param('s', $_POST["username"]);
	if ($ps->execute()) {
		$rs = $ps->get_result();
		if ($array = $rs->fetch_array()) {
			if (crypt($_POST['password'], 'rl') === $array[0]) {
				setcookie("user", $_POST['username'], time()+3600);
				return "1";
			}
		}
	}
	return "0";
}

echo getResult();
?>