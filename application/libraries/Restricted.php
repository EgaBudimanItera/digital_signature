<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Restricted {

    private $ci;
	private $apps;
	private $level;
	private $current_apps;
	private $current_level;
	private $current_rule;

	public function __construct(){
      	$this->ci =& get_instance();
        $this->apps = $this->ci->session->userdata('apps');
        $this->level = $this->ci->session->userdata('level');
        $this->current_rule = $this->ci->session->userdata('rule');
        
    }
	
	public function restrict_check($data=NULL){
		if($this->ci->session->userdata('rule') == 'mahasiswa' || $this->ci->session->userdata('rule') == 'admin'){
			return FALSE;
		} else {
			for ($i=0; $i < count($data['apps']); $i++) {
				if ($data['apps'][$i] == $this->current_apps) {
					return $this->current_level=$data['level'][$i];
				}
			}
		}
	}

	public function restrict_get(){
		return $this->level;
	}

	public function restrict_current(){
		return array(
			'apps' => $this->current_apps,
			'level' => $this->current_level
		);
	}

	public function execution($restrict_page, $data){
        $this->current_apps = $this->ci->config->item('client_id');
       
        if (!$this->restrict_check($data)) {
        	switch ($this->ci->session->userdata('rule')) {
        	    case 'dosen':
        	    	$this->ci->session->set_userdata(array('level_kehadiran' => 'dosen'));
	            	redirect(base_url().'kehadiran', 'location', 303);
        	    break;
        	    default:
        	    	$this->ci->session->set_userdata(array('level_kehadiran' => 'user'));
        	    	redirect(base_url().'kehadiran', 'location', 303);
	            break;
        	}
		} else {
			switch ($this->current_level) {	            
				case 'spi':
	            	$this->ci->session->set_userdata(array('level_kehadiran' => 'spi'));
	                redirect(base_url().'kehadiran', 'location', 303);
				break;
				case 'kepegawaian':
	            	$this->ci->session->set_userdata(array('level_kehadiran' => 'kepegawaian'));
	                redirect(base_url().'kehadiran', 'location', 303);
				break;
				case 'rektor':
	            	$this->ci->session->set_userdata(array('level_kehadiran' => 'rektor'));
	                redirect(base_url().'kehadiran', 'location', 303);
				break;						
	            default:
	                $this->ci->session->set_userdata(array('level_kehadiran' => 'user'));
        	    	redirect(base_url().'kehadiran', 'location', 303);
	            break;
	        }
		}
	}
    
}