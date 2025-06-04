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
                    <h1 class="display-4">Genes</h1>
                    <h3>List of genes linked to phenotypes</h3>
                </div>
                <div class="row">
                    <input id="search" type="text" class="form-control" placeholder="Search" onkeyup="myFunction()">
                </div>
                <div class="row text-center my-3">
                    <table id="table" class="mainTable table tableGenes">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <!-- <th></th> -->
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                                require_once('database.php');
                                $sql = 'SELECT ID, GeneName FROM Gene;';
                                $result = $conn->query($sql);
                                $inc = 1;
                                while ($row = $result->fetch_assoc()){
                                    $id = $row['ID'];
                                    $name = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
                                    echo '<tr>
                                            <td>' . $inc . '</td>
                                            <td>' . $name . '</td>
                                            <td><a href="Gene?id=' . $id . '&name=' . $name . '" class="btn btn-sm myBtn">View Gene Details</a></td>
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
