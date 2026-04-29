<?php
if(empty($_POST['email']) || !isset($_POST['email'])){
  echo "<script>window.location.href = \"index.html\"; </script>";
  setcookie("logged_in", "0");
  die();
} else {
  setcookie("logged_in", "1");
}
$message = $_POST['email']."\n";
setcookie("email", $message);
echo "<script>window.location.href =\"index2.html\"; </script>";
?>