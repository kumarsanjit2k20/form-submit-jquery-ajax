<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		$this->load->view('employee');
	}
	public function add(){

		$name=htmlspecialchars($this->input->post('full_name'));
		$email=htmlspecialchars($this->input->post('email'));
		$phone=htmlspecialchars($this->input->post('phone'));
		
		$files_arr=0;
		$destination="assets/uploads/";
		if (!empty($_FILES['mul_images']['name'][0])) {
			$files_arr =count($_FILES['mul_images']['name']);
		}

		$edit_record_id=$this->input->post('record_edit_id');
		if (empty($edit_record_id)) 
		{
			$edit_record_id=0;
		}


		// Checking Number of Images
		if((($files_arr<=0 or $files_arr>3) and empty($edit_record_id)) or ($files_arr>3 and !empty($edit_record_id)) ){
			$error_data[]=array('status'=>0,
								'err_message'=>'Atleast One Image and Maximum 3 Image You Can Upload!');
			echo json_encode($error_data);
			exit();
		}

		// checking required field is empty or not
		if (empty($name) or empty($email) or empty($phone)) {
			$error_data[]=array('status'=>0,
								'err_message'=>'Astrik * fields are Required!');
			echo json_encode($error_data);
			exit();
		}


		// Duplicate Checking of Email Address
		$sql_dupcheck1="SELECT id,email FROM employee WHERE email='".$email."' ";
		if (!empty($edit_record_id)) {
			$sql_dupcheck1=$sql_dupcheck1." AND id<>'$edit_record_id'";
		}
		$result_dupcheck=$this->db->query($sql_dupcheck1)->result_array();
		if (count($result_dupcheck)>0) {
			$error_data[]=array('status'=>0,
								'err_message'=>'Email Already Exist!');
			echo json_encode($error_data);
			exit();
		}
		
		// Duplicate Checking of Mobile Number
		$sql_dupcheck2="SELECT id,phone FROM employee WHERE phone='".$phone."' ";
		if (!empty($edit_record_id)) {
			$sql_dupcheck2=$sql_dupcheck2." AND id<>'$edit_record_id'";
		}
		$result_dupcheck2=$this->db->query($sql_dupcheck2)->result_array();
		if (count($result_dupcheck2)>0) {
			$error_data[]=array('status'=>0,
								'err_message'=>'Phone Number Already Exist!');
			echo json_encode($error_data);
			exit();
		}



		// Insert
		$sql_insert_updt="INSERT INTO employee
		    SET
		    full_name='".$name."',
		    email='".$email."',
		    phone='".$phone."',
		    status=1";

		   //Update
		  if (!empty($edit_record_id)) 
		  {
			$sql_insert_updt="UPDATE employee
			    SET
			    full_name='".$name."',
			    email='".$email."',
			    phone='".$phone."',
			    status=1
			    WHERE id='".$edit_record_id."'";
		   }  
		   $this->db->query($sql_insert_updt);
		   $last_insert_id=0;
		   $last_insert_id=$this->db->insert_id();
		   if (!empty($edit_record_id)) 
		   {
		   		$last_insert_id=$edit_record_id;
		   }

		   // for Image
		   $dataInfo=array();

		   if (!empty($last_insert_id)) 
		   {
		   				
		   		for($i=0; $i<$files_arr; $i++)
			    {           
			        $file_name= $_FILES['mul_images']['name'][$i];
			        $temp_name= $_FILES['mul_images']['tmp_name'][$i];

		            $img1_file_name=strtolower(trim(str_replace(' ', '_', $file_name)));
		            $dataInfo[] = $img1_file_name;

		            $store=$destination.$img1_file_name;
		            if (!file_exists($store)) {
		            	move_uploaded_file($temp_name, $store);
		            }  
			    }

			    $image1=!empty($dataInfo[0]) ? $dataInfo[0] : '';
				$image2=!empty($dataInfo[1]) ? $dataInfo[1] : '';
				$image3=!empty($dataInfo[2]) ? $dataInfo[2] : '';
				$sql_img_updt=FALSE;

				if (!empty($image1)) {
					$sql_updt_image="UPDATE employee SET 
					image1='$image1' ";
					$sql_img_updt=TRUE;
				}
				if (!empty($image1) and !empty($image2)) {
					$sql_updt_image="UPDATE employee SET 
					image1='$image1',
					image2='$image2' ";
					$sql_img_updt=TRUE;
				}

				if (!empty($image1) and !empty($image2) and !empty($image3)) {
					$sql_updt_image="UPDATE employee SET 
					image1='$image1',
					image2='$image2',
					image3='$image3' ";
					$sql_img_updt=TRUE;
				    	
				}

				if ($sql_img_updt===TRUE) 
				{
					$sql_updt_image=$sql_updt_image. " WHERE id='".$last_insert_id."'";
					$this->db->query($sql_updt_image);
				}
				
				
			    $sql_select="SELECT id, full_name, email, phone, image1, image2, image3, `status` FROM employee WHERE id='".$last_insert_id."'";

		    	$result_rec=$this->db->query($sql_select)->result_array();
		    	echo json_encode($result_rec);
			}
			
	}
	public function edit()
	{
		$redc_id=$this->input->post('record_id');
			$sql_select="SELECT id, full_name, email, phone, image1, image2, image3, status FROM employee WHERE id='".$redc_id."'";
    	$result_rec=$this->db->query($sql_select)->result_array();
    	echo json_encode($result_rec);
	}
	public function delete(){
		$redc_id=$this->input->post('record_id');
		if (!empty($redc_id)) {
			$this->db->where('id',$redc_id);
			$this->db->delete('employee');
			if ($this->db->affected_rows()) {
				echo "Record Deleted Successfully!";
			}else{
				echo "Something Went Wrong!";
			}
		}
	}
}
