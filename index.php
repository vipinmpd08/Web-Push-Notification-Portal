<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>HTML5 Form</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/jquery.placeholder.js"></script>
<script src="js/jquery.form.js"></script>
<link rel="stylesheet" href="css/style.css">
<script>
$(function(){
$('#contact').validate({
submitHandler: function(form) {
    $(form).ajaxSubmit({
    url: 'process.php',
    success: function() {
    $('#contact').hide();
    $('#contact-form').append("<p class='thanks'>Thanks! Your request has been sent.</p>")
    }
    });
    }
});         
});
</script>
</head>

<body>

    <h1>Send Your Notification</h1>
    <span id="wn-unsupported" class="hidden">API not supported</span>

	<div id="contact-form">	

	<form id="contact" method="post" action="">
		<fieldset>	
			<h2>Your Details</h2>
			<label for="name">Name</label>
			<input type="text" name="name" placeholder="Full Name" title="Enter your name" class="required">

			<label for="email">E-mail</label>
			<input type="email" name="email" placeholder="yourname@domain.com" title="Enter your e-mail address" class="required email">
			
			<label for="website">Website</label>
			<input type="url" name="url" placeholder="http://">
			
			<br><br>
			<h2>Notification Details</h2>
			<label for="title">Title:</label>
			<input type="text" id="title" name="title" class="required" />

			<label for="body">Body:</label>
			<textarea id="body" name="body" class="required"></textarea>
		  
			<h2>Logs</h2>
			<div id="log"><i>trigger the transaction to see logs here</i></div>
			
			<a id="clear-log" class="button">Clear log</a>
			<button id="button-wn-show-preset" class="button">Preset Notification</button>
			<input type="submit" id="button-wn-show-custom" class="button" value="Show Notification" />

	</fieldset>
	</form>

	
</div><!-- /end #contact-form -->

<script src="js/modernizr-min.js"></script>

<script>
	if (!Modernizr.input.placeholder){
		$('input[placeholder], textarea[placeholder]').placeholder();
	}
</script>

    <script>
      if (!('Notification' in window)) {
        document.getElementById('wn-unsupported').classList.remove('hidden');
        document.getElementById('button-wn-show-preset').setAttribute('disabled', 'disabled');
        document.getElementById('button-wn-show-custom').setAttribute('disabled', 'disabled');
      } else {
        var log = document.getElementById('log');
        var notificationEvents = ['onclick', 'onshow', 'onerror', 'onclose'];

        function notifyUser(event) {
          var title;
          var options;

          event.preventDefault();

          if (event.target.id === 'button-wn-show-preset') {
            title = 'Email received';
            options = {
              body: 'You have a total of 3 unread emails',
              tag: 'preset',
              icon: 'http://www.audero.it/favicon.ico'
            };
          } else {
            title = document.getElementById('title').value;
            options = {
              body: document.getElementById('body').value,
              tag: 'custom'
            };
          }

          Notification.requestPermission(function() {
            var notification = new Notification(title, options);

            notificationEvents.forEach(function(eventName) {
              notification[eventName] = function(event) {
                log.innerHTML = 'Event "' + event.type + '" triggered for notification "' + notification.tag + '"<br />' + log.innerHTML;
              };
            });
          });
        }

        document.getElementById('button-wn-show-preset').addEventListener('click', notifyUser);
        document.getElementById('button-wn-show-custom').addEventListener('click', notifyUser);
        document.getElementById('clear-log').addEventListener('click', function() {
          log.innerHTML = ''; 
        });
      }
    </script>
	
</body>
</html>