<?php
function get_messages($userOneId = null, $userTwoId = null, $limit = 15) {
	include("connection.php");
	try {
		$sql = "SELECT *
				FROM users
				JOIN messages ON messages.userOneId = users.userId
				WHERE (messages.userOneId = '$userOneId' AND messages.userTwoId = '$userTwoId')
					OR (messages.userOneId = '$userTwoId' AND messages.userTwoId = '$userOneId')
				ORDER BY messageId DESC
				LIMIT $limit;";
		$results = $db->prepare($sql);
		$results->execute();
	} catch (Exception $e) {
		echo "Problems occured. Please contact admin";
	}
	$messages = $results->fetchAll();
	return $messages;
}

function show_message_of_two_users($userOneId, $userTwoId, $limit=15) {
	$messages = get_messages($userOneId, $userTwoId, $limit);
	//array_reverse($messages);
	// reverse message to display last message at the end
	$messages_reverse = array_reverse($messages);
	// return json_encode(array_values($messages_reverse));
	return array_values($messages_reverse);
}

function send_message($userOneId, $userTwoId, $message) {
	include("connection.php");
	$message = addslashes($message);
	try {
		$sql = "INSERT INTO messages(userOneId, userTwoId, chatMessage) 
				VALUES ('$userOneId', '$userTwoId', '$message');";
		$db->query($sql);
	} catch (Exception $e) {
		echo $e->getMessage();
		echo "Bad query";
	}
}

function list_all_users($currentUser) {
	include("connection.php");
	try {
		$sql = "SELECT userId, username FROM users
				WHERE NOT userId = '$currentUser'
				";
		$results = $db->prepare($sql);
		$results->execute();
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	$allusers = $results->fetchAll();
	return $allusers;
}

function create_new_user($user, $password) {
	include("connection.php");
	try {
		$sql = "INSERT INTO users(username, password) VALUES ('$user', '$password');";
		if ($db->query($sql)) {
			echo "<script type= 'text/javascript'>alert('User Registration Successfully');</script>";
		} else{
			echo "<script type= 'text/javascript'>alert('Problems Occured. Please contact admin!');</script>";
		}
	} catch (Exception $e) {
		echo $e->getMessage();
		echo "Bad query";
	}
}

function login($username, $password) {
	include ("connection.php");
	try {
		$sql = "SELECT username FROM users WHERE username='$username' AND password = '$password'";
		$result = $db->query($sql);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		if ($row['username'] == $username) {
			$_SESSION['loggedin']=$username;
			header("location: chat-box.php");
		} else {
			echo "Username or Password is invalid";
		}
	} catch (Exception $e) {
		echo $e-> getMessage();
		echo "Please try again";
	}
}
