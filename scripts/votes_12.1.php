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

  This script creates the table 'deputes_loyaute' which take all loyalty score per mandate

  -->
  <body>
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
					<a class="btn btn-outline-success" href="./votes_13.php" role="button">NEXT</a>
				</div>
			</div>
			<div class="row mt-3">
        <div class="col-12">
          <table class="table">
            <thead>
                <tr>
                  <th scope="col">classement</th>
                  <th scope="col">mpId</th>
                  <th scope="col">score</th>
                  <th scope="col">votesN</th>
                  <th scope="col">dateMaj</th>
                </tr>
              </thead>
              <tbody>
        <?php

        // CONNEXION SQL //
        	include 'bdd-connexion.php';

          $bdd->query('
            DROP TABLE IF EXISTS deputes_loyaute;
            CREATE TABLE deputes_loyaute
              (id INT(5) NOT NULL AUTO_INCREMENT,
              mpId VARCHAR(15)CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
              mandatId VARCHAR(15)CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
              score DECIMAL(4,3) NOT NULL,
              votesN INT(10) NOT NULL,
              dateMaj DATE NOT NULL,
              PRIMARY KEY (id));
              ALTER TABLE deputes_loyaute ADD INDEX idx_mpId (mpId);
              ALTER TABLE deputes_loyaute ADD INDEX idx_mandatId (mandatId);
          ');
          $result = $bdd->query('
          SELECT v.mpId, v.organeId AS mandatId, ROUND(AVG(v.scoreLoyaute),3) AS score, COUNT(v.scoreLoyaute) AS votesN
          FROM votes_scores v
          LEFT JOIN mandat_groupe mg ON mg.mandatId = v.organeId
          WHERE v.scoreLoyaute IS NOT NULL
          GROUP BY v.organeId
          ORDER BY v.mpId
          ');

          while ($depute = $result->fetch()) {
            $mpId = $depute["mpId"];
            $mandatId = $depute["mandatId"];
            $score = $depute["score"];
            $votesN = $depute["votesN"];
            $dateMaj = date('Y-m-d');

            echo "<tr>";
            echo "<td>".$mpId."</td>";
            echo "<td>".$mandatId."</td>";
            echo "<td>".$score."</td>";
            echo "<td>".$votesN."</td>";
            echo "<td>".$dateMaj."</td>";
            echo "</tr>";


            $sql = $bdd->prepare("INSERT INTO deputes_loyaute (mpId, mandatId, score, votesN, dateMaj) VALUES (:mpId, :mandatId, :score, :votesN, :dateMaj)");
            $sql->execute(array('mpId' => $mpId, 'mandatId' => $mandatId, 'score' => $score, 'votesN' => $votesN, 'dateMaj' => $dateMaj));
          }
        ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
