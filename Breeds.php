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
                    <h1 class="display-4">Breeds</h1>
                    <h3>Aplphabetic list of breeds</h3>
                </div>
                <div class="row">
                    <input id="search" type="text" class="form-control" placeholder="Search" onkeyup="myFunction()">
                </div>
                <div class="row text-center my-3">
                    <table id="table" class="mainTable table tableBreeds">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Ancestor</th>
                            <th scope="col">Classification</th>
                            <th scope="col">Origin</th>
                            <!-- <th></th>-->
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                                require_once('database.php');
                                
                                $sql = 'SELECT B.ID, B.BreedName, IFNULL(B.Ancestor, "NA") AS Ancestor, IFNULL(B.Classification, "NA") AS Classification, IFNULL(Cn.ContinentName, "NA") AS ContinentName, IFNULL(C.CountryName, "NA") AS CountryName
                                FROM Breed B LEFT JOIN Continent Cn ON B.BreedOriginContinent = Cn.ID LEFT JOIN Country C ON B.BreedOriginCountry = C.ID;';
                                $result = $conn->query($sql);
                                $inc = 1;
                                while ($row = $result->fetch_assoc()){
                                    $id = $row['ID'];
                                    $name = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
                                    $ancestor = htmlspecialchars($row['Ancestor'], ENT_QUOTES, 'UTF-8');
                                    $classification = htmlspecialchars($row['Classification'], ENT_QUOTES, 'UTF-8');
                                    $originContinent = htmlspecialchars($row['ContinentName'], ENT_QUOTES, 'UTF-8');
                                    $originCountry = htmlspecialchars($row['CountryName'], ENT_QUOTES, 'UTF-8');
                                    // $family = htmlspecialchars($row['BreedFamily'], ENT_QUOTES, 'UTF-8');
                                    echo '<tr>
                                            <td>' . $inc . '</td>
                                            <td>' . $name . '</td>
                                            <td>' . $ancestor . '</td>
                                            <td>' . $classification . '</td>
                                            <td>' . $originCountry . ', ' . $originContinent . '</td>
                                            <td><a href="Breed?id=' . $id . '&name=' . $name . '" class="btn btn-sm myBtn">View Breed Details</a></td>
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
