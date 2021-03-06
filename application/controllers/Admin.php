<?php
  class Admin extends CI_Controller{

    public function __construct() {
      parent::__construct();
      $this->load->model('admin_model');
      $this->load->model('deputes_model');
      $this->load->model('post_model');
      $this->load->model('fields_model');
      //$this->password_model->security_password(); Former login protection
      $this->password_model->security_admin();
    }

    // Dashboard homepage
    public function index(){
      $data['username'] = $this->session->userdata('username');
      $user_id = $this->session->userdata('user_id');

      $data['votesUnpublished'] = $this->admin_model->get_votes_datan_user($user_id, $published = FALSE);
      $data['votesLast'] = $this->admin_model->get_votes_datan_user($user_id, $published = TRUE);

      $this->load->view('dashboard/header', $data);
      $this->load->view('dashboard/index', $data);
      $this->load->view('dashboard/footer');
    }

    public function votes(){
      $data['username'] = $this->session->userdata('username');
      $data['usernameType'] = $this->session->userdata('type');
      $data['title'] = 'Tous les votes datan';

      $data['votes'] = $this->admin_model->get_votes_datan();

      $this->load->view('dashboard/header', $data);
      $this->load->view('dashboard/votes_datan', $data);
      $this->load->view('dashboard/footer');
    }

    public function create_vote(){
      $data['username'] = $this->session->userdata('username');
      $user_id = $this->session->userdata('user_id');
      $data['title'] = 'Créer un nouveau vote_datan';
      $data['categories'] = $this->fields_model->get_fields();

      //Form valiation
      $this->form_validation->set_rules('vote_id', 'Vote_id', 'required');
      $this->form_validation->set_rules('title', 'Title', 'required');
      $this->form_validation->set_rules('category', 'Category', 'required');
      //$this->form_validation->set_rules('description', 'Description', 'required');

      if ($this->form_validation->run() === FALSE) {
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/vote_create', $data);
        $this->load->view('dashboard/footer');
      } else {
        $this->admin_model->create_vote($user_id);
        redirect('admin/votes');
      }

    }

    public function modify_vote($vote){
      $data['username'] = $this->session->userdata('username');
      $data['usernameType'] = $this->session->userdata("type");
      $user_id = $this->session->userdata('user_id');

      $data['title'] = 'Modifier un vote_datan';
      $data['vote'] = $this->admin_model->get_vote_datan($vote);
      if (empty($data['vote'])) {
        redirect('admin/votes');
      }

      if ($data['vote']['state'] == "published" && $data['usernameType'] != "admin") {
        redirect('admin/votes');
      } else {
        $data['categories'] = $this->fields_model->get_fields();

        //Form valiation
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        //$this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() === FALSE) {
          $this->load->view('dashboard/header', $data);
          $this->load->view('dashboard/vote_modify', $data);
          $this->load->view('dashboard/footer');
        } else {
          $this->admin_model->modify_vote($vote,$user_id);
          redirect('admin/votes');
        }
      }

    }

    public function delete_vote($vote){
      $data['usernameType'] = $this->session->userdata("type");

      if ($data['usernameType'] != "admin") {
        redirect();
      } else {
        $data["username"] = $this->session->userdata('username');

        $data['title'] = 'Supprimer un vote_datan';

        $data['vote'] = $this->admin_model->get_vote_datan($vote);

        //Form validation
        $this->form_validation->set_rules('delete', 'Delete', 'required');

        if ($this->form_validation->run() === FALSE) {
          $this->load->view('dashboard/header', $data);
          $this->load->view('dashboard/vote_delete', $data);
          $this->load->view('dashboard/footer');
        } else {
          $this->admin_model->delete_vote($vote);
          redirect('admin/votes');
        }
      }

    }

    public function votes_an_position(){
      $data['username'] = $this->session->userdata('username');
      $data['title'] = 'Tous les votes_an (position)';
      $data['groupes'] = array('PO723569', 'PO730934', 'PO730940', 'PO730946', 'PO730952', 'PO730958', 'PO730964', 'PO730970', 'PO767217', 'PO744425', 'PO758835', 'PO759900', 'PO765636');

      $data['groupes_libelle'] = $this->admin_model->get_groupes_libelle($data['groupes']);
      $data['votes'] = $this->admin_model->get_votes_an_position();

      $this->load->view('dashboard/header', $data);
      $this->load->view('dashboard/votes_an', $data);
      $this->load->view('dashboard/footer');
    }

    public function votes_an_cohesion(){
      $data['username'] = $this->session->userdata('username');
      $data['title'] = 'Tous les votes_an (cohesion)';
      $data['groupes'] = array('PO723569', 'PO730934', 'PO730940', 'PO730946', 'PO730952', 'PO730958', 'PO730964', 'PO730970', 'PO767217', 'PO744425', 'PO758835', 'PO759900', 'PO765636');

      $data['groupes_libelle'] = $this->admin_model->get_groupes_libelle($data['groupes']);
      $data['votes'] = $this->admin_model->get_votes_an_cohesion();

      $this->load->view('dashboard/header', $data);
      $this->load->view('dashboard/votes_an', $data);
      $this->load->view('dashboard/footer');
    }

    public function analyses($url){
      $data['username'] = $this->session->userdata('username');
      if ($url == "class_loyaute_group") {
        if (!isset($_GET["group"])) {
          echo "Indiquez le nom du groupe (lrem, fi, etc.) après ?group=lrem dans l'URL ";
        } else {
          $libelle = $_GET["group"];
          $data['title'] = 'Classement loyauté pour le groupe '.$libelle;

          $data['table'] = $this->admin_model->get_classement_loyaute_group($libelle);

          $this->load->view('dashboard/header', $data);
          $this->load->view('dashboard/table_all', $data);
          $this->load->view('dashboard/footer');
      }
      } else {
        show_404();
      }
    }

    public function votes_an_em_lost(){
      $data['username'] = $this->session->userdata('username');
      $data['title'] = 'Votes où En Marche (LAREM) a perdu';

      $data['votes'] = $this->admin_model->get_votes_em_lost();

      $this->load->view('dashboard/header', $data);
      $this->load->view('dashboard/table', $data);
      $this->load->view('dashboard/footer');
    }

    public function socialmedia($page, $id){
      $data['username'] = $this->session->userdata('username');

      if ($page == "deputes_entrants") {
        $data['title'] = 'Liste des députés entrants (datePriseFonction)';
        $data['deputes'] = $this->deputes_model->get_deputes_entrants();

        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/socialmedia_table', $data);
        $this->load->view('dashboard/footer');
      } elseif ($page == "deputes_sortants") {
        $data['title'] = 'Liste des députés sortants (dateFin)';
        $data['deputes'] = $this->deputes_model->get_deputes_sortants();

        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/socialmedia_table', $data);
        $this->load->view('dashboard/footer');
      } elseif ($page == "postes_assemblee") {
        $data['title'] = 'Nouveaux postes Assemblée (dateDebut)';
        $data['deputes'] = $this->deputes_model->get_postes_assemblee();

        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/socialmedia_table', $data);
        $this->load->view('dashboard/footer');
      } elseif ($page == "groupes_entrants") {
        $data['title'] = 'Groupes entrants (dateDebut)';
        $data['deputes'] = $this->deputes_model->get_groupes_entrants();
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/socialmedia_table', $data);
        $this->load->view('dashboard/footer');
      } elseif ($page == "historique") {
        if ($id == "NULL") {
          $data['deputes'] = $this->deputes_model->get_deputes_all(legislature_current(), NULL, NULL);
          $data['title'] = "Liste des députés";
          $this->load->view('dashboard/header', $data);
          $this->load->view('dashboard/socialmedia_list', $data);
          $this->load->view('dashboard/footer');
        } else {
          $data['depute'] = $this->deputes_model->get_infos($id);
          $data['title'] = "Historique pour le député ".$data['depute']['nameFirst']." ".$data['depute']['nameLast'];
          $data['historique'] = $this->deputes_model->get_historique($id);
          $data['deputes'] = $data['historique'];
          $this->load->view('dashboard/header', $data);
          $this->load->view('dashboard/socialmedia_table', $data);
          $this->load->view('dashboard/footer');

        }
      } else {
        show_404();
      }
    }

  }
?>
