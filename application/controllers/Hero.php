<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hero extends CI_Controller {

	public function index($idJenis)
	{
		$this->load->model('hero_model');
		$data["hero_list"] = $this->hero_model->getHeroByJenis($idJenis);
		$this->load->view('hero',$data);	
	}

	public function create($idJenis)
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation'); 
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->load->model('hero_model');	
		if($this->form_validation->run()==FALSE){

			$this->load->view('tambah_hero_view');

		}else{
			$config['upload_path']          = './assets/uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 1000000000;
            $config['max_width']            = 10240;
            $config['max_height']           = 7680;

			$this->load->library('upload', $config);

			 if ( ! $this->upload->do_upload('userfile'))
            {
                    $error = array('error' => $this->upload->display_errors());
					$this->load->view('tambah_hero_view',$error);
            }
            else
            {
					$this->hero_model->insertHero($idJenis);
					$this->load->view('tambah_hero_sukses');
            }
		}
	}

	public function update($idHero)
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		$this->load->model('hero_model');

		$data['hero']=$this->hero_model->getHeroById($idHero);
		$data2=$this->hero_model->getHeroById($idHero);
		$nama = $data2[0]->foto;

		if($this->form_validation->run()==FALSE){
			$this->load->view('edit_hero_utama_view',$data);
		}
		else{
			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '1000';
			$config['max_width']  = '10240';
			$config['max_height']  = '7680';

			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload()){

				$error = array('error' => $this->upload->display_errors());
				$this->load->view('edit_hero_utama_view',$error);
			}
			else
			{
				$image_data = $this->upload->data();

				$this->hero_model->UpdateHero($idHero);
				unlink('assets/uploads/'.$nama);

				$this->load->view('edit_hero_utama_sukses');
			}
		}
	}

	public function delete($idHero)
	{
		$this->load->helper('url','form');
		$this->load->library('form_validation');
		$this->load->model('hero_model');
		$this->hero_model->deleteHero($idHero);
		
		if($this->form_validation->run()==FALSE){
			redirect('jenis_hero');
		}
	}
}


/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */

 ?>