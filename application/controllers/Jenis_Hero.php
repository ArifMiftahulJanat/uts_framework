<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_Hero extends CI_Controller {

	public function index()
	{
		$this->load->model('hero_model');
		$data["hero_list"] = $this->hero_model->getDataJenisHero();
		$this->load->view('jenis_hero',$data);	
	}

	public function datatable()
	{
		$this->load->model('hero_model');
		$data["hero_list"] = $this->hero_model->getDataJenisHero();
		$this->load->view('jenis_hero', $data);
	}

	public function create()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
		$this->load->model('hero_model');	
		if($this->form_validation->run()==FALSE)
		{
			$this->load->view('tambah_hero_view');
		}
		else
		{
			$this->hero_model->insertJenisHero();
			$this->load->view('tambah_hero_sukses');
		}
	}

	public function update($id)
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
		//sebelum update data harus ambil data lama yang akan di update
		$this->load->model('hero_model');
		$data['jenis_hero']=$this->hero_model->getJenisHero($id);
		//skeleton code
		if($this->form_validation->run()==FALSE)
		{

		//setelah load data dikirim ke view
			$this->load->view('edit_hero_view',$data);

		}
		else
		{
			$this->hero_model->updateById($id);
			$this->load->view('edit_hero_sukses');
		}
	}

	public function delete($id)
	{ 
		$this->load->model('hero_model');
		$this->hero_model->deleteById($id);
		redirect('jenis_hero');
	}
}


/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */

 ?>