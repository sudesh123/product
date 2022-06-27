<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->model('crud_model');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function insert()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('product_name', 'Product Name', 'required');
			$this->form_validation->set_rules('product_price', 'Product Price', 'required');
			$this->form_validation->set_rules('product_description', 'Product Description', 'required');
			// $this->form_validation->set_rules('img', 'Profile Picture', 'required');

			if ($this->form_validation->run() == FALSE) {
				$data = array('res' => "error", 'message' => validation_errors());
			} else {
				$config['upload_path'] = APPPATH . '../assets/uploads/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['max_size']     = '10000';
				// $config['max_width'] = '1024';
				// $config['max_height'] = '768';
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload("product_images")) {
					$data = array('res' => "error", 'message' => $this->upload->display_errors());
				} else {
					$ajax_data = $this->input->post();
					$ajax_data['product_image'] = $this->upload->data('file_name');
                    $ids = $this->crud_model->insert_entry($ajax_data);
					if ($ids) {
						$data = array('res' => "success", 'message' => "Product added successfully");
					} else {
						$data = array('res' => "error", 'message' => "Failed to add data");
					}
					$number_of_files_uploaded = count($_FILES['product_image']['name']);
				for($i = 0; $i < $number_of_files_uploaded; $i++){ 
                            $_FILES['file']['name']     = $_FILES['product_image']['name'][$i]; 
                            $_FILES['file']['type']     = $_FILES['product_image']['type'][$i]; 
                            $_FILES['file']['tmp_name'] = $_FILES['product_image']['tmp_name'][$i]; 
                            $_FILES['file']['error']    = $_FILES['product_image']['error'][$i]; 
                            $_FILES['file']['size']     = $_FILES['product_image']['size'][$i]; 
                             
                            // File upload configuration 
                            $uploadPath =  APPPATH . '../assets/uploads/';
                            $config['upload_path'] = $uploadPath; 
                            $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                             
                            // Load and initialize upload library 
                            $this->load->library('upload', $config); 
                            $this->upload->initialize($config); 
                             
                            // Upload file to server 
                            if($this->upload->do_upload('file')){ 
                                // Uploaded file data 
                                $fileData = $this->upload->data(); 
                                $uploadData[$i]['product_id'] = $ids; 
                                $uploadData[$i]['file_name'] = $fileData['file_name']; 
                                $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                            }else{ 
                                	$data = array('res' => "success", 'message' => "Product added successfully");
                            } 
                        } 
                        if(!empty($uploadData)){ 
                            // Insert files info into the database 
                            $insert = $this->crud_model->insertImage($uploadData); 
                        }
				}
			}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
	public function fetch()
	{
		$posts = $this->crud_model->get_entries();
		echo json_encode($posts);
	}
	public function delete()
	{
		if ($this->input->is_ajax_request()) {

			$del_id = $this->input->post('del_id');

			$post = $this->crud_model->single_entry($del_id);

			unlink(APPPATH . '../assets/uploads/' . $post->product_image);

			if ($this->crud_model->delete_entry($del_id)) {
			    if ($this->crud_model->delete_entry_all($del_id)) {
				        $data = array('res' => "success", 'message' => "Product delete successfully");
			    } else {
				$data = array('res' => "error", 'message' => "Delete query errors");
			}
			} else {
				$data = array('res' => "error", 'message' => "Delete query errors");
			}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

	/* -------------------------------------------------------------------------- */
	/*                                Edit Records                                */
	/* -------------------------------------------------------------------------- */

	public function edit()
	{
		if ($this->input->is_ajax_request()) {

			$edit_id = $this->input->get('edit_id');

			if ($post = $this->crud_model->single_entry($edit_id)) {
				$data = array('res' => "success", 'post' => $post);
			} else {
				$data = array('res' => "error", 'message' => "Failed to fetch data");
			}

			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

	/* -------------------------------------------------------------------------- */
	/*                               Update Records                               */
	/* -------------------------------------------------------------------------- */

	public function update()
	{
		if ($this->input->is_ajax_request()) {
		    $this->form_validation->set_rules('edit_product_name', 'Product Name', 'required');
			$this->form_validation->set_rules('edit_product_price', 'Product Price', 'required');
			$this->form_validation->set_rules('edit_product_description', 'Product Description', 'required');

			if ($this->form_validation->run() == FALSE) {
				$data = array('res' => "error", 'message' => validation_errors());
			} else {
				if (isset($_FILES["edit_product_images"]["name"])) {
					$config['upload_path'] = APPPATH . '../assets/uploads/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']     = '1000';
					// $config['max_width'] = '1024';
					// $config['max_height'] = '768';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload("edit_product_images")) {
						$data = array('res' => "error", 'message' => $this->upload->display_errors());
					} else {
						$edit_id = $this->input->post('edit_id');
						if ($post = $this->crud_model->single_entry($edit_id)) {
							unlink(APPPATH . '../assets/uploads/' . $post->product_image);
							$ajax_data['product_image'] = $this->upload->data('file_name');
						}
					}
				}
				$id = $this->input->post('edit_id');
				$ajax_data['product_name'] = $this->input->post('edit_product_name');
				$ajax_data['product_price'] = $this->input->post('edit_product_price');
				$ajax_data['product_description'] = $this->input->post('edit_product_description');
				if ($this->crud_model->update_entry($id, $ajax_data)) {
					$data = array('res' => "success", 'message' => "Product update successfully");
				} else {
					$data = array('res' => "error", 'message' => "Failed to update data");
				}
					if(!empty($_FILES['product_image']['name'])){
				$number_of_files_uploaded = count($_FILES['product_image']['name']);
				for($i = 0; $i < $number_of_files_uploaded; $i++){ 
                            $_FILES['file']['name']     = $_FILES['product_image']['name'][$i]; 
                            $_FILES['file']['type']     = $_FILES['product_image']['type'][$i]; 
                            $_FILES['file']['tmp_name'] = $_FILES['product_image']['tmp_name'][$i]; 
                            $_FILES['file']['error']    = $_FILES['product_image']['error'][$i]; 
                            $_FILES['file']['size']     = $_FILES['product_image']['size'][$i]; 
                             
                            // File upload configuration 
                            $uploadPath =  APPPATH . '../assets/uploads/';
                            $config['upload_path'] = $uploadPath; 
                            $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                             
                            // Load and initialize upload library 
                            $this->load->library('upload', $config); 
                            $this->upload->initialize($config); 
                             
                            // Upload file to server 
                            if($this->upload->do_upload('file')){ 
                                // Uploaded file data 
                                $fileData = $this->upload->data(); 
                                $uploadData[$i]['product_id'] = $id; 
                                $uploadData[$i]['file_name'] = $fileData['file_name']; 
                                $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                            }else{ 
                                	$data = array('res' => "success", 'message' => "Product update successfully");
                            } 
                        } 
                        if(!empty($uploadData)){ 
                            // Insert files info into the database 
                            $insert = $this->crud_model->insertImage($uploadData); 
                        }
			}else{
			    $data = array('res' => "success", 'message' => "Product update successfully");
			}
			}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
}
