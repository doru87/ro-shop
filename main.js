
$(document).on('click','.category',function(event){

		// $(".nav-dropdown").css('display','block');
	
	var id_categorie = $(this).attr("id_cat");
	// var category = $(this);

		$.ajax({
			url	:"functions.php",
			method:"POST",
			data:{id_categorie:id_categorie},
			success:function(data){
				$(".nav-dropdown").html(data);
				
				// category.parent().find(".nav-dropdown").html(data);
				// category.parent().find(".nav-dropdown").css("display", "block");
			}
		})
		return false;
    
});


$(document).on('change','.marca',function(){

	 var valori_selectate = getFilterData('marca');
	 var valoare_selectata = $(this).attr("titlu");
	 var id_cat = $(this).attr("id_cat");
	 var id_sub = $(this).attr("id_sub");

	 $.ajax({
		url	:"functions.php",
		method:"POST",
		data:{valori_selectate:valori_selectate,valoare_selectata:valoare_selectata,id_cat:id_cat,id_sub:id_sub},
		success:function(data){
			$(".card-body .row").html(data);
		}
	})
// }
});

$(document).on('change','.pret',function(){

	var valoare_sortare = $(this).val();
			$.ajax({
				url:"functions.php",
				method:"POST",
				data:{valoare_sortare:valoare_sortare},
				success:function(data){
					$(".card-body .row").html(data);
					
				}
			})
	  
	});


function getFilterData(className) {
	var filter = [];
		$('.'+className+':checked').each(function(){
		filter.push($(this).val());
	});
	return filter;
}

$(document).ready(function() {
	$('#form-cart').on('submit',function(e){
		e.preventDefault();

		var id_produs = $(this).find(".add_to_cart_button").attr("id");
		var input = document.getElementById('qty');
		
		var value = input.getAttribute('value');
		var nume = $(this).parent().find(".product-name").text();
		var price = parseInt($(this).parent().find(".product-inner-price").text());

		$.ajax({
			url	:"functions.php",
			method:"POST",
			data:{addToCart:value,id_produs:id_produs,pret:price,nume:nume},
			success:function(data){
				$('#product_message').html(data);
			}
		})
		window.setTimeout(function() {
			$(".alert").fadeTo(100, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 4000);
	
	});

});

count_item();
function count_item(){
	$.ajax({
		url:"functions.php",
		method:"POST",
		data:{count_item:1},
		success:function(data){
			$(".total_produse").html(data);
		}
	})
}
function checkOutDetails(){

	   $.ajax({
		   url:"functions.php",
		   method:"POST",
		   data:{Common:1},
		   success:function(data){
			$("#cart_checkout").html(data);
			net_total();
			getValue();
			actualizeaza_total();
		   }
	   })
   }

   checkOutDetails();

   function net_total(){
		var net_total = 0;
		$('input[type=number]').each(function(){

			var row = $(this).parent().parent();
			var price = row.find('.price').val();
			var total = price * $(this).val();
			row.find('.total').val(total);
		})
			$('.total').each(function(){
				net_total += ($(this).val()-0);
			})

			$('.cost_produse').html(net_total);
			
	}

	function getValue(){
		$("input[type=number]").bind('keyup input',function(){
			var value = $(this).val();
			var row = $(this).parent().parent();
			var id_produs = row.find('.remove').attr('remove_id');

			var cost_produse = parseInt($('.cost_produse').html());
			var cost_livrare = parseInt($('.cost_livrare').html());
			var cost_total = cost_produse + cost_livrare;
			$('.net_total').html(cost_total);

			$.ajax({
				url:"functions.php",
				method:"POST",
				data:{valoare_actualizata:value,id:id_produs},
				success:function(data){
					net_total();
					
				}
			})
			
			
		});
	}
	
	function actualizeaza_total(){
		var cost_produse = parseInt($('.cost_produse').html());
		var cost_livrare = parseInt($('.cost_livrare').html());
		var cost_total = cost_produse + cost_livrare;
		$('.net_total').html(cost_total);
	}

		$(document).on('click','.remove',function(event){
		var remove = $(this).parent().parent().parent();
		var remove_id = remove.find(".remove").attr("remove_id");
		$.ajax({
			url:"functions.php",
			method:"POST",
			data:{stergeProdusCart:1,remove_id:remove_id},
			success:function(data){
				$("#cart_message").html(data);
				checkOutDetails();
			}
		})
		window.setTimeout(function() {
			$(".alert").fadeTo(100, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 4000);
	})

	
