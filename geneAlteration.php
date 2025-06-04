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
                $query = 'SELECT 
                            GA.ID,
                            GA.GeneID,
                            GA.VariantType,
                            GA.Deleterious,
                            GA.KeyVariantKnown,
                            GA.YearDiscovered,
                            GA.IsDefect,
                            GA.InheritanceMode,
                            GA.ReferenceSequence,
                            GA.VariantSource,
                            GA.gORm,
                            GA.cORn,
                            GA.p,
                            GA.Description,
                            GA.ReferenceURL,
                            G.GeneName, 
                            G.Chromosome,
                            CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""), ": ", IFNULL(T.Val, "Unknown value") ) AS Trait,
                            IFNULL(GROUP_CONCAT(B.BreedName SEPARATOR ","), "NA") AS RBreeds,
                            IFNULL(GROUP_CONCAT(B.ID SEPARATOR ","), "NA") AS BreedIDs
                            FROM GeneAlteration GA 
                            LEFT JOIN Gene G ON GA.GeneID = G.ID 
                            LEFT JOIN Trait T ON GA.TraitID = T.ID
                            LEFT JOIN GeneAlterationBreeds GAB ON GAB.GeneAlterationID = GA.ID
                            LEFT JOIN Breed B ON GAB.BreedID = B.ID
                            WHERE GA.ID = ?
                            GROUP BY GA.ID,
                            GA.GeneID,
                            GA.VariantType,
                            GA.Deleterious,
                            GA.KeyVariantKnown,
                            GA.YearDiscovered,
                            GA.IsDefect,
                            GA.InheritanceMode,
                            GA.ReferenceSequence,
                            GA.VariantSource,
                            GA.gORm,
                            GA.cORn,
                            GA.p,
                            GA.Description,
                            GA.ReferenceURL,
                            G.GeneName, 
                            G.Chromosome,
                            Trait;';
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_GET['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = mysqli_fetch_assoc($result);
                $id = $row['ID'];
                $geneID = htmlspecialchars($row['GeneID'], ENT_QUOTES, 'UTF-8');
                $chromosome = htmlspecialchars($row['Chromosome'], ENT_QUOTES, 'UTF-8');
                $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
                $variantType = htmlspecialchars($row['VariantType'], ENT_QUOTES, 'UTF-8');
                $deleterious = htmlspecialchars($row['Deleterious'], ENT_QUOTES, 'UTF-8');
                $keyVariantKnown = htmlspecialchars($row['KeyVariantKnown'], ENT_QUOTES, 'UTF-8');
                $yearDiscovered = htmlspecialchars($row['YearDiscovered'], ENT_QUOTES, 'UTF-8');
                $isDefect = htmlspecialchars($row['IsDefect'], ENT_QUOTES, 'UTF-8');
                $inheritanceMode = htmlspecialchars($row['InheritanceMode'], ENT_QUOTES, 'UTF-8');
                $referenceSequence = htmlspecialchars($row['ReferenceSequence'], ENT_QUOTES, 'UTF-8');
                $variantSource = htmlspecialchars($row['VariantSource'], ENT_QUOTES, 'UTF-8');
                $gOrM = htmlspecialchars($row['gORm'], ENT_QUOTES, 'UTF-8');
                $cOrN = htmlspecialchars($row['cORn'], ENT_QUOTES, 'UTF-8');
                $p = htmlspecialchars($row['p'], ENT_QUOTES, 'UTF-8');
                $verbalDescription = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8');
                $trait = htmlspecialchars($row['Trait'], ENT_QUOTES, 'UTF-8');
                // $breeds = htmlspecialchars($row['RBreeds'], ENT_QUOTES, 'UTF-8');
                $referenceURL = htmlspecialchars($row['ReferenceURL'], ENT_QUOTES, 'UTF-8');
                $breeds = explode(",", htmlspecialchars($row['RBreeds'], ENT_QUOTES, 'UTF-8'));
                $breedLinks = explode(",", $row['BreedIDs']);
            ?>
            <div class="container">
                <div class="row text-center">
                    <h3>DNA Alteration Details</h3>
                    <hr class="mb-3">
                </div>
                <div class="row">
                    <div class="col-6 bgDetailO py-3"><strong>System ID: </strong> <?php echo $id; ?></div>
                    <div class="col-6 bgDetailE py-3"><strong>Gene: </strong> <?php echo $geneName; ?></div>
                    <div class="col-6 bgDetailE py-3"><strong>Chromosome: </strong> <?php echo $chromosome; ?></div>
                    <div class="col-6 bgDetailO py-3"><strong>Variant Type: </strong> <?php echo $variantType; ?></div>
                    <div class="col-6 bgDetailO py-3"><strong>Deleterious: </strong> <?php echo $deleterious; ?></div>
                    <div class="col-6 bgDetailE py-3"><strong>Year Discovered: </strong> <?php echo $yearDiscovered; ?></div>
                    <div class="col-6 bgDetailE py-3"><strong>Is Defect?: </strong> <?php echo $isDefect; ?></div>
                    <div class="col-6 bgDetailO py-3"><strong>Mode of Inheitance: </strong> <?php echo $inheritanceMode; ?></div>
                    <div class="col-6 bgDetailO py-3"><strong>Reference Sequence: </strong> <?php echo $referenceSequence; ?></div>
                    <div class="col-6 bgDetailE py-3"><strong>Variant Source: </strong> <?php echo $variantSource; ?></div>
                    <div class="col-6 bgDetailE py-3"><strong>Genomic or Mitochondrial: </strong> <?php echo $gOrM; ?></div>
                    <div class="col-6 bgDetailO py-3"><strong>Coding DNA Sequence or Genomic DNA Sequence: </strong> <?php echo $cOrN; ?></div>
                    <div class="col-6 bgDetailO py-3"><strong>Protein Sequence: </strong> <?php echo $p; ?></div>
                    <div class="col-6 bgDetailE py-3"><strong>Reference Website: </strong><a href="<?php echo $referenceURL; ?>">Visit website</a> </div>
                    <div class="col-12 bgDetailE py-3"><strong>Verbal Description: </strong> <?php echo $verbalDescription; ?></div>
                    <div class="col-12 bgDetailO py-3"><strong>Trait: </strong> <?php echo $trait; ?></div>
                    <div class="col-12 bgDetailE py-3"><strong>Breeds: </strong> 
                    <?php for ($i=0; $i < count($breeds); $i++){
                        if ($i == count($breeds) - 1){
                            echo '<a href="Breed?id=' . $breedLinks[$i] . '">' . $breeds[$i] . '</a>';
                        } else{
                            echo '<a href="Breed?id=' . $breedLinks[$i] . '">' . $breeds[$i] . ', </a>';
                        }
                    } ?>
                </div>
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
