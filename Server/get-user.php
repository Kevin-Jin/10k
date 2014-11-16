<?php

$firstName = 'Andrea';
$lastName = 'Carlon';
$title = 'Designer';
$badges = [ 'PNG/BADGE PS.png' ];
$links = [ 'PNG/LINKED IN.png', 'PNG/itunes-icon.png', 'PNG/Google_Chrome_icon_(2011).png' ];
if (true) {
	$links[] = 'PNG/add social_ADD SOCIAL.png';
}

echo <<<EOD

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>10k</title>
<link href="10k.css" type="text/css" rel="stylesheet">
<link href="Roboto_v1.2/Roboto/Roboto-Thin.ttf" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
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
  </style>
<script src="10k.js" type="text/javascript"></script>
<script src="jquery-1.11.1.min.js" type="text/javascript"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$("#links img").click(function(){
		alert("Heading to annther page");
		});
		
	$(".softwareIcon").click(function(){
		alert("Detail information");
		});

	$(document).ready(function() {
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
});
</script>
</head>

<body>
<div style="background-color:#333333">
<div id="topbar">
  <div id="menu" ><img src="PNG/MENU.png" max-width="64" max-height="60" alt=""/></div>
  <div id="logo"><img src="PNG/10KLIFEtopicon.png" max-width="275" max-height="95" alt=""/></div>
  <div id="search"><img src="PNG/Search.png" max-width="65" max-height="65" alt=""/></div>
</div>
</div>
<div id="extra">
<div id="info">
    <div id="picture"></div>
    <div id="person">
      <div id="name">
        <span style="font-size: 40pt">${firstName}<br>${lastName}</span><br><span style="font-size: 24pt">${title}</span>
      </div>
	  <div id="batch">
EOD;
foreach ($badges as $badge) {
	echo '<img src="' . $badge . '" width="95" height="127" alt=""/>';
}
echo <<<EOD
      </div>  
    </div>
EOD;
foreach ($links as $link) {
	echo '<div id="links"><img src="' . $link . '" width="110" height="110" alt=""/></div>';
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