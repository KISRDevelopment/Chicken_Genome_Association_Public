<?php
include ("UserAuth.php");
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    include ("htmlHead.html");
    ?>
    <link href="stylesheet.css" rel="stylesheet">
</head>

<body>
    <div class="mainHeader mb-3">
        <?php
        include ("Header.php");
        ?>
    </div>
    <div class="content">
        <?php
        include "notifications.php";
        ?>
        <div class="container">
            <div class="row text-center">
                <h1 class="display-4">Breeds</h1>
                <h3>Explore breeds by images</h3>
            </div>
            <div class="row">
                <input id="search" type="text" class="form-control" placeholder="Search" onkeyup="myFunction()">
            </div>
            <div class="row text-center my-3">
                <?php
                require_once ('database.php');

                $sql = 'SELECT B.ID, B.BreedName, IFNULL(B.Ancestor, "NA") AS Ancestor, IFNULL(B.Classification, "NA") AS Classification, IFNULL(Cn.ContinentName, "NA") AS ContinentName, IFNULL(C.CountryName, "NA") AS CountryName
                    FROM Breed B LEFT JOIN Continent Cn ON B.BreedOriginContinent = Cn.ID LEFT JOIN Country C ON B.BreedOriginCountry = C.ID;';
                $result = $conn->query($sql);
                $inc = 1;
                while ($row = $result->fetch_assoc()) {
                    $id = $row['ID'];
                    $name = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
                    $ancestor = htmlspecialchars($row['Ancestor'], ENT_QUOTES, 'UTF-8');
                    $classification = htmlspecialchars($row['Classification'], ENT_QUOTES, 'UTF-8');
                    $originContinent = htmlspecialchars($row['ContinentName'], ENT_QUOTES, 'UTF-8');
                    $originCountry = htmlspecialchars($row['CountryName'], ENT_QUOTES, 'UTF-8');
                    // $family = htmlspecialchars($row['BreedFamily'], ENT_QUOTES, 'UTF-8');
                    $breedImage = 'assets/images/noImage.jpg';
                    if (file_exists("assets/Breed-Images/" . $id . ".jpg")){
                        $breedImage = 'assets/Breed-Images/' . $id . '.jpg';
                    }
                    echo '<div class="col-md-3 col-sm-6" id="breed-' . $id . '">
                        <div class="card py-2 my-2">
                            <img src="' . $breedImage . '" style="height: 300px; object-fit: contain;" class="card-img-top" alt="' . $name . '">
                            <div class="card-body">
                                <h5 class="card-title breed-name" id="breed-name-' . $id . '">' . $name . '</h5>
                                <a href="Breed?id=' . $id . '&name=' . $name . '" class="btn myBtn">View Breed Details</a>
                            </div>
                        </div></div>';
                    $inc++;
                }
                ?>
            </div>
        </div>
    </div>
    <div class="Footer containter-fluid">
        <?php
        include ("Footer.php");
        ?>
    </div>
    <script>
        function myFunction() {
            search = document.getElementById("search").value;
            breeds = document.getElementsByClassName("breed-name");
            if (search.length > 2) {
                for (i = 0; i < breeds.length; i++) {
                    if (!breeds[i].innerText.toLowerCase().includes(search.toLowerCase())) {
                        document.getElementById("breed-" + breeds[i].id.split("-")[2]).style.display = "none";
                    }
                    else {
                        document.getElementById("breed-" + breeds[i].id.split("-")[2]).style.display = "block";
                    }
                }
            }
            else {
                for (i = 0; i < breeds.length; i++) {
                    document.getElementById("breed-" + breeds[i].id.split("-")[2]).style.display = "block";
                }
            }
        }
    </script>
</body>

</html>