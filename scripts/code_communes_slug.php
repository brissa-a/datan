<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>code_comunes_slug</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
  </head>
  <body>
		<div class="container" style="background-color: #e9ecef;">
			<div class="row">
				<h1>code_communes_slug</h1>
			</div>
			<div class="row">
				<div class="col-4">
					<a class="btn btn-outline-primary" href="./" role="button">Back</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-secondary" href="http://<?php echo $_SERVER['SERVER_NAME']. ''.$_SERVER['REQUEST_URI'] ?>" role="button">Refresh</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-success" href="./code_1_deputes_contacts.php" role="button">NEXT</a>
				</div>
			</div>
			<div class="row mt-3">
        <div class="col">
          <?php

          	/**
           * Supprimer les accents
           *
           * @param string $str chaîne de caractères avec caractères accentués
           * @param string $encoding encodage du texte (exemple : utf-8, ISO-8859-1 ...)
           */
          function suppr_accents($str, $encoding='utf-8')
          {
              // transformer les caractères accentués en entités HTML
              $str = htmlentities($str, ENT_NOQUOTES, $encoding);

              // remplacer les entités HTML pour avoir juste le premier caractères non accentués
              // Exemple : "&ecute;" => "e", "&Ecute;" => "E", "à" => "a" ...
              $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);

              // Remplacer les ligatures tel que : , Æ ...
              // Exemple "œ" => "oe"
              $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
              // Supprimer tout le reste
              $str = preg_replace('#&[^;]+;#', '', $str);

              return $str;
          }

          // TEST
          //$texte = 'test';
          //echo suppr_accents($texte);
          // Affiche : "Ca va mon coeur adore?"



          	include 'bdd-connexion.php';

          	$reponse_last_id = $bdd->query('
          		SELECT id,
                REPLACE(commune_nom, " (Le)", "") AS commune_nom
          		FROM circos
          		WHERE commune_slug is null
          		ORDER BY id ASC
          		LIMIT 10000
          		');

          	echo '<hr>';

          	while ($donnees_last_id = $reponse_last_id->fetch()) {
              $commune_nom = $donnees_last_id['commune_nom'];
              //Replace with LE devant
              $commune_nom = str_replace("Rousses (Les)", "Les Rousses", $commune_nom);
              // Replace others
              $to_replace = array(" (les)", " (la)", " (ville)", "(ville)", "(campagne)", "(Ville)", "(Campagne)", " (La)");
              $commune_nom = str_replace($to_replace, "", $commune_nom);


          		$uid = $donnees_last_id['id'];

          		echo '<p>Last id: '.$donnees_last_id['id'].'</p>';
          		echo '<p>commune origine: '.$commune_nom.'</p>';

          		$commune = $commune_nom;
          		$commune = suppr_accents($commune);
          		$commune = strtolower($commune);

          		echo '<p>prenom Accent: '.($commune).'</p>';

          		$commune = strtr($commune, array("'" => "", "-" => "-", " " => "-"));
          		echo '<p>prenom OK: '.$commune.'</p>';


          		echo '<hr>';


          		$sql = $bdd->prepare('UPDATE circos SET commune_slug = :commune_slug, commune_nom = :commune_nom WHERE id = "'.$uid.'"');
          		$sql -> execute(array('commune_slug' => $commune, 'commune_nom' => $commune_nom));
          	}




          ?>
        </div>
      </div>
    </div>
  </body>
</html>
