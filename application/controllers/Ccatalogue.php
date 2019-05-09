<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ccatalogue extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('lcatalogue');
		$this->load->model('Catalogues');
		$this->auth->check_admin_auth();
    }
	//Default loading for unit system.
	public function index()
	{
        $content = $this->lcatalogue->catologue_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Insert unit
	public function insert_catalogue()
	{
		$this->form_validation->set_rules('catalogue_name', display('name'), 'trim|required');
		$this->form_validation->set_rules('catalogue_short_name', display('short_name'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_catalogue')
			);
        	$content = $this->parser->parse('catalogue/add_catalogue',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {

			$data=array(
				'catalogue_id' 		=> $this->auth->generator(15),
				'catalogue_name' 	=> $this->input->post('catalogue_name'),
				'catalogue_short_name' => $this->input->post('catalogue_short_name'),
                'catalogue_description' => $this->input->post('catalogue_description'),
				);

			$result=$this->Catalogues->catalogue_entry($data);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message'=>display('successfully_added')));
				if(isset($_POST['add-catalogue'])){
					redirect(('Ccatalogue/manage_catalogue'));
				}elseif(isset($_POST['add-catalogue-another'])){
					redirect(('Ccatalogue'));
				}

			}else{
				$this->session->set_userdata(array('error_message'=>display('already_inserted')));
				redirect(('Ccatalogue'));
			}
        }
	}
	//Manage unit
	public function manage_catalogue()
	{
        $content =$this->lcatalogue->catalogue_list();
        $this->template->full_admin_html_view($content);
	}

    public function catalogue_add_product($catalogue_id,$product_id)
    {
        $data=array(
            'catalogue_product_id' 		=> $this->auth->generator(15),
            'catalogue_id' 		=> $catalogue_id,
            'product_id' 	=> $product_id,
        );

        $result=$this->Catalogues->catalogue_product_entry($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message'=>display('successfully_added')));
            redirect(('Ccatalogue/product/'.$catalogue_id));

        }else{
            $this->session->set_userdata(array('error_message'=>"Ya este producto existe en el catálogo"));
            redirect(('Ccatalogue/product/'.$catalogue_id));
        }
    }

    public function catalogue_delete_product($catalogue_id,$catalogue_product_id)
    {
        $result=$this->Catalogues->catalogue_product_delete($catalogue_product_id);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message'=>display('successfully_delete')));
            redirect(('Ccatalogue/product/'.$catalogue_id));

        }else{
            $this->session->set_userdata(array('error_message'=>"Error al eliminar el producto del catálogo"));
            redirect(('Ccatalogue/product/'.$catalogue_id));
        }
    }


    public function product($catalogue_id)
    {
        $content =$this->lcatalogue->product($catalogue_id);
        $this->template->full_admin_html_view($content);
    }

	//unit Update Form
	public function catalogue_update_form($catalogue_id)
	{	
		$content = $this->lcatalogue->catalogue_edit_data($catalogue_id);
		$this->template->full_admin_html_view($content);
	}
	// unit Update
	public function catalogue_update($catalogue_id=null)
	{

		$this->form_validation->set_rules('catalogue_name', display('name'), 'trim|required');
		$this->form_validation->set_rules('catalogue_short_name', display('short_name'), 'trim|required');


		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('catalogue_edit')
			);
        	$content = $this->parser->parse('catalogue/edit_catalogue/'.$catalogue_id,$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {

			$data=array(
				'catalogue_name' 	=> $this->input->post('catalogue_name'),
				'catalogue_short_name' 	=> $this->input->post('catalogue_short_name'),
                'catalogue_description' 	=> $this->input->post('catalogue_description')
				);

			$result=$this->Catalogues->update_catalogue($data,$catalogue_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message'=>display('successfully_updated')));
                    redirect(('Ccatalogue/manage_catalogue'));
            }else{
                $this->session->set_userdata(array('error_message'=>display('already_inserted')));
                redirect(('Ccatalogue'));
            }
        }
	}
	// unit Delete
	public function catalogue_delete($catalogue_id)
	{	
		$result = $this->Catalogues->delete_catalogue($catalogue_id);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			redirect('Ccatalogue/manage_catalogue');
		}	
	}
}