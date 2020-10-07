<?php
session_start();
include_once("connect.php");


//current URL of the Page. cart_update.php redirects back to this URL
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Scarf</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/main.css">
<meta name="viewport" content="width=device-width, initial-scale=1,user-scaleable=no">
<style type="text/css">
		@font-face { font-family:Angelface; src: url('Angelface.otf'); }		</style>
	<script 
	src="https://code.jquery.com/jquery-3.4.1.js"
	integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	crossorigin="anonymous">
	</script>
	<script src="js/bootstrap.min.js"></script>

	</head>
<body>
	<nav class ="navbar navbar-default navbar-fixed-top" id="navbar">
		<div class="container">
			<ul class="nav navbar-nav">
						<li><a href="index.php" id="text"> Home</a></li>								
						<li><a href="#" id="text"> Products </a></li>
						
				</ul>
			<ul class="nav navbar-nav navbar-right" >
        		<li><a href="registration.php" id="text">Sign up</a></li>
        		<li><a href="login.php" id="text">Log in</a></li>
        		<li><a href="#" id="text">My account</a></li>
        		<li><a href="shoppingcart.php" id="text">Shopping cart</a></li>
      		</ul>
		</div>
	</nav>


<h1 align="center">Products </h1>

<!-- Aici poti vedea cosul de cuparaturi si ce este in el -->
<?php
if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0)
{
	//de aici are loc "descrierea" cosului propriu-zis de cumparaturi
	echo '<div class="cart-view-table-front" id="view-cart">';
	echo '<h3>Your Shopping Cart</h3>';
	echo '<form method="post" action="cart_update.php">';
	echo '<table width="100%"  cellpadding="5" cellspacing="3">';
	echo '<tbody>';
//Aici se ocupa tot de cosul de cumparaturi, acel div lateral
	$total =0;
	$b = 0;

	foreach ($_SESSION["cart_products"] as $cart_itm)
	{
		$product_name = $cart_itm["product_name"];
		$product_qty = $cart_itm["product_qty"];
		$product_price = $cart_itm["product_price"];
		$product_code = $cart_itm["product_code"];
		$product_color = $cart_itm["product_color"];
		$bg_color = ($b++%2==1) ? 'odd' : 'even'; //zebra stripe
		echo '<tr class="'.$bg_color.'">';
		echo '<td>Qty <input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
		echo '<td>'.$product_name.'</td>';
		echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /> Remove</td>';
		echo '</tr>';
		$subtotal = ($product_price * $product_qty);
		$total = ($total + $subtotal);
	}

	echo '<td colspan="2">';
	//pe parcursul a cate celule sa se intinda cele doua butoatne
	//CheckOUT si UPDATE
	echo '<button type="submit">Update</button><a href="view_cart.php" class="button">Checkout</a>';
	echo '</td>';
	echo '</tbody>';
	echo '</table>';
	
	$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
	echo '</form>';
	echo '</div>';
	//pana aici are loc "descrierea" cosului propriu-zis de cumparaturi
}
?>


<!--Lista de produse-->
<?php
$results = $mysqli->query("SELECT product_code, product_name, product_desc, product_img_name, price FROM products ORDER BY id ASC");
if($results){ 
$products_item = '<ul class="products">';
//fetch results set as object and output HTML
while($obj = $results->fetch_object())
{
	//produs cu produs se trece in lista de produse
$products_item .= <<<EOT
	<li class="product">
	<form method="post" action="cart_update.php">
	<div class="product-content"><h3>{$obj->product_name}</h3>
	<div class="product-thumb"><img src="images/{$obj->product_img_name}" id ="produse"></div>
	<div class="product-desc">{$obj->product_desc}</div>
	<div class="product-info">
	Price {$currency}{$obj->price} 
	
	<fieldset>
	<!--se face un labelunde clientul poate sa aleaga culoarea dorita prodului respectiv-->
	<!--se foloseste <select>-->
	<!--Aici am aduagat pagina ADAUGAT.PHP-->
	<tr>
	<td align="center">
				<a href="adaugare.php" class="button" id="buton">Modalitate de Plata</a>
    </td>  
</tr>	
	<!--se face un alt label cu un textbox unde clientul poate sa introduca cantitatea dorita din acel produs-->
	<label>
		<span>Quantity</span>
		<input type="text" size="2" maxlength="2" name="product_qty" value="1" />
	</label>
	
	</fieldset>
	<input type="hidden" name="product_code" value="{$obj->product_code}" />
	<input type="hidden" name="type" value="add" />
	<input type="hidden" name="return_url" value="{$current_url}" />
	<div align="center"><button type="submit" class="add_to_cart">Add product</button></div>
	</div></div>
	</form>
	</li>
EOT;
}
$products_item .= '</ul>';
echo $products_item;
}
?> 
<!--Aici se termina lista de produse-->
</body>
</html>
