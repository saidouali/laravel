<?php
include_once('db/connexiondb.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Prendre rdv</title>

	<!--Requirement jQuery-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<!--Load Script and Stylesheet -->
	<script type="text/javascript" src="jquery.simple-dtpicker.js"></script>
	<link type="text/css" href="jquery.simple-dtpicker.css" rel="stylesheet" />
	<!---->
	  <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

     <link rel="stylesheet" href="css/style.css">

	<style type="text/css">
		body { background-color: #fefefe; padding-left: 2%; padding-bottom: 100px; color: #101010; }
	
	</style>
</head>
<body>


	<hr />

		<input type="text" name="date3" value="">
		<script type="text/javascript">
			$(function(){
				$('*[name=date3]').appendDtpicker({
					"inline": true,
					"current": "2012-3-4 12:30"
				});
			});
		</script>
		
</script>

<div>

	<input type="submit" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="background: #1abc9c" name="envoyer" value="Envoyer">
</div>
 <?php
   require_once('pages.php');
    ?>
</body>
</html>
