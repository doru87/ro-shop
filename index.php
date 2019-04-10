<?php require_once("./resources/config.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css"/> -->
  <!-- <link rel="stylesheet" href="css/bootstrap.css"/> -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- <script src="js/bootstrap.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="main.js"></script>
<title>Mizuxe</title>
</head>
<body>

<div class="container">
	
<section class="navigation">

    <div class="nav navbar-nav float-left">
        <nav>
            <ul class="left">
                <?php
                    getCategories();
                ?>
            </ul>   
        </nav>
    </div>
    <div class="nav navbar-nav float-right">
        <nav>
            <ul class="right">
                <li><a href="login.php">Log In</a></li>
                <li>
                    <a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart<span class="badge">0</span></a>
                </li>
            </ul>
        </nav>
    </div>
</section>
		
    <div class="wrapper">
        <div class="row">	
           <div class="col-1"></div>
                <div class="col-10 mt-5">
                    <div class="card">
                    <div class="card-header">
                        Ultimele produse adaugate
                    </div>
                    <div class="card-body">
                        <div class="row">
                        
                       <?php
                       $limit = 6;
                       if (isset($_GET["page"])) { 
                           $page  = $_GET["page"]; 
                       } else { 
                           $page=1; 
                       };
                       $start_from = ($page-1) * $limit;
                        $result = query("SELECT * FROM produse ORDER BY data_adaugarii DESC LIMIT $start_from, $limit");
                        while($produse = fetch_array($result)){
                            $id_categorie = $produse['id_categorie'];
                            $id_subcategorie = $produse['id_subcategorie'];
                                echo '	<div class="col-md-4">
                                            <div class="card setheight">
                                                <img class="card-img-top" src="poze_produse/'.$produse['imagine'].'">
                                                
                                                <div class="card-block"
                                                    <h6 class="card-title mt-1"><a href="produs.php?id='.$produse['id_produs'].'&titlu='.$produse['titlu'].'">'.$produse['titlu'].'</a></h6>
                                                </div>
                                                <div class="card-text"> 
                                                    Pret: '.$produse['pret'].'
                                                </div>
                                                <div class="card-footer">
                                                    <small>Produse ramase in stoc: '.$produse['stoc'].'</small>
                                                    <a href="produs.php?id='.$produse['id_produs'].'&titlu='.$produse['titlu'].'"><button class="btn btn-secondary float-right btn-sm">show</button></a>
                                                </div>
                                            </div>
                                        </div>';
                            }

                            $result = query("SELECT COUNT(id_produs) FROM produse");
                            
                            while($produse = fetch_array($result)){
                                $total_inregistrari = $produse[0];
                            }
                            $total_pagini= ceil($total_inregistrari / $limit);

                            $pagLink = "<div class='pagination'>";
                            
                            for ($i=1; $i<=$total_pagini; $i++) {
                                $pagLink .= "<a href='?page=".$i."'>".$i."</a>";
                            };
                                echo $pagLink . "</div>"; 
                      
                          
                       ?>
                            
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>