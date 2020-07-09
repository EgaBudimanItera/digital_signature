<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->helper('function');
        $this->load->library('image_lib');
        $this->load->library('upload');
        $this->load->library('pdf');
        // // // $this->load->library('src/autoload');
        // $this->load->library('src/fpdi');
		$this->load->library('ci_qr_code');
		$this->config->load('qr_code');
		$this->load->model(array('Digital'));
        
        
        // if(empty($this->session->userdata('username'))){
		// 	echo '<script>alert("Anda tidak memiliki akses ke halaman ini");</script>';
		// 	echo '<script>window.location.href = "https://kendali.itera.ac.id/welcome/detail/1";</script>';
		// 	exit();
        // }  
    }
	public function index()
	{
		$data = array(
			'page' => 'welcome_message',
			'link' => 'dashboard'
		);
		$this->load->view('template/wrapper', $data);
	}

	public function master(){
		$data = array(
			'page' => 'master',
			'link' => 'master'
		);
		$this->load->view('template/wrapper', $data);
	}

	public function transaksi(){
        $script = array(
            'script_aksi' => 'trans_digital_signature/script-aksi'
        );

        $modal = array(
            'modal_aksi' => 'trans_digital_signature/modal-aksi'
        );
        
        $data = array(
			'page' => 'trans_digital_signature/transaksi',
            'link' => 'transaksi',
            'modal'=>$modal,
            'script'=>$script,
            'autonumber'=>$this->Digital->autonumber(),
			'list'=>$this->Digital->get_data_all_trans(),
		);
		$this->load->view('template/wrapper', $data);
	}

    public function simpan_trans(){
        $file = NULL;
        $id_trans=$this->Digital->autonumber();
        //cek bukti
        if(empty($_FILES['file_upload']['name'])){
            $return = array(
                'status' => 'failed',
                'text' => '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>File Harus diisi</div>',
            );
            echo json_encode($return);
            exit();
        }

        //1. simpan dokumen
        if(!empty($_FILES['file_upload']['name'])){

            $config ['upload_path'] = './assets/file_upload';
            $config ['allowed_types'] = 'pdf|PDF';
            $config ['max_size'] = '10240';
            // $config ['file_name'] = date("YmdHis");
            $config ['file_name'] = $id_trans."pdf";

            $this->upload->initialize($config);

            if(!$this->upload->do_upload('file_upload')){
                $error = $this->upload->display_errors();
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a> '.$error.' </div>';
            }

            $upload_data = $this->upload->data();
            $file = $id_trans;
        }
        $data = array(
            'nama_dokumen' => $this->input->post('nama_dokumen', true),
            'id_trans'=>$id_trans,
            'tanggal_kegiatan' => date('Y-m-d H:i:s'),
            'no_sertifikat' => $this->input->post('no_sertifikat', true),
            'file_upload' => $file
        );
        $simpan = $this->Digital->add_trans($data);
        
        //2. simpan QR code
        
        $hasil=$this->print_qr($id_trans);
        

        //3. gabungkan file pdf dan qrcodenya
        $databarang=$this->Digital->get_data_row($id_trans);
        $source=$databarang->file_upload;
        //$image=$id_trans.".png";
        // $this->combine($source,$image);

        if($simpan){
            $return = array(
                'status' => 'success',
                'text' => '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>Berhasil disimpan</div>',
                // 'location' => base_url().'bkd_fed/isi_fed/'.$this->input->post('id_frkd', true).'?page=buku' 
            );
        }else{
            $return = array(
                'status' => 'failed',
                'text' => '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>Gagal disimpan</div>',
            );
        }
        echo json_encode($return);
        exit();
    }
    /*
    public function combine($source,$image.$id){
        $this->load->library('mytcpdf');

        $this->mytcpdf=new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        //doc information
        $this->mytcpdf->SetCreator(PDF_CREATOR);
        $this->mytcpdf->SetAuthor('Nicola Asuni');
        $this->mytcpdf->SetTitle('TCPDF Example 002');
        $this->mytcpdf->SetSubject('TCPDF Tutorial');
        $this->mytcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        $this->mytcpdf->SetY(-20);
        $this->mytcpdf->Image($image);


        // set default header data
        $this->mytcpdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 004', PDF_HEADER_STRING);

        // set header and footer fonts
        $this->mytcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->mytcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $this->mytcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
         $this->mytcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
         $this->mytcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
         $this->mytcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
         $this->mytcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
         $this->mytcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
             $this->mytcpdf->setLanguageArray($l);
        }

        // set font
        $this->mytcpdf->SetFont('times', 'BI', 12);

        // add a page
        $this->mytcpdf->AddPage();

   

        // print a block of text using Write()
        $this->mytcpdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
        
        //untuk download di folder tertentu
        // file_put_contents(base_url().'assets/file_upload_hasil'.$id.".pdf", $this->mytcpdf->output());
        
        
    }
    */

    public function preview_hasil($id_trans){
        $source =$this->Digital->get_data_row($id_trans)->file_upload;
        $image=$id_trans.".png";
        $data=array(
            'source'=>$source,
            'image'=>$image
        );
        $this->load->view("trans_digital_signature/preview_pdf",$data);
    }
    // public function combine2($source,$image,$id_trans){
        
    //     $this->pdf->setSourceFile(base_url()."assets/file_upload/".$source);

    //     // initiate PDF
    //     $this->pdf = new MyPDF (PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, ' UTF-8 ', false);
    //     $this->pdf-> SetMargins (PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
    //     $this->pdf-> SetAutoPageBreak (true, 20);
    //     $this->pdf-> setFontSubsetting (false);
    
    //     // add a page
    //     $this->pdf-> AddPage ();
    
    //     $this->pdf-> SetFont ('freeserif', '', 12);

    //     $this->pdf->SetY(-20);
    //     $this->pdf->Image(base_url()."assets/temp/qr_codes/".$image);

    //     //untuk download di folder tertentu
    //     file_put_contents(base_url().'assets/file_upload_hasil'.$id_trans.".pdf", $this->pdf->output());
    // }
	public function print_qr($id)
    {
		$output=$this->Digital->get_data_row($id);
		$qr_code_config = array();
        $qr_code_config['cacheable'] = $this->config->item('cacheable');
        $qr_code_config['cachedir'] = $this->config->item('cachedir');
        $qr_code_config['imagedir'] = $this->config->item('imagedir');
        $qr_code_config['errorlog'] = $this->config->item('errorlog');
        $qr_code_config['ciqrcodelib'] = $this->config->item('ciqrcodelib');
        $qr_code_config['quality'] = $this->config->item('quality');
        $qr_code_config['size'] = $this->config->item('size');
        $qr_code_config['black'] = $this->config->item('black');
        $qr_code_config['white'] = $this->config->item('white');
        $this->ci_qr_code->initialize($qr_code_config);

        // get full name and user details
        $user_details = $output->no_sertifikat;
        $image_name = $id . "-QrCode.png";
    
        // create user content
		//$codeContents = $output->web_download.'/'.$this->Digital->enkripsi($output->no_sertifikat);
		$codeContents = $output->web_download.'/'.password_hash($output->no_sertifikat,PASSWORD_DEFAULT);
		//$codeContents="https://harviacode.com/2015/01/16/membuat-fungsi-untuk-enkripsi-dan-dekripsi-php/";
        // $codeContents .= "$user_details->user_name";
        // $codeContents .= " user_address:";
        // $codeContents .= "$user_details->user_address";
        // $codeContents .= "\n";
        // $codeContents .= "user_email :";
        // $codeContents .= $user_details->user_email;

        $params['data'] = $codeContents;
        $params['level'] = 'H';
        $params['size'] = 6;

        $params['savename'] = FCPATH . $qr_code_config['imagedir'] . $image_name;
        $this->ci_qr_code->generate($params);

        $this->data['qr_code_image_url'] = base_url() . $qr_code_config['imagedir'] . $image_name;

        // save image path in tree table
        //$this->user->change_userqr($id, $image_name);
        // then redirect to see image link
        $file = $params['savename'];
        return $file;
        /*
        if(file_exists($file)){
            header('Content-Description: File Transfer');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            //unlink($file); // deletes the temporary file

            //exit;
        }
        */
    }
}
