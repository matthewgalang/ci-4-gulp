<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to CodeIgniter 4!</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
	<?php print_assets($_SESSION['css_assets']) ?>
</head>
<body>

<div <?=className('componentOne', ['myClass'])?>>This should appear red</div>
<div <?=className('componentTwo', ['myClass'])?>>This should appear blue</div>
<p class="globalClass">I am a global class</p>
<div <?=className('componentThree', ['myClass'])?>>This should be font size 64px</div>


<?php if (ENVIRONMENT === 'development') { ?>
		<script src="http://localhost:35729/livereload.js"></script>
	<?php } ?>
</body>
</html>
