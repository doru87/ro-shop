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
                        <a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart<span class="total_produse">0</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
    	
    <div class="wrapper">
        <div class="row">	
            <div class="col-12 mt-5">
            <div id="product_message"></div>	
                <div class="card">
                    <div class="card-header">
                    
                    </div>
                        <div class="card-body">
                        <?php
                        if(isset($_GET['id'])){
                            $id = $_GET['id'];

                            $result = query("SELECT * FROM produse WHERE id_produs=$id");
                            while($produse = fetch_array($result)){
                                $id_categorie = $produse['id_categorie'];
                                $id_subcategorie = $produse['id_subcategorie'];

                                $result = query("SELECT * FROM categorii WHERE id=$id_categorie");
                                while($categorie = fetch_array($result)){
                            
                                    $titlu_categorie = $categorie['titlu'];

                                    $result = query("SELECT * FROM subcategorii WHERE id_categorie=$id_categorie AND id_subcategorie=$id_subcategorie");
                                    while($subcategorie = fetch_array($result)){
                                
                                        $nume_subcategorie = $subcategorie['nume_subcategorie'];
                                
                                        $result = query("SELECT * FROM marci WHERE categorie_id=$id_categorie AND subcategorie_id=$id_subcategorie GROUP BY marca_titlu");
                                        while($marca = fetch_array($result)){
                                            $titlu_marca = $marca['marca_titlu'];

                                            $result = query("SELECT * FROM produse WHERE id_produs= $id AND id_categorie= $id_categorie");
                                            while($produse = fetch_array($result)){
                                                echo'
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                            <div class="product-images">
                                                            <img src="poze_produse/'.$titlu_categorie.'/'.$nume_subcategorie.'/'.$produse['imagine'].'" style="height: 100%; width: 100%; object-fit: contain"/>
                                                            </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                            <div class="product-inner">
                                                                <h2 class="product-name">'.$produse['titlu'].'</h2>
                                                                <div class="product-inner-price">
                                                                    '.$produse['pret'].'
                                                                </div>    
                                                                
                                                                <form action="cart.php" id="form-cart">
                                                                    <div class="quantity">
                                                                        <input type="number" size="4" id="qty" value="1" name="quantity" min="1" step="1">
                                                                    </div>
                                                                    <button class="add_to_cart_button" id="'.$id.'" type="submit">Add to cart</button>
                                                                </form>   
                                                                <p>&nbsp;</p>
                                                            
                                                                <div role="tabpanel">
                                                                    <div class="product-tab">
                                                                        <ul class="nav nav-tabs" role="tablist">
                                                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Descriere</a></li>
                                                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Comentarii</a></li>
                                                                        </ul>
                                                                    </div>
                                                                
                                                                    <div class="tab-content">
                                                                        <div role="tabpanel" class="tab-pane show active" id="home">
                                                                            <h2>Descrierea Produsului</h2>  
                                                                            '.$produse['descriere'].'
                                                                        </div>
                                                                        <div role="tabpanel" class="tab-pane fade" id="profile">
                                                                            <h2>Reviews</h2>
                                                                            <div class="submit-review">
                                                                                <p><label for="name">Name</label> <input name="name" type="text"></p>
                                                                                <p><label for="email">Email</label> <input name="email" type="email"></p>
                                                                                <div class="rating-chooser">
                                                                                    <p>Your rating</p>

                                                                                    <div class="rating-wrap-post">
                                                                                        <i class="fa fa-star"></i>
                                                                                        <i class="fa fa-star"></i>
                                                                                        <i class="fa fa-star"></i>
                                                                                        <i class="fa fa-star"></i>
                                                                                        <i class="fa fa-star"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <p><label for="review">Your review</label> <textarea name="review" id="" cols="30" rows="10"></textarea></p>
                                                                                <p><input type="submit" value="Submit"></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>


                                                    </div>';

                                            }   

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

<script type="text/javascript">

$("input[type=number]").bind('keyup input',function(){
	$(this).attr('value', $(this).val());
});

(function($) { 
  $(function() { 

    $('nav ul li a').click(function(e) {
 
    $(this).siblings(".nav-dropdown").css('display','block')
      $(this).parent().siblings("li").find(".nav-dropdown").css("display", "none");
 
    });
}); 
})(jQuery); 

</script>
</body>
</html>
