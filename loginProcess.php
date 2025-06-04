<?php
ini_set("session.cookie_httponly", True);
session_start();
require_once('database.php');
if (isset($_POST['Login'])){

	if(empty($_POST['uName']) || empty($_POST['pass'])){
		header("location:Login?Empty=1");
	}
	else{

		//The following statement is just an example and the sql can be changed based on required action (e.g. delete from, select from)
		//The if statement will only be true if the sql is correct to avoid any errors unaccounted for
		if ($stmt = $conn->prepare("SELECT * FROM Users WHERE Username = ? OR Email = ?;")){

			//The first parameter is to define the data type (s for string, i for integer and d for double)
			//The following will execute the sql statement and then close the statement for security
			$stmt->bind_param("ss", $_POST['uName'], $_POST['uName']);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if ($values = mysqli_fetch_assoc($result)){
				if (password_verify($_POST['pass'], $values['UserPass'])){
					if ($values['Role'] != "0"){
						$_SESSION['userID'] = $values['ID'];
						$_SESSION['user']=$_POST['uName'];
						$_SESSION['role']=$values['Role'];
						$_SESSION['lastAction'] = time();
						header("location: Home.php");
					}
					else{
						header("location:Login?Invalid=1");
					}
				}
				else{
					header("location:Login?Invalid=1");
				}
			}
			else{
				header("location:Login?Invalid=1");
			}

			$conn->close();
		}
		else {
			//In case there is an sql error, the following statements will execute
			header("location:Login?Empty=1");
		}
	}

}

	

?>