<?php
require_once 'database.php';

if (isset($_GET['user'])) {
	$user = $_GET['user'];
} else if (isset($_COOKIE['user'])) {
	$user = $_COOKIE['user'];
} else {
	header("Location: .");
	die();
}

$con = makeDatabaseConnection();
$ps = $con->prepare("SELECT `id`,`username`,`firstname`,`lastname`,`title`,`avatar` FROM `user` WHERE `username` = ? OR `id` = ?");
$ps->bind_param('ss', $user, $user);
if (!$ps->execute()) {
	header("Location: http://" . $_SERVER['HTTP_HOST']);
	die();
}
$rs = $ps->get_result();
if (!($array = $rs->fetch_array())) {
	header("Location: http://" . $_SERVER['HTTP_HOST']);
	die();
}
$userId = $array[0];
$userName = $array[1];
$firstName = $array[2];
$lastName = $array[3];
$title = $array[4];
$avatar = $array[5];

$selfProfile = false;
if (isset($_COOKIE['user']) && $userName == $_COOKIE['user']) {
	$selfProfile = true;
}

if (!$title)
	$title = '';
if ($avatar)
	$avatar = '<img src="' . $avatar . '" alt=""/>';
else
	$avatar = '';
if ($selfProfile)
	$avatar = '<a href="changepic.php" style="width: 100%; height: 100%; display: block">' . $avatar . '</a>';

$ps = $con->prepare("SELECT `s`.`badge` FROM `info` `i` LEFT JOIN `software` `s` ON `s`.`shortname` = `i`.`software` WHERE `i`.`userid` = ? AND `i`.`time` >= 10000 * 60 * 60 * 1000 AND `s`.`badge` IS NOT NULL");
$ps->bind_param('i', $userId);
$badges = [ ];
if ($ps->execute()) {
	$rs = $ps->get_result();
	while ($array = $rs->fetch_array()) {
		$badges[] = $array[0];
	}
}

$ps = $con->prepare("SELECT `l`.`network`, `l`.`url`,`s`.`icon` FROM `links` `l` LEFT JOIN `socialnetworks` `s` ON `s`.`shortname` = `l`.`network` WHERE `l`.`userid` = ? AND `s`.`icon` IS NOT NULL");
$ps->bind_param('i', $userId);
$links = [ ];
if ($ps->execute()) {
	$rs = $ps->get_result();
	while ($array = $rs->fetch_array()) {
		$links[$array[0]] = ['url' => $array[1], 'img' => $array[2]];
	}
}
if ($selfProfile) {
	$links[] = ['url' => 'newlink.php', 'img' => 'PNG/add social_ADD SOCIAL.png'];
}

echo <<<EOD

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>10k</title>
<link href="10k.css" type="text/css" rel="stylesheet">
<link href="Roboto_v1.2/Roboto/Roboto-Thin.ttf" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="jquery-ui.css">
  <style>
  .ui-progressbar {
    position: relative;
  }
  .progress-label {
    position: absolute;
    top: 4px;
    font-weight: bold;
    text-shadow: 1px 1px 0 #fff;
	width: 100%;
	text-align:center;
  }
  #popup select, #popup input {
	font-size: 100%;
  }
  </style>
  <script src="jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="file/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="jquery.jqplot.1.0.8r1250/dist/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="jquery.jqplot.1.0.8r1250/dist/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="jquery.jqplot.1.0.8r1250/dist/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
        <link rel="stylesheet" href="css/jquery-ui.min.css">
        <link rel="stylesheet" href="css/jquery-ui.theme.min.css">
        <link rel="stylesheet" href="css/jdialog.css?v=2.0">
        
        <script type="text/javascript" src="jqModal.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="jqModal.css" />


<script src="10k.js" type="text/javascript"></script>

<script type="text/javascript">
	var selfProfile = ${selfProfile};

	$(document).ready(function() {
		$('#fade').on('click', function(e) {
			$('#fade').css('display', 'none');
		});

		$('#popup').on('click', function(e) {
			e.stopPropagation();
		});

		$(document).on('keydown', function(e) {
			if (e.which == 27)
				$('#fade').css('display', 'none');
		});

		$("#links a").click(function(e){
			if ($(this).attr('href') == 'newlink.php') {
				$.get($(this).attr('href'), function(data) {
					$('#fade').css('display', 'block');
					$('#popup').html(data);
				});
				e.preventDefault();
			}
		});
			
		$(".softwareIcon").click(function(){
			alert("Detail information");
		});
		$('#picture a').click(function(e){
			$.get($(this).attr('href'), function(data) {
				$('#fade').css('display', 'block');
				$('#popup').html(data);
			});
			e.preventDefault();
		});

		var progressbar = $( "#progressbar" ),
		  progressLabel = $( ".progress-label" );
	 
		progressbar.progressbar({
		  value: false,
		  change: function() {
			progressLabel.text( progressbar.progressbar( "value" ) + "%" );
		  },
		  complete: function() {
			progressLabel.text( "Complete!" );
		  }
		});

		//progressbar.progressbar( "value", 10 );
		$.get('get-user-information.php', function(data) {
			$('#statistics').html(data);
		});
	});
</script>
</head>

<body>
<div id="fade" style="font-family: Roboto-Thin, sans-serif; display: none; left: 0; top: 0; width: 100%; height: 100%; position: fixed; background: rgba(0, 0, 0, 0.5)"><div id="popup" style="font-size: 200%; position: fixed; margin: auto; width: 50%; left:0; right: 0; top: 0; bottom: 0; height: 50%; background: white; padding: 15px"></div></div>
<div style="background-color:#333333">
<div id="topbar">
  <div id="menu" ><img src="PNG/MENU.png" max-width="64" max-height="60" alt=""/></div>
  <div id="logo"><img src="PNG/10KLIFEtopicon.png" max-width="275" max-height="95" alt=""/></div>
  <div id="search"><img src="PNG/Search.png" max-width="65" max-height="65" alt=""/></div>
</div>
</div>
<div id="extra">
<div id="info">
    <div id="picture">${avatar}</div>
    <div id="person">
      <div id="name">
        <span style="font-size: 50pt">${firstName}<br>${lastName}</span><br><span style="font-size: 24pt">${title}</span>
      </div>
	  <div id="batch">
EOD;
foreach ($badges as $badge) {
	echo '<img src="' . $badge . '" width="64" height="86" alt=""/>';
}
echo <<<EOD
      </div>  
    </div>
EOD;
foreach ($links as $link) {
	echo '<div id="links"><a href="' . $link['url'] . '"><img src="' . $link['img'] . '" width="96" height="96" alt=""/></a></div>';
}
echo <<<EOD
</div>
<div id="content">
  <div id = "statistics"> 
 <div id="progressbar"><div class="progress-label">Loading...</div></div>
  </div>  
</div>
</div>
</body>
</html>

EOD;

?>