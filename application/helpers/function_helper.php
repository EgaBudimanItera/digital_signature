<?php 

	function encrypt_param($param){
		$CI =& get_instance();
		return strtr($CI->encrypt->encode($param), '+/', '-_');
	}

	function decrypt_param($param){
		$CI =& get_instance();
		$param = strtr($param, '-_', '+/');
		$param = $CI->encrypt->decode($param);
		return $param;
	}

	function active_url(){
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
			$link = "https"; 
		else
			$link = "http"; 
		
		// Here append the common URL characters. 
		$link .= "://"; 
		
		// Append the host(domain name, ip) to the URL. 
		$link .= $_SERVER['HTTP_HOST']; 
		
		// Append the requested resource location to the URL 
		$link .= $_SERVER['REQUEST_URI']; 
			
		// Print the link 
		return $link; 
	}

	function menghitung_selisih($awal, $akhir){
		// $awal  = new DateTime('2017-09-06'); //Waktu awal

		// $akhir = new DateTime(); // Waktu sekarang atau akhir

		$diff  = $awal->diff($akhir);

		// return $diff->y . ' tahun, '. $diff->m . ' bulan, '. $diff->d . ' hari, '. $diff->h . ' jam, '. $diff->i . ' menit, '. $diff->s . ' detik ';
		return $diff->y . ' tahun, '. $diff->m . ' bulan, '. $diff->d . ' hari';

	}

	function disable_active_button($id_ref_status_jabfung){
		// $param = array('1', '3', '6', '9', '12', '15');
		$param = array('1', '3', '6', '9');
		$cek = in_array($id_ref_status_jabfung, $param);
		if($cek){
			return true;
		}else{
			return false;
		}
	}

	function get_status_ditolak($id_ref_status_jabfung){
		$param = array('12', '15');
		$cek = in_array($id_ref_status_jabfung, $param);
		if($cek){
			return true;
		}else{
			return false;
		}
	}

	function allow_kepegawaian($id_ref_status_jabfung){
		$param = array('11', '13', '14', '16', '17', '18');
		$cek = in_array($id_ref_status_jabfung, $param);
		if($cek){
			return true;
		}else{
			return false;
		}
	}

	function enable_dosen_submit($id_ref_status_jabfung){
		$param = array('1', '3', '6', '9');
		$cek = in_array($id_ref_status_jabfung, $param);
		if($cek){
			return true;
		}else{
			return false;
		}
	}

	function get_total_waktu($id=''){
		$CI=& get_instance();
		
		$cek_riwayat =  $CI->db->get_where('tb_data_pengajuan_nomor_induk_riwayat', array('id_data_pengajuan_nomor_induk' => $id));
		if($cek_riwayat->num_rows() != 0){
			$awal_1 = $CI->db->query("SELECT * from tb_data_pengajuan_nomor_induk_riwayat where id_data_pengajuan_nomor_induk = '$id' order by id_data_pengajuan_nomor_induk_riwayat ASC limit 1");
			$awal = new DateTime($awal_1->row()->tgl_create); //Waktu awal

			$akhir_1 = $CI->db->query("SELECT * from tb_data_pengajuan_nomor_induk_riwayat where id_data_pengajuan_nomor_induk = '$id' and id_data_pengajuan_nomor_induk_riwayat='18' order by id_data_pengajuan_nomor_induk_riwayat  DESC limit 1");
			if($akhir_1->num_rows() != 0){
				$akhir = new DateTime($akhir_1->row()->tgl_create); //Waktu akhir
			}else{
				$akhir = new DateTime(date('Y-m-d H:i:s')); //Waktu akhir
			}
			// var_dump($akhir);exit();
			$track = menghitung_selisih($awal, $akhir);
		}else{
			$track = 'belum ada';
		}
		return $track;
	}

	function total_waktu_rule($rule = '', $id_data_pengajuan_nomor_induk = ''){
		$CI=& get_instance();
		$total_waktu = 'Belum ada perhitungan waktu';
		$waktu_akhir = new DateTime(date('Y-m-d H:i:s'));
		// $waktu_awal = new DateTime(date('Y-m-d H:i:s'));
		$tgl_awal = array(			
			'jurusan' => '1',
			'kepegawaian' => '4',
			'kementerian' => '7'
		);	
		
		$get_waktu_awal = $CI->db->get_where('tb_data_pengajuan_nomor_induk_riwayat', array('id_ref_status' => $tgl_awal[$rule], 'id_data_pengajuan_nomor_induk' => $id_data_pengajuan_nomor_induk));
		// var_dump($rule);exit();
		if($get_waktu_awal->num_rows() == 0){
			return $total_waktu; 
		}else{
					
			$CI->db->from('tb_data_pengajuan_nomor_induk_riwayat');
			// if($rule == 'prodi'){
			// 	// $CI->db->where_in('status', array('ybs', 'prodi'));
			// 	$CI->db->where(array('id_data_pengajuan_nomor_induk' => $id_data_pengajuan_nomor_induk, 'id_ref_status_jabfung' => $tgl_awal[$rule]));
			// }else{
			// 	$CI->db->where(array('status' => $rule, 'id_data_pengajuan_nomor_induk' => $id_data_pengajuan_nomor_induk, 'id_ref_status_jabfung' => $tgl_awal[$rule]));
			// }		
			$CI->db->where(array('id_data_pengajuan_nomor_induk' => $id_data_pengajuan_nomor_induk, 'id_ref_status' => $tgl_awal[$rule]));	
			// $CI->db->where(array('id_data_pengajuan_nomor_induk' => $id_data_pengajuan_nomor_induk, 'id_ref_status_jabfung' => $tgl_awal[$rule]));
			$CI->db->order_by('id_data_pengajuan_nomor_induk_riwayat', 'ASC');
			$CI->db->limit('1');
			$get_waktu_awal = $CI->db->get();
			if($get_waktu_awal->num_rows() != 0){
				$waktu_awal = new DateTime($get_waktu_awal->row()->tgl_create);
			}
			
			$tgl_akhir = array(				
				'jurusan' => '4',
				'kepegawaian' => '7',
				'kementerian' => '10'
			);
			$CI->db->from('tb_data_pengajuan_nomor_induk_riwayat');
			// $CI->db->where(array('status' => $rule, 'id_data_pengajuan_nomor_induk' => $id_data_pengajuan_nomor_induk, 'id_ref_status_jabfung' => $tgl_akhir[$rule]));
			$CI->db->where(array('id_data_pengajuan_nomor_induk' => $id_data_pengajuan_nomor_induk, 'id_ref_status' => $tgl_akhir[$rule]));
			$CI->db->order_by('id_data_pengajuan_nomor_induk_riwayat', 'DESC');
			$CI->db->limit('1');
			$get_waktu_akhir = $CI->db->get();
			
			if($get_waktu_akhir->num_rows() != 0){
				$waktu_akhir = new DateTime($get_waktu_akhir->row()->tgl_create);
			}
			
			$total_waktu = menghitung_selisih($waktu_awal, $waktu_akhir);
			return $total_waktu;
			
			// return array($waktu_akhir, $waktu_awal, $rule, $id_pengajuan_jabfung, $tgl_awal[$rule], $tgl_akhir[$rule]);
		}
		
	}
?>