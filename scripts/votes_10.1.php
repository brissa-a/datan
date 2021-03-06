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

  This script creates the table 'class_participation_commission'

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
				<h1><?= $_SERVER['REQUEST_URI'] ?></h1>
			</div>
			<div class="row">
				<div class="col-4">
					<a class="btn btn-outline-primary" href="./" role="button">Back</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-secondary" href="http://<?php echo $_SERVER['SERVER_NAME']. ''.$_SERVER['REQUEST_URI'] ?>" role="button">Refresh</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-success" href="./votes_11.php" role="button">NEXT</a>
				</div>
			</div>
			<div class="row mt-3">
        <div class="col-12">

        <?php

        	include 'bdd-connexion.php';

          $bdd->query('
            DROP TABLE IF EXISTS class_participation_commission;
            CREATE TABLE class_participation_commission
            SELECT A.*, da.legislature,
            CASE WHEN da.dateFin IS NULL THEN 1 ELSE 0 END AS active,
            curdate() AS dateMaj
            FROM
            (
            SELECT v.mpId, ROUND(AVG(v.participation),2) AS score, COUNT(v.participation) AS votesN, ROUND(COUNT(v.participation)/100) AS "index"
            FROM votes_participation_commission v
            WHERE v.participation IS NOT NULL
            GROUP BY v.mpId
            ORDER BY ROUND(COUNT(v.participation)/100) DESC, AVG(v.participation) DESC
            ) A
            LEFT JOIN deputes_all da ON da.mpId = A.mpId AND da.legislature = 15;
            ALTER TABLE class_participation_commission ADD INDEX idx_mpId (mpId);
            ALTER TABLE class_participation_commission ADD INDEX idx_active (active);
          ');

        ?>

        </div>
      </div>
    </div>
  </body>
</html>
