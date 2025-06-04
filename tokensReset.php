<?php
    
    if (session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $expire = 600;
    if (isset($_SESSION['tokenAddUserTime'])){
        unset($_SESSION['tokenAddUser']);
        unset($_SESSION['tokenAddUserTime']);
    }
    if (isset($_SESSION['tokenAddBreedTime'])){
        unset($_SESSION['tokenAddBreed']);
        unset($_SESSION['tokenAddBreedTime']);
    }
    if (isset($_SESSION['tokenAddTraitValueTime'])){
        unset($_SESSION['tokenAddTraitValue']);
        unset($_SESSION['tokenAddTraitValueTime']);
    }
    if (isset($_SESSION['tokenAddGeneTime'])){
        unset($_SESSION['tokenAddGene']);
        unset($_SESSION['tokenAddGeneTime']);
    }
    if (isset($_SESSION['tokenAddSNPTime'])){
        unset($_SESSION['tokenAddSNP']);
        unset($_SESSION['tokenAddSNPTime']);
    }
?>