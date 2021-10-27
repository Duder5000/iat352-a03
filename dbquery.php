<?php

	include($_SERVER['DOCUMETN_ROOT'] . "db.php");

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	if(mysqli_connect_errno()){
		echo "Error: " . mysqli_connect_error() . '</br>';
	}else{
		echo 'No Error</br>';
	}

	var_dump($_POST);

?>

<h1>Query</h1>
<h2>Select Order Parameters</h2>

<form action="dbquery.php" method="post">
    Order Number: <input type="text" name="orderNumber" value=""/> OR </br>
    Order Date (YYYY-MM-DD):</br>
    From: <input type="text" name="dateFrom" value=""/> To: <input type="text" name="dateTo" value=""/></br>

    <h2>Select Columns to Display</h2>    

    <input type="checkbox" id="number" name="number" value="number">
	<label for="vehicle1">Order Number</label><br>

	<input type="checkbox" id="date" name="date" value="date">
	<label for="vehicle2">Order Date</label><br>

	<input type="checkbox" id="shipped" name="shipped" value="shipped">
	<label for="vehicle3">Shipped Date</label><br>

	<input type="checkbox" id="name" name="name" value="name">
	<label for="vehicle3">Product Name</label><br>

	<input type="checkbox" id="desc" name="desc" value="desc">
	<label for="vehicle3">Product Description</label><br>

	<input type="checkbox" id="quantity" name="quantity" value="quantity">
	<label for="vehicle3">Quantity Order</label><br>

	<input type="checkbox" id="price" name="price" value="price">
	<label for="vehicle3">Price Each</label><br><br>

	<input type="submit"/>
</form>

<?php
	
	$qstr = 'SELECT ';
	if($_POST['number'] == TRUE){
		$qstr = $qstr . 'orders.orderNumber, ';
	}
	if($_POST['date'] == TRUE){
		$qstr = $qstr . 'orders.orderDate, ';
	}
	if($_POST['shipped'] == TRUE){
		$qstr = $qstr . 'orders.shippedDate, ';
	}
	if($_POST['name'] == TRUE){
		$qstr = $qstr . 'products.productName, ';
	}
	if($_POST['desc'] == TRUE){
		$qstr = $qstr . 'products.productDescription, ';
	}
	if($_POST['quantity'] == TRUE){
		$qstr = $qstr . 'orderdetails.quantityOrdered, ';
	}
	if($_POST['price'] == TRUE){
		$qstr = $qstr . 'orderdetails.priceEach ';
	}

	// Add if statements to remove joins when not needed
	$qstr = $qstr . ' FROM orders 
		INNER JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber 
		INNER JOIN orderdetails.productCode = products.productCode';

	if($_POST['orderNumber'] != ''){
		$qstr = $qstr . ' WHERE orders.orderNumber = ' . $_POST['orderNumber'];
	}else if($_POST['dateFrom'] != '' && $_POST['dateTo'] != ''){
		$qstr = $qstr . ' WHERE NOT (orders.orderDate > ' . $_POST['dateTo'] . ' OR orders.orderDate < ' . $_POST['dateFrom'] . ')';
	}

	echo $qstr;

?>

<h2>Results</h2>

<?php
	
	$result = mysqli_query($conn, $qstr);
	var_dump($result);

?>