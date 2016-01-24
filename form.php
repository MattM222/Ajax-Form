<?php 
/* include row display defaults */

	include ('controller.php');

/* include functions */

	include ('functions.php');
?>

<html>
<head>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <title>	
    </title>

<!-- include CSS -->

    <link href="css/style.css" rel="stylesheet">

<!-- include JS/Ajax library -->

	<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body onload="ajaxrequest('submit.php','context','load',<?php echo $default_row_count ;?>,<?php echo $default_column_count ;?>)";>

<!-- display input form (the ajax functions calls to this based on its id ) -->

		<div id="context"></div>

</body>
</html>

