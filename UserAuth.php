<?php
	ini_set("session.cookie_httponly", True);
	session_start();
	$expire = 1800;
	if (isset($_SESSION['lastAction'])){
		$inactive = time() - $_SESSION['lastAction'];
		if ($inactive >= $expire){
			session_unset();
			session_destroy();
		}
		else{
			$_SESSION['lastAction'] = time();
		}
	}
	else{
		//header("location:login");
	}
	if (isset($_SESSION['user'])){
		require_once('database.php');
		$pageName = strtolower(basename($_SERVER['PHP_SELF'], ".php"));
		$query = 'SELECT * FROM Users WHERE ID = ?';
		$stmt = $conn->prepare($query);
		$stmt->bind_param('i', $_SESSION['userID']);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = mysqli_fetch_assoc($result);
        $role = $row['Role'];
		switch ($pageName){
			case "addBreed":
				if ($role != "1" && $role != "2"){
					header("location:login");
				}
				break;
            case "editBreed":
                if ($role != "1" && $role != "2"){
                    header("location:login");
                }
                break;
            case "addGene":
                if ($role != "1" && $role != "2"){
					header("location: Dashboard");
				}
				break;
            case "editGene":
                if ($role != "1" && $role != "2"){
                    header("location: Dashboard");
                }
                break;
            case "addSNP":
                if ($role != "1" && $role != "2"){
					header("location: Dashboard");
				}
				break;
            case "editSNP":
                if ($role != "1" && $role != "2"){
                    header("location: Dashboard");
                }
                break;
            case "addTraitValue":
                if ($role != "1" && $role != "2"){
					header("location: Dashboard");
				}
				break;
            case "editTraitValue":
                if ($role != "1" && $role != "2"){
                    header("location: Dashboard");
                }
                break;
            case "addUser":
                if ($role != "1"){
                    header("location: Dashboard");
                }
                break;
            case "editUser":
                if ($role != "1"){
                    header("location: Dashboard");
                }
                break;
            case "Users":
                if ($role != "1"){
					header("location: Dashboard");
				}
				break;
            case "User":
                if ($role != "1"){
					header("location: Dashboard");
				}
				break;
            case "editUser":
                if ($role != "1"){
					header("location: Dashboard");
				}
				break;
		}
	}
	else{
		//header("location:login");
	}
?>