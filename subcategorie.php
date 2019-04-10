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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
            <div class="col-2">
                <div class="vertical-nav mt-5">
                    <div class="nav flex-column nav-pills mt-60" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <ul class="list-group">
			                <h3>Marci</h3>
					
                                <?php
                                if(isset($_GET['id_sub']) && isset($_GET['id_cat'])){
                                    $id_cat = $_GET['id_cat'];
                                    $id_sub = $_GET['id_sub'];
                                    
                                    $result = query("SELECT * FROM marci where subcategorie_id=$id_sub GROUP BY marca_titlu");
                                    while($marca = fetch_array($result)){
                                        $marci = '<li class="list-group-item checkbox"><input type="checkbox" class="productDetail marca"  value="'.$marca['marca_titlu'].'" id_cat= "'.$id_cat.'" id_sub= "'.$id_sub.'"><span>'.$marca['marca_titlu'].'</span></input></li>';
                                            echo $marci;
                                    } 
                                }
                                ?>
                                
                        </ul>
                        
                        
                    </div>
                       
                </div>
            </div>		
   
                <div class="col-10 mt-5">
                    <div class="card">
                    <div class="card-header">
                        <?php
                       
                       if(isset($_GET['id_sub']) && isset($_GET['id_cat'])){
                            $id_sub = $_GET['id_sub'];
                            $id_cat = $_GET['id_cat'];
                        
                            $result = query("SELECT * FROM subcategorii WHERE id_subcategorie=$id_sub GROUP BY id_categorie");
                            while($subcategorie = fetch_array($result)){
                                $nume_subcategorie = $subcategorie['nume_subcategorie'];

                                $result = query("SELECT * FROM categorii WHERE id=$id_cat");
                                while($categorie = fetch_array($result)){
                            
                                    $titlu_categorie = $categorie['titlu'];
                                }
                            }
                            echo  $titlu_categorie;
                        }

                        if(isset($_SESSION['id_utilizator'])){
                        echo  $_SESSION['id_utilizator'];
                    }
                    var_dump($_SESSION);
                        ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        
                        <?php
                            
                            if(isset($_GET['id_sub']) && isset($_GET['id_cat'])){
                                $id_sub = $_GET['id_sub'];
                                $id_cat = $_GET['id_cat'];
                              
                                $result = query("SELECT * FROM subcategorii WHERE id_subcategorie=$id_sub GROUP BY id_categorie");
                                while($subcategorie = fetch_array($result)){
                                    $nume_subcategorie = $subcategorie['nume_subcategorie'];

                                    $result = query("SELECT * FROM categorii WHERE id=$id_cat");
                                    while($categorie = fetch_array($result)){
                                 
                                        $titlu_categorie = $categorie['titlu'];
                                     
                                    
                                        $result = query("SELECT * FROM marci WHERE categorie_id=$id_cat AND subcategorie_id=$id_sub");
                                        while($marca = fetch_array($result)){
                                            $titlu_marca = $marca['marca_titlu'];

                                            $result = query("SELECT * FROM produse WHERE id_categorie= $id_cat AND id_subcategorie=$id_sub");
                                            while($produse = fetch_array($result)){
                                                echo '	<div class="col-md-4">
                                                            <div class="card setheight">
                                                                <img class="card-img-top" src="poze_produse/'.$titlu_categorie.'/'.$nume_subcategorie.'/'.$produse['imagine'].'">
                                                                
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

                                        }
                                    }
                                }
                            }
                            
                            
                        ?>
    
                            
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">



// $(document).on('click','.subcategory',function(event){
// 	// $("body").delegate(".category","click",function(event){
// 		// $(".nav-dropdown").css('display','block');
		
// 	var id_subcategorie = $(this).attr("id_sub");
// 	console.log(id_subcategorie);
// 		$.ajax({
// 			url	:	"functions.php",
// 			method:	"POST",
// 			data	:	{id_subcategorie:id_subcategorie},
// 			success	:	function(data){
// 				$(".nav").html(data);
// 			}
// 		})
// 		return false;
    
// });

// $(document).on('click','.card-block a',function(event){

//     var titlu = $(this).attr("titlu");
//     // console.log(titlu);
    
// });
// $(document).on('click','.card-block a',function(event){
//     // event.preventDefault();
//     var href = $(this).attr("href");
//     var titlu = href.split("titlu=")[1];
//     var model_produs = titlu.replace(/%20/g, '-').toLowerCase();    
// // alert(model_produs);
// window.history.pushState(null, null, model_produs);
// });

</script>
</body>
</html>