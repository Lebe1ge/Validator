<?php session_start(); include('include/connect.php'); ?>
<!DOCTYPE html>
<html lang="en" ng-app="connect">
    <head>
        <meta charset="utf-8" />
        <title>Valid[W3C]</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <h1><img src="images/W3C_Logo.png" alt="W3C Validator" title="W3C Validator"/> </h1>
        </header>
<?php
		
	if(isset($_SESSION['pseudo']))
	{ ?>
        <div class="container">
            <search></search>
        </div>
<?php }	
	else
	{ ?>
		<section class="blue-box"  id="connexion">
			<div class="alert alert-info" style="margin:20px;" role="alert">Vous n'êtes pas connecté</div>
			<a href="index.php" role="button" class="btn btn-success" style="display:block; margin:auto; margin-bottom:20px;">Se connecter</a>
		</section>
		
<?php } ?>
		
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/angular.min.js"></script>
		<script src="https://code.angularjs.org/1.3.0/angular-messages.min.js"></script>
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>