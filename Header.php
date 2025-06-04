<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #F6EFE7;">
    <div class="container-fluid">
        <a class="navbar-brand" href="Home"><img src="assets/images/logo.png" width="150"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBreed" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Breeds
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownBreed">
                        <li><a href="breedsCatalog" class="dropdown-item">Visual Catalog</a></li>
                        <li><a href="Breeds" class="dropdown-item">Name Catalog</a></li>
                        <?php
                            if (isset($_SESSION['user'])){
                                echo '<li><a href="addBreed" class="dropdown-item">Add</a></li>';
                            }
                        ?>
                        
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSNP" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Traits
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownSNP">
                        <li><a href="Traits" class="dropdown-item">Explore</a></li>
                        <?php
                            if (isset($_SESSION['user'])){
                                echo '<li><a href="#" class="dropdown-item">Add</a></li>';
                            }
                        ?>
                        
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownGene" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Genomes & Genes
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownGene">
                        <li><a href="Alterations" class="dropdown-item">DNA alterations linked to phenotypes</a></li>
                        <li><a href="Genes" class="dropdown-item">Genes linked to phenotypes</a></li>
                        <li><a href="SequenceGenomes" class="dropdown-item">Sequence Genomes</a></li>
                        <?php
                            if (isset($_SESSION['user'])){
                                echo '<li><a href="addGene" class="dropdown-item">Add</a></li>';
                            }
                        ?>
                        
                    </ul>
                </li>
                <?php
                    if (isset($_SESSION['user'])){
                        if ($_SESSION['role'] == 1){
                            echo '<li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Users
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                                        <li><a href="Users" class="dropdown-item">View Users</a></li>
                                        <li><a href="addUser" class="dropdown-item">Add User</a></li>
                                    </ul>
                                </li>';
                        }
                        echo '<li class="nav-item">
                                <a href="logout" class="nav-link text-danger">Logout</a>
                            </li>';
                    }
                    else{
                        echo '<li class="nav-item">
                                <a href="login" class="nav-link text-danger">Login</a>
                            </li>';
                    }
                ?>
                
            </ul>
        </div>
    </div>
</nav>
<?php
    //include("breadCrumbs.php");
?>