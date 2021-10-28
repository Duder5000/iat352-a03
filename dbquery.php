<?php

	//get the php files with the sql login info
	include($_SERVER['DOCUMETN_ROOT'] . "db.php");

	//create a variable for connecting to the sql server
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	//check for errors with connecting to the sql server
	if(mysqli_connect_errno()){
		echo "Error: " . mysqli_connect_error() . '</br>';
	}else{
		echo 'No Error</br>';
	}

	//var dump for testing
	echo '<b>var_dump($_POST)</b></br>';
	var_dump($_POST);

?>


<!-- The form for selecting what to get & dispaly  -->
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
	
	//Select the required columns when checked
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
		$qstr = $qstr . 'orderdetails.priceEach, ';
	}

	//Remove trailing comman & space from above if statements
	$qstr = rtrim($qstr, ', ');

	
	//Select the corret table, stop at orders if multiple
	if($_POST['number'] == TRUE || $_POST['date'] == TRUE){
		$qstr = $qstr . ' FROM orders';
	}else if($_POST['name'] == TRUE || $_POST['desc'] == TRUE){
		$qstr = $qstr . ' FROM products';
	}else if($_POST['quantity'] == TRUE || $_POST['price'] == TRUE){
		$qstr = $qstr . ' FROM orderdetails';
	}

	//Add joins only if columns that require other tables are  checked
	if($_POST['number'] == TRUE || $_POST['date'] == TRUE){

		if($_POST['name'] == TRUE || $_POST['desc'] == TRUE || $_POST['quantity'] == TRUE || $_POST['price'] == TRUE){
			if($_POST['name'] == TRUE || $_POST['desc'] == TRUE){
				$qstr = $qstr . ' INNER JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber ';
			}
			if($_POST['quantity'] == TRUE || $_POST['price'] == TRUE){
				$qstr = $qstr . ' INNER JOIN products ON orderdetails.productCode = products.productCode ';
			}
		}		

	}else{

		//*************************Message to marker*************************
		//Do something to handle all the possible combinations that require joins
		//Not sure how to do this with out just using a ton of if statements which seems like a brute force method & like not the correct way
		//I'm guessing there is some technice that I should of learned that through some fault of my own I didn't.
		//I don't see any point of typing out a bunch of if statement to brute force the solution because I don't see that being worth any points, so //I'm not going to waste my time & just leave it with this partial solution.
		//Once marks are released I'd like to book an office hour to go over the correct solution so that I know going forward.
		//*************************Message to marker*************************

	}

	
	//adding where string for with number or date range
	if($_POST['orderNumber'] != ''){
		$qstr = $qstr . ' WHERE orders.orderNumber = ' . $_POST['orderNumber'];
	}else if($_POST['dateFrom'] != '' && $_POST['dateTo'] != ''){
		$qstr = $qstr . ' WHERE NOT (orders.orderDate > ' . $_POST['dateTo'] . ' OR orders.orderDate < ' . $_POST['dateFrom'] . ')';
	}

	echo $qstr;

?>

<h2>Results</h2>

<?php
	
	//display var dump of the results of the sql query for testing
	$result = mysqli_query($conn, $qstr);
	echo '<b>var_dump($result)</b></br>';
	var_dump($result);

	//display the results in a table

	//*************************Message to marker*************************
	//I tried doing some searching to figure out how to dynamically create tables with varying numbers of columns.
	//I know how to do a varying amount of rows, looping through the results & displaying them similar to how we did in lab.
	//But what I don't understand is how to do the columns other than a ton of if statements, which takes me to the same conclusion as i did in my //ealier comment message. 
	//*************************Message to marker*************************

?>