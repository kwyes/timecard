<?php
	unset($_SESSION['timecardID']);
	session_destroy();
	echo "<script>location.href='/'</script>"
?>
