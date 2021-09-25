<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Tables_report extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Payments');

        $this->load->model('Settings_model'); // load the settings model
        $this->load->model('Payments_report_model'); // load the payments model
        $this->load->model('Tables_report_model');
        $this->load->model('Countries_model');
        $this->load->model('Extensions_model');
        $this->load->model('Locations_model');
        $this->load->model('Statuses_model');

        $this->load->library('permalink');
        $this->load->library('pagination');
        $this->load->library('calendar');
        $this->lang->load('tables_report');
    }

	public function index() {
        /*$this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));

        $post = $this->input->post();
        $location_id = $post['location'];
        $date = '2018-10-24';
        $time = '11:15:00';
        $location_id = $this->Locations_model->getLocationId($location_id,$date,$time);
       
        $loc_id = $location_id[0]['location_id'];
       
        $data = $this->Tables_report_model->getReservedList($loc_id);*/
        $id = $this->user->getStaffId();
        $_SESSION['stf_id'] =  $this->user->getStaffId();

        if(!$this->input->get('id') != "" && $this->user->getStaffId() == 11 && $this->input->get('show')==''  ){
            return redirect('tables_report');
        }else if($this->input->get('id') != "" && $this->user->getStaffId() == 11){
            $edit_link = "edit?vendor_id=".$id;
        }else{
            $edit_link = "edit";
        }

        
        $url = '?';
        $filter = array();
        if ($this->input->get('page')) {
            $filter['page'] = (int) $this->input->get('page');
        } else {
            $filter['page'] = '';
        }

        if ($this->config->item('page_limit')) {
            $filter['limit'] = $this->config->item('page_limit');
        }

        if (is_numeric($this->input->get('show_calendar'))) {
            $filter['show_calendar'] = $data['show_calendar'] = $this->input->get('show_calendar');
            $url .= 'show_calendar='.$filter['show_calendar'].'&';
        } else {
            $data['show_calendar'] = '';
        }

        if ($this->input->get('filter_search')) {
            $filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
            $url .= 'filter_search='.$filter['filter_search'].'&';
        } else {
            $data['filter_search'] = '';
        }

        if ($this->input->get('search_filter')) {
            $filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
            $filter['filter_location'] = $data['filter_location'] = $this->input->get('filter_location');
            $filter['filter_table'] = $data['filter_table'] = $this->input->get('filter_table');
            $filter['filter_location'] = $data['filter_location'] = $this->input->get('filter_location');
            $time = strtotime($this->input->get('srcdate')); 
            $filter['filter_day'] = $data['filter_day'] = date("d",$time);
            $filter['filter_month'] = $data['filter_month'] = date('m',$time);
            $filter['filter_year'] = $data['filter_year'] = date("Y",$time);
            $filter['filter_status'] = 'all';
            $url = '?show_calendar=1&filter_location='. $filter['filter_location'].'&filter_table='. $filter['filter_table'].'&filter_day='.$filter['filter_day'] .'&filter_status='.$filter['filter_status'].'&filter_month='. $filter['filter_month'].'&filter_year='.$filter['filter_year'].'&';
        } else {
            $data['search_filter'] = '';
        }

        if ($data['user_strict_location'] = $this->user->isStrictLocation()) {
            $filter['filter_location'] = $data['filter_location'] = $this->user->getLocationId();
            $url .= 'filter_location='.$filter['filter_location'].'&';
        } else if (is_numeric($this->input->get('filter_location'))) {
            $filter['filter_location'] = $data['filter_location'] = $this->input->get('filter_location');
            $url .= 'filter_location='.$filter['filter_location'].'&';
        } else {
            $filter['filter_location'] = $data['filter_location'] = '';
        }

        if (is_numeric($this->input->get('filter_status')) || $this->input->get('filter_status') == "all") {
            $filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
            $url .= 'filter_status='.$filter['filter_status'].'&';
        } else {
            $filter['filter_status'] = $data['filter_status'] = 'all';
        }

        if ($this->input->get('filter_date')) {
            $filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
            $url .= 'filter_date='.$filter['filter_date'].'&';
        } else {
            $filter['filter_date'] = $data['filter_date'] = '';
        }

        if (is_numeric($this->input->get('filter_year'))) {
            $filter['filter_year'] = $data['filter_year'] = $this->input->get('filter_year');
        } else {
            $filter['filter_year'] = $data['filter_year'] = '';
        }

        if (is_numeric($this->input->get('filter_month'))) {
            $filter['filter_month'] = $data['filter_month'] = $this->input->get('filter_month');
        } else {
            $filter['filter_month'] = $data['filter_month'] = '';
        }

        if (is_numeric($this->input->get('filter_day'))) {
            $filter['filter_day'] = $data['filter_day'] = $this->input->get('filter_day');
        } else {
            $filter['filter_day'] = $data['filter_day'] = '';
        }

        if ($this->input->get('sort_by')) {
            $filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
        } else {
            $filter['sort_by'] = $data['sort_by'] = 'reserve_date';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') .' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'ASC';
            $data['order_by_active'] = 'ASC';
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        //$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
 
        if ($this->input->post('delete') AND $this->_deleteReservation() === TRUE) {
            redirect('tables_report');
        }


        if ($this->input->get('show_calendar') === '1') {
            if($this->input->get('srcdate') !=''){
            $time = strtotime($this->input->get('srcdate')); 
            $filter['filter_day'] = $data['filter_day'] = date("d",$time);
            $filter['filter_month'] = $data['filter_month'] = date('m',$time);
            $filter['filter_year'] = $data['filter_year'] = date("Y",$time);
            $data['srcdate'] = $this->input->get('srcdate');
            }
            $day = ($filter['filter_day'] === '') ? date('d', time()) : $filter['filter_day'];
            $month = ($filter['filter_month'] === '') ? date('m', time()) : $filter['filter_month'];
            $year = ($filter['filter_year'] === '') ? date('Y', time()) :  $filter['filter_year'];
            $url .= 'filter_year='.$filter['filter_year'].'&filter_month='.$filter['filter_month'].'&filter_day='.$filter['filter_day'].'&';

            $data['days'] = $this->calendar->get_total_days($month, $year);
            $data['months'] = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
            $data['years'] = array('2018', '2019', '2020', '2021', '2022', '2023', '2024','2025');
           
            $total_tables = $this->Tables_report_model->getTotalCapacityByLocation($filter['filter_location']);

            $calendar_data = array();
            for ($i = 1; $i <= $data['days']; $i++) {
                $date = $year . '-' . $month . '-' . $i;
                $reserve_date = mdate('%Y-%m-%d', strtotime($date));
                $total_guests = $this->Tables_report_model->getTotalGuestsByLocation($filter['filter_location'], $reserve_date);
                $state  = '';
                if ($total_guests < 1) {
                    $state  = 'no_booking';
                } else if ($total_guests > 0 AND $total_guests < $total_tables) {
                    $state  = 'half_booked';
                } else if ($total_guests >= $total_tables) {
                    $state  = 'booked';
                }

                $fmt_day = (strlen($i) == 1) ? '0'.$i : $i;
                if ($fmt_day == $day) {
                    $calendar_data[$i]  = $state.' selected';
                } else {
                    $calendar_data[$i]  = $state;
                }
            }

            $calendar_data['url'] = site_url('tables_report');
            $calendar_data['url_suffix'] = $url;
            //$this->template->setIcon('<a class="btn btn-default" title="'.$this->lang->line('text_switch_to_list').'" href="'.site_url('tables_report/') .'"><i class="fa fa-list"></i></a>');
            $data['calendar'] = $this->calendar->generate($year, $month, $calendar_data);

        } else {

            $this->template->setIcon('<a class="btn btn-default" title="'.$this->lang->line('text_switch_to_calendar').'" href="'.site_url('tables_report?show_calendar=1&show=all') .'"><i class="fa fa-calendar"></i></a>');
            $data['calendar'] = '';
        }

        $order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
        $data['sort_id']            = site_url('tables_report'.$url.'sort_by=reservation_id&show=all&order_by='.$order_by);
        $data['sort_location']      = site_url('tables_report'.$url.'sort_by=location_name&show=all&order_by='.$order_by);
        $data['sort_customer']      = site_url('tables_report'.$url.'sort_by=first_name&show=all&order_by='.$order_by);
        $data['sort_guest']         = site_url('tables_report'.$url.'sort_by=guest_num&show=all&order_by='.$order_by);
        $data['sort_table']         = site_url('tables_report'.$url.'sort_by=table_name&show=all&order_by='.$order_by);
        $data['sort_status']        = site_url('tables_report'.$url.'sort_by=status_name&show=all&order_by='.$order_by);
        $data['sort_staff']         = site_url('tables_report'.$url.'sort_by=staff_name&show=all&order_by='.$order_by);
        $data['sort_date']          = site_url('tables_report'.$url.'sort_by=reserve_date&show=all&order_by='.$order_by);

        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        $data['filter_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
        $data['vendor_id'] = $id;
        $data['reservations'] = array();
        
        if($this->input->get("show") == 'all' ){
        $url .= "show=all";
        $data['show'] = 'all';
        $results = $this->Tables_report_model->getList($filter); 
        $config['total_rows']       = $this->Tables_report_model->getCount($filter);
        }else{
        $url .= "id=".$id;  
        $results = $this->Tables_report_model->getList($filter,$id,'list');  
        $config['total_rows']       = $this->Tables_report_model->getCount($filter,$id,'list');
        }
        
        foreach ($results as $result) {
            $data['reservations'][] = array(
                'reservation_id'    => $result['reservation_id'],
                'location_name'     => $result['location_name'],
                'first_name'        => $result['first_name'],
                'last_name'         => $result['last_name'],
                'guest_num'         => $result['guest_num'],
                'otp'               => $result['otp'],
                'table_name'        => $this->Tables_report_model->getReservationTables($result['reservation_id']),
                'status_name'       => $result['status_name'],
                'status_code'       => $result['status_code'],
                'status_color'      => $result['status_color'],
                'staff_name'        => $result['staff_name'],
                'reserve_date'      => day_elapsed($result['reserve_date']),
                'reserve_time'      => mdate('%H:%i', strtotime($result['reserve_time'])),
                'added_date'        => day_elapsed($result['reserved_on']),
                'edit'              => site_url('reservations/edit?id=' . $result['id'].'&res_id='.$reservation_id)
            );
        }

        $data['locations'] = array();
        $results = $this->Locations_model->getLocations();
        foreach ($results as $result) {
            $data['locations'][] = array(
                'location_id'   =>  $result['location_id'],
                'location_name' =>  $result['location_name'],
            );
        }

        $data['statuses'] = array();
        $statuses = $this->Statuses_model->getStatuses('reserve');
        foreach ($statuses as $status) {
            $data['statuses'][] = array(
                'status_id'     => $status['status_id'],
                'status_name'   => $status['status_name'],
                'status_code'   => $status['status_code']
            );
        }

        $data['reserve_dates'] = array();
        $reserve_dates = $this->Tables_report_model->getReservationDates();
        foreach ($reserve_dates as $reserve_date) {
            $month_year = $reserve_date['year'].'-'.$reserve_date['month'];
            $data['reserve_dates'][$month_year] = mdate('%F %Y', strtotime($reserve_date['reserve_date']));
        }

        if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
            $url .= '&sort_by='.$filter['sort_by'].'&';
            $url .= '&order_by='.$filter['order_by'].'&';
        }

        $config['base_url']         = site_url('tables_report'.$url);
        
        $config['per_page']         = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info'      => $this->pagination->create_infos(),
            'links'     => $this->pagination->create_links()
        );
        $this->template->render('tables_report', $data);

    }
    public function show_tables() {


        $location_id = $_POST['get_option'];
        $results = $this->Locations_model->getLocationtables($location_id);
        foreach ($results as $result) {
            $data['locations'][] = array(
                'table_id'   =>  $result['table_id'],
                'table_name' =>  $result['table_name'],
            );
        }
       
        $this->template->render('show_tables', $data);
    }
    
}
/* End of file Payments_report.php */
/* Location: ./admin/controllers/payments_report.php */