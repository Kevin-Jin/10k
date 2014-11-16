<?php
require_once 'database.php';

function displayForm() {
	echo
<<<EOD
<form method="POST" action="newlink.php"><select name="network"><option value="LinkedIn">LinkedIn</option><option value="GitCafe">GitCage</option><option value="BE">BE</option></select><label for="networkurl" style="margin-right: 10px">URL:</label><input type="text" id="networkurl" name="networkurl" style="margin-right: 10px" /><input type="submit" value="Submit" /></form>
EOD;
}

function setValue() {
	$con = makeDatabaseConnection();
	$ps = $con->prepare("INSERT INTO `links` (`userid`,`network`,`url`) SELECT `id`,?,? FROM `user` WHERE `username` = ?");
	$ps->bind_param('sss', $_POST['network'], $_POST['networkurl'], $_COOKIE["user"]);
	$points = [ ];
	$ps->execute();
	$ps->close();
	$con->close();

	header("Location: get-user.php");
}

if (empty($_COOKIE['user'])) {
	header("Location: .");
	die();
} else if (empty($_POST['networkurl']) || empty($_POST['network'])) {
	displayForm();
} else {
	setValue();
}

?>