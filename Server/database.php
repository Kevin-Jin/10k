<?php

function makeDatabaseConnection() {
	return new mysqli("localhost", "root", "", "hacker");
}

?>