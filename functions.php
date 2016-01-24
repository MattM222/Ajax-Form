<?php

/* include default settings */

	include ('controller.php');

/* Function to update Array contents to the datastore - if file doesn't exists then it creates one*/

	function accessdatastore($write_array, $filename){
		if(file_exists($filename)){
			if(is_writable($filename)){
				$file = fopen($filename ,"w+");
				fwrite($file, $write_array);
				fclose($file);
				if($_GET['action'] == 'update'){
					echo "<h2>File successfully uploaded!</h2>";
				}
			}else{
				$file = fopen($filename ,"w+");
				fwrite($file, $write_array);
				fclose($file);
				chmod($file, 666);
				echo "<h2>Error: There was a problem writing to datastore, please try again</h2>";
			}
		}else{
				$file = fopen($filename,"w+");
				fwrite($file, $write_array);
				fclose($file);
				chmod($file, 666);
				echo "<h2>Ooops: It appears your datastore was missing so we've made one for you, please try again</h2>";
		}
	}
?>
<!-- using Ajax to prevent page reload whilst sending data (user friendly and clean approach) -->
<script type="text/javascript">
	function ajaxrequest(serverPage, tagID, action, row, column , remove) {
		var request = new XMLHttpRequest();	
		var inputs = document.getElementsByClassName( 'input' ),
		names  = [].map.call(inputs, function( input ) {
        		return input.value;
   		});
		headers  = [].map.call(inputs, function( output ) {
        		return output.name;
   		});
		var url = serverPage+'?&headers=' + headers + '&input=' + names +'&action=' + action + '&addrow=' + row + '&addcolumn=' + column + '&callback=receiver';
		request.open("GET", url, true);
		request.send(null);
		request.onreadystatechange = function() {
			if (request.readyState == 4) {
				document.getElementById(tagID).innerHTML = request.responseText;
			}
		}
	}
</script>