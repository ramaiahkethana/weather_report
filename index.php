

<html>
    <head>
	  <title>Weahter Report</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="css/bootstrap.min.css">
	  <script src="js/jquery.min.js"></script>
	  <script src="js/bootstrap.min.js"></script>
	  <style>
	  	#footer{
		 position:fixed;
		 bottom:0;
		 left:0;
		 width: 100%;
		 padding:14px 7px 7px 7px;
		 background-color: black;
		}
	</style>
	 
	  </script>
	</head>
    <body>
        <?php
			include "home.php";
		?>
		<center>
        <h3>About Us</h3>
		<hr style="border-top: 2px solid skyblue; width: 10%"/>
		<p class="data" style="border:1px solid black;width: 80%;padding:20px;border-radius: 10px;">
			Here, we know the current weather report and 5 days weather report of a city. We developed this application by using openweather api.
		</p>
		<br>
		<p>
			<a href="report.php" class="btn btn-default">Current Weather</a> &nbsp; &nbsp; <a href="future_report.php" class="btn btn-default">Current Weather</a>
		</p>
		</center>
		
		<div id="footer">

		  <div class="container">
		    <div class="fnav">
		      <p>Copyright &copy; Helios. Designed by <a href="http://www.templatewire.com" rel="nofollow">TemplateWire</a></p>
		    </div>
		  </div>
		</div>
    </body>
</html>
