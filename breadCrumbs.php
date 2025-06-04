<?php
    session_start();
    if (!isset($_SESSION['BC'])){
        $_SESSION['BC'] = [];
    }
    $pageName = strtolower(basename($_SERVER['PHP_SELF'], ".php"));
    $cancel_pages = ['addalteration', 'addbreed', 'addgene', 'addtraitvalue', 'adduser', 'alterations', 'breeds', 'genes', 'home', 'traits'];
    if (in_array($pageName, $cancel_pages)){
        $_SESSION['BC'] = [];
    }
    $itemName = $_GET['name'];
    $id = $_GET['id'];
    $index = count($_SESSION['BC']);
    if (isset($_GET['index'])){
        $newArray = [];
        for ($k = 0; $k < $_GET['index']; $k++){
            array_push($newArray, $_SESSION['BC'][$k]);
        }
        $_SESSION['BC'] = $newArray;
        $index = count($_SESSION['BC']);
    }
    $elem = '<a href="' . $pageName . '?id=' . $id . '&index=' . $index . '&name=' . $itemName . '">' . $itemName . '</a>';
    $elemtmp = '<a href="' . $pageName . '?id=' . $id . '&index=' . ($index - 1) . '&name=' . $itemName . '">' . $itemName . '</a>';
    if ($elemtmp != $_SESSION['BC'][$index-1]){
        array_push($_SESSION['BC'], $elem);
    }
    else{
        $index--;
    }
?>
<div class="container">
        <?php
            if ($index > 0){
                echo 'bread crumbs: ';
            }
            if ($index > 6){
                $i = $index-5;
            }
            else{
                $i = 1;
            }
            $first = 1;
            while ($i < $index + 1){
                if ($first != 1){
                    echo ' -> ';
                }
                else{
                    $first = 0;
                    if ($index > 6){
                        echo ' ... ';
                    }
                }
                echo $_SESSION['BC'][$i];
                $i++;
            }

        ?>
</div>