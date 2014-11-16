<?php
require_once 'database.php';

function displayForm() {
	echo
<<<EOD
<form method="POST" action="changepic.php"><label for="profpicurl" style="margin-right: 10px">URL:</label><input type="text" id="profpicurl" name="profpicurl" style="margin-right: 10px" /><input type="submit" value="Submit" /></form>
EOD;
}

function setValue() {
	$con = makeDatabaseConnection();
	$ps = $con->prepare("UPDATE `user` SET `avatar` = ? WHERE `username` = ?");
	$ps->bind_param('ss', $_POST['profpicurl'], $_COOKIE["user"]);
	$points = [ ];
	$ps->execute();
	$ps->close();
	$con->close();

	header("Location: get-user.php");
}

if (empty($_COOKIE['user'])) {
	header("Location: .");
	die();
} else if (empty($_POST['profpicurl'])) {
	displayForm();
} else {
	setValue();
}

?>