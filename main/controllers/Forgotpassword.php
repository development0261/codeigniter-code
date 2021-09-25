<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Forgotpassword extends Main_Controller {

    public function __construct() {
		parent::__construct(); 																	// calls the constructor

        $this->load->model('Vendor_model');
	}

	public function setpass() {
        $email = $this->input->get('email');
        $date  = $this->input->get('date');
        $hash  = $this->input->get('hash');

        $load_view =  false;
        $show_message = '';

        if(!empty($email) && !empty($date) && !empty($hash)){
            $new_hash_customer   = md5($email.'#'.$date.'#customer');
            $new_hash_restaurant = md5($email.'#'.$date.'#restaurant');

            if($new_hash_customer == $hash || $new_hash_restaurant == $hash){
                if($this->input->post()){
                    $password        = $this->input->post('password');
                    $cofirm_password = $this->input->post('cofirm_password');
                    if(($password == $cofirm_password) && ($new_hash_customer == $hash)){                        
                        $this->Vendor_model->resetCustomerPassword($email, $password);
                        redirect('forgotpassword/success');
                    } else if(($password == $cofirm_password) && ($new_hash_restaurant == $hash)){                        
                        $staff_id = $this->Vendor_model->getStaffId($email);                        
                        $this->Vendor_model->resetRestaurantPassword($email, $staff_id);
                        redirect('forgotpassword/success');
                    } else {
                        $_SESSION["show_message"] = "Password & confirm pasword does not match!";
                        redirect('forgotpassword/setpass/?email='.$email.'&date='.$date.'&hash='.$hash);
                    }                  
                } 
                $data['email'] = $email;
                $data['date']  = $date;
                $data['hash']  = $hash;
                $data['show_message']  = $show_message;
                $load_view = true;                                
            } 
        } 
        if($load_view == true){
            $this->template->render('forgotpassword', $data);
        } else {
            $this->template->render('erroronforgotpass', $data);
        }
	}

    public function success() {
        $this->template->render('success', $data);
    }
}

/* End of file home.php */
/* Location: ./main/controllers/home.php */