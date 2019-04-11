<?php
require_once("./resources/config.php"); 

function getCategories(){
 
    $result = query("SELECT * FROM categorii");
        while($categorie = fetch_array($result)){
            echo '<li><a href="'.$categorie['titlu'].'" class="category" id_cat="'.$categorie['id'].'">'.$categorie['titlu'].'</a><ul class="nav-dropdown"></ul></li>';
        }
}

if(isset($_POST['id_categorie'])){
    $id = $_POST['id_categorie'];
    
    $result = query("SELECT * FROM subcategorii where id_categorie=$id");
    while($subcategorie = fetch_array($result)){
        $subcategorii = '<li><a href="subcategorie.php?id_cat='.$id.'&id_sub='.$subcategorie['id_subcategorie'].'" class="subcategory" id_sub="'.$subcategorie['id_subcategorie'].'">'.$subcategorie["nume_subcategorie"].'</a></li>';
           echo $subcategorii;
    } 
}

function query($sql){
    global $db;
    $result = mysqli_query($db,$sql);
    if(!$result) {
        die("Query Failed! " . mysqli_error($db));
    }
    return $result;
}

function fetch_array($result) {
    return mysqli_fetch_array($result);
}

function redirect($link) {
    header("Location: {$link}");
}



    if(isset($_POST["id_cat"]) && !empty($_POST["id_cat"]) && isset($_POST["id_sub"]) && !empty($_POST["id_sub"]) || (
        isset($_POST["id_cat"]) && !empty($_POST["id_cat"]) && isset($_POST["id_sub"]) && !empty($_POST["id_sub"]) && isset($_POST["valoare_sortare"]) && !empty($_POST["valoare_sortare"]))
    ){
       
        global $db;
        $valoare_selectata ='';
        $valoare_sortare = '';
        $id_categorie = $_POST['id_cat'];
        $id_subcategorie = $_POST['id_sub'];
    
        $sqlQuery = "SELECT * FROM produse WHERE id_categorie = $id_categorie AND id_subcategorie=$id_subcategorie"; 

        $result = query("SELECT * FROM subcategorii WHERE id_subcategorie=$id_subcategorie");
        while($subcategorie = fetch_array($result)){
            $nume_subcategorie = $subcategorie['nume_subcategorie'];
            $id_categorie = $subcategorie['id_categorie'];
    
            $result = query("SELECT * FROM categorii WHERE id=$id_categorie");
        
                
            while($categorie = fetch_array($result)){
           
                $titlu_categorie = $categorie['titlu'];

                if(isset($_POST["valoare_selectata"]) && !empty($_POST["valoare_selectata"])){
                    $valoare_selectata = $_POST["valoare_selectata"];
                }
                if(isset($_POST["valori_selectate"]) && !empty($_POST["valori_selectate"])){
                    $valori_selectate = implode("','",$_POST["valori_selectate"]);
                  
                    $sqlQuery .= " AND nume_marca IN ('".$valori_selectate."')";
                }

                    if(isset($_POST["valoare_sortare"]) && !empty($_POST["valoare_sortare"])){
                        $valoare_sortare = $_POST['valoare_sortare'];
                        $sqlQuery .= "ORDER BY pret $valoare_sortare";
                    
                    }
                        $sqlQuery = query($sqlQuery);
                        while($produse = fetch_array($sqlQuery)){
                            echo'	<div class="col-md-4">
                                        <div class="card setheight">
                                            <img class="card-img-top" src="poze_produse/'.$titlu_categorie.'/'.$nume_subcategorie.'/'.$valoare_selectata.'/'.$produse['imagine'].'">
                                            
                                            <div class="card-block"
                                                <h6 class="card-title mt-1"><a href="produs.php?id='.$produse['id_produs'].'&titlu='.$produse['titlu'].'">'.$produse['titlu'].'</a></h6>
                                            </div>
                                            <div class="card-text"> 
                                                Pret: '.$produse['pret'].'
                                            </div>
                                            <div class="card-footer">
                                                <small>Produse ramase in stoc: '.$produse['stoc'].'</small>
                                                <a href="produs.php?id_cat='.$produse['id_produs'].'&id_subcat='.$id_subcategorie.'"><button class="btn btn-secondary float-right btn-sm">show</button></a>
                                            </div>
                                        </div>
                                    </div>';
                        }   
            }
        }
    }
    
      
$adresa_ip = getenv("REMOTE_ADDR");

if (isset($_POST['addToCart']) && !empty($_POST["addToCart"]) && isset($_POST['id_produs']) && !empty($_POST["id_produs"]) && isset($_POST['pret']) && !empty($_POST["pret"]) && isset($_POST['nume']) && !empty($_POST["nume"])){
    $id_produs = $_POST['id_produs'];
    $valoare_input = $_POST['addToCart'];
    $pret = $_POST['pret'];
    $nume = $_POST['nume'];
   

    if(isset($_SESSION['id_utilizator'])){
        $id_utilizator = $_SESSION['id_utilizator'];

        $sql = "SELECT * FROM cart WHERE id_produs = '$id_produs' AND id_utilizator = '$id_utilizator'";

        $run_query = query($sql);
        if(mysqli_num_rows($run_query) >0){
            $fetch = fetch_array($run_query);
            $_SESSION['produse_cos'] = $fetch;
            $cantitate = $fetch['cantitate'];
            $update = "UPDATE cart SET cantitate = '$cantitate' + '$valoare_input' WHERE id_produs = '$id_produs'";

            if(query($update)){
                echo "
					<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert'  aria-label='close'>&times;</a>
						<b>Produsul a fost actualizat..!</b>
					</div>
				";
            }
        }else{
            $insert = "INSERT INTO cart (id_produs, nume_produs, id_utilizator, pret,cantitate) VALUES ('$id_produs','$nume','$id_utilizator','$pret','$valoare_input')";
            if(query($insert)){
                echo "
					<div class='alert alert-warning'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Produsul a fost adaugat in cosul de cumparaturi..!</b>
					</div>
				";
            };
        }
    }else{

        $sql = "SELECT * FROM cart WHERE id_produs = '$id_produs' AND adresa_ip = '$adresa_ip' AND id_utilizator = '-1'";

        $run_query = query($sql);
        if(mysqli_num_rows($run_query) >0){
            $fetch = fetch_array($run_query);
            $_SESSION['produse_cos'] = $fetch;
            $cantitate = $fetch['cantitate'];
            $update = "UPDATE cart SET cantitate = '$cantitate' + '$valoare_input' WHERE id_produs = '$id_produs' ";
            if(query($update)){
                echo "
					<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert'  aria-label='close'>&times;</a>
						<b>Produsul a fost actualizat..!</b>
					</div>
				";
            }
        }else{
        
        $insert = "INSERT INTO cart (id_produs,id_utilizator,cantitate,adresa_ip) VALUES ('$id_produs','-1','$valoare_input','$adresa_ip')";
        if(query($insert)){
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Produsul a fost adaugat in cosul de cumparaturi..!</b>
                </div>
            ";
        };
    }
   
}
}


if (isset($_POST["count_item"])) {
	
	if (isset($_SESSION['id_utilizator'])) {
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE id_utilizator = '".$_SESSION['id_utilizator']."'";
	
        $query = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($query);
        echo $row["count_item"];
        exit();
    }
}

if (isset($_POST["Common"])) {

    if (isset($_SESSION['id_utilizator'])) {
        $id_utilizator = $_SESSION['id_utilizator'];
        $sql = query("SELECT a.id_produs,a.titlu,a.pret,a.imagine,b.id,b.cantitate FROM produse a,cart b WHERE a.id_produs=b.id_produs AND b.id_utilizator='".$_SESSION['id_utilizator']."'");
    } else {
        $sql = query("SELECT a.id_produs,a.titlu,a.pret,a.imagine,b.id,b.cantitate FROM produse a,cart b WHERE a.id_produs=b.id_produs AND b.adresa_ip='$adresa_ip' AND b.id_utilizator= '-1'");
    }

        if (mysqli_num_rows($sql) > 0) {
            $n=0;
            while($produse_cart = fetch_array($sql)){
                $n=0;
                $id_produs = $produse_cart['id_produs'];
                $titlu = $produse_cart['titlu'];
                $pret = $produse_cart['pret'];
                $imagine = $produse_cart['imagine'];
                $cart_id = $produse_cart['id'];
                $cantitate = $produse_cart['cantitate'];
                $pret_provizoriu = $cantitate*$pret;

                $result = query("SELECT * FROM produse WHERE id_produs=$id_produs");
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

                                    $result = query("SELECT * FROM produse WHERE id_produs= $id_produs AND id_categorie= $id_categorie");
                                    while($produse = fetch_array($result)){

                                        echo 
                                        '<div class="row">
                                            <div class="col-md-2 mt-5">
                                                <div class="btn-group">
                                                    <a href="#" remove_id="'.$id_produs.'" class="btn btn-danger remove"><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-2 mt-4"> <img src="poze_produse/'.$titlu_categorie.'/'.$nume_subcategorie.'/'.$produse['imagine'].'" style="height: 85%; width: 85%; object-fit: contain"/></div>
                                            <div class="col-md-2 mt-5">'.$titlu.'</div>
                                            <div class="col-md-2 mt-5"><input type="number" id="qty" value="'.$cantitate.'" name="quantity" min="1" step="1"></div>
                                            <div class="col-md-2 mt-5"><input type="text" class="form-control price" value="'.$pret.'" readonly="readonly"></div>
                                            <div class="col-md-2 mt-5"><input type="text" class="form-control total" value="'.$pret_provizoriu.'" readonly="readonly"></div>
                                        </div>';

                                    }  
                                }

                            }
                        }
                    }
            }   
                    
        }
    
}       


if (isset($_POST['valoare_actualizata']) && isset($_POST['id'])){

    $valoare_actualizata = $_POST['valoare_actualizata'];
    $id_produs = $_POST['id'];
    
    if(isset($_SESSION['id_utilizator'])){
        $id_utilizator = $_SESSION['id_utilizator'];

        $update = "UPDATE cart SET cantitate = '$valoare_actualizata' WHERE id_produs = '$id_produs' AND id_utilizator = '$id_utilizator'";
        query($update);
        exit();
           
    }else{
        $update = "UPDATE cart SET cantitate = '$valoare_actualizata' WHERE id_produs = '$id_produs' AND adresa_ip='$adresa_ip' AND id_utilizator= '-1'";
        query($update);
        exit();
    }
}


if (isset($_POST['stergeProdusCart']) && isset($_POST['remove_id'])){
    $id_sters = $_POST['remove_id'];

    if(isset($_SESSION['id_utilizator'])){
        $delete_item = "DELETE FROM cart WHERE id_produs='$id_sters' AND id_utilizator='$_SESSION[id_utilizator]'";
        $run_query = query($delete_item);
   
            if($run_query){
            echo "<div class='alert alert-danger'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>Produsul a fost sters din cosul de cumparaturi</b>
                </div>";
		    exit();
        }
    }else{
        $delete_item = "DELETE FROM cart WHERE id_produs='$id_sters' AND adresa_ip='$adresa_ip' AND id_utilizator= '-1'";
        $run_query = query($delete_item);
   
            if($run_query){
            echo "<div class='alert alert-danger'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>Produsul a fost sters din cosul de cumparaturi</b>
                </div>";
		    exit();
        }

    }
}

?>

