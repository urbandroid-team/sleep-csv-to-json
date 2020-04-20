<!DOCTYPE html>

<html>
<head>


<!--  TITEL  -->
<title>Convert CSV to JSON</title>

<!-- STILMALL -->
<style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap');

@media (prefers-color-scheme: light) {
	:root {
		--hue_blue: 210;
		--hue_yellow: 50;
		--hue_green: 110;
		--hue_red: 10;
		--background: hsl(var(--hue_blue), 10%, 99%);
		--background_input: hsl(var(--hue_blue), 10%, 90%);
		--background_button: hsl(var(--hue_green), 80%, 85%);
		--color: hsl(var(--hue_blue), 10%, 15%);
		--color_link: hsl(var(--hue_blue), 80%, 5%);
		--color_red: hsl(var(--hue_red), 80%, 30%);
		--color_blue: hsl(var(--hue_blue), 80%, 30%);
		--color_green: hsl(var(--hue_green), 80%, 30%);
	}
}


@media (prefers-color-scheme: dark) {
	:root {
		--hue_blue: 210;
		--hue_yellow: 50;
		--hue_green: 110;
		--hue_red: 10;
		--background: hsl(var(--hue_blue), 10%, 5%);
		--background_input: hsl(var(--hue_blue), 10%, 10%);
		--background_button: hsl(var(--hue_green), 80%, 10%);
		--color: hsl(var(--hue_blue), 10%, 95%);
		--color_link: hsl(var(--hue_blue), 80%, 85%);
		--color_red: hsl(var(--hue_red), 80%, 70%);
		--color_blue: hsl(var(--hue_blue), 80%, 70%);
		--color_green: hsl(var(--hue_green), 80%, 70%);
	}
}



html {
	margin: 0;
	padding: 0;
}

body {
	background-color: var(--background);
	color: var(--color);
	font-family: 'Source Sans Pro', sans-serif;
	font-size: 0.960rem;
	font-weight: 400;
	margin: 0 auto;
	padding: 50px 0;
	overflow-y: scroll;
	width: 600px;
}



a {
	color: var(--color_link);
}

p {
	margin: 0;
	padding: 5px 0;
}

input {
	background-color: var(--backgroun_input);
	border: 0;
	border-radius: 3px;
	color: hsl(210, 10%, 10%);
	font-family: 'Source Sans Pro', sans-serif;
	font-size: 0.860rem;
	font-weight: 400;
	padding: 5px;
	line-height: 15px;
}

input[type="submit"] {
	background-color: var(--background_button);
	color: var(--color);
	margin-left: 10px;
	padding: 8px 10px;
}

form {
	margin-top: 50px;
}

header {
	font-size: 1.580rem;
	font-weight: 700;
	margin-bottom: 10px;
}

#made-by {
	margin-top: 50px;
	opacity: .5;
}



.message {
	display: none;
	margin-bottom: 15px;
}

.color-red {
	color: var(--color_red);
}

.color-blue {
	color: var(--color_blue);
}

.color-green {
	color: var(--color_green);
}



.NFI-wrapper {
	vertical-align: middle;
}

.NFI-button {
	padding: 5px 10px;
}

.NFI-filename {
	background-color: var(--background_input);
	border: 0;
	border-radius: 2px;
	color: var(--color);
	height: 30px;
}







@media only screen and (max-width: 840px), only screen and (max-device-width: 840px) {

	body {
		padding: 25px 30px;
		width: calc(100% - (30px * 2));
	}

}







@media only screen and (max-width: 375px), only screen and (max-device-width: 375px) {

	input[type="submit"] {
		margin-top: 10px;
	}

}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
!function(a){a.fn.nicefileinput=function(t){var e={label:"Browse...",fullPath:!1};return t&&a.extend(e,t),this.each(function(){var t=this;if(void 0===a(t).attr("data-styled")){var l=Math.round(1e4*Math.random()),r=new Date,i=r.getTime()+l.toString(),n=a('<input type="text" readonly="readonly">').css({display:"block","float":"left",margin:0,padding:"0 5px"}).addClass("NFI-filename NFI"+i),s=a("<div>").css({overflow:"hidden",position:"relative",display:"block","float":"left","white-space":"nowrap","text-align":"center"}).addClass("NFI-button NFI"+i).attr("disabled",a(t).attr("disabled")).html(e.label);a(t).after(n),a(t).wrap(s),a(".NFI"+i).wrapAll('<div class="NFI-wrapper" id="NFI-wrapper-'+i+'" />'),a(".NFI-wrapper").css({overflow:"auto",display:"inline-block"}),a("#NFI-wrapper-"+i).addClass(a(t).attr("class")),a(t).css({opacity:0,position:"absolute",border:"none",margin:0,padding:0,top:0,right:0,cursor:"pointer",height:"60px"}).addClass("NFI-current"),a(t).on("change",function(){var l=a(t).val();if(e.fullPath)n.val(l);else{var r=l.split(/[/\\]/);n.val(r[r.length-1])}}),a(t).attr("data-styled",!0)}})}}(jQuery);

$(document).ready(function() {


	$('[type="file"]').nicefileinput({
		label: 'Browse'
	});


	// 
	$('body').on('click', '[name="button-upload"]', function() {
		$('.message').show().removeClass('color-red').removeClass('color-blue');

		if($('[type="file"]').val() == '') {
			$('.message').addClass('color-red').text('Please choose a file first.');

		} else {
			$.ajax({
				url: 'convert.php',
				method: 'POST',
				beforeSend: function() {
					$('.message').addClass('color-blue').text('Please wait - working...');
				},

				success: function(s) {
					$('.message').addClass('color-green').text('Your file has been converted.');
					$('form')[0].reset();
					window.location = 'download.php?file=' + s;
				},

				data: new FormData($('form')[0]),
				cache: false,
				contentType: false,
				processData: false
			});
		}
	})


});
</script>

<meta name="viewport" content="initial-scale=1.0, user-scalable=no">



</head>
<body>







<?php


	echo '<header>';
		echo 'Convert sleep data CSV file to JSON';
	echo '</header>';

	echo '<p>Sleep as Android normally outputs your sleep data in CSV format. If you want to have them in a more human-friedly JSON format, you can convert it here.</p>';
	echo '<p>To download your CSV file from Sleep as Android, tap <i>Backup</i> in the left menu drawer and choose <i>Export data</i>. The CSV can be found in /sleep-data/sleep-export.csv on your internal memory.</p>';



	echo '<form action="javascript:void(0)" method="POST" enctype="multipart/form-data" autocomplete="off">';

		echo '<div class="message"></div>';
		echo '<input type="file" name="file" accept=".csv">';
		echo '<input type="submit" name="button-upload" value="Upload">';

	echo '</form>';

	echo '<p id="made-by">Made by Erik. Check out his other project - the weather service <a href="https://serenum.org/" target="_blank">Serenum</a>.</p>';


?>







</body>
</html>
