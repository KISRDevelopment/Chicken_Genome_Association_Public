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
                $query = 'SELECT ID, GeneName, IFNULL(Chromosome, "N/A") AS Chromosome FROM Gene WHERE ID = ?';
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_GET['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = mysqli_fetch_assoc($result);
                $id = $row['ID'];
                $name = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
                $chromosome = htmlspecialchars($row['Chromosome'], ENT_QUOTES, 'UTF-8');
            ?>
            <div class="container">
                <div class="row text-center">
                    <h3>Gene Details</h3>
                    <hr class="mb-3">
                </div>
                <div class="row">
                    <div class="col-4 bgDetailO py-3"><strong>ID: </strong> <?php echo $id; ?></div>
                    <div class="col-4 bgDetailE py-3"><strong>Name: </strong> <?php echo $name; ?></div>
                    <div class="col-4 bgDetailO py-3"><strong>Chromosome: </strong> <?php echo $chromosome; ?></div>
                </div>
                <div class="row text-center my-3">
                    <h3>DNA Alterations in the Gene</h3>
                    <hr class="mb-3">
                    <table class="mainTable table tableSnps">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Alteration</th>
                            <th scope="col">Mendelian</th>
                            <th scope="col">Trait</th>
                            <th scope="col">Breeds</th>
                            <th scope="col">Reference</th>
                        </thead>
                        <tbody>
                            <?php
                                $query = 'SELECT 
                                            IFNULL(GA.VariantType, "N/A") AS VariantType, 
                                            IFNULL(GA.IsMendelian, "N/A") AS IsMendelian, 
                                            GA.ID, 
                                            GA.ReferenceURL,
                                            CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""), ": ", IFNULL(T.Val, "Unknown value") ) AS TraitDescription,
                                            IFNULL(GROUP_CONCAT(B.BreedName SEPARATOR ", "), "N/A") AS RBreeds 
                                            FROM GeneAlteration GA 
                                            LEFT JOIN Trait T ON GA.TraitID = T.ID 
                                            LEFT JOIN GeneAlterationBreeds GAB ON GAB.GeneAlterationID = GA.ID
                                            LEFT JOIN Breed B ON GAB.BreedID = B.ID 
                                            WHERE GA.GeneID = ? GROUP BY VariantType, IsMendelian, GA.ID, GA.ReferenceURL, TraitDescription;;';
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $inc = 1;
                                while ($row = mysqli_fetch_assoc($result)){
                                    $alterationID = $row['ID'];
                                    $VariantType = htmlspecialchars($row['VariantType'], ENT_QUOTES, 'UTF-8');
                                    $IsMendelian = htmlspecialchars($row['IsMendelian'], ENT_QUOTES, 'UTF-8');
                                    $TraitDescription = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
                                    $reference = htmlspecialchars($row['ReferenceURL'], ENT_QUOTES, 'UTF-8');
                                    $breeds = htmlspecialchars($row['RBreeds'], ENT_QUOTES, 'UTF-8');
                                    echo '<tr>
                                        <td>' . $inc . '</td>
                                        <!--<td><a href="Alteration?id=' . $alterationID . '&name=' . $alteration . '">' . $VariantType . '</a></td>-->
                                        <td>' . $VariantType . '</td>
                                        <td>' . $IsMendelian . '</td>
                                        <td>' . $TraitDescription . '</td>
                                        <td>' . $breeds . '</td>
                                        <td><a href="' . $reference . '">Visit reference</a></td>
                                    </tr>';
                                    $inc++;
                                }
                                if ($inc == 1){
                                    echo '<tr><td colspan="6">None</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row text-center my-3">
                    <h3>DNA Alterations near to the Gene</h3>
                    <hr class="mb-3">
                    <table class="mainTable table tableSnps">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">SNP ID</th>
                            <th scope="col">Chromsome</th>
                            <th scope="col">Position</th>
                            <th scope="col">Trait</th>
                            <th scope="col">Reference</th>
                        </thead>
                        <tbody>
                            <?php
                                $query = 'SELECT SA.ID, SA.SNPID, SA.Chromosome, SA.SnpPosition, SA.Paper, SA.clickPaper,
                                            CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""), ": ", IFNULL(T.Val, "Unknown value") ) AS Trait
                                            FROM snpAlteration SA
                                            LEFT JOIN Trait T ON SA.TraitID = T.ID
                                            WHERE SA.ID IN (SELECT SNPID FROM NearestGenes WHERE GeneID = ?)';
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $inc = 1;
                                while ($row = mysqli_fetch_assoc($result)){
                                    $alterationID = $row['ID'];
                                    $SNPID = htmlspecialchars($row['SNPID'], ENT_QUOTES, 'UTF-8');
                                    $snpChromosome = htmlspecialchars($row['Chromosome'], ENT_QUOTES, 'UTF-8');
                                    $SnpPosition = htmlspecialchars($row['SnpPosition'], ENT_QUOTES, 'UTF-8');
                                    $Trait = htmlspecialchars($row['Trait'], ENT_QUOTES, 'UTF-8');
                                    $paper = htmlspecialchars($row['Paper'], ENT_QUOTES, 'UTF-8');
                                    $reference = htmlspecialchars($row['clickPaper'], ENT_QUOTES, 'UTF-8');
                                    echo '<tr>
                                        <td>' . $inc . '</td>
                                        <!--<td><a href="Alteration?id=' . $alterationID . '&name=' . $alteration . '">' . $SNPID . '</a></td>-->
                                        <td>' . $SNPID . '</td>
                                        <td>' . $snpChromosome . '</td>
                                        <td>' . $SnpPosition . '</td>
                                        <td>' . $Trait . '</td>
                                        <td><a href="' . $reference . '">Visit Reference</a></td>
                                    </tr>';
                                    $inc++;
                                }
                                if ($inc == 1){
                                    echo '<tr><td colspan="6">None</td></tr>';
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
