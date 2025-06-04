<?php

    if (isset($_GET["msg"])){
        $urlcol = htmlspecialchars($_GET['col'], ENT_QUOTES, 'UTF-8');
        $urlmsg = htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8');
        if ($urlcol == 1){
            echo '<div class="alert alert-success alert-dismissible text-center w-75 mx-auto mt-2 mb-0 fade show" role="alert" style="font-size: 1.2rem;">' . $urlmsg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        else if ($urlcol == 2){
            echo '<div class="alert alert-warning alert-dismissible text-center w-75 mx-auto mt-2 mb-0 fade show" role="alert" style="font-size: 1.2rem;">' . $urlmsg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        else if ($urlcol == 3){
            echo '<div class="alert alert-danger alert-dismissible text-center w-75 mx-auto mt-2 mb-0 fade show" role="alert " style="font-size: 1.2rem;">' . $urlmsg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }


?>