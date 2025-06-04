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
            ?>
            <div class="container">
                <div class="row text-center">
                    <h1 class="display-4">DNA Alterations</h1>
                    <h3>DNA alterations linked to phenotypes</h3>
                </div>
                <div class="row text-center my-3">
                    <table class="mainTable table tableSnps">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Gene</th>
                            <th scope="col">Alteration</th>
                            <th scope="col">Trait</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                                require_once('database.php');
                                $sql = '(SELECT
                                            GA.ID,
                                            G.GeneName,
                                            IFNULL(GA.VariantType, "N/A") AS Alteration,
                                            CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""),": ", IFNULL(T.Val, "Unknown value") ) AS Trait,
                                            T.ID AS TraitID,
                                            G.ID AS DNAID,
                                            "G" AS AType
                                        FROM GeneAlteration GA
                                        LEFT JOIN Gene G ON GA.GeneID = G.ID
                                        LEFT JOIN Trait T ON GA.TraitID = T.ID
                                        LEFT JOIN GeneAlterationBreeds GAB ON GAB.GeneAlterationID = GA.ID
                                        WHERE TraitID IS NOT NULL)
                                        UNION
                                        (SELECT 
                                            SA.ID,
                                            CONCAT ("Nearest Genes: ", IFNULL(GROUP_CONCAT(DISTINCT G.GeneName SEPARATOR ", "), "N/A")) AS GeneName, 
                                            CONCAT("SNP Position: ", IFNULL(SA.SnpPosition, "N/A"), "; in chromosome: ", IFNULL(SA.Chromosome, "N/A"), ", SNP ID: ", S.SNPID) AS Alteration,
                                            CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""), ": ", IFNULL(T.Val, "Unknown value") ) AS Trait,
                                            T.ID AS TraitID,
                                            S.ID AS DNAID,
                                            "S"
                                        FROM snpAlteration SA
                                        LEFT JOIN Trait T ON SA.TraitID = T.ID
                                        LEFT JOIN snpAlterationBreeds SAB ON SA.ID = SAB.SNPID
                                        LEFT JOIN SNPs S ON SA.SNPID = S.ID
                                        LEFT JOIN NearestGenes NG ON NG.SNPID = SA.ID
                                        LEFT JOIN Gene G ON NG.GeneID = G.ID
                                        WHERE TraitID IS NOT NULL
                                        GROUP BY SA.ID, Alteration, Trait, TraitID);';
                                $result = $conn->query($sql);
                                $inc = 1;
                                while ($row = $result->fetch_assoc()){
                                    $id = $row['ID'];
                                    $gene = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
                                    $dnaID = htmlspecialchars($row['DNAID'], ENT_QUOTES, 'UTF-8');
                                    $alteration = htmlspecialchars($row['Alteration'], ENT_QUOTES, 'UTF-8');
                                    $trait = htmlspecialchars($row['Trait'], ENT_QUOTES, 'UTF-8');
                                    $mendelian = htmlspecialchars($row['Mendelian'], ENT_QUOTES, 'UTF-8');

                                    if ($row['AType'] == "G"){
                                        $href = 'href="geneAlteration?id=' . $id . '" ';
                                    }
                                    else{
                                        $href = 'href="snp?id=' . $dnaID . '" ';
                                    }

                                    echo '<tr>
                                            <td>' . $inc . '</td>
                                            <td>' . $gene . '</td>
                                            <td>' . $alteration . '</td>
                                            <td>' . $trait . '</td>
                                            <!--<td><a href="Alteration?id=' . $id . '&name=' . $alteration . '" class="btn btn-sm myBtn">View DNA Alteration Details</a></td>-->
                                            <td><a ' . $href . ' class="btn btn-sm myBtn">View DNA Alteration Details</a></td>
                                        </tr>';
                                    $inc++;
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
