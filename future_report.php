<!DOCTYPE html>
<html>
<head>
	<title>5 days Weather Report</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script></script>
	<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	
</head>
<body>
<?php include "home.php"; ?>
<center>
<h3>5 days Weather report by city name</h3>
		<form class="form-inline" method="post">
			<div class="form-group">
				<input type="text" class="form-control" type="text" name="name" placeholder="City name">
			</div>&nbsp;
			<div class="form-group">
				<input type="submit" class="form-control btn btn-info" type="text" name="submit" value="search">
			</div>
		</form>
		</center>
		<br>
		
<center><div id="chartContainer" style="height: 230px; width: 90%;"></div></center><br>
<div class="data">
<?php
if(isset($_POST["submit"])){
	$name = $_POST["name"];
	 //5 days data by five days by co-ordinates
	$connected = @fsockopen("www.google.com", 80); 
	if($connected){
		//arrays initilization
		$tempMinArr = array_fill(0,5,0);
		$tempMaxArr = array_fill(0,5,0);
		$windArr = array_fill(0,5,0);
		$cloudsArr = array_fill(0,5,0);
		$pressureArr = array_fill(0,5,0);
		$humidityArr = array_fill(0,5,0);
		$datesArr = array_fill(0,5,0);
		$fullDatesArr = array_fill(0,40,0);
		$fullTempArr = array_fill(0,40,0);
		
		$data = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?q=$name&appid=b8541037d3308fa3249b2c2659e6c031");
		//decoding the data into json
		$a = json_decode($data);
		$b =  $a->{"list"};
		
		$i = 0;
		$count = sizeof($b);
		
		$j = 0;
		while ($j == 0){
			$temp_min = 0;
			$temp_max = 0;
			$wind = 0;
			$clouds = 0;
			$pressure = 0;
			$humidity = 0;
			while($i < ($count - 32)){
				$temp_min = $temp_min+($b[$i]->{"main"}->{"temp_min"}-273.15);
				$pressure = $pressure+$b[$i]->{"main"}->{"pressure"};
				$temp_max = $temp_max+($b[$i]->{"main"}->{"temp_max"}-273.15);
				$wind = $wind + $b[$i]->{"wind"}->{"speed"};
				$clouds = $clouds + $b[$i]->{"clouds"}->{"all"};
				$fullDatesArr[$i] = $b[$i]->{"dt_txt"};
				
				$fullTempArr[$i] = round((($b[$i]->{"main"}->{"temp_min"}-273.15) + ($b[$i]->{"main"}->{"temp_max"}-273.15))/2) ;
				$i++;
			}
			$datesArr[$j] = date("d-m-Y",$b[0]->{"dt"});
			$tempMinArr[$j] = round(($temp_min/($count - 32)),2);
			$tempMaxArr[$j] = round(($temp_max/($count - 32)),2);
			$windArr[$j] = round($wind/(($count - 32)),2);
			$cloudsArr[$j] = round($clouds/($count - 32),2);
			$pressureArr[$j] = round($pressure/($count - 32),2);
			$j++;
		}
		while ($j < 5){
			$temp_min = 0;
			$temp_max = 0;
			$wind = 0;
			$clouds = 0;
			$pressure = 0;
			$k = 0;
			while($k <= 7){
				if($j == 5 && $k == 7){
					break;
				}
				if($k == 0){
					$datesArr[$j] = date("d-m-Y",$b[$i]->{"dt"});
				}
				$temp_min = $temp_min+($b[$i]->{"main"}->{"temp_min"}-273.15);
				$temp_max = $temp_max+($b[$i]->{"main"}->{"temp_max"}-273.15);
				$wind = $wind + $b[$i]->{"wind"}->{"speed"};
				$pressure = $pressure+$b[$i]->{"main"}->{"pressure"};
				$clouds = $clouds + $b[$i]->{"clouds"}->{"all"};
				$fullDatesArr[$i] = $b[$i]->{"dt_txt"};
				$fullTempArr[$i] = round((($b[$i]->{"main"}->{"temp_min"}-273.15) + ($b[$i]->{"main"}->{"temp_max"}-273.15))/2) ;
				
				$i++;
				$k++;
			}
			$tempMinArr[$j] = round(($temp_min/8),2);
			$tempMaxArr[$j] = round(($temp_max/8),2);
			$windArr[$j] = round(($wind/8),2);
			$cloudsArr[$j] = round(($clouds/8),2);
			$pressureArr[$j] = round(($pressure/8),2);
			$j++;
		}
		
		//table 
		
		echo "<center>";
		echo "Report of <b>".$name."</b>";
		echo "<table class='table table-bordered' style='width:82%'>";
		
		$j = 0;
		while ($j < 5){
			
			echo "<tr>";
			echo '<td><span></span>'.$datesArr[$j].'</td>';
			echo "<td><span class='badge'>".$tempMinArr[$j]." °C</span>";
			echo "&nbsp;<span class='badge ' style='background-color:orange' >".$tempMaxArr[$j]." °C</span>";
			echo '<br><span style="margin-left:5px;">Wind: '.$windArr[$j].' m/s</span>';
			echo '<br><span style="margin-left:5px;margin-top:5px;">Clouds: '.$cloudsArr[$j].'% &nbsp; Pressure: '.$pressureArr[$j].' hpa</span></td>';
			echo "<tr>";
			$j++;
		}
		
		echo "</table>";
		echo "</center>";
		
		//ending table
	}else{
		echo "<center><b style='color:red'>no internet connection.</b></center> ";
	}
}
?>
</div>


<!-- chart script -->
<?php
if(isset($_POST["submit"])){
?>
<script type="text/javascript">
	window.onload = function () {
		
		
		
		console.log("ss");
		var chart = new CanvasJS.Chart("chartContainer",
		{
			title: {
				text: "Weather Report"
			},
                        animationEnabled: true,
			axisX:{      
				
				interval:6,
				intervalType: "hour",
				labelAngle: 0,
				labelFontColor: "rgb(0,75,141)",
				minimum:new Date
				<?php
					echo '('.date("Y",strtotime($fullDatesArr[0])).','.date("m",strtotime($fullDatesArr[0])).','.date("d",strtotime($fullDatesArr[0])).','.date("H",strtotime($fullDatesArr[0])).',00,00)';
				?>
			},
			axisY: {
				title: "Temprature",
				tickColor: "azure",
				titleFontColor: "rgb(0,75,141)",
				interval:30
				
			},
			data: [
			{        
				indexLabelFontColor: "darkSlateGray",
				name: 'views',
				type: "area",
				color: "rgba(0,75,141,0.7)",
				markerSize:8,
				dataPoints: [
				<?php
				
				$count = 36;
					$i = 0;
					//echo '{ x: new Date("'.date("Y",$fullDatesArr($i)).','.date("m",$fullDatesArr($i)).','.date("d",$fullDatesArr($i)).','.date("H",$fullDatesArr($i)).',00,00"), y: 23,  indexLabel: "23m", indexLabelOrientation: "vertical", indexLabelFontColor: "orangered", markerColor: "orangered"},';       
					echo '{ x: new Date('.date("Y",strtotime($fullDatesArr[$i])).','.date("m",strtotime($fullDatesArr[$i])).','.date("d",strtotime($fullDatesArr[$i])).','.date("H",strtotime($fullDatesArr[$i])).',00,00), y: '.$fullTempArr[$i].',  indexLabel: "'.$fullTempArr[$i].'", indexLabelOrientation: "vertical", indexLabelFontColor: "orangered", markerColor: "orangered"},';       
					
					$i = 1;
					
					
					
					while ($i < $count){
						echo '{ x: new Date('.date("Y",strtotime($fullDatesArr[$i])).','.date("m",strtotime($fullDatesArr[$i])).','.date("d",strtotime($fullDatesArr[$i])).','.date("H",strtotime($fullDatesArr[$i])).',00,00), y: '.$fullTempArr[$i].',  indexLabel: "'.$fullTempArr[$i].'°C"},';       
						$i++;
					}
					
				?>
				
				
				]	
			}
			
			]
		});
		

chart.render();

}
</script>
<?php 
	}
?>
</body>
</html>