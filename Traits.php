<?php include("UserAuth.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            include("htmlHead.html");
        ?>
        <link href="stylesheet.css" rel="stylesheet">
        <link href="package/dist/theme/mermaid.min.css" rel="stylesheet" />
        <script src="package/dist/gridjs.umd.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
		<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
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
                    <h1 class="display-4">Traits</h1>
                    <h3>List of chicken traits</h3>
                </div>
                <div class="row">
                    <input id="search" type="text" class="form-control" placeholder="Search" onkeyup="myFunction()">
                </div>
                <?php
                    /*
                    require_once('database.php');
                    $sql = 'SELECT * FROM Trait;';
                    $result = $conn->query($sql);
                    $inc = 1;
                    $arr = '';
                    while($row = mysqli_fetch_assoc($result)){
                        $traitID = $row['ID'];
                        $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
                        $arr = $arr . '[' . $inc . ',' . '"' . $traitDesc . '","H"],';
                        $inc++;
                    }
                    $arr = $arr . ',';
                    */
                ?>
                <!--
                <div id="wrapper"></div>
                -->
                <div class="row text-center my-3">
                    <table id="table" class="mainTable table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Trait Description</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                                
                                require_once('database.php');
                                $sql = 'SELECT ID, CONCAT( IFNULL(T.MainCat,""), IF(T.SubCat IS NULL, "", " -> "), IFNULL(T.SubCat,""), IF(T.SubCat_2 IS NULL, "", " -> "), IFNULL(T.SubCat_2,""), ": ", IFNULL(T.Val, "Unknown value") ) AS Trait 
                                FROM Trait T;';
                                /*
                                WHERE EXISTS
                                    (SELECT 1 FROM GeneAlteration G WHERE G.TraitID = T.ID)
                                    OR EXISTS
                                    (SELECT 1 FROM snpAlteration S WHERE S.TraitID = T.ID)
                                    OR EXISTS
                                    (SELECT 1 FROM BreedTrait B WHERE B.TraitID = T.ID)
                                    */
                                $result = $conn->query($sql);
                                $inc = 1;
                                while($row = mysqli_fetch_assoc($result)){
                                    $traitID = $row['ID'];
                                    $traitDesc = htmlspecialchars($row['Trait'], ENT_QUOTES, 'UTF-8');
                                    echo '<tr>
                                        <td>' . $inc . '</td>
                                        <td>' . $traitDesc . '</td>
                                        <td><a href="Trait?id=' . $traitID . '&name=' . $traitDesc . '" class="btn btn-sm myBtn">View Trait details</a></td>
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
            /*new gridjs.Grid({
                columns: ["#", "Trait Description", ""],
                pagination: {
                    enabled: true,
                    limit: 30,
                },
                search: true,
                sort: true,
                fixedHeader: true,
                data: [<?php echo $arr; ?>]
                }).render(document.getElementById("wrapper"));
            */
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
