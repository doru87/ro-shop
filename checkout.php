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
    </div>

    <div class="row">	
    <div class="col-md-2 mt-5"></div>
        <?php
        		if(isset($_SESSION['id_utilizator'])){
                    $id_utilizator = $_SESSION['id_utilizator'];
 
                    $result = query("SELECT * FROM utilizatori WHERE id='$id_utilizator'");
                    
                    while($utilizator = fetch_array($result)){
                        $nume = $utilizator['nume'];
                        $prenume = $utilizator['prenume'];
                        $email = $utilizator['email'];
                        $telefon = $utilizator['telefon'];
                        $adresa = $utilizator['adresa'];

                        echo '<div class="col-md-5 checkout-details">		
                        <h3>Customer Shipping Details</h3>				
                            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="">
                                <div class="form-group">
                                    <div class="col-sm-10"> 
                                        <input type="text" class="form-control" name="firstName" value="'.$nume.'"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10"> 
                                        <input type="text" class="form-control" name="lastName" value="'.$prenume.'"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10"> 
                                        <textarea class="form-control" rows="5" name="address">'.$adresa.'</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8"> 
                                        <input type="number" class="form-control" min="9" name="contactNumber" value="'.$telefon.'"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10"> 
                                        <input type="email" class="form-control" name="emailAddress" value="'.$email.'"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6"> 
                                        <input class="btn btn-primary" type="submit" name="proceedPayment" value="Proceed to payment"/>
                                    </div>
                                </div>
                            </form>					
                        </div>';

                    }

                        if(isset($_POST['cost_total'])){
                            $_SESSION['cost_total'] = $_POST['cost_total'];
                            $_SESSION['cost_produse'] = $_POST['cost_produse'];
                            $_SESSION['cost_livrare'] = $_POST['cost_livrare'];
                            
                          
                        }
                  
                    
                        if(isset($_POST['proceedPayment'])){
                            global $db;
                            $nume_produse_cart = '';
                            $insert = query("INSERT INTO comenzi (id_utilizator,nume,prenume,email,telefon,adresa,status_comanda,data_comanda,valoare_comanda,tip_plata) 
                            VALUES ('$id_utilizator','$nume','$prenume','$email','$telefon','$adresa','In asteptare','".date("Y-m-d H:i:s")."','$_SESSION[cost_total]','PAYPAL')");
                            $id_comanda = mysqli_insert_id($db);

                            if($id_comanda > 0){
                                $produse_cart = query("SELECT * FROM cart WHERE id_utilizator ='$id_utilizator'");
                                   while($produs = fetch_array($produse_cart)){
                                       $nume_produs = $produs['nume_produs'];
                                       $nume_produse_cart = $nume_produse_cart." ".$nume_produs;
                                       $_SESSION['produse_cart'] = $nume_produse_cart;
                                        $insert = query("INSERT INTO detalii_comanda(id_comanda, id_produs, pret_produs, cantitate) VALUES ('$id_comanda','$produs[id_produs]','$produs[pret]','$produs[cantitate]')");

                                    }       
                               
                            }

                            if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['address'])
                            && isset($_POST['contactNumber']) && isset($_POST['emailAddress'])){

                                $nume = $_POST['firstName'];
                                $prenume = $_POST['lastName'];
                                $email = $_POST['emailAddress'];
                                $telefon = $_POST['contactNumber'];
                                $adresa = $_POST['address'];

                                echo '
                                <div class="col-md-2 checkout-details">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-header">
                                           Detalii Comanda
                                        </div>
                                        <ul class="list-group list-group-flush">
                                        <h6 class="card-title">
                                        <li class="list-group-item">Cost Produse - '.$_SESSION['cost_produse'].'</li>
                                        <li class="list-group-item">Cost Livrare - '.$_SESSION['cost_livrare'].'</li>
                                        <li class="list-group-item">Cost Total - '.$_SESSION['cost_total'].'</li>
                                        </h6>
                                        </ul>
                                        <div class="card-header">
                                            Informatii de livrare
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">'.$nume.' '.$prenume.'</li>
                                            <li class="list-group-item">'.$adresa.'</li>
                                            <li class="list-group-item">'.$telefon.'</li>
                                            <li class="list-group-item">'.$email.'</li>
                                        </ul>
                                        
                                    </div>
                                    
                                    <form class="form-horizontal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="POST">
                                        <input type="hidden" name="business" value="hurricane.1987-facilitator@yahoo.com">
                                        <input type="hidden" name="item_name" value="'.$_SESSION['produse_cart'].'"> 
                                        <input type="hidden" name="item_number" value="'.$id_comanda.'">
                                        <input type="hidden" name="amount" value="'.$_SESSION['cost_total'].'"> 
                                        <input type="hidden" name="currency_code" value="LEI"> 
                                        <input type="hidden" name="notify_url" value="localhost/topsport/notify.php">
                                        <input type="hidden" name="return" value="localhost/topsport/success.php">
                                        <input type="hidden" name="cmd" value="_xclick"> 
                                        <input type="hidden" name="order" value="<?php echo $_SESSION["orderNumber"]; ?>">
                                        <br>
                                        <div class="form-group">
                                            <div class="col-sm-10"> 
                                                 <input type="submit" class="btn btn-lg btn-block btn-danger" name="continue_payment" value="Pay Now">				 
                                            </div>
                                        </div>
                                    </form>

                                </div>';
                            }
                        }
                               
                } else {
                    header('Location:login.php');
                }
            
        ?>
       
        	
        <div class="col-md-1 mt-5"></div>
    </div>
</div>		

</body>
</html>