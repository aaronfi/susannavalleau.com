<?php

	$items_to_show=999;
	$futureOnly="false";
	include 'include/gCalendarReader.php';
	
	
	$jumpToYear = array();
?>



<?php

	include 'include/header.php';
	
?>

<center><h2 style="margin-bottom: 8px;"> Concerts </h2></center>

<center>
<a href="#upcoming" id="onpagelinks" style="padding-right:50px;">Upcoming Performances</a> 
<a href="#past" id="onpagelinks">Past Performances</a>
</center>

<br /><br />

<center>
<img src="pics/St. Barnabas, Bainbridge_long.JPG" alt="" title="Solo recital at St. Barnabas Episcopal Church, Bainbridge Island, WA" height="250" id="banner" border="7"> <br />
Solo recital at St. Barnabas Episcopal Church, Bainbridge Island, WA
</center>

<a name="upcoming"></a>
<br />

<center><h2> Upcoming Performances </h2></center>


<br />

	<?php
	//loop through all items
	
	$previousConcertsArray = array();
	
	$lineBreak = "";

	
	foreach ($events as $event):
		
		//Get and format dates to use
		$startTime = strtotime("-2 hours", strtotime($event->getStart()->getDateTime()));
		$eventTime = date($timeformat, $startTime);
		$gCalDate = date($dateformat, $startTime);
		$dateIconMonth = date($dateIconMonthFormat, $startTime);
		$dateIconDay = date($dateIconDayFormat, $startTime);
		$gCalStartTime = date($startTime);
		
		//pull variables out of the description
		//Make any URLs used in the description clickable
		$description = $event->getDescription();
		
		#$description = preg_replace('"\b(http://\S+)"', '<a href="$1" target="_blank">More Information</a>',  $description);
		#$description = preg_replace('"\b(https://\S+)"', '<a href="$1" target="_blank">More Information</a>',  $description);
		$descriptionArray = explode("\n", $description);
		
		$subtitleArray = array();
		$LocationArray = explode(",", $event->getLocation());
		$location = $LocationArray[0];
		
		$currentIndex  = 0;
		for ($i = $currentIndex ; $i < count($descriptionArray); $i++){
			
			if (substr($descriptionArray[$i], 0, 4) === "http"){			
				$descriptionArray[$i] = '<a href="' . $descriptionArray[$i] . '" target="_blank">More Information</a>';
			}elseif (strpos($descriptionArray[$i], 'http') !== false) {
				
				$row_str = "";
				foreach (explode("<br>", $descriptionArray[$i]) as $subrow ){

					if (substr($subrow, 0, 7) === "<a href"){	
						$end_post = strpos($subrow, '>');
						$next_start = strpos($subrow, '<', $next_post);
						
						$subrow = substr($subrow, 0, $end_post) . ">More Information</a><br>" ;
					}
					
					$row_str = $row_str . "<br>" . $subrow;
				}
				
				$descriptionArray[$i] = $row_str;
				
			}
			
			
			if ($descriptionArray[$i] != ""){
				array_push($subtitleArray, $descriptionArray[$i]);
			}
			else {
				$i = count($descriptionArray);
			}
			$currentIndex++;
				
		}
		

		if (  $gCalStartTime > $currentDate){
		
			echo $lineBreak;
			$lineBreak = "<br /> <hr /> <br />";
					
			echo "
			<table>
				<tr>
				<td width=\"50\" id=\"date\" height=\"63\"><h3>$dateIconMonth</h3><h3>$dateIconDay</h3></td>
					<td>
					<b style=\"color:#fff\"> $gCalDate, $eventTime<br />
					$location</b><br />
			";
			
			foreach ($subtitleArray as $subtitle){
				echo "$subtitle <br />";
			}
			
			echo "	
					</td>
				</tr>
			</table>
			<br />
			";
			
			for ($i = $currentIndex; $i < count($descriptionArray); $i++){
					echo $descriptionArray[$i];
					echo "<br />";
			}
		}
		else{ //create past performances strings
			$stringToPush = "";
			
			$stringToPush .= "<b style\"color:#fff\">$gCalDate";
			if ($eventTime != "")
				$stringToPush .= ", $eventTime";
			$stringToPush .= "<br />$location</b><br />";
			foreach ($subtitleArray as $subtitle){
				$stringToPush .= "$subtitle <br />";
			}
			
			$stringToPush .=  $timeTestingVariable;
			$stringToPush .=  "<br />";
			
			for ($i = $currentIndex; $i < count($descriptionArray); $i++){
					$stringToPush .= $descriptionArray[$i];
					$stringToPush .= "<br />";
			}
			
			/*//create link system
			if (!$year2011){ //we're still in 2010, fuck off
				if (date('Y', $startTime) == "2011"){
					$year2011 = true;
					$stringToPush.="<a name=\"2010\"></a>"; //Because we're working backwards
				}
			
			}
			else if (!$year2012){ //we're still in 2011, fuck off
				if (date('Y', $startTime) == "2012"){
					$year2012 = true;
					$stringToPush.="<a name=\"2011\"></a>"; //Because we're working backwards
				}
			}
			else if (!$year2013){ //we're still in 2012, fuck off
				if (date('Y', $startTime) == "2013"){
					$year2013 = true;
					$stringToPush.="<a name=\"2012\"></a>"; //Because we're working backwards
				}
			}*/
				
		
			if (count($jumpToYear) == 0 || $jumpToYear[0] != date('Y', $startTime)){
				if (count($jumpToYear) != 0){
					$stringToPush.="<a name=\"$jumpToYear[0]\"></a>"; //Because we're working backwards
				}
				array_unshift($jumpToYear, date('Y', $startTime));
			}
			
			$stringToPush .= "<br />";
			array_unshift($previousConcertsArray, $stringToPush);
		}
    
	//END INITIAL LOOP
	endforeach;
	
	//PAST PERFORMANCES
	
		echo "
		<br /><br />
		<center>
		<img src=\"pics/with the Seattle Metropolitan Chamber Orchestra_long.jpg\" alt=\"\" title=\"Susanna plays harpsichord with the Seattle Metropolitan Chamber Orchestra\" height=\"250\" id=\"banner\" border=\"7\">
		<br />
		Susanna plays harpsichord with the Seattle Metropolitan Chamber Orchestra 
		<br />
		</center>
		
		<a name=\"past\"></a>
		<br />

		<center><h2 style=\"margin-bottom: 5px;\"> Past Performances </h2></center>
		
		<center>";

		for ($i = 0; $i <  count($jumpToYear); $i++){
			$yearNum = $jumpToYear[$i];
			
			if ($i != count($jumpToYear)-1){
				echo "<a href=\"#$yearNum\" id=\"onpagelinks\" style=\"padding-right:50px;\">$yearNum</a> ";
			}
			else{
				echo "<a href=\"#$yearNum\" id=\"onpagelinks\">$yearNum</a>";
			}
		}
		echo "</center><br />";
		
		echo "<a name=\"$jumpToYear[0]\"></a>";


		
		foreach ($previousConcertsArray as $previousConcert){
			echo $previousConcert;
		}		
		?>


<?php
	include 'include/footer.php';
?>