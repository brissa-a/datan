<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $_SERVER['REQUEST_URI'] ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    <style>
      table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
      }
    </style>
  </head>
  <!--

  This script creates the table 'deputes_accord_cleaned'

  -->
  <body>
    <?php
      $url = $_SERVER['REQUEST_URI'];
      $url = str_replace(array("/", "datan", "scripts", "votes_", ".php"), "", $url);
      $url_current = substr($url, 0, 2);
      $url_second = $url_current + 1;
    ?>
		<div class="container" style="background-color: #e9ecef;">
			<div class="row">
				<h1>Create table deputes_accord_cleaned</h1>
			</div>
			<div class="row">
				<div class="col-4">
					<a class="btn btn-outline-primary" href="./code_vote_10_class_participation_all.php" role="button">Back</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-secondary" href="http://<?php echo $_SERVER['SERVER_NAME']. ''.$_SERVER['REQUEST_URI'] ?>" role="button">Refresh</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-success" href="./votes_<?= $url_second ?>.php" role="button">Next</a>
				</div>
			</div>
			<div class="row mt-3">
        <div class="col-12">
        <?php

        // CONNEXION SQL //
        	include 'bdd-connexion.php';

          $bdd->query('
            DROP TABLE IF EXISTS deputes_accord_cleaned;
            CREATE TABLE deputes_accord_cleaned AS
            SELECT A.*, o.libelle, o.libelleAbrege, o.libelleAbrev, o.positionPolitique,
            CASE WHEN o.dateFin IS NOT NULL THEN 1 ELSE 0 END AS ended, CURDATE() AS dateMaj
            FROM
            (
              SELECT da.mpId, da.organeRef, ROUND(AVG(da.accord)*100) AS accord, COUNT(da.accord) AS votesN
              FROM deputes_accord da
              GROUP BY da.mpId, da.organeRef
            ) A
            LEFT JOIN organes o ON o.uid = A.organeRef
            WHERE A.accord IS NOT NULL;
            ALTER TABLE deputes_accord_cleaned ADD INDEX idx_mpId (mpId);
          ');

        ?>

        </div>
      </div>
    </div>
  </body>
</html>
