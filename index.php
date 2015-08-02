<?php
require_once("config.php");

$button_restart_vnc = "";

if (isDesktop()) {
	$button_restart_vnc = '
<div class="row">
<button type="button" id="refreshvnc" class="btn btn-warning center-block" aria-label="Refresh VNC">
  <span class="glyphicon glyphicon-refresh" aria-hidden="true">&nbsp;Refresh VNC</span>
</button>
</div>
<br/>';
}

$buttons = '<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Controls</h3>
  </div>
  <div class="panel-body">

<div class="row">
          <div class="input-group-btn center-block">
            <button type="button" class="btn btn-success" id="sleep"><span class="glyphicon glyphicon-leaf" aria-hidden="true">&nbsp;Sleep Viewer</button>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
	      <li><a href="javascript:loadLink(\'sleep\')">Sleep Now</a></li>
	      <li><a href="javascript:loadLink(\'sleep-5\')">Sleep in 5 min</a></li>
	      <li><a href="#javascript:loadLink(\'sleep-15\')">Sleep in 15 min</a></li>
	      <li><a href="#"javascript:loadLink(\'sleep-30\')>Sleep in 30 min</a></li>
	      <li><a href="#"javascript:loadLink(\'sleep-45\')>Sleep in 45 min</a></li>
	      <li><a href="#"javascript:loadLink(\'sleep-60\')>Sleep in 1 hour</a></li>
	      <li role="separator" class="divider"></li>
	      <li><a href="javascript:loadLink(\'sleep-clear\')">Clear Planned Sleep</a></li>
            </ul>
          </div>
</div>
<br/>
<div class="row">
<button type="button" id="services" class="btn btn-warning center-block" aria-label="Restart Services">
  <span class="glyphicon glyphicon-refresh" aria-hidden="true">&nbsp;Restart Services</span>
</button>
</div>
<br/>
' . $button_restart_vnc . '
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
<br/>
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
</div>';

function isDesktop() {
	return (strpos($_SERVER['HTTP_USER_AGENT'], "Android") === FALSE) && (strpos($_SERVER['HTTP_USER_AGENT'], "iOS") === FALSE) && (strpos($_SERVER['HTTP_USER_AGENT'], "Web Launcher") === FALSE);
}
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
    <script src="js/bootstrap.min.js"></script>
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
      .btn, .input-group-btn {
        margin-left: 10px;
	border-radius: 0px;
      }
    </style>

    <script type="text/javascript">
      // focus the iframe
      function setFocusIframe() {
          var iframe = $("#vnc")[0];
          iframe.contentWindow.focus();
      }

      // set the iframe focus (must be done with setTimeout)
      function focusIframe() {
         setTimeout(setFocusIframe, 100);
      }

      function loadLink(link) {
        $.ajax({
	  type: "POST",
	  url: "launcher.php",
	  data: { url: link }
	})
	  .done(function( msg ) {
                focusIframe();
	  });  
      }

      function refreshVNC() {
           $("#vnc").attr("src", $("#vnc").attr("src"));
           focusIframe();
      }

      $( document ).ready(function() {
         $("#download").click(function() {
           document.location.href="<?php echo $DOWNLOAD_LINK; ?>";
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
         $("#sleepdropdown").click(function() {
           $(".dropdown-toggle").dropdown('toggle');
         });
         $("#services").click(function() {
           loadLink("services");
           setTimeout(refreshVNC, 5000);
	 });
         $("#close").click(function() {
           loadLink("close");
	 });
	$("#refreshvnc").click(function() {
	   refreshVNC();
	});

        // focus on iframe so keyboard events are passed to VNC session
        focusIframe();
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
      </div>
      <br/>
      <?php } ?>
    <?php } ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title text-center"><b>Name:</b> <?php echo $VIEWER_HOST; ?></h3>
  </div>
  <div class="panel-body">

<?php if (isDesktop()) { ?>

      <div class="row">
    <div class="col-md-10 center-block" id="vncwrapper">
    <div style="width:<?php echo $VIEWER_VNC_WIDTH; ?>px;margin-left:auto;margin-right:auto">
    <p class="text-center"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Keyboard not working? Click the blue bar below to capture the keyboard input</p>
  <iframe id="vnc" src="noVNC/vnc_auto.html?host=<?php echo $VIEWER_HOST; ?>&port=5901&resize=true" width="<?php echo $VIEWER_VNC_WIDTH; ?>px" height="<?php echo $VIEWER_VNC_HEIGHT; ?>px"></iframe> 
    <?php echo $buttons; ?>
    </div>
    </div>
    <div class="col-md-2">
  <?php } else { ?>
     <div><div>
  <?php } ?>
    <ul class="list-group">
      <?php foreach ($links as $title => $url) { ?>
      <li class="list-group-item"><a href="javascript:void();" onclick="loadLink('<?php echo $url; ?>');"><?php echo $title; ?></a></li>
      <?php } ?>
    </ul>
    </div>
    </div>
  </div>
</div>

<?php if (!isDesktop()) { 
	echo $buttons;
} ?>
<div class="text-center" id="footer">&copy; <?php echo date("Y"); ?> <a href="http://www.avidandrew.com" target="_blank">Avid Andrew</a></div>
  </body>
</html>
