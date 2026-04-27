<?php
// logout.php — encerra a sessão e redireciona para login
session_start();
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;