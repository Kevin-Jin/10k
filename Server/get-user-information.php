<?php
require_once 'database.php';

$con = makeDatabaseConnection();
$ps = $con->prepare("SELECT `i`.`time`, `i`.`clicks`, `i`.`keystrokes`, `s`.`displayname`, `s`.`icon` FROM `user` `u` LEFT JOIN `info` `i` ON `i`.`userid` = `u`.`id` LEFT JOIN `software` `s` ON `s`.`shortname` = `i`.`software` WHERE `u`.`username` = ?");
$ps->bind_param('s', $_COOKIE["user"]);
$points = [ ];
if ($ps->execute()) {
	$rs = $ps->get_result();
	while ($array = $rs->fetch_array()) {
		$points[] = ['time' => $array[0], 'clicks' => $array[1], 'keystrokes' => $array[2], 'displayname' => $array[3], 'icon' => $array[4]];
	}
}
$ps->close();
$con->close();

foreach ($points as $software) {
	echo 
<<<EOD
	<div class = "softwareIcon"><img src="${software['icon']}" width="165" height="165" alt=""/></div>
    <div class="softwareInfo">
      <div class="softwareName">${software['displayname']}</div>
      <div class="scoreBar"><img src="PNG/10k life  home mockup v3_LOG IN.png" width="500" height="80" alt=""/></div>
    </div>
EOD;
}
?>
