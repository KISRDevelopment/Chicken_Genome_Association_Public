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
                require_once('database.php');
                $query = 'SELECT ID, TraitDescription, IFNULL(MainCat, "N/A") AS MainCat, IFNULL(SubCat, "N/A") AS SubCat, IFNULL(SubCat_2, "N/A") AS SubCat_2, IFNULL(Val, "N/A") AS Val
                            FROM Trait WHERE ID = ?;';
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_GET['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = mysqli_fetch_assoc($result);
                $id = $row['ID'];
                $traitDescription = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
                $mainCat = htmlspecialchars($row['MainCat'], ENT_QUOTES, 'UTF-8');
                $subCat = htmlspecialchars($row['SubCat'], ENT_QUOTES, 'UTF-8');
                $subCat2 = htmlspecialchars($row['SubCat_2'], ENT_QUOTES, 'UTF-8');
                $val = htmlspecialchars($row['Val'], ENT_QUOTES, 'UTF-8');
            ?>
            <div class="container">
                <div class="row text-center">
                    <h1 class="display-4">Trait Details</h1>
                </div>
                <?php
                    if ($subCat2 != "N/A"){
                ?>
                <div class="row">
                    <div class="col-1 bgDetailO py-3"><strong>ID: </strong> <?php echo $id; ?></div>
                    <div class="col-3 bgDetailE py-3"><strong>Main Category: </strong> <?php echo $mainCat; ?></div>
                    <div class="col-3 bgDetailO py-3"><strong>Sub Category 1: </strong> <?php echo $subCat; ?></div>
                    <div class="col-2 bgDetailE py-3"><strong>Sub Category 2: </strong> <?php echo $subCat2; ?></div>
                    <div class="col-3 bgDetailO py-3"><strong>Value: </strong> <?php echo $val; ?></div>
                    <hr class="mt-3">
                </div>
                <?php
                    }
                    else if ($subCat != "N/A"){
                ?>
                <div class="row">
                    <div class="col-3 bgDetailO py-3"><strong>ID: </strong> <?php echo $id; ?></div>
                    <div class="col-3 bgDetailE py-3"><strong>Main Category: </strong> <?php echo $mainCat; ?></div>
                    <div class="col-3 bgDetailO py-3"><strong>Sub Category 1: </strong> <?php echo $subCat; ?></div>
                    <div class="col-3 bgDetailO py-3"><strong>Value: </strong> <?php echo $val; ?></div>
                    <hr class="mt-3">
                </div>
                <?php
                    }
                    else {
                ?>
                <div class="row">
                    <div class="col-2 bgDetailO py-3"><strong>ID: </strong> <?php echo $id; ?></div>
                    <div class="col-5 bgDetailE py-3"><strong>Main Category: </strong> <?php echo $mainCat; ?></div>
                    <div class="col-5 bgDetailO py-3"><strong>Value: </strong> <?php echo $val; ?></div>
                    <hr class="mt-3">
                </div>
                <?php
                    }
                ?>
                <div class="row text-center my-1">
                    <h2>Inherent to Breeds</h2>
                    <table id="table" class="mainTable table tableBreeds">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Ancestor</th>
                            <th scope="col">Classification</th>
                            <th scope="col">Origin</th>
                        </thead>
                        <tbody>
                            <?php
                                require_once('database.php');
                                $sql = 'SELECT DISTINCT B.ID, 
                                            B.BreedName, 
                                            IFNULL(B.Ancestor, "NA") AS Ancestor, 
                                            IFNULL(B.Classification, "NA") AS Classification, 
                                            IFNULL(Cn.ContinentName, "NA") AS ContinentName, 
                                            IFNULL(C.CountryName, "NA") AS CountryName
                                        FROM BreedTrait BT
                                        LEFT JOIN Breed B ON BT.BreedID = B.ID
                                        LEFT JOIN Continent Cn ON B.BreedOriginContinent = Cn.ID 
                                        LEFT JOIN Country C ON B.BreedOriginCountry = C.ID
                                        WHERE BT.TraitID = ?;';
                                $result = selectFromSQL('i',[$id], $sql);
                                $inc = 1;
                                while ($row = mysqli_fetch_assoc($result)){
                                    $breedId = $row['ID'];
                                    $name = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
                                    $ancestor = htmlspecialchars($row['Ancestor'], ENT_QUOTES, 'UTF-8');
                                    $classification = htmlspecialchars($row['Classification'], ENT_QUOTES, 'UTF-8');
                                    $originContinent = htmlspecialchars($row['ContinentName'], ENT_QUOTES, 'UTF-8');
                                    $originCountry = htmlspecialchars($row['CountryName'], ENT_QUOTES, 'UTF-8');
                                    echo '<tr>
                                            <td>' . $inc . '</td>
                                            <!--<td><a href="Breed?id=' . $breedId . '&name=' . $name . '">' . $name . '</a></td>-->
                                            <td>' . $name . '</td>
                                            <td>' . $ancestor . '</td>
                                            <td>' . $classification . '</td>
                                            <td>' . $originCountry . ', ' . $originContinent . '</td>
                                        </tr>';
                                    $inc++;
                                }
                                if ($inc == 1){
                                    echo '<tr><td colspan="7">None</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                    <hr class="mt-3">
                </div>
                <div class="row text-center my-1">
                    <h2>DNA Alterations</h2>
                    <table class="mainTable table tableSnps">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Gene</th>
                            <th scope="col">DNA Alteration</th>
                            <th scope="col">Breeds</th>
                            <th scope="col">Reference</th>
                        </thead>
                        <tbody>
                            <?php
                                require_once('database.php');
                                $sql = '(SELECT
                                            GA.ID,
                                            G.GeneName,
                                            IFNULL(GA.VariantType, "N/A") AS Alteration,
                                            IFNULL(GROUP_CONCAT(B.BreedName), "N/A") AS Breeds,
                                            "Paper" AS Paper,
                                            GA.ReferenceURL,
                                            "Gene" AS VarType
                                        FROM GeneAlteration GA
                                        LEFT JOIN Gene G ON GA.GeneID = G.ID
                                        LEFT JOIN Trait T ON GA.TraitID = T.ID
                                        LEFT JOIN GeneAlterationBreeds GAB ON GAB.GeneAlterationID = GA.ID
                                        LEFT JOIN Breed B ON GAB.BreedID = B.ID
                                        WHERE T.ID = ?
                                        GROUP BY GA.ID, G.GeneName, Alteration, ReferenceURL)
                                        UNION
                                        (SELECT 
                                            SA.ID,
                                            CONCAT ("Nearest Genes: ", IFNULL(GROUP_CONCAT(G.GeneName SEPARATOR ", "), "N/A")) AS GeneName, 
                                            CONCAT("SNP Position: ", IFNULL(SA.SnpPosition, "N/A"), "; in chromosome: ", IFNULL(SA.Chromosome, "N/A"), ", SNP ID: ", IFNULL(S.SNPID, "N/A")) AS Alteration,
                                            IFNULL(GROUP_CONCAT(B.BreedName), "N/A") AS Breeds,
                                            SA.Paper,
                                            SA.clickPaper,
                                            "SNP"
                                        FROM snpAlteration SA
                                        LEFT JOIN Trait T ON SA.TraitID = T.ID
                                        LEFT JOIN snpAlterationBreeds SAB ON SA.ID = SAB.SNPID
                                        LEFT JOIN SNPs S ON SA.SNPID = S.ID
                                        LEFT JOIN NearestGenes NG ON NG.SNPID = SA.ID
                                        LEFT JOIN Gene G ON NG.GeneID = G.ID
                                        LEFT JOIN Breed B ON SAB.BreedID = B.ID
                                        WHERE T.ID = ?
                                        GROUP BY SA.ID, Alteration, SA.Paper)';
                                $result = selectFromSQL('ii',[$id, $id], $sql);
                                $inc = 1;
                                while ($row = mysqli_fetch_assoc($result)){
                                    $alterationId = $row['ID'];
                                    $alteration = htmlspecialchars($row['Alteration'], ENT_QUOTES, 'UTF-8');
                                    $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
                                    $reference = htmlspecialchars($row['ReferenceURL'], ENT_QUOTES, 'UTF-8');
                                    $paper = htmlspecialchars($row['Paper'], ENT_QUOTES, 'UTF-8');
                                    $breeds = htmlspecialchars($row['Breeds'], ENT_QUOTES, 'UTF-8');
                                    if ($row['VarType'] == "Gene"){
                                        $ref = '<a href="' . $reference . '">Visit Reference</a>';
                                    }
                                    else{
                                        $ref = '<a href="' . $reference . '">Visit Reference</a>';
                                    }
                                    echo '<tr>
                                            <td>' . $inc . '</td>
                                            <!--<td><a href="Alteration?id=' . $alterationId . '&name=' . $alteration . '">' . $alteration . '</a></td>-->
                                            <td>' . $geneName . '</td>
                                            <td>' . $alteration . '</td>
                                            <td>' . $breeds . '</td>
                                            <td>' . $ref . '</td>
                                        </tr>';
                                    $inc++;
                                }
                                if ($inc == 1){
                                    echo '<tr><td colspan="5">None</td></tr>';
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
