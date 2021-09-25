<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Home extends Main_Controller {

	public function index__() {
        $this->lang->load('home');
        $this->load->model('Locations_model');

        $this->template->setTitle($this->lang->line('text_heading'));

        $this->session->unset_userdata('cart_contents');

        $filter = array("filter_status"=>1);
        $data['locations'] = $this->Locations_model->getList($filter);
        $i = 0 ;
        foreach ($data['locations'] as $location) {
        	 $permalink = $this->permalink->getPermalink('location_id='.$location['location_id']);
        	 $data['locations'][$i]['permalink'] = $permalink['slug'];
        	 $i++;
        } 
       

		$this->template->render('home', $data);

	}


	public function index() {

         $this->lang->load('home');
        $this->load->model('Locations_model');

        $this->template->setTitle($this->lang->line('text_heading'));

        $this->session->unset_userdata('cart_contents');

        $filter = array("filter_status"=>1);
        $data['locations'] = $this->Locations_model->getList($filter);
        $i = 0 ;
        foreach ($data['locations'] as $location) {
        	 $permalink = $this->permalink->getPermalink('location_id='.$location['location_id']);
        	 $data['locations'][$i]['permalink'] = $permalink['slug'];
        	 $i++;
        } 
       

		 

		$this->template->render('homenew', $data);

	}



    public function indexblank() {

         

        $this->template->render('homeblank', $data);

    }



	public function change_lang(){

	if($_POST['lang'] == "عربى"){	 
	 	$_SESSION["lang"] = "arabic";
    	$_SESSION["dir"] = "rtl";
	}else if($_POST['lang'] == "spanish") {
        $_SESSION["lang"] = "spanish";
        $_SESSION["dir"] = "ltr";
     } 
    else {
	 	$_SESSION["lang"] = "english";
	 	$_SESSION["dir"] = "ltr";
	 }   

	}

}


/* End of file home.php */
/* Location: ./main/controllers/home.php */