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

  This script creates the table 'class_groups_proximite'

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
					<a class="btn btn-outline-primary" href="./code_vote_10_class_participation_all.php" role="button">Back</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-secondary" href="http://<?php echo $_SERVER['SERVER_NAME']. ''.$_SERVER['REQUEST_URI'] ?>" role="button">Refresh</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-success" href="./votes_<?= $url_second ?>.php" role="button">NEXT</a>
				</div>
			</div>
			<div class="row mt-3">
        <div class="col-12">
        <?php

        // CONNEXION SQL //
        	include 'bdd-connexion.php';

          $reponse_groupes = $bdd->prepare('
            SELECT uid
            FROM organes
            WHERE coteType = "GP" AND legislature = 15
          ');
          $reponse_groupes->execute();
          $groupes = $reponse_groupes->fetchAll();

          $sql_delete = 'DROP TABLE IF EXISTS class_groups_proximite';
          $bdd->query($sql_delete);

          $sql_create_1 = '
          CREATE TABLE class_groups_proximite AS
          SELECT B.*, curdate() AS dateMaj
          FROM
          (
          ';
          $sql_create_2 = "";
          foreach ($groupes as $key => $value) {
            $groupe_id = $value["uid"];
            if ($key+1 < count($groupes)) {
              $sql_create_2 = $sql_create_2." SELECT A.* FROM ( SELECT organeRef, '".$groupe_id."' AS prox_group, AVG(".$groupe_id.") AS score, COUNT(".$groupe_id.") AS votesN FROM groupes_accord GROUP BY organeRef ) A UNION ALL";
            } else {
              $sql_create_2 = $sql_create_2." SELECT A.* FROM ( SELECT organeRef, '".$groupe_id."' AS prox_group, AVG(".$groupe_id.") AS score, COUNT(".$groupe_id.") AS votesN FROM groupes_accord GROUP BY organeRef ) A";
            }
          }
          $sql_create_3 = ') B';

          $sql_create = $sql_create_1." ".$sql_create_2." ".$sql_create_3;
          echo $sql_create;
          $bdd->query($sql_create);

          $bdd->query("ALTER TABLE class_groups_proximite ADD INDEX idx_organeRef (organeRef)");


        ?>

        </div>
      </div>
    </div>
  </body>
</html>
