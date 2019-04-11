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
                        <a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="total_produse">0</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>

    <div class="wrapper">
        <div class="row">	

            <div class="col-9 mt-5">
                <div id="cart_message"></div>
                    <div class="card">
                        <div class="card-header">
                            Featured
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2"><b>Actiune</b></div>
                                <div class="col-md-2"><b>Imagine</b></div>
                                <div class="col-md-2"><b>Nume</b></div>
                                <div class="col-md-2"><b>Cantitate</b></div>
                                <div class="col-md-2"><b>Pret</b></div>
                                <div class="col-md-2"><b>Subtotal</b></div>
                            </div>
                            <div id="cart_checkout"></div>
                        </div>
                    </div>
            </div>
            
                
            <div class="col-md-3 mt-5">
                <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Sumar comanda</div>
                    <div class="card-body">
                        <h5 class="card-title">Cost produse: <span class="cost_produse"></span></h5>
                        <h5 class="card-title">Cost livrare: <span class="cost_livrare">15</span></h5>
                        <h5 class="card-title">Total de plata: <span class="net_total"></span></h5>
                    </div>
                </div>
                <a href="checkout.php" class="btn btn-success btn-block">Checkout</a>
            </div>

        </div>
    </div>    
</div>
</body>
<script type="text/javascript">

function comanda_cost_total(){
    
    $(document).on('click','.btn-success',function(event){
        var cost_produse = parseInt($('.cost_produse').html());
        var cost_livrare = parseInt($('.cost_livrare').html());
        var cost_total = cost_produse + cost_livrare;

        $.ajax({
            url:"checkout.php",
            method:"POST",
            data:{cost_total:cost_total,cost_produse:cost_produse,cost_livrare:cost_livrare},
            success : function(data){
            }
        });
    });
}
comanda_cost_total();

(function($) { 
  $(function() { 

    $('nav ul li a').click(function(e) {
 
    $(this).siblings(".nav-dropdown").css('display','block')
      $(this).parent().siblings("li").find(".nav-dropdown").css("display", "none");
 
    });
}); 
})(jQuery); 


</script>
</html>

