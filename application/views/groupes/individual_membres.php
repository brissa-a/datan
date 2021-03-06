    <div class="container-fluid bloc-img-deputes bloc-img d-flex async_background" id="container-always-fluid" data-src="<?= asset_url() ?>imgs/cover/hemicycle-front.jpg" data-tablet="<?= asset_url() ?>imgs/cover/hemicycle-front-768.jpg" data-mobile="<?= asset_url() ?>imgs/cover/hemicycle-front-375.jpg">
      <div class="container d-flex flex-column justify-content-center py-2">
        <h1><?= $title ?></h1>
      </div>
    </div>
    <div class="liseret-groupe" style="background-color: <?= $groupe['couleurAssociee'] ?>"></div>
    <div class="container pg-groupe-membres my-4">
      <!-- ROW PRESIDENT -->
      <?php if ($groupe['libelleAbrev'] != 'NI'): ?>
        <div class="row my-5">
          <div class="col-12 d-flex justify-content-center">
            <h2>Président<?php if ($president['civ'] == 'Mme'): ?>e<?php endif; ?></h2>
          </div>
          <div class="col-lg-4 offset-lg-4">
            <div class="card card-depute">
              <div class="liseret" style="background-color: <?= $groupe["couleurAssociee"] ?>"></div>
              <div class="card-avatar">
                <img src="<?= base_url(); ?>assets/imgs/deputes/depute_<?= substr($president["mpId"], 2) ?>.png" alt="<?= $president['nameFirst'].' '.$president['nameLast'] ?>">
              </div>
              <div class="card-body">
                <h3 class="d-block card-title"><a href="<?= base_url(); ?>deputes/<?= $president['dpt_slug'].'/depute_'.$president['nameUrl'] ?>" class="stretched-link no-decoration"><?= $president['nameFirst'] .' ' . $president['nameLast'] ?></a></h4>
                <span class="d-block"><?= $president["departement_nom"] ?> (<?= $president["departement_code"] ?>)</span>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <!-- ROW MEMBRES -->
      <div class="row my-5">
        <?php if ($groupe['libelleAbrev'] != 'NI'): ?>
          <div class="col-12 d-flex justify-content-center">
            <h2>Membres</h2>
          </div>
        <?php endif; ?>
        <?php foreach ($membres as $mp): ?>
          <div class="col-lg-4 col-md-6">
            <div class="card card-depute">
              <div class="liseret" style="background-color: <?= $groupe["couleurAssociee"] ?>"></div>
              <div class="card-avatar">
                <img src="<?= base_url(); ?>assets/imgs/deputes/depute_<?= substr($mp["mpId"], 2) ?>.png" alt="<?= $mp['nameFirst'].' '.$mp['nameLast'] ?>">
              </div>
              <div class="card-body">
                <h3 class="d-block card-title"><a href="<?= base_url(); ?>deputes/<?= $mp['dpt_slug'].'/depute_'.$mp['nameUrl'] ?>" class="stretched-link no-decoration"><?= $mp['nameFirst'] .' ' . $mp['nameLast'] ?></a></h3>
                <span class="d-block"><?= $mp["departement_nom"] ?> (<?= $mp["departement_code"] ?>)</span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- ROW APPARENTES -->
      <?php if ($groupe['libelleAbrev'] != 'NI'): ?>
        <div class="row my-5">
          <div class="col-12 d-flex justify-content-center">
            <h2>Membres apparentés</h2>
          </div>
          <?php foreach ($apparentes as $mp): ?>
            <div class="col-lg-4 col-md-6">
              <div class="card card-depute">
                <div class="liseret" style="background-color: <?= $groupe["couleurAssociee"] ?>"></div>
                <div class="card-avatar">
                  <img src="<?= base_url(); ?>assets/imgs/deputes/depute_<?= substr($mp["mpId"], 2) ?>.png" alt="<?= $mp['nameFirst'].' '.$mp['nameLast'] ?>">
                </div>
                <div class="card-body">
                  <h3 class="d-block card-title"><a href="<?= base_url(); ?>deputes/<?= $mp['dpt_slug'].'/depute_'.$mp['nameUrl'] ?>" class="stretched-link no-decoration"><?= $mp['nameFirst'] .' ' . $mp['nameLast'] ?></a></h3>
                  <span class="d-block"><?= $mp["departement_nom"] ?> (<?= $mp["departement_code"] ?>)</span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
