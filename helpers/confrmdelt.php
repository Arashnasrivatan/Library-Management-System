<?php
include('../db.php');
$bookid = $_POST['bookid'];
$bookname = $_POST['bookname'];
$bookimg = $_POST['bookimg'];
if(isset($_POST['confirmbtn'])){

$sql = mysqli_query($db,"UPDATE books SET confirmed='1' WHERE bookid='$bookid';");
header('Location: ../admin/index.php?res=The \''.$bookname.'\' book has been verified successfully');

}elseif(isset($_POST['deletebtn'])) {
$sqldelete = mysqli_query($db,"DELETE FROM books where bookid='$bookid';");
header('Location: ../admin/index.php?res=The \''.$bookname.'\' book was successfully deleted');
if($bookimg <> 'assets/uploadsnotfound.png'){unlink('../'.$bookimg.'');}
}elseif(isset($_POST['bookdeletebtn'])){
     $sqlbookdelete = mysqli_query($db,"DELETE FROM books where bookid='$bookid';");
     header('Location: ../admin/books.php?res=The \''.$bookname.'\' book was successfully deleted');
     if($bookimg <> 'assets/uploadsnotfound.png'){unlink('../'.$bookimg.'');}
}else{
     header('Location: ../index.php');
}




?>