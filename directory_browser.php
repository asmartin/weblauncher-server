<?php

$page_title=ucwords(basename(getcwd()));

function removeExtension($filename) {
	$temp = explode('.', $filename);
	$ext  = array_pop($temp);
	$name = implode('.', $temp);
	return $name;
}

function renderPlayer($filename) {
	$title = removeExtension($filename);

	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $title; ?></h3>
		</div>
		<div class="panel-body">
			<video class="video-js vjs-default-skin" controls preload="auto" width="640" height="264" data-setup='{}'>
			  <source src="<?php echo $filename; ?>" type='video/mp4'>
			  <p class="vjs-no-js">
			    To view this video please enable JavaScript, and consider upgrading to a web browser
			    that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
			  </p>
			</video>
		</div>
	</div>
<?php } ?>
<html>
	<head>
		<!-- video.js - https://github.com/videojs/video.js -->
		<link href="http://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
		<script src="http://vjs.zencdn.net/4.12/video.js"></script>

		<!-- bootstrap -->
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<title><?php echo $page_title; ?></title>
	</head>
	<body>

		<div class="row">
			<div class="center-block" style="width:672px">
				<div class="page-header"><h1><?php echo $page_title; ?></h1></div>
				<ol class="breadcrumb">
				<?php
					$parts = explode(DIRECTORY_SEPARATOR, getcwd());
					for ($i = 0; $i < count($parts); $i++) {
						if ($i + 2 == count($parts)) {
							// allow navigating to parent directory
							echo "<li><a href='../'>" . $parts[$i] . "</a></li>";		
						} else if ($i + 1 == count($parts)) {
							// only display text
							echo "<li class='active'>" . $parts[$i] . "</li>";		
						}
					}
				?>
				</ol>
				<?php
					$videos = glob('*.{m4v,M4V,mp4,MP4,vob,VOB,flv,FLV,mpg,MPG,mpeg,MPEG,mov,MOV}', GLOB_BRACE);
					foreach ($videos as $video) {
						renderPlayer($video);
					}
				?>
			</div>
		</div>
	</body>
</html>
