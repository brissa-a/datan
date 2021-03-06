    <!-- NEW ELEMENT FROM HERE -->
    <div class="container-fluid pg-vote-all" id="container-always-fluid">
      <div class="row">
        <div class="container">
          <div class="row row-grid bloc-titre">
            <div class="col-lg-4 col-md-5 mb-4 mb-md-0">
              <h1>Les votes décryptés par Datan</h1>
            </div>
            <div class="col-lg-4 col-md-7 mt-md-0">
              <p>
                L'équipe de Datan décrypte pour vous les votes les plus intéressants de la législature.
                Il s'agit des votes qui ont fait l'objet d'attention médiatique, ou sur lesquels un ou plusieurs groupes parlementaires étaient fortement divisés.
              </p>
              <p>
                Tous ces votes décryptés font l'objet d'une reformulation et d'une contextualisation, afin de les rendre plus accessibles et plus compréhensibles.
                Pour en savoir plus, <a href="#">cliquez ici</a>.
              </p>
              <p>
                Si vous voulez avoir accès à <b>tous</b> les votes de l'Assemblée nationale, qu'ils soient décryptés par nos soins ou non, <a href="<?= base_url() ?>votes/legislature-<?= legislature_current() ?>">cliquez ici</a>.
              </p>
            </div>
            <div class="col-md-4 d-none d-lg-block">
              <div class="px-4">
                <?= file_get_contents(asset_url()."imgs/svg/undraw_voting_nvu7.svg") ?>
              </div>
            </div>
          </div>
          <div class="row bloc-carousel-votes-flickity mt-5">
            <div class="col-12 carousel-cards">
              <?php foreach ($votes_datan as $vote): ?>
                <div class="card card-vote">
                  <div class="thumb d-flex align-items-center <?= $vote['sortCode'] ?>">
                    <div class="d-flex align-items-center">
                      <span><?= mb_strtoupper($vote['sortCode']) ?></span>
                    </div>
                  </div>
                  <div class="card-header d-flex flex-row justify-content-between">
                    <span class="date"><?= $vote['dateScrutinFRAbbrev'] ?></span>
                  </div>
                  <div class="card-body d-flex align-items-center">
                    <span class="title">
                      <a href="<?= base_url() ?>votes/legislature-<?= $vote['legislature'] ?>/vote_<?= $vote['voteNumero'] ?>" class="stretched-link no-decoration"></a>
                      <?= $vote['voteTitre'] ?>
                    </span>
                  </div>
                  <div class="card-footer">
                    <span class="field badge badge-primary py-1 px-2"><?= $vote['category_libelle'] ?></span>
                  </div>
                </div>
              <?php endforeach; ?>
              <div class="card card-vote see-all">
                <div class="card-body d-flex align-items-center justify-content-center">
                  <a href="<?= base_url() ?>votes/decryptes" class="stretched-link no-decoration">VOIR TOUS</a>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4 mb-5"> <!-- BUTTONS BELOW -->
            <div class="col-12 d-flex justify-content-center">
              <div class="bloc-carousel-votes">
                <div class="carousel-buttons">
                  <button type="button" class="btn prev mr-2 button--previous">
                    <?php echo file_get_contents(asset_url()."imgs/icons/arrow_left.svg") ?>
                  </button>
                  <a class="btn all mx-2" href="<?= base_url() ?>votes/decryptes">
                    <span>VOIR TOUS</span>
                  </a>
                  <button type="button" class="btn next ml-2 button--next">
                    <?php echo file_get_contents(asset_url()."imgs/icons/arrow_right.svg") ?>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- BY CATEGORY -->
      <div class="row bloc-category" id="pattern_background">
        <div class="container py-5">
          <div class="row pb-5">
            <div class="col-12">
              <h2>Derniers votes décryptés par catégorie</h2>
            </div>
          </div>
          <?php foreach ($by_field as $field): ?>
            <div class="row my-5">
              <div class="col-2 col-md-1 logo-field d-flex justify-content-center align-items-center my-3 my-lg-0">
                <?php if ($field["logo"] == TRUE): ?>
                  <div class="logo">
                    <img src="<?= asset_url().'imgs/fields/'.$field['slug'].'.svg' ?>">
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-10 col-md-11 col-lg-2 d-flex justify-content-start align-items-end align-items-lg-center my-3 my-lg-0">
                <h3 class="ml-4 ml-lg-0 mb-0"><?= $field['name'] ?></h3>
              </div>
              <div class="col-lg-7 col-md-11 offset-md-1 offset-lg-0 d-flex justify-content-center justify-content-md-start flex-wrap my-3 my-lg-0">
                <?php foreach ($field['votes'] as $vote): ?>
                  <div class="card card-vote my-4 my-md-0">
                    <div class="thumb d-flex align-items-center <?= $vote['sortCode'] ?>">
                      <div class="d-flex align-items-center">
                        <span><?= mb_strtoupper($vote['sortCode']) ?></span>
                      </div>
                    </div>
                    <div class="card-header d-flex flex-row justify-content-between">
                      <span class="date"><?= $vote['dateScrutinFR'] ?></span>
                    </div>
                    <div class="card-body d-flex align-items-center">
                      <span class="title">
                        <a href="<?= base_url() ?>votes/legislature-<?= $vote['legislature'] ?>/vote_<?= $vote['voteNumero'] ?>" class="stretched-link"></a>
                        <?= $vote['vote_titre'] ?></span>
                    </div>
                    <div class="card-footer">
                      <span class="field badge badge-primary py-1 px-2"><?= $vote['category_libelle'] ?></span>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="col-md-11 col-lg-2 offset-md-1 offset-lg-0 btn-all d-flex justify-content-center align-items-center my-3 my-lg-0">
                <a class="btn py-1" href="<?= base_url() ?>votes/decryptes/<?= $field['slug'] ?>">
                  <span>VOIR TOUS</span>
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <!-- ALL THE VOTES -->
      <div class="row">
        <div class="container py-5">
          <div class="row pb-5">
            <div class="col-12">
              <h2>Derniers votes non-decryptés de l'Assemblée nationale</h2>
            </div>
          </div>
          <div class="row bloc-carousel-votes-flickity mt-5"> <!-- CARDS -->
            <div class="col-12 carousel-cards">
              <?php foreach ($votes as $vote): ?>
                <div class="card card-vote">
                  <div class="thumb d-flex align-items-center <?= $vote['sortCode'] ?>">
                    <div class="d-flex align-items-center">
                      <span><?= mb_strtoupper($vote['sortCode']) ?></span>
                    </div>
                  </div>
                  <div class="card-header d-flex flex-row justify-content-between">
                    <span class="date"><?= $vote['dateScrutinFRAbbrev'] ?></span>
                  </div>
                  <div class="card-body d-flex align-items-center">
                    <span class="title">
                      <a href="<?= base_url() ?>votes/legislature-<?= $vote['legislature'] ?>/vote_<?= $vote['voteNumero'] ?>" class="stretched-link no-decoration"></a>
                      <?= ucfirst(word_limiter($vote['titre'], 20, " ...")) ?>
                    </span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="row mt-4 mb-5"> <!-- BUTTONS BELOW -->
            <div class="col-12 d-flex justify-content-center">
              <div class="bloc-carousel-votes">
                <div class="carousel-buttons">
                  <button type="button" class="btn prev mr-2 button--previous">
                    <?php echo file_get_contents(asset_url()."imgs/icons/arrow_left.svg") ?>
                  </button>
                  <a class="btn all mx-2" href="<?= base_url() ?>votes/legislature-<?= legislature_current() ?>">
                    <span>VOIR TOUS</span>
                  </a>
                  <button type="button" class="btn next ml-2 button--next">
                    <?php echo file_get_contents(asset_url()."imgs/icons/arrow_right.svg") ?>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ARCHIVES -->
      <div class="row" id="pattern_background">
        <div class="container py-5">
          <div class="row pb-5">
            <div class="col-12">
              <h2>Archives</h2>
            </div>
          </div>
          <div class="row pb-4">
            <div class="col-12 text-center">
              <span>
                Pour voir tous les votes,
                <a href="<?= base_url() ?>votes/legislature-<?= legislature_current() ?>">cliquez ici</a>.
              </span>
            </div>
          </div>
          <div class="row">
            <div class="col-12 d-flex flex-row flex-wrap">
              <?php foreach ($years as $year): ?>
                <div class="flex-fill text-center px-1 py-2">
                  <div class="year d-flex flex-column align-items-center">
                    <div class="my-2 d-flex justify-content-center align-items-center">
                      <div class="d-flex justify-content-center align-items-center">
                        <span><a href="<?= base_url() ?>votes/legislature-<?= legislature_current() ?>/<?= $year?>" class="no-decoration underline-blue"><?= $year ?></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="months mt-4 d-flex flex-column align-items-center">
                    <?php foreach ($months as $month): ?>
                      <?php if ($month['years'] == $year): ?>
                        <div class="my-2 d-flex justify-content-center align-items-center">
                          <div class="d-flex justify-content-center align-items-center">
                            <a href="<?= base_url() ?>votes/legislature-<?= legislature_current() ?>/<?= $year?>/<?= $month['index'] ?>" class="no-decoration underline-blue"><?= ucfirst($month["month"]) ?></a>
                          </div>
                        </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
