<?php include("UserAuth.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            include("htmlHead.html");
        ?>
        <link href="stylesheet.css" rel="stylesheet">
    </head>
    <body>
        <div class="mainHeader mb-3">
            <?php
                include("Header.php");
            ?>
        </div>
        <div class="content">
            <?php
                include "notifications.php";
            ?>
            <div class="container">
                <div class="row text-center">
                    <h1 class="display-4">Users</h1>
                </div>
                <div class="row text-center my-3">
                    <table class="mainTable table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                            <th scope="col">Email</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                                require_once('database.php');
                                $query = 'SELECT ID, FirstName, LastName, Email, Role FROM Users;';
                                $result = $conn->query($query);
                                while ($row = $result->fetch_assoc()){
                                    $id = $row['ID'];
                                    $firstName = htmlspecialchars($row['FirstName'], ENT_QUOTES, 'UTF-8');
                                    $lastName = htmlspecialchars($row['LastName'], ENT_QUOTES, 'UTF-8');
                                    $email = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');
                                    $role = htmlspecialchars($row['Role'], ENT_QUOTES, 'UTF-8');
                                    $seq = 1;
                                    switch($role){
                                        case "1":
                                            $roleName = "Admin";
                                            break;
                                        case "2":
                                            $roleName = "Editor";
                                            break;
                                        case "3":
                                            $roleName = "Viewer";
                                            break;
                                    }
                                    
                                    echo '<tr>
                                    <td>' . $seq . '</td>
                                    <td>' . $firstName . ' ' . $lastName . '</td>
                                    <td>' . $roleName . '</td>
                                    <td>' . $email . '</td>
                                    <td><a href="editUser?id=' . $id . '" class="btn btn-sm myBtn">Edit</a></td>
                                    </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="Footer containter-fluid">
            <?php
                include  ("Footer.php");
            ?>
        </div>
    </body>
</html>
