<?php
	session_start();
	var_dump($_SESSION);
	// if($_POST['secureCode'] == $_SESSION['security_code']) {
	// 	echo 'OK';
	// }else {
	// 	echo 'FAIL';
	// }
?>
<div id="lower_group">
<form action="index_3.php" method="post">
	<img src="captcha.php" id="captcha">
	<input type="text" class="form-control" name="secureCode" placeholder="Проверочный код">
	<a id="refresh" href="javascript:void(0);" onclick="document.getElementById('captcha').src='captcha.php?'+ Math.random()">Обновить</a>
	<input type="submit">
</form>
</div>