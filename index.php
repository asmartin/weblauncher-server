<?php
require_once("config.php");

// example links if included file doesn't contain any data
$links = array(
    "Example Link" => "http://www.google.com",
);

require_once("links.php");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $APP; ?></title>

    <!-- jQuery -->
     <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
      h2 {
        padding-left: 10px;
        padding-bottom: 15px;
      }
      .list-group-item a {
        display: block;
      }
      #customurl {
        width: 100%;
        padding-left: 5px;
      }
      #footer {
	padding-bottom: 20px;
      }
    </style>

    <script type="text/javascript">
      function loadLink(link) {
        $.ajax({
	  type: "POST",
	  url: "launcher.php",
	  data: { url: link }
	})
	  .done(function( msg ) {
	  });  
      }

      $( document ).ready(function() {
         $("#download").click(function() {
           document.location.href="<?php echo $DOWNLOAD_LINK; ?>";
         });
         $("#download-remote").click(function() {
           document.location.href="<?php echo $DOWNLOAD_REMOTE_LINK; ?>";
         });
         $("#custombtn").click(function() {
	   loadLink($("#customurl").val());
         });
         $("#reboot").click(function() {
           loadLink("reboot");
         });
         $("#sleep").click(function() {
           loadLink("sleep");
         });
         $("#mouse").click(function() {
           loadLink("mouse");
	 });
         $("#close").click(function() {
           loadLink("close");
	 });
      });
    </script>
  </head>
  <body>
    <?php if (strpos($_SERVER['HTTP_USER_AGENT'], "$APP") === FALSE) { ?>
      <h2><img src="icon.png" />&nbsp;<?php echo $APP; ?></h2>
<ul class="nav nav-list">
  <li class="divider"></li>
</ul>
      <?php if (strpos($_SERVER['HTTP_USER_AGENT'], "Android") !== FALSE) { ?>
      <div class="col-md-4 center-block">
        <div class="row">
          <button type="button" id="download" class="btn btn-info center-block" aria-label="Download App">
            <span class="glyphicon glyphicon-download" aria-hidden="true">&nbsp;Download App</span>
          </button>
        </div>
	<br/>
	<div class="row">
          <button type="button" id="download-remote" class="btn btn-info center-block" aria-label="Download App">
            <span class="glyphicon glyphicon-download" aria-hidden="true">&nbsp;Download Remote</span>
          </button>
        </div>
      </div>
      <br/>
      <?php } ?>
    <?php } ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Links</h3>
  </div>
  <div class="panel-body">
    <ul class="list-group">
      <?php foreach ($links as $title => $url) { ?>
      <li class="list-group-item"><a href="#" onclick="loadLink('<?php echo $url; ?>');"><?php echo $title; ?></a></li>
      <?php } ?>
    </ul>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Other Link</h3>
  </div>
  <div id="customlink" class="panel-body row">
      <div class="col-xs-1"><span class="span2 glyphicon glyphicon-globe"></span></div>
      <div class="col-xs-8"><input class="span2" id="customurl" type="text" placeholder="Custom URL"></div>
      <div class="col-xs-2"><button class="btn" id="custombtn" type="button">Go!</button></div>
  </div>
</div>
<br/>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Controls</h3>
  </div>
  <div class="panel-body">

<div class="col-md-4 center-block">
<div class="row">
<button type="button" id="sleep" class="btn btn-success center-block" aria-label="Sleep TV Streamer">
  <span class="glyphicon glyphicon-leaf" aria-hidden="true">&nbsp;Sleep Viewer</span>
</button>
</div>
<br/>
<div class="row">
<button type="button" id="mouse" class="btn btn-warning center-block" aria-label="Restart Mouse Server">
  <span class="glyphicon glyphicon-remove-circle" aria-hidden="true">&nbsp;Restart Mouse Server</span>
</button>
</div>
<br/>
<div class="row">
<button type="button" id="close" class="btn btn-warning center-block" aria-label="Close Browser">
  <span class="glyphicon glyphicon-remove-circle" aria-hidden="true">&nbsp;Close Browser</span>
</button>
</div>
<br/>
<div class="row">
<button type="button" id="reboot" class="btn btn-danger center-block" aria-label="Reboot TV Streamer">
  <span class="glyphicon glyphicon-off" aria-hidden="true">&nbsp;Reboot Viewer</span>
</button>
</div>
</div>
<br/>
</div>
</div>
<div class="text-center" id="footer">&copy; <?php echo date("Y"); ?> <a href="http://www.avidandrew.com" target="_blank">Avid Andrew</a></div>
  </body>
</html>
