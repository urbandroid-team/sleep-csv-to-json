<!DOCTYPE html>

<html>
<head>

<title>Convert CSV to JSON</title>

<style type="text/css">
@media (prefers-color-scheme: light) {
	:root {
		--background: #ffffff;
		--background_button: #8ccd8e;
		--color: #030f16;
		--color_link: #2166cf;
		--color_red: #970606;
		--color_blue: #064397;
		--color_green: #06970a;
	}
}


@media (prefers-color-scheme: dark) {
	:root {
		--background: #191c1f;
		--background_button: #103d15;
		--color: #f7f9fb;
		--color_link: #659ff0;
		--color_red: #f64646;
		--color_blue: #4690f6;
		--color_green: #46f657;
	}
}



html {
	margin: 0;
	padding: 0;
}

body {
	background-color: var(--background);
	color: var(--color);
	font-family: 'Clear Sans', sans-serif;
	font-size: 0.920rem;
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
	border: 0;
	border-radius: 3px;
	font-family: 'Clear Sans', sans-serif;
	font-size: 0.920rem;
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

header {
	font-size: 1.580rem;
	font-weight: 700;
	line-height: 2rem;
	margin: 0 0 10px 0;
	padding: 0;
}

form {
	align-items: center;
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	margin: 30px 20px;
}

p#made-by {
	margin-top: 10px;
	opacity: .5;
}

p#made-by > a {
	color: var(--color);
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







@media only screen and (max-width: 660px), only screen and (max-device-width: 660px) {

	body {
		padding: 25px 30px;
		width: calc(100% - (30px * 2));
	}

}



@media only screen and (max-width: 476px), only screen and (max-device-width: 476px) {

	input[type="submit"] {
		margin-top: 10px;
	}

}
</style>

<script src="jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {


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

<link rel="stylesheet" href="//brick.freetls.fastly.net/Clear+Sans:400,700/Ubuntu:400">
<link href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQEAYAAABPYyMiAAAABmJLR0T///////8JWPfcAAAACXBIWXMAAABIAAAASABGyWs+AAAAF0lEQVRIx2NgGAWjYBSMglEwCkbBSAcACBAAAeaR9cIAAAAASUVORK5CYII=" rel="icon" type="image/x-icon">

<meta name="viewport" content="initial-scale=1.0, user-scalable=no">



</head>
<body>







<?php


	echo '<header>';
		echo 'Convert sleep data CSV file to JSON';
	echo '</header>';

	echo '<p>Sleep as Android normally outputs your sleep data in CSV format. If you want to have it in a more human-readable JSON format, you can convert it here.</p>';
	echo '<p>To download your CSV file from Sleep as Android, tap <b>Backup</b> in the left menu drawer and choose <b>Export data</b>. The CSV can be found in /sleep-data/sleep-export.csv on your internal memory.</p>';


	echo '<form action="javascript:void(0)" method="POST" enctype="multipart/form-data" autocomplete="off">';

		echo '<div class="message"></div>';
		echo '<input type="file" name="file" accept=".csv">';
		echo '<input type="submit" name="button-upload" value="Upload">';

	echo '</form>';


	echo '<p id="privacy">The file is converted on the fly, your data is deleted from the server right after the conversion. The convertor is open-source (<a href="https://github.com/urbandroid-team/sleep-csv-to-json" target="_blank">see the source</a>) so you can take a look yourself, or run it on your server/local computer.</p>';
	echo '<p id="made-by">Made by <a href="https://airikr.me/lang:en" target="_blank">Erik</a>. Check out his other project, the weather service <a href="https://serenum.org/" target="_blank">Serenum</a>.</p>';


?>







</body>
</html>
