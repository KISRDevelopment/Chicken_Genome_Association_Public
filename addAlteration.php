<?php
    include("UserAuth.php");
    include 'tokensReset.php';
	$randomToken = random_bytes(20);
	$_SESSION['tokenAddSNP'] = bin2hex($randomToken);
	$_SESSION['tokenAddSNPTime'] = time();
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
                    <h1 class="display-4">Add SNP</h1>
                </div>
                <form action="#" name="addSNP" method="POST">
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-6">
                            <label>Tag before</label>
                            <input type="text" class="form-control" name="tagBefore">
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label>Tag after</label>
                            <input type="text" class="form-control" name="tagAfter">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-4">
                            <label>Location</label>
                            <input type="text" class="form-control" name="Locatioj">
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Gene</label>
                            <select class="form-control" name="breedType">
                                <option value="A">Gene A</option>
                                <option value="B">Gene B</option>
                                <option value="C">Gene C</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Breed</label>
                            <select class="form-control" name="breedType">
                                <option value="A">Breed A</option>
                                <option value="B">Breed B</option>
                                <option value="C">Breed C</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-3 text-center">
                        <input type="submit" name="submit" class="btn btn-md myBtn btn-submit mx-auto" value="Add SNP">
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
