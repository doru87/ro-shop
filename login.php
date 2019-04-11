<?php require_once("./resources/config.php");?>

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
<title></title>
</head>
<body>
<section class="navigation">
    <div class="nav-container">
        <nav>
            <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
                <ul class="nav-list">
                    <?php
                        getCategories();
                    ?>
                    <li><a href="login.php">Log In</a></li>
                </ul>
        </nav>
    </div>
</section>


<div id="login">
    <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6 mt-5">
                    <div id="login-box" class="col-md-12 mt-5">
                        <form id="login-form" class="form" enctype="multipart/form-data" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Utilizator:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Parola:</label><br>
                                <input type="text" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <input type="submit" name="submit" name="login" class="btn btn-info btn-md mt-5" value="submit">
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="#" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
     if(isset($_POST['username']) && isset($_POST['password'])) {
         global $db;

         $nume_utilizator = mysqli_escape_string($db,trim($_POST['username']));
         $parola = mysqli_escape_string($db,trim($_POST['password']));
         $result = query("SELECT * FROM utilizatori WHERE nume_utilizator='$nume_utilizator' AND parola='$parola'");

         while($utilizator = fetch_array($result)){
            $_SESSION['nume_utilizator'] = $utilizator['nume_utilizator'];
            $_SESSION['id_utilizator'] = $utilizator['id_utilizator'];
        }
        header("location: index.php");
      
    }
    ?>
</body>

<script type="text/javascript">

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
