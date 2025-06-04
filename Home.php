<?php include("UserAuth.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once('database.php');
            include("htmlHead.html");
        ?>
        <link href="stylesheet.css" rel="stylesheet">
        <style>
            .autoComplete {
                position: relative;
            }
            .autocomplete-items {
                position: absolute;
                border: 1px solid #d4d4d4;
                border-bottom: none;
                border-top: none;
                z-index: 99;
                /*position the autocomplete items to be the same width as the container:*/
                top: 100%;
                left: 0;
                right: 0;
                max-height: 200px;
                overflow-y: scroll;
            }

            .autocomplete-items div {
                padding: 10px;
                cursor: pointer;
                background-color: #fff; 
                border-bottom: 1px solid #d4d4d4; 
            }

            /*when hovering an item:*/
            .autocomplete-items div:hover {
                background-color: #e9e9e9; 
            }

                /*when navigating through the items using the arrow keys:*/
            .autocomplete-active {
                background-color: DodgerBlue !important; 
                color: #ffffff; 
            }
        </style>
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
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="bg-breeds m-1 p-3 text-center" style="border-radius: 2%; min-height: 100px;">
                            <h6 class="my-2">Breeds</h6>
                            <div style="border-top: 1px solid #BBBBBB" class="py-3">
                                <a class="btn  myBtn w-100 my-2" href="BreedsCatalog">Explore Visual Catalog</a>
                                <a class="btn  myBtn w-100 my-2" href="Breeds">Explore Name Catelog</a>
                                <?php
                                    if (isset($_SESSION['user'])){
                                        echo '<a class="btn  myBtn w-100 my-2" href="addBreed">Add</a>';
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="mainBG m-1 p-3 text-center" style="border-radius: 2%; min-height: 100px;">
                            <h6 class="my-2">Traits</h6>
                            <div style="border-top: 1px solid #BBBBBB" class="py-3">
                                <a class="btn  myBtn w-100 my-2" href="Traits">Explore</a>
                                <?php
                                    if (isset($_SESSION['user'])){
                                        echo '<a class="btn  myBtn w-100 my-2" href="#">Add</a>';
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="bg-genes m-1 p-3 text-center" style="border-radius: 2%; min-height: 100px;">
                            <h6 class="my-2">Genomes & Genes</h6>
                            <div style="border-top: 1px solid #BBBBBB" class="py-3">
                            <a class="btn  myBtn w-100 my-2" href="Alterations">DNA Alterations Linked to Phenotypes</a>
                                <a class="btn  myBtn w-100 my-2" href="Genes">Explore Genes Linked to Phenotypes</a>
                                <a class="btn  myBtn w-100 my-2" href="SequenceGenomes">Sequence Genomes</a>
                                <?php
                                    if (isset($_SESSION['user'])){
                                        echo '<a class="btn  myBtn w-100 my-2" href="addGene">Add</a>';
                                        echo '<a class="btn  myBtn w-100 my-2" href="addSNP">Add</a>';
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 col-sm-12">
                        <div class="bg-snps m-1 p-3 text-center" style="border-radius: 2%; min-height: 100px;">
                            <h6 class="my-2">DNA Alterations</h6>
                            <div style="border-top: 1px solid #BBBBBB" class="py-3">
                                <a class="btn  myBtn w-100 my-2" href="Alterations">Explore</a>
                                <?php
                                    if (isset($_SESSION['user'])){
                                        echo '<a class="btn  myBtn w-100 my-2" href="addSNP">Add</a>';
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row text-center mt-3">
                    <h3>Search Engine</h3>
                    <hr>
                </div>
                <?php
                    $breedInputValue = "";
                    $traitInputValue = "";
                    $geneInputValue = "";
                    $alterationInputValue = "";
                    if (isset($_POST['breedText']) || isset($_POST['traitText']) || isset($_POST['geneText']) || isset($_POST['alterationsText'])){
                        if ($_POST['breedText'] != ""){
                            $breedInputValue = $_POST['breedText'];
                        }
                        else{
                            $breedInputValue = "";
                        }
                        if ($_POST['traitText'] != ""){
                            $traitInputValue = $_POST['traitText'];
                        }
                        else{
                            $traitInputValue = "";
                        }
                        if ($_POST['geneText'] != ""){
                            $geneInputValue = $_POST['geneText'];
                        }
                        else{
                            $geneInputValue = "";
                        }
                        if ($_POST['alterationsText'] != ""){
                            $alterationInputValue = $_POST['alterationsText'];
                        }
                        else{
                            $alterationInputValue = "";
                        }
                    }
                ?>
                <form method="POST" autocomplete="off">
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-12 my-2">
                            <label>Breed</label>
                            <div class="autoComplete">
                                <input class="form-control" name="breedText" value="<?php echo $breedInputValue; ?>" id="breedText" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 my-2">
                            <label>Trait</label>
                            <div class="autoComplete">
                                <input class="form-control" name="traitText" value="<?php echo $traitInputValue; ?>" id="traitText" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 my-2">
                            <label>Gene</label>
                            <div class="autoComplete">
                                <input class="form-control" name="geneText" value="<?php echo $geneInputValue; ?>" id="geneText" type="text" autocomplete="off">
                            </div>
                        </div>
                        <!-- <div class="col-md-6 col-sm-12 my-2">
                            <label>DNA Alteration</label>
                            <div class="autoComplete">
                                <input class="form-control" name="alterationsText" value="<?php echo $alterationInputValue; ?>" id="alterationsText" type="text" autocomplete="off">
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <p class="text-danger">
                            Serperate multiple keywords with a semi-colon ";". e.g. "Fayoumi; Rhode Island Red". Keywords in the same box follow "OR" Logic while an "AND" Logic is followed between different boxes.</p>
                    </div>
                    <div class="row mb-3 px-3">
                        <div class="mx-auto text-center">
                            <input type="submit" value="Search" class="btn myBtn mb-3 mx-1 btn-submit">
                            <input type="button" onclick="clearSearch()" value="Clear" class="btn myBtn mb-3 mx-1 bg-warning">
                        </div>
                        <hr>
                    </div>
                </form>
                <div class="row">
                    <table class="table">
                    <?php
                        if (isset($_POST['breedText']) || isset($_POST['traitText']) || isset($_POST['geneText']) || isset($_POST['alterationsText'])){
                            include('searchEngine.php');
                        }
                    ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="Footer containter-fluid">
            <?php
                include  ("Footer.php");
            ?>
        </div>
        
        <script src="autoComplete.js"></script>
        <script>
            var breeds = [<?php 
                            $sql = 'SELECT BreedName FROM Breed;';
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()){
                                echo '"' . $row['BreedName'] . '",';
                            }
                        ?>];
            var traits = [<?php 
                            $sql = 'SELECT CONCAT(IFNULL(MainCat, ""), " ", IFNULL(SubCat,""), " ", IFNULL(SubCat_2, ""), " ", IFNULL(Val, "")) AS TraitDescription FROM Trait;';
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()){
                                echo '"' . $row['TraitDescription'] . '",';
                            }
                        ?>];
            var genes = [<?php 
                            $sql = 'SELECT GeneName FROM Gene;';
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()){
                                echo '"' . $row['GeneName'] . '",';
                            }
                        ?>];
            autocomplete(document.getElementById("breedText"), breeds);
            autocomplete(document.getElementById("geneText"), genes);
            autocomplete(document.getElementById("traitText"), traits);
            //autocomplete(document.getElementById("alterationsText"), alterations);
        </script>
        <script>
            function clearSearch(){
                document.getElementById("breedText").value = "";
                document.getElementById("traitText").value = "";
                document.getElementById("geneText").value = "";
               // document.getElementById("alterationsText").value = "";
            }
        </script>
    </body>
</html>
