<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Finis tes légumes ! Le générateur d'idées de salades</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
	</head>
	
	<body>
		<header>
			
		</header>	
		<section>
				<h1>Finis tes légumes</h1>
				<?php
					try
					{
						$bdd = new PDO('mysql:host=localhost;dbname=finisteslegumes;charset=utf8', 'root', '');
					}
					catch(Exception $e)
					{
							die('Erreur : '.$e->getMessage());
					}
					//Base
					if(isset($_POST['aleatoire']) OR isset($_POST['base']))
					{
						$reponse_base = $bdd->query('SELECT produit FROM base ORDER BY rand() LIMIT 1');
						while ($base = $reponse_base->fetch())
						{
							$_SESSION['base'] = $base['produit'];
						}
						$reponse_base->closeCursor();
					}
					
					?>
						<form method="post" name="base" action="generateur.php" id="base_aleatoire"> 
							<input type="submit"  value="<?php echo $_SESSION['base']; ?> " name="base" />
						</form>
					<?php
					
					//Legume 1
					$date = date("m");
					if(isset($_POST['aleatoire']) OR isset($_POST['legume1']))
					{
						$reponse_legume1 = $bdd->query('SELECT produit, mois FROM legumes ORDER BY rand() LIMIT 1');
						while ($legume1 = $reponse_legume1->fetch())
						{
							if(strpos($legume1['mois'],$date) == FALSE)
							{
								$reponse_legume1 = $bdd->query('SELECT produit, mois FROM legumes ORDER BY rand() LIMIT 1');
							}
							else
							{
								if(isset($_SESSION['legume2']))
								{
									if($_SESSION['legume2'] !== $legume1['produit'])
									{
										$repet1 = substr($_SESSION['legume2'], 0, 3);
										$repet1_verif = substr($legume1['produit'], 0, 3);
										if($repet1 == $repet1_verif)
										{
											$reponse_legume1 = $bdd->query('SELECT produit, mois FROM legumes ORDER BY rand() LIMIT 1');
										}
										else
										{
											$_SESSION['legume1'] = $legume1['produit'];
										}
									}
									else
									{
										$reponse_legume1 = $bdd->query('SELECT produit, mois FROM legumes ORDER BY rand() LIMIT 1');
									}
								}
								else
								{
									$_SESSION['legume1'] = $legume1['produit'];
								}
							}
						}
						$reponse_legume1->closeCursor();
					}
					?>
						<form method="post" name="legume1" action="generateur.php" id="legume1_aleatoire"> 
							<input type="submit"  value="<?php echo $_SESSION['legume1']; ?> " name="legume1" />
						</form>
					<?php
					
					//Legume 2
					$date = date("m");
					if(isset($_POST['aleatoire']) OR isset($_POST['legume2']))
					{
						$reponse_legume2 = $bdd->query('SELECT produit, mois FROM legumes ORDER BY rand() LIMIT 1');
						while ($legume2 = $reponse_legume2->fetch())
						{
							if(strpos($legume2['mois'],$date) == FALSE)
							{
								$reponse_legume2 = $bdd->query('SELECT produit, mois FROM legumes ORDER BY rand() LIMIT 1');
							}
							else
							{
								if($_SESSION['legume1'] !== $legume2['produit'])
								{
									$repet2 = substr($_SESSION['legume1'], 0, 3);
									$repet2_verif = substr($legume2['produit'], 0, 3);
									if($repet2 == $repet2_verif)
									{
										$reponse_legume2 = $bdd->query('SELECT produit, mois FROM legumes ORDER BY rand() LIMIT 1');
									}
									else
									{
										$_SESSION['legume2'] = $legume2['produit'];
									}
								}
								else
								{
									$reponse_legume2 = $bdd->query('SELECT produit, mois FROM legumes ORDER BY rand() LIMIT 1');
								}
							}
						}
						$reponse_legume2->closeCursor();
					}
					?>
						<form method="post" name="legume2" action="generateur.php" id="legume2_aleatoire"> 
							<input type="submit"  value="<?php echo $_SESSION['legume2']; ?> " name="legume2" />
						</form>
					<?php
					
					//Bonus
					if(isset($_POST['aleatoire']) OR isset($_POST['bonus']))
					{
						$reponse_bonus = $bdd->query('SELECT produit FROM bonus ORDER BY rand() LIMIT 1');
						while ($bonus = $reponse_bonus->fetch())
						{
							$_SESSION['bonus'] = $bonus['produit'];
						}
						$reponse_bonus->closeCursor();
					}
					?>
						<form method="post" name="bonus" action="generateur.php" id="bonus_aleatoire"> 
							<input type="submit"  value="<?php echo $_SESSION['bonus']; ?>" name="bonus" />
						</form>
				
				<form method="post" name="connexion" id="connect" action="generateur.php">
					<input type="hidden" value="aleatoire" />
					<input type="submit" name="aleatoire" id="bouton" value="Une idée !"/>
				</form>
		</section>
		<footer>
			
		</footer>
			</div>
		</div>
	</body>
</html>