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
            ?>
            <div class="container">
                <div class="row text-center">
                    <h1 class="display-4">Sequence Genomes</h1>
                    <h3>Full genome sequences of specific breeds</h3>
                </div>
                <div class="row">
                    <table class="mainTable table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Breed</th>
                            <th scope="col">Genome Sequence Paper Reference</th>
                            <th scope="col">Genome Sequence Database Reference</th>
                        </thead>
                        <tbody>
                            <?php
                                require_once('database.php');
                                
                                $sql = 'SELECT ID, BreedName, GenomeSequenceRef FROM Breed WHERE GenomeSequenceRef IS NOT NULL;';
                                $result = $conn->query($sql);
                                
                                while ($row = $result->fetch_assoc()){
                                    $id = $row['ID'];
                                    $breedName = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
                                    $genomeSequence = htmlspecialchars($row['GenomeSequenceRef'], ENT_QUOTES, 'UTF-8');
                                    $genomeSequencePaper = htmlspecialchars($row['GenomeSequencePaper'], ENT_QUOTES, 'UTF-8');
                                    
                                    echo '<tr>
                                            <td>' . $id . '</td>
                                            <td><a href="Breed?id=' . $id . '">' . $breedName . '</a></td>
                                            <td><a href="' . $genomeSequencePaper . '" target="_blank">Paper Reference</a></td>
                                            <td><a href="' . $genomeSequence . '" target="_blank">Database Reference</a></td>
                                          </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="row">
                    <p>You can request the full genome sequence for the following breeds:</p>
                    <ul>
                        <li>Fayoumi M44 Genome</li>
                        <li>Fayoumi M43 Genome</li>
                        <li>Leghorn GB2 Genome</li>
                    </ul>
                    <p><strong>The request form will be available soon!</strong></p>
                </div> -->
            </div>
        </div>
        <div class="Footer containter-fluid">
            <?php
                include("Footer.php");
            ?>
        </div>
    </body>
</html>
