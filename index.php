<?php session_start(); include('include/connect.php'); $log = "admin";$mdp ="mdp";$message=""; ?>
<!DOCTYPE html>
<html lang="en" ng-app="connect">
    <head>
        <meta charset="utf-8" />
        <title>Valid[W3C]</title>        
        <link rel="stylesheet" href="style.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <header>
            <h1><img src="images/W3C_Logo.png" alt="W3C Validator" title="W3C Validator"/> </h1>
        </header>
        <section id="connexion" class="blue-box">
            <?php
				if(isset($_SESSION['pseudo']))
				   {
					echo ('<div class="alert alert-info" style="margin:20px;" role="alert">Vous êtes déjà connecté</div>');   
				   }
				   else
				   {
					   if(isset($_POST['pseudo'])&&isset($_POST['mdp']))
					   {
						   if($_POST['pseudo'] == $log && $_POST['mdp'] == $mdp)
						   {
							   $_SESSION['pseudo'] == $_POST['pseudo'];
							   echo ('<div class="alert alert-success" style="margin:20px;" role="alert">Connexion réussi</div>');
							   echo ('<META HTTP-EQUIV="Refresh" 
							   		CONTENT="3;
									URL=http://127.0.0.1/validator/validator.php">');
						   }
						   else
							   $message = '<div class="alert alert-danger" style="margin:20px;" role="alert">Identifiants invalides</div>';
					   }
			?>
            <form method="post" action="index.php" enctype="multipart/form-data" >
                <fieldset>
					<?php if($message!="")echo($message."<br>");?>
                    <input type="text" name="pseudo" placeholder="Identifiant">
                    <input type="password" name="mdp" placeholder="Mot de passe">
                    <input style="color:#365D95" class="btn right" type="submit" value="Se connecter">
                </fieldset>
            </form>
			<?php }?>
        </section>
    </body>
</html>