<?php
  class Digital extends CI_Model {
  	
    public function __construct(){
        parent::__construct();
        $this->signature = $this->load->database('signature', TRUE);
        
    }

    function get_data_all_master(){
      $this->signature->select('id,tb_master_signature.id_pegawai,created_time,nama_pegawai')->from('tb_master_signature')
                    ->join('db_simpeg.tb_pegawai','tb_master_signature.id_pegawai=db_simpeg.tb_pegawai.id_pegawai');
      
        return $this->signature->get();
    }

    function get_data_all_trans(){
        
      
        $hasiltrans=$this->signature->get('tb_trans_signature')->result();
        
        // $output=array();
        // foreach($hasiltrans as $h){
        //     $h->hasil=$this->enkripsi($h->id_trans."|".$h->nama_dokumen);
        // }
        
        return $hasiltrans;
    }

    function get_data_row($id){
        return $this->signature->get_where('tb_trans_signature', array('id_trans' => $id))->row();
    }

    function get_secret_key(){
       return $this->signature->get('tb_secret',1);
    }
    
    function enkripsi($str){
        $kunci=$this->get_secret_key()->row()->secret_key;
        $hasil = '';
        //$kunci="979a218e0632df2935317f98d47956c7";
        for ($i = 0; $i < strlen($str); $i++) {
            $karakter = substr($str, $i, 1);
            $kuncikarakter = substr($kunci, ($i % strlen($kunci))-1, 1);
            $karakter = chr(ord($karakter)+ord($kuncikarakter));
            $hasil .= $karakter;
        }
        return urlencode(base64_encode($hasil));
    }

    function dekripsi($str){
        $str = base64_decode(urldecode($str));
        $hasil = '';
        $kunci = $this->get_secret_key();
        for ($i = 0; $i < strlen($str); $i++) {
            $karakter = substr($str, $i, 1);
            $kuncikarakter = substr($kunci, ($i % strlen($kunci))-1, 1);
            $karakter = chr(ord($karakter)-ord($kuncikarakter));
            $hasil .= $karakter;
        }
        return $hasil;
    }

    function add_trans($data){
        return $this->signature->insert('tb_trans_signature',$data);
    }

    function last_id(){
        return $this->signature->insert_id();
    }

    function autonumber(){
        //FD 0001 07 2020
        $tgl = date("ymd"); //date(Ymd) : jika mau tahun 4 digit

        $this->signature->select("MID(id_trans,3,4) as kode",FALSE);
        $this->signature->order_by("id_trans", "desc");
        $this->signature->limit(1);
        $this->signature->from("tb_trans_signature");
        
        $query = $this->signature->get();
        if($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        }
        else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 4, 0, STR_PAD_LEFT).date('mY', strtotime($tgl))  ; 
        $kodejadi = "FD". $kodemax;

        return $kodejadi;
    }

  }
?>
