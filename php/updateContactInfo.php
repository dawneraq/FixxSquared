<?php
	session_start();

	$config = array(
		'DB_HOST'			=> 'localhost',
		'DB_USERNAME'	=> 'root',
		'DB_PASSWORD' => ''
	);

	if (isset($_POST['updateEmail']) || isset($_POST['updateResHall']) || isset($_POST['updateRoom'])) {
		echo updateContactInfo($config);
	}

	function updateContactInfo($config) {
		try {
			$connection = new PDO('mysql:host=localhost:3306', $config['DB_USERNAME'], $config['DB_PASSWORD']);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			if ($connection) {
				$result = "";
			}
			else {
				$error = "Unable to connect to database.";
			}
			
			if (isset($_POST['updateEmail']) && $_POST['updateEmail'] != '') {
				$statementUpdateEmail = $connection->prepare(
					"UPDATE fixx_squared.users
						SET username=:newEmail
						WHERE uid=:userId;"
				);
				
				$statementUpdateEmail->bindParam(':newEmail', $_POST['updateEmail']);
				$statementUpdateEmail->bindParam(':userId', $_SESSION['uid']);
				
				if ($statementUpdateEmail->execute()) {
					$result .= "Email address updated successfully.\n";
				};
			}
			
			if (isset($_POST['updateResHall']) && $_POST['updateResHall'] != '') {
				$statementUpdateResHall = $connection->prepare(
					"UPDATE fixx_squared.users
						SET residence_hall=:newResHall
						WHERE uid=:userId;"
				);
				
				$statementUpdateResHall->bindParam(':newResHall', $_POST['updateResHall']);
				$statementUpdateResHall->bindParam(':userId', $_SESSION['uid']);
				
				if ($statementUpdateResHall->execute()) {
					$result .= "Residence Hall updated successfully.\n";
				};
			}
			
			if (isset($_POST['updateRoom']) && $_POST['updateRoom'] != '') {
				$statementUpdateRoom = $connection->prepare(
					"UPDATE fixx_squared.users
						SET room=:newRoom
						WHERE uid=:userId;"
				);
				
				$statementUpdateRoom->bindParam(':newRoom', $_POST['updateRoom']);
				$statementUpdateRoom->bindParam(':userId', $_SESSION['uid']);
				
				if ($statementUpdateRoom->execute()) {
					$result .= "Room updated successfully.\n";
				};
			}
		}
		catch (PDOException $e) {
			$error = "PDO ERROR: ".$e->getMessage();
		}
		
		if (isset($error)) {
			return $error;
		}
		else if (isset($result)) {
			return $result;
		}
		
		return "ERROR: updateContactInfo failed";
	}
?>