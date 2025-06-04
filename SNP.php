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
                //$query = 'SELECT ID, SNPID, Chromosome, SnpPosition, PValue, IFNULL(Paper, "N/A") AS PaperName, IFNULL(DOI, "N/A") AS PaperDOI FROM snpAlteration WHERE ID = ?';
                $query = 'SELECT * FROM SNPs WHERE ID = ?;';
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_GET['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = mysqli_fetch_assoc($result);
                $id = $row['ID'];
                $snpID = htmlspecialchars($row['SNPID'], ENT_QUOTES, 'UTF-8');
                $chromosome = htmlspecialchars($row['Chromosome'], ENT_QUOTES, 'UTF-8');
                $position = htmlspecialchars($row['SnpPosition'], ENT_QUOTES, 'UTF-8');
            ?>
            <div class="container">
                <div class="row text-center">
                    <h3>SNP Details</h3>
                    <hr class="mb-3">
                </div>
                <div class="row">
                    <div class="col-3 bgDetailO py-3"><strong>System ID: </strong> <?php echo $id; ?></div>
                    <div class="col-3 bgDetailE py-3"><strong>SNP ID: </strong> <?php echo $snpID; ?></div>
                    <div class="col-3 bgDetailO py-3"><strong>Chromosome: </strong> <?php echo $chromosome; ?></div>
                    <div class="col-3 bgDetailE py-3"><strong>Position: </strong> <?php echo $position; ?></div>
                </div>
                <div class="row text-center my-3">
                    <h3>Nearest Genes</h3>
                    <hr class="mb-3">
                    <table class="mainTable table tableGenes">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Gene</th>
                        </thead>
                        <tbody>
                            <?php
                                $query = 'SELECT G.ID, G.GeneName FROM NearestGenes NG LEFT JOIN Gene G ON NG.GeneID = G.ID WHERE NG.SNPID = ?;';
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $inc = 1;
                                while ($row = mysqli_fetch_assoc($result)){
                                    $geneID = $row['ID'];
                                    $gene = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
                                    echo '<tr>
                                        <td>' . $inc . '</td>
                                        <td><a href="Gene?id=' . $geneID . '&name=' . $gene . '">' . $gene . '</a></td>
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
                    <h3>Associated Traits</h3>
                    <hr class="mb-3">
                    <table class="mainTable table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Trait Description</th>
                            <th scope="col">P value</th>
                            <th scope="col">Breeds</th>
                            <th scope="col">Paper</th>
                            <!--<th scope="col">DOI</th>-->
                        </thead>
                        <tbody>
                            <?php
                                $query = 'SELECT 
                                                CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""), ": ", IFNULL(T.Val, "Unknown value") ) AS TraitDescription, 
                                                T.ID AS TraitID, 
                                                SA.ID AS AlterationID, 
                                                SA.PValue, 
                                                IFNULL(SA.Paper, "N/A") AS PaperName, 
                                                IFNULL(SA.DOI, "N/A") AS PaperDOI,
                                                SA.clickPaper,
                                                IFNULL(GROUP_CONCAT(B.BreedName SEPARATOR ", "), "NA") AS Breeds
                                            FROM snpAlteration SA 
                                            LEFT JOIN Trait T ON SA.TraitID = T.ID
                                            LEFT JOIN snpAlterationBreeds SAB ON SA.ID = SAB.SNPID
                                            LEFT JOIN Breed B ON SAB.BreedID = B.ID
                                            WHERE TraitID IS NOT NULL
                                            AND SA.SNPID = ?
                                            GROUP BY T.TraitDescription, TraitID, AlterationID, PValue, PaperName, PaperDOI;';
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $inc = 1;
                                while ($row = mysqli_fetch_assoc($result)){
                                    $traitID = $row['TraitID'];
                                    $alterationID = $row['AlterationID'];
                                    $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
                                    $p_value = htmlspecialchars($row['PValue'], ENT_QUOTES, 'UTF-8');
                                    $paperName = htmlspecialchars($row['PaperName'], ENT_QUOTES, 'UTF-8');
                                    $paperDOI = htmlspecialchars($row['PaperDOI'], ENT_QUOTES, 'UTF-8');
                                    $reference = htmlspecialchars($row['clickPaper'], ENT_QUOTES, 'UTF-8');
                                    $breeds = htmlspecialchars($row['Breeds'], ENT_QUOTES, 'UTF-8');
                                    if ($p_value == ""){
                                        $p_value = "NA";
                                    }
                                    echo '<tr>
                                        <td>' . $inc . '</td>
                                        <td><a href="Trait?id=' . $traitID . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>
                                        <td>' . $p_value . '</td>
                                        <td>' . $breeds . '</td>
                                        <td><a href="' . $reference . '">Visit Reference</a></td>
                                        <!--<td>' . $paperDOI . '</td>-->
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
