<?php
ini_set("session.cookie_httponly", True);
session_start();
$errMsg = "An error have occured please try again later or contact an admin";
$expire = 1800;
	if (isset($_SESSION['lastAction']) && $_SESSION['tokenAddUser'] == $_POST['tokenAddUser'] || 1 == 1){
		unset($_SESSION['tokenAddUser']);
		unset($_SESSION['tokenAddUserTime']);
		$inactive = time() - $_SESSION['lastAction'];
		if ($inactive >= $expire && 1 == 2){
			session_unset();
			session_destroy();
			header("location:login");
		}
		else{
            echo "1";
			$_SESSION['lastAction'] = time();
			require_once ('database.php');
            $sql = "SELECT * FROM Users WHERE Email = ? OR Username = ?;";
            if ($result = selectFromSQL("ss", [$_POST['email'], $_POST['username']], $sql)){
                if (mysqli_fetch_assoc($result)){
                    $msg = $lang == 'ar' ? "اسم المستخدم او البريد الالكتروني مضاف مسبقاً" : "The username or/and email address already exist";
                    header("location: addUser?col=3&msg=" . $msg);
                }
                else{
                    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $query = "INSERT INTO Users (Role, FirstName, LastName, Email, Username, UserPass) VALUES (?,?,?,?,?,?);";
                    $params = [$_POST['role'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['username'], $passwordHash];
                    if (insertToSQL("isssss", $params, $query)){
                        $msg = "The user was added successfully";
                        header("location: Users?col=1&msg=" . $msg);
                    }
                    else{
                        header("location: addUser?col=3&msg=" . $errMsg . ": 2");
                    }
                }
            }
            else{
                header("location: addUser?col=3&msg=" . $errMsg . ": 1");
            }
        }
		$conn->close();
	}

?>