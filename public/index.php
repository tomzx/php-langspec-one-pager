<html>
<head>
	<meta charset="UTF-8">
	<title>PHP LangSpec</title>

	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,700|Inconsolata|Raleway:200">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<div class="container">
	<?php

	define('APP_ROOT', realpath(__DIR__.'/..'));

	require_once APP_ROOT.'/vendor/autoload.php';

	$files = glob(APP_ROOT.'/spec/*.md');
	foreach ($files as $file) {
		$filename = basename($file);
		$content = file_get_contents($file);
		$content = preg_replace('/\]\(#/', '](#'.$filename.'/', $content); // Convert internal links to external links
		$content = preg_replace('/\]\((.+)#/', '](#$1/', $content); // External links
		$content = Michelf\MarkdownExtra::defaultTransform($content);
		$content = preg_replace_callback('/<(h[1-6])>(.*)<\/\1>/', function($input) use ($filename) {
			$title = strip_tags($input[2]);
			$link = $filename.'/'.strtolower(str_replace(' ', '-', $title));
			return '<'.$input[1].' id="'.$link.'">'.$input[2].'</'.$input[1].'>';
		}, $content);
		echo $content;
	}
	?>
	</div>
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>

