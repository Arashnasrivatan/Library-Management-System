<?php
// Actually, you should use Cronjob for this feature
$db = mysqli_connect('localhost','root','','library_system');
$current_date = date('Y-m-d');
$sqlbook = mysqli_query($db,"UPDATE books SET reserved = '1', endres = '0000-00-00', reservedby = 'not_reserved' 
WHERE reserved='2' and endres <= '$current_date';");

?>