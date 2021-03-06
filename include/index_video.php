
<?php

	include 'include/header.php';
	
?>

<?php

	$items_to_show=5;
	$futureOnly="true";
	include 'include/gCalendarReader.php';
	
?>

<img src="pics/Susanna 110_thumb.JPG" alt="" height="250" style="float:right">


<center><h2> <b style="font-size:31px">U</b>PCOMING <b style="font-size:31px">C</b>ONCERTS </h2></center>

<br />

<table>



<?php
	foreach ($events as $event):
		
		//Get and format dates to use
		$startTime = strtotime("-2 hours", strtotime($event->getStart()->getDateTime()));
		$eventTime = date($timeformat, $startTime);
		$gCalDate = date($dateformat, $startTime);
		$dateIconMonth = date($dateIconMonthFormat, $startTime);
		$dateIconDay = date($dateIconDayFormat, $startTime);
		
		//pull variables out of the description
		//Make any URLs used in the description clickable
		$description = preg_replace('"\b(http://\S+)"', '<a href="$1" target="_blank">Church Info</a>',  $event->getDescription());
		$descriptionArray = explode("\n", $description);
		$subtitleArray = array();
		$LocationArray = explode(",", $event->getLocation());
		$location = $LocationArray[0];
		
		$currentIndex  = 0;
		for ($i = $currentIndex ; $i < count($descriptionArray); $i++){
			if ($descriptionArray[$i] != ""){
				array_push($subtitleArray, $descriptionArray[$i]);
			}
			else {
				$i = count($descriptionArray);
			}
			$currentIndex++;
		}
		
			echo "
				<tr>
				<td width=\"50\" id=\"date\"><h3>$dateIconMonth</h3><h3>$dateIconDay</h3></td>
					<td>
					<b> $gCalDate, $eventTime<br />
					$location</b><br />
			";
			
			foreach ($subtitleArray as $subtitle){
				echo "$subtitle <br />";
			}
			
			//this is for giving it half the line break heigh of <br />.   
			echo "<p style=\"margin: 0; text-indent: 0em;padding-top:5px;\">";
			echo $descriptionArray[$currentIndex];
			
			echo "<br /><br />";
			
			echo "</td></tr>";
		
    
	//END INITIAL LOOP
	endforeach;

?>

</table>

<center><h2> <b style="font-size:31px">T</b>HE <b style="font-size:31px">L</b>IVE <b style="font-size:31px">M</b>USIC <b style="font-size:31px">P</b>ROJECT </h2></center>

Susanna was featured in a video produced by the Live Music Project, showing the Fisk Opus 140 organ at Plymouth Church in Seattle and previewing her concert in that venue.  

<br> <br>

<center>
<iframe width="853" height="480" src="https://www.youtube.com/embed/_7f87ZcwUfU" frameborder="0" allowfullscreen></iframe>
</center>

<br>

<?php
	include 'include/footer.php';
?>


