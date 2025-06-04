<?php
    include("UserAuth.php");
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
                require_once('database.php');
                $query = 'SELECT B.*, C.ContinentName, Co.CountryName FROM Breed B LEFT JOIN Country Co ON B.BreedOriginCountry = Co.ID LEFT JOIN Continent C ON B.BreedOriginContinent = C.ID WHERE B.ID = ?';
                $queryNext = 'SELECT * FROM Breed WHERE ID > ? LIMIT 1;';
                $queryPrev = 'SELECT * FROM Breed WHERE ID < ? ORDER BY ID DESC LIMIT 1;';
                $result = selectFromSQL("i",[$_GET['id']], $query);
                $resultNext = selectFromSQL("i",[$_GET['id']], $queryNext);
                $resultPrev = selectFromSQL("i",[$_GET['id']], $queryPrev);
                $row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($resultNext) > 0){
                    $rowNext = mysqli_fetch_assoc($resultNext); 
                }
                else{
                    $rowNext = [];
                }
                if (mysqli_num_rows($resultPrev) > 0){
                    $rowPrev = mysqli_fetch_assoc($resultPrev); 
                }
                else{
                    $rowPrev = [];
                }
                //$rowNext = mysqli_fetch_assoc($resultNext);
                //$rowPrev = mysqli_fetch_assoc($resultPrev);
                $id = $row['ID'];
                $name = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
                $ancestor = htmlspecialchars($row['Ancestor'], ENT_QUOTES, 'UTF-8');
                $classification = htmlspecialchars($row['Classification'], ENT_QUOTES, 'UTF-8');
                $breedingTechnique = htmlspecialchars($row['BreedingTechnique'], ENT_QUOTES, 'UTF-8');
                $originContinent = htmlspecialchars($row['ContinentName'], ENT_QUOTES, 'UTF-8');
                $originCountry = htmlspecialchars($row['CountryName'], ENT_QUOTES, 'UTF-8');
                $originDesc = htmlspecialchars($row['BreedOriginDesc'], ENT_QUOTES, 'UTF-8');
                $imageAttr = htmlspecialchars($row['ImageAttr'], ENT_QUOTES, 'UTF-8');
                $genomeSequenceRef = htmlspecialchars($row['GenomeSequenceRef'], ENT_QUOTES, 'UTF-8');
                $genomeSequencePaper = htmlspecialchars($row['GenomeSequencePaper'], ENT_QUOTES, 'UTF-8');
            ?>
            <div class="container">
                <div class="row text-center">
                    <h3>Breed Details</h3>
                    <?php
                        if (count($rowPrev) > 0 && count($rowNext) > 0){
                            echo '<a class="btn btn-sm myBtn w-25 ms-auto me-1 my-3" href="Breed?id=' . $rowPrev['ID'] . '">Previous</a>';
                            echo '<a class="btn btn-sm myBtn w-25 me-auto ms-1 my-3" href="Breed?id=' . $rowNext['ID'] . '">Next</a>';
                        }
                        else if (count($rowNext) > 0){
                            echo '<a class="btn btn-sm myBtn w-25 mx-auto my-3" href="Breed?id=' . $rowNext['ID'] . '">Next</a>';
                        }
                        else if (count($rowPrev) > 0){
                            echo '<a class="btn btn-sm myBtn w-25 mx-auto my-3" href="Breed?id=' . $rowPrev['ID'] . '">Previous</a>';
                        }
                    ?>
                    <hr class="mb-3">
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <table class="mainTable table breed-desc-table h-100">
                            <tbody>
                                <tr><td class="px-2">ID:</td><td><?php echo $id; ?></td></tr>
                                <tr><td class="px-2">Name:</td><td><?php echo $name; ?></td></tr>
                                <?php
                                    if ($ancestor != ""){
                                        echo '<tr><td class="px-2">Ancestor:</td><td>' . $ancestor . '</td></tr>';
                                    }
                                    if ($classification != ""){
                                        echo '<tr><td class="px-2">Classification:</td><td>' . $classification . '</td></tr>';
                                    }
                                    if ($originCountry != ""){
                                        echo '<tr><td class="px-2">Origin:</td><td>' . $originCountry . ', ' . $originContinent . '</td></tr>';
                                    }
                                ?>
                                <!--<tr><td>Origin Description:</td><td><?php echo $originDesc; ?></td></tr>-->
                                <?php
                                    if ($imageAttr != ""){
                                        echo '<tr style="font-size: 0.5rem;"><td class="px-2">Image attribution: </td><td>' . $imageAttr . '</td></tr>';
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center">
                        <?php
                            if (!file_exists("assets/Breed-Images/" . $id . ".jpg")){
                                echo '<img class="img-thumbnail w-50" src="assets/images/noImage.jpg" alt="">';
                            }
                            else{
                                echo '<img class="img-thumbnail w-50" src="assets/Breed-Images/' . $id . '.jpg" alt="">';
                            }
                        ?>
                    </div>
                    <!--
                    <div class="col-4 bgDetailO py-3"><strong>ID: </strong> <?php echo $id; ?></div>
                    <div class="col-4 bgDetailE py-3"><strong>Name: </strong> <?php echo $name; ?></div>
                    <div class="col-4 bgDetailO py-3"><strong>Ancestor: </strong> <?php echo $ancestor; ?></div>
                    -->
                </div>
                <!--
                <div class="row">
                    <div class="col-4 bgDetailE py-3"><strong>Classification: </strong> <?php echo $classification; ?></div>
                    <div class="col-4 bgDetailO py-3"><strong>Origin: </strong> <?php echo $originCountry . ', ' . $originContinent; ?></div>
                    <div class="col-4 bgDetailE py-3"><strong>Origin Description: </strong> <?php echo $originDesc; ?></div>
                </div>
                -->
                <div class="row text-center my-3">
                    <h3>Traits inherent to the breed</h3>
                    <hr class="mb-3">
                    <table class="mainTable table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Trait Description</th>
                        </thead>
                        <tbody>
                            <?php
                                $query = 'SELECT  
                                            DISTINCT
                                            T.ID,
                                            CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""), ": ", IFNULL(T.Val, "Unknown value") ) AS Trait
                                            FROM BreedTrait BT 
                                            LEFT JOIN Breed B ON BT.BreedID = B.ID 
                                            LEFT JOIN Trait T ON BT.TraitID = T.ID
                                            WHERE B.ID = ?
                                            ORDER BY Trait;';
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $inc = 1;
                                while ($row = mysqli_fetch_assoc($result)){
                                    $traitID = $row['ID'];
                                    $traitDesc = htmlspecialchars($row['Trait'], ENT_QUOTES, 'UTF-8');
                                    echo '<tr>
                                        <td>' . $inc . '</td>
                                        <!--<td><a href="Trait?id=' . $traitID . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>-->
                                        <td>' . $traitDesc . '</td>
                                    </tr>';
                                    $inc++;
                                }
                                if ($inc == 1){
                                    echo '<tr><td colspan="2">None</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row text-center my-3">
                    <h3>DNA alterations linked to phenotypes specific to the breed</h3>
                    <hr class="mb-3">
                    <table class="mainTable table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Gene</th>
                            <th scope="col">DNA Alteration</th>
                            <th scope="col">Trait</th>
                            <th scope="col">Reference</th>
                        </thead>
                        <tbody>
                            <?php
                                $query = '(SELECT
                                                GA.ID,
                                                G.GeneName,
                                                GA.VariantType AS Alteration,
                                                CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""), ": ", IFNULL(T.Val, "Unknown value") ) AS Trait,
                                                T.ID AS TraitID,
                                                "Paper" AS Paper,
                                                GA.ReferenceURL,
                                                "Gene" AS VarType
                                            FROM GeneAlteration GA
                                            LEFT JOIN Gene G ON GA.GeneID = G.ID
                                            LEFT JOIN Trait T ON GA.TraitID = T.ID
                                            LEFT JOIN GeneAlterationBreeds GAB ON GAB.GeneAlterationID = GA.ID
                                            WHERE GAB.BreedID = ?)
                                            UNION
                                            (SELECT 
                                                SA.ID,
                                                CONCAT ("Nearest Genes: ", IFNULL(GROUP_CONCAT(G.GeneName SEPARATOR ", "), "NA")) AS GeneName, 
                                                CONCAT("SNP Position: ", IFNULL(SA.SnpPosition, "NA"), "; in chromosome: ", IFNULL(SA.Chromosome, "NA"), ", SNP ID: ", S.SNPID) AS Alteration, 
                                                CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""), ": ", IFNULL(T.Val, "Unknown value") ) AS Trait,
                                                T.ID,
                                                SA.Paper,
                                                SA.clickPaper,
                                                "SNP"
                                            FROM snpAlteration SA
                                            LEFT JOIN Trait T ON SA.TraitID = T.ID
                                            LEFT JOIN snpAlterationBreeds SAB ON SA.ID = SAB.SNPID
                                            LEFT JOIN SNPs S ON SA.SNPID = S.ID
                                            LEFT JOIN NearestGenes NG ON NG.SNPID = SA.ID
                                            LEFT JOIN Gene G ON NG.GeneID = G.ID
                                            WHERE SAB.BreedID = ?
                                            GROUP BY SA.ID, Alteration, Trait, T.ID, SA.DOI)
                                            ';
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("ii", $id, $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $inc = 1;
                                while ($row = mysqli_fetch_assoc($result)){
                                    $traitID = $row['ID'];
                                    $gene = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
                                    $alteration = htmlspecialchars($row['Alteration'], ENT_QUOTES, 'UTF-8');
                                    $traitDesc = htmlspecialchars($row['Trait'], ENT_QUOTES, 'UTF-8');
                                    $reference = htmlspecialchars($row['ReferenceURL'], ENT_QUOTES, 'UTF-8');
                                    $paper = htmlspecialchars($row['Paper'], ENT_QUOTES, 'UTF-8');
                                    if ($row['VarType'] == "Gene"){
                                        $ref = '<a href="' . $reference . '">Visit Reference</a>';
                                    }
                                    else{
                                        $ref = '<a href="' . $reference . '">Visit Reference</a>';
                                    }
                                    echo '<tr>
                                        <td>' . $inc . '</td>
                                        <td>' . $gene . '</td>
                                        <td>' . $alteration . '</td>
                                        <!--<td><a href="Trait?id=' . $traitID . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>-->
                                        <td>' . $traitDesc . '</td>
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
                <div class="row text-center my-3">
                    <h3>Genome Sequence Reference</h3>
                    <hr class="mb-3">
                    <table class="mainTable table">
                        <tbody>
                            <tr>
                                <?php
                                    if ($genomeSequenceRef != ""){
                                        echo '<td><a href="' . $genomeSequencePaper . '" target="_blank">Paper reference</a></td>
                                        <td><a href="' . $genomeSequenceRef . '" target="_blank">Database Reference</a></td>';
                                    }
                                    else{
                                        echo '<td colspan="2">No genome sequence reference available.</td>';
                                    }
                                ?>
                                <td></td>
                            </tr>
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
