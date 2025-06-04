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
                    <h1 class="display-4">SNPs</h1>
                    <h3>List of reported SNPs</h3>
                </div>
                <div class="row">
                    <input id="search" type="text" class="form-control" placeholder="Search" onkeyup="myFunction()">
                </div>
                <div class="row text-center my-3">
                    <table id="table" class="mainTable table tableGenes">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">SNPID</th>
                            <th scope="col">Chromosome</th>
                            <th scope="col">Position</th>
                            <th scope="col">Nearest Genes</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                                require_once('database.php');
                                $sql = 'SELECT S.ID, S.SNPID, IFNULL(S.Chromosome, "N/A") AS Chromosome, IFNULL(S.SnpPosition, "N/A") AS SnpPosition, IFNULL(GROUP_CONCAT(G.GeneName SEPARATOR ", "), "N/A") AS NearestGenes FROM SNPs S LEFT JOIN NearestGenes NG ON S.ID = NG.SNPID LEFT JOIN Gene G ON NG.GeneID = G.ID GROUP BY ID, SNPID, Chromosome, SnpPosition;';
                                $result = $conn->query($sql);
                                $inc = 1;
                                while ($row = $result->fetch_assoc()){
                                    $id = $row['ID'];
                                    $snpID = htmlspecialchars($row['SNPID'], ENT_QUOTES, 'UTF-8');
                                    $chromosome = htmlspecialchars($row['Chromosome'], ENT_QUOTES, 'UTF-8');
                                    $position = htmlspecialchars($row['SnpPosition'], ENT_QUOTES, 'UTF-8');
                                    $nearestGenes = htmlspecialchars($row['NearestGenes'], ENT_QUOTES, 'UTF-8');
                                    echo '<tr>
                                            <td>' . $inc . '</td>
                                            <td>' . $snpID . '</td>
                                            <td>' . $chromosome . '</td>
                                            <td>' . $position . '</td>
                                            <td>' . $nearestGenes . '</td>
                                            <td><a href="SNP?id=' . $id . '&name=' . $name . '" class="btn btn-sm myBtn">View SNP Details</a></td>
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
        <script>
            function myFunction(){
                search = document.getElementById("search").value;
                if (search.length > 2){
                    rows = document.getElementById("table").rows;
                    for (i=1;i<rows.length;i++){
                        rows[i].style.display = "table-row";
                        if (!rows[i].cells[1].innerText.toLowerCase().includes(search.toLowerCase())){
                            rows[i].style.display = "none";
                        }
                    }
                }
                else{
                    rows = document.getElementById("table").rows;
                    for (i=1;i<rows.length;i++){
                        rows[i].style.display = "table-row";
                    }
                }
            }
        </script>
    </body>
</html>
