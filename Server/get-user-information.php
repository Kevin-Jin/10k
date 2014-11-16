<?php
require_once 'database.php';

$con = makeDatabaseConnection();
$ps = $con->prepare("SELECT `i`.`time`, `i`.`clicks`, `i`.`keystrokes`, `s`.`displayname`, `s`.`icon`,`s`.`shortname` FROM `user` `u` LEFT JOIN `info` `i` ON `i`.`userid` = `u`.`id` LEFT JOIN `software` `s` ON `s`.`shortname` = `i`.`software` WHERE `u`.`username` = ?");
$ps->bind_param('s', $_COOKIE["user"]);
$points = [ ];
if ($ps->execute()) {
	$rs = $ps->get_result();
	while ($array = $rs->fetch_array()) {
		$points[] = ['time' => $array[0], 'clicks' => $array[1], 'keystrokes' => $array[2], 'displayname' => $array[3], 'icon' => $array[4],'shortname' => $array[5]];
	}
}
$ps->close();
$con->close();

foreach ($points as $software) {
	echo 
<<<EOD
	<div class = "softwareIcon"><img src="${software['icon']}" width="165" height="165" alt=""/></div>
    <div class="softwareInfo ${software['displayname']}" href="#${software['shortname']}" >
      <div class="softwareName">${software['displayname']}</div>
      <div id="${software['displayname']}"></div>
      <script>$(function(){

      	var tmp = ${software['time']}/10000*600;

		$( "#${software['displayname']}" ).attr("style","width:"+tmp+"px;").progressbar({
			value: false,
			complete: function() {
				progressLabel.text( tmp + "%" );
			},
		}).show("drop","left","slow")
		$(document).click(function(){
			$("#chart").attr("style","");
		});

		});
		</script>
		
		<div id="chart" style="display:none;"></div>
		<script>
			var plot1 = $.jqplot ('chart', [[3,7,9,1,4,6,8,2,5]]);
		</script>
		<div class="nani ">${software['time']} HOURS</div>

    </div>
EOD;

echo
<<<EOD
<div id="chart" style="display:none;"></div>
		<script>
			var plot1 = $.jqplot ('chart', [[3,7,9,1,4,6,8,2,5]]);
		</script>
EOD;
}
?>
