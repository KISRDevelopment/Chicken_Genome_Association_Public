<?php
    include("UserAuth.php");
    include 'tokensReset.php';
	$randomToken = random_bytes(20);
	$_SESSION['tokenAddTraitValue'] = bin2hex($randomToken);
	$_SESSION['tokenAddTraitValueTime'] = time();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            include("htmlHead.html");
        ?>
        <link href="stylesheet.css" rel="stylesheet">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
		<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
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
                    <h1 class="display-4">Add Trait</h1>
                </div>
                <form action="#" name="addTrait" method="POST">
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-4">
                            <label>Trait</label>
                            <select class="form-control" id="traitType" name="traitType" onchange="changeTrait()">
                                <option value="A">Trait A</option>
                                <option value="B">Trait B</option>
                                <option value="C">Trait C</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Value</label>
                            <select id="valCat" class="form-control" name="valCat">
                                <option value="A">Value A</option>
                                <option value="B">Value B</option>
                                <option value="C">Value C</option>
                            </select>
                            <input id="valNum" type="text" class="form-control" name="valNum" style="display: none;">
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Breed</label>
                            <select class="form-control" name="breed">
                                <option value="A">Breed A</option>
                                <option value="B">Breed B</option>
                                <option value="C">Breed C</option>
                            </select>
                        </div>
                    </div>
                    <div class="row text-center my-3">
                        <div class="col-sm-12 col-md-6">
                            <label><h2>Genes</h2></label>
                            <select class="form-control chosen-select" name="gene" multiple>
                                <option value="A">Gene A</option>
                                <option value="B">Gene B</option>
                                <option value="C">Gene C</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label><h2>SNPs</h2></label>
                            <select class="form-control chosen-select" name="snps" multiple>
                                <option value="A">SNP A</option>
                                <option value="B">SNP B</option>
                                <option value="C">SNP C</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-3 text-center">
                        <input type="submit" name="submit" class="btn btn-md myBtn btn-submit mx-auto" value="Add Trait">
                    </div>
                </form>
            </div>
        </div>
        <div class="Footer containter-fluid">
            <?php
                include  ("Footer.php");
            ?>
        </div>
        <script>
            $(".chosen-select").chosen({
				no_results_text: "Oops, nothing found!"
				});
            function changeTrait(){
                let tType = document.getElementById("traitType");
                let selectedOptionValue = tType.options[tType.selectedIndex].value;
                if (selectedOptionValue == "A"){
                    document.getElementById("valCat").style.display = "Block";
                    document.getElementById("valNum").style.display = "none";
                }
                else if(selectedOptionValue == "B"){
                    document.getElementById("valCat").style.display = "none";
                    document.getElementById("valNum").style.display = "Block";
                }
                else{
                    document.getElementById("valCat").style.display = "Block";
                    document.getElementById("valNum").style.display = "none";
                }
                
            }
        </script>
        <script src="bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
