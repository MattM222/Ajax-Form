<?php

/* ### this is the main controller for the default settings of the form, i also added declared variables ### */


/* set default datastore file name */

	$filename = "datastore.ser";

/* Default row count/ column to display  - this prevents too many inputs being removed */
	
	$default_row_display = "1";

	$default_column_display = "2";

/* The amount of maximum rows that can be displayed */

	$row_limit ='10';

/* default first column header */

	$first_header = "First Name";

/* default second column header */

	$second_header = "Surname";

/* The amount of maximum columns that can be displayed */

	$column_limit ='8';

/* declare variables used to prevent error reports */
	$explode_input_array = "";
	$merge_input_arrays = array();
	$form_input = "";
	$update_result = "";

/* this reads data from the file and defines rows & columns containing data */

	$get_datastore = file_get_contents($filename,true);
	$unserialize_datastore = unserialize($get_datastore);
	$count_datastore_rows = count($unserialize_datastore);
	if($count_datastore_rows > 1 ){
		$default_row_count = $count_datastore_rows;
	}else{
		$default_row_count = $default_row_display;
	}
	$count_datastore_columns = count($unserialize_datastore[0]);
	if($count_datastore_rows > 1 ){
		$default_column_count = $count_datastore_columns;
	}else{
		$default_column_count = $default_column_display;
	}

?>
