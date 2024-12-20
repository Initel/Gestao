<?php


if (!isset($_SESSION["id"])) {
  header("Location: loginout.php");
  exit;
}

if (isset($_REQUEST["logout"]) && $_REQUEST["logout"] == true) {
  sleep(3);
  session_destroy();
  header("Location: index.php");
  exit;
}
?>