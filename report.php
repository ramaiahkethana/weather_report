

<html>
    <head>
	  <title>Current day Weather Report</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="css/bootstrap.min.css">
	  <script src="js/jquery.min.js"></script>
	  <script src="js/bootstrap.min.js"></script>
	  
	  </script>
	</head>
    <body>
        <?php
			include "home.php";
		?>
		<center>
        <h3>Weather report by city name</h3>
		<form class="form-inline" method="post">
			<div class="form-group">
				<input type="text" class="form-control" type="text" name="name" placeholder="City name">
			</div>&nbsp;
			<div class="form-group">
				<input type="submit" class="form-control btn btn-info" type="text" name="submit" value="search">
			</div>
		</form>
		<br>
		<p class="data">
			<?php
				if(isset($_POST["submit"])){
					//use for connected the net
					$connected = @fsockopen("www.google.com", 80); 
					if($connected){
						$name = $_POST["name"];
						error_reporting(0);
						
						if($data = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=$name&units=Celsius&appid=b8541037d3308fa3249b2c2659e6c031")){
							$a = json_decode($data);
							
							date_default_timezone_set("Asia/Calcutta");
							echo '<div style=""><span><img src="http://openweathermap.org/img/w/'.$a->{"weather"}[0]->{"icon"}.'.png"/>&nbsp;&nbsp;</span><span class=" " style="color:orange;"><b>'.$a->{"name"}.'</b></span> <b style="color:orange">,'.$a->{"sys"}->{"country"}.' </b>   <img src="http://openweathermap.org/images/flags/'.strtolower($a->{"sys"}->{"country"}).'.png">&nbsp; &nbsp;<b>'.$a->{"weather"}[0]->{"description"}.'</b></div>';
							echo '<div style="margin-top:10px;"><span class="badge">'.round(($a->{"main"}->{"temp"}-273.15),2).'°C</span><span> Temperature from '.round(($a->{"main"}->{"temp_min"}-273.15),2).'°C to '.round(($a->{"main"}->{"temp_max"}-273.15),2).'°C, Wind speed: '.round($a->{"wind"}->{"speed"},2).'m/s, Clouds: '.round($a->{"clouds"}->{"all"},2).'%, Humidity: '.round($a->{"main"}->{"humidity"},2).'%,'.round($a->{"main"}->{"pressure"},2).'hPa</div>';
							echo '<div style="margin-top:10px;">Sun rise: '.date("Y-m-d H:i:s",$a->{"sys"}->{"sunrise"}).', Sun sets: '.date("Y-m-d H:i:s",$a->{"sys"}->{"sunset"}).'</div>';
						}else{
							echo "<b style='color:red'>No data found with the city name ".$name."</b>";
						}
					}else{
						echo '<b style="color:red">No internet connection</b>';
					}
				}
			?>
		</p>
		</center>
    </body>
</html>
