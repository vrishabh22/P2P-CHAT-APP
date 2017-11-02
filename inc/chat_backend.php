<?php

include('connection.php');
include('functions.php');

session_start();
// sessioncheck should be equal to the name of the user who logged in
$sessioncheck = $_SESSION['loggedin'];
if (empty($sessioncheck)) {
	header('location: login.php');
}
// getting username from the session
$result = $db->query("SELECT * from users WHERE username = '$sessioncheck'");
$row = $result->fetch(PDO::FETCH_ASSOC);
// save the userId of the user who logged in, which can then be used as userOneId
$loggedinUserId = $row['userId'];
$q = intval($_GET['q']);

$messages = get_messages($loggedinUserId, $q);
$messages_reverse = array_reverse($messages);
echo json_encode(array_values($messages_reverse));

