<?php
    include("UserAuth.php");
    include 'tokensReset.php';
	$randomToken = random_bytes(20);
	$_SESSION['tokenAddGene'] = bin2hex($randomToken);
	$_SESSION['tokenAddGeneTime'] = time();
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
                    <h1 class="display-4">Add Gene</h1>
                </div>
                <form action="#" name="addGene" method="POST">
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Name</label>
                            <input type="text" class="form-control" name="geneName" placeholder="Gene name">
                        </div>
                    </div>
                    <div class="row my-3 text-center">
                        <input type="submit" name="submit" class="btn btn-md myBtn btn-submit mx-auto" value="Add Gene">
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
