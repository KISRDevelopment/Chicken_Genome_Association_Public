<?php
    include("UserAuth.php");
    include 'tokensReset.php';
	$randomToken = random_bytes(20);
	$_SESSION['tokenAddBreed'] = bin2hex($randomToken);
	$_SESSION['tokenAddBreedTime'] = time();
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
                    <h1 class="display-4">Add Breed</h1>
                </div>
                <form action="#" name="addBreed" method="POST">
                    <div class="row form-group my-3">
                        <div class="col-sm-12 col-md-4">
                            <label>Name</label>
                            <input type="text" class="form-control" name="breedName" placeholder="Breed name">
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Breed Origin Continent</label>
                            <select class="form-control" name="breedOriginContinent">
                                <option value="0">N/A</option>
                                <?php
                                    $sql = 'SELECT * FROM Continent;';
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()){
                                        echo '<option value="' . $row['ID'] . '">' . $row['ContinentName'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Breed Origin Country</label>
                            <select class="form-control" name="breedOriginCountry">
                                <option value="0">N/A</option>
                                <?php
                                    $sql = 'SELECT * FROM Country;';
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()){
                                        echo '<option value="' . $row['ID'] . '">' . $row['CountryName'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-sm-12 col-md-3">
                            <label>Breed Origin Description</label>
                            <input type="text" class="form-control" name="breedOriginDesc" placeholder="Origin Description">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label>Ancestor</label>
                            <input type="text" class="form-control" name="breedAncestor" placeholder="Ancestor">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label>Classification</label>
                            <input type="text" class="form-control" name="breedClassification" placeholder="Classification">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label>Breeding Technique</label>
                            <input type="text" class="form-control" name="breedingTechnique" placeholder="Breeding Technique">
                        </div>
                    </div>
                    <div class="row my-3 text-center">
                        <input type="submit" name="submit" class="btn btn-md myBtn btn-submit mx-auto" value="Add Breed">
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
