		
		<script src="assets/js/vendor/jquery.js"></script>
		<script src="assets/js/foundation.min.js"></script>
		<script src="assets/js/fingerprint.js"></script>
		<script>
			$(document).foundation();

			var $finger = $('input[name=fingerprint]');
			var $uagent = $('input[name=uagent]');

			if ($finger.length) { $finger.val(new Fingerprint().get({canvas: true})); }
			if ($uagent.length) { $uagent.val(navigator.userAgent); }
		</script>
	</body>
</html>