<?php
setcookie('id', '', -1, '/');
setcookie('namefull', '', -1, '/');
setcookie('email', '', -1, '/'); 
setcookie('username', '', -1, '/'); 
setcookie('password', '', -1, '/');
header("Location: ../loginregister.php");
exit;
?>