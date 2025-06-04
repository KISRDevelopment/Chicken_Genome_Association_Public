<?php
    include("UserAuth.php");
    include 'tokensReset.php';
	$randomToken = random_bytes(20);
	$_SESSION['tokenAddUser'] = bin2hex($randomToken);
	$_SESSION['tokenAddUserTime'] = time();
?>
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
                    <h1 class="display-4">Add User</h1>
                </div>
                <form action="addUserDB" name="addUser" method="POST">
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstName" placeholder="E.g. John">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastName" placeholder="E.g. Doe">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="E.g. John@Doe.com">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label>Role</label>
                            <select class="form-control" name="role">
                                <option value="1">Admin</option>
                                <option value="2">Editor</option>
                                <option value="3">Viewer</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-4">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" placeholder="E.g. Doe1991">
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="row my-3 text-center">
                        <input type="submit" name="submit" class="btn btn-md myBtn btn-submit mx-auto" value="Add User">
                    </div>
                </form>
            </div>
        </div>
        <div class="Footer containter-fluid">
            <?php
                include  ("Footer.php");
            ?>
        </div>
    </body>
</html>
