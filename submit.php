<?php

/* include default settings */

	include ('controller.php');

/* include functions */

	include ('functions.php');

/* Get the amount of rows being used, if not found revert to default row count */

	if(isset($_GET['addrow'])){
		$row = $_GET['addrow'];
	}else{
		$row = $default_row_count;
	}

/* Get the amount of columns being used, if not found revert to default column count */

	if(isset($_GET['addcolumn'])){
		$column = $_GET['addcolumn'];
	}else{
		$column = $default_column_count;
	}

/* Collect table header data from the Ajax form submission and convert to array */

	if(isset($_GET['headers'])){
		$table_headers = $_GET['headers'];
		$explode_header_array = explode(',', $table_headers);
	}

/* Collect GET data from the Ajax form submission and convert to array */

	if(isset($_GET['input']) || !empty($_GET['input'])){
		$input_get_data = $_GET['input'];
		$explode_input_array = explode(',', $input_get_data);
	}else{
		$input_get_data = "";
		$explode_input_array = "";
	}

/* iterate through array and group based on column count. */

	if(is_array($explode_input_array)){
		$split_input_array = array_chunk($explode_input_array, $column);
		foreach($split_input_array as $key => $input_array_pieces){
			$grouped_input_arrays[] = $input_array_pieces;
		}
	}

/* combine input fields and column headers into one array */

	$merge_input_arrays = array();
	foreach($grouped_input_arrays as $inner_grouped_array){
		foreach($inner_grouped_array as $grouped_key => $grouped_value){
			$newArr[$explode_header_array[$grouped_key]] = $grouped_value;
		}
		array_push($merge_input_arrays, $newArr);
	}

/* check if a row/column is being added or removed, if true update counter */

	if(isset($_GET['action'])){
		if($_GET['action'] == 'addrow'){
			$row ++;
		}else if($_GET['action'] == 'removerow'){
			$row --;
		}else if($_GET['action'] == 'addcolumn'){
			$column ++;		
		}else if($_GET['action'] == 'removecolumn'){
			$column --;
		}
	}
	
/* serialize Array for storage later */

	if(is_array($merge_input_arrays)){	
		$serialized_array = serialize($merge_input_arrays);
	}else{
		$serialized_array = "";
	}

/* check if the submit button has been clicked - if true update datastore and send callback*/

	if(isset($_GET['action']) && ($_GET['action'] !== 'load')){
		accessdatastore($serialized_array, $filename);
	}

/* get data from datastore to use in the form values */

	$check_datastore = file_get_contents($filename,true);
	$merge_input_arrays = unserialize($check_datastore);
	

/* automated row and column generator*/
/* this is added to protect the form from creating too many rows */

	if($row == $row_limit || $row > $row_limit){
		$prevent_row_adding = "";
	}else{
		$prevent_row_adding = "<img src='img/add_button.png' alt='Add Row' title='Add a Row'>";
	}

/* this is added to protect the form from removing too many rows */

	if($row == $default_column_display || $row < $default_column_display){
		$prevent_row_removing = "";
	}else{
		$prevent_row_removing = "<img src='img/remove_button.png' alt='Remove Row' title='Remove a Row'>";
	}
	

/* this is added to protect the form from creating too many columns */

	if($column == $column_limit || $column > $column_limit){
		$prevent_column_adding = "";
	}else{
		$prevent_column_adding = "<img src='img/add_button.png' alt='Add Column' title='Add a column'>";
	}

/* this is added to protect the form from creating too many columns */

	if($column == $default_column_display  || $column < $default_column_display){
		$prevent_column_removing = "";
	}else{
		$prevent_column_removing = "<img src='img/remove_button.png' alt='Remove Column' title='Remove a column'>";
	}

/* this part builds the input fields and table layout */

	for($index = 0; $index < $row; $index ++){
		$column_header_count = 0;
		$show_row_number = $index + 1;
		$form_input .="<tr><td align=left><span class='row_number'>$show_row_number:</span></td>";
		$fixed_table_header ="";
		$input_data = "";
		for($column_index = 0; $column_index < $column; $column_index ++){
			$column_header_count ++;
			if(isset($merge_input_arrays[$index])){
			$input_data = $merge_input_arrays[$index];
			}
			$new_header_title = "Column $column_header_count";
			if($column_index == '0'){
				$fixed_table_header .="<th>$first_header</th>";
				$form_input .="<td><input type='text' class='input' name='$first_header' value='$input_data[$first_header]' ></td>";
			}else if($column_index =='1'){
				$fixed_table_header .="<th>$second_header</th>";
				$form_input .="<td><input type='text' class='input' name='$second_header' value='$input_data[$second_header]' ></td>";
			}else{
				$fixed_table_header .="<th>Column $column_header_count</th>";
				$form_input .="<td><input type='text' class='input' name='Column $column_header_count' value='$input_data[$new_header_title]' ></td>";
			}
		}
		$form_input .="</tr>";
	}

/* added just to make the submit button move with the expanding table */

	$add_column_rowspan = $column - 2;
?>

<!-- input form start -->
	<form action="javascript:void(0);" class='main_form'>
   		<table>
       			<tr>
				<th></th>
				<?php echo $fixed_table_header ;?>
			</tr>
				<?php echo $form_input;?>
			<tr>	
				<td class='index_row'>
				</td>
				<td align=center>
					Row <a  class='action_btn' href="javascript:void(0);" onclick="ajaxrequest('submit.php','context','addrow', <?php echo $row ;?>, <?php echo $column ;?>);" ><?php echo $prevent_row_adding;?></a><a href="javascript:void(0);" onclick="ajaxrequest('submit.php','context','removerow', <?php echo $row ;?>, <?php echo $column ;?>);" ><?php echo $prevent_row_removing ;?></a>
				</td>
				<td align=center>
					Column <a  class='action_btn' href="javascript:void(0);" onclick="ajaxrequest('submit.php','context','addcolumn', <?php echo $row ;?>, <?php echo $column ;?>);"><?php echo $prevent_column_adding;?></a><a href="javascript:void(0);" onclick="ajaxrequest('submit.php','context','removecolumn', <?php echo $row ;?>, <?php echo $column ;?>);" ><?php echo $prevent_column_removing ;?></a>
				</td>	
				<td align=right colspan="<?php echo $add_column_rowspan ;?>">
					<button class='btn submit_btn' href="javascript:void(0);"  onclick="ajaxrequest('submit.php','context','update', <?php echo $row ;?>, <?php echo $column ;?>);">Update</button>
				</td>
			</tr>
		</table>
	</form>
<!-- input form end -->

<?php

/* send the stored data back to the front end just so we can check the script has run*/
	
	if(isset($_GET['action'])){
		if($_GET['action'] == 'update'){
			$json_array = json_encode($merge_input_arrays);
			if(array_key_exists('callback', $_GET)){
				$callback = $_GET['callback'];
				echo $update_result;
				echo "<div class='upload_results'>The section below shows the data that was stored<br /><br />";
				echo $callback.'('.$json_array.');';
				echo "</div>";
			}else{
			}
		}
	}		
?>