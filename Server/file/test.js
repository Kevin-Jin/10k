$(document).ready(function() {
	function runEffect() {
		// get effect type from
		var selectedEffect = $( "#effectTypes" ).val();
		// most effect types need no options passed by default
		var options = {};
		// some effects have required parameters
		if ( selectedEffect === "scale" ) {
		options = { percent: 0 };
		} else if ( selectedEffect === "size" ) {
		options = { to: { width: 200, height: 60 } };
		}
		// run the effect
		$( "#effect" ).hide( selectedEffect, options, 1000, callback );
	};
	// body...
	$(".click-part").click(function(){
		alert($(".search-input").val());
	});
	$("#login-btn").click(function(){
		$( ".user-reg" ).hide("drop",{ direction: "right" },"slow");
		$(".search").hide("drop",{ direction: "right" },"slow");
		$("#reg-btn").hide("drop",{ direction: "left" },"slow");
		$("#login-btn").hide("drop",{ direction: "right" },"slow",function(){
			$( ".user-login" ).removeAttr( "style" ).hide().fadeIn();
			//$( "#reg" ).removeAttr( "style" ).hide().fadeIn();
		});
	});
	$("#reg-btn").click(function(){
		$( ".user-login" ).hide("drop",{ direction: "right" },"slow");
		$(".search").hide("drop",{ direction: "right" },"slow");
		$("#reg-btn").hide("drop",{ direction: "left" },"slow");
		$("#login-btn").hide("drop",{ direction: "right" },"slow",function(){
			$( ".user-reg" ).removeAttr( "style" ).hide().fadeIn();
			//$( "#reg" ).removeAttr( "style" ).hide().fadeIn();
		});
	});
	$("#login").click(function() {
		// body...
		$("#login-btn").click();
	});
	$("#register").click(function() {
		// body...
		$.post("register.php",{
			username:$("#reg-username").val(),
			password:$("#reg-password").val(),
		},
		function(data){
			if (data == "1") {
				$( ".text-field" ).html("<strong>SUCCESS !!</strong>").addClass( "ui-state-highlight" );;
				$("#login-btn").click();
			}
			else {
				$( ".text-field" ).html("<strong>ALREADY USERNAME</strong>").addClass( "ui-state-highlight" );;
			}
		});
	});
	$("#login").click(function() {
		// body...
		$.post("login.php",{
			username:$("#username").val(),
			password:$("#password").val(),
		},
		function(data){
			if (data == 1) {
				window.location.href = 'get-user.php';
			}
			else {
				$( ".text-field" ).html("<strong>INCORRECT USERNAME OR PASSWORD</strong>").addClass( "ui-state-highlight" );;
			}
		});
	});
});