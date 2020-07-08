<?php 
$sql_q="SELECT `id`, `full_name`, `email`, `phone`, `image1`, `image2`, `image3`, `status` FROM `employee` WHERE 1";
$resilt_arr=$this->db->query($sql_q)->result_array();
$result_count=count($resilt_arr);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> 
 
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	#container h1{
		text-align: center;
	}
	#form_container{
		display: flex;
		justify-content: center;
		border:1px solid lightgrey;
		margin-left: 25%;
		width: 50%;
		border-radius: 5px;
		padding: 10px;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Employee Records Entry!</h1>
	<div class="row mx-auto my-0" >
		<div class="col-sm-12 p-5">
			<div id="form_container">
		<form id="my_add_form" method="post" enctype="multipart/form-data">
			<input type="hidden" id="record_edit_id" name="record_edit_id" value="">
		  <div class="form-group">
		    <label for="full_name">Email address<span style="color:red;">*</span>:</label>
		    <input required="required" type="text" name="full_name" class="form-control" placeholder="Enter Name" id="full_name">
		  </div>
		  <div class="form-group">
		    <label for="phone">Phone<span style="color:red;">*</span>:</label>
		    <input required="required" type="text" name="phone" max_length="10" class="form-control" placeholder="Enter Phone" id="phone">
		  </div>
		  <div class="form-group">
		    <label for="email">Email address<span style="color:red;">*</span>:</label>
		    <input required="required" type="email" name="email" class="form-control" placeholder="Enter email" id="email">
		  </div>
		  <div class="form-group">
		    <label>Photo<span style="color:red;">*</span>:</label>
		    <input required="required" type="file" name="mul_images[]" multiple="multiple" class="form-control" id="mul_images">
		  </div>

		  <div class="form-group form-check">
		    <!-- <label class="form-check-label">
		      <input class="form-check-input" type="checkbox"> Remember me
		    </label> -->
		  </div>
		  <input type="submit" name="Submit" class="btn btn-primary" value="Submit">		

		</form> 
	</div>
	</div>
	
		</div>
	<br>
	<div class="row">
		<div class="col-sm-12">
				<div id="body">
		<table class="table table-dark table-striped table-bordered" style="width: 100% !important; " id="table_id">
		  <thead>
		    <tr>
		      <th scope="col">SL.No</th>
		      <th scope="col">Name</th>
		      <th scope="col">Phone</th>
		      <th scope="col">Email</th>
		      <th scope="col">Photo</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody id="table_body">
		    <?php
		    $j=1;
		    foreach ($resilt_arr as $key => $value) {?>
		    	<tyr>
		    	<td><?php echo $j++; ?></td>
			    		<td><?php echo $value['full_name']; ?></td>
			    		<td><?php echo $value['email']; ?></td>
			    		<td><?php echo $value['phone']; ?></td>
			    		<td>
			    			<img style="width:150px;" src="<?php echo base_url().'assets/uploads/'.$value['image1']; ?>" >
			    			<?php if(!empty($value['image2'])){ ?>
			    			<img style='width:150px;' src="<?php echo base_url().'assets/uploads/'.$value['image2']; ?>" >
			    			<?php } if(!empty($value['image3'])){ ?>
			    			<img style='width:150px;' src="<?php echo base_url().'assets/uploads/'.$value['image3']; ?>" >
			    		<?php }?>
			    		<td>
			    			<a  class="btn btn-primary" onclick="editRec('<?php echo $value['id']; ?>')" href="javascript:void(0);" id="edit_btn" data-id="<?php echo $value['id']; ?>" href="<?php echo base_url().'edit'; ?>">Edit</a>
			    			<a class="btn btn-danger" onclick="deleteRec('<?php echo $value['id']; ?>')" href="javascript:void(0);" id="edit_btn_<?php echo $value['id']; ?>" data-id="<?php echo $value['id']; ?>" href="<?php echo base_url().'delete'; ?>">Delete</a>
			    		</td>
			   </tr>
		   <?php }
		    ?>
		  </tbody>
		</table>

		</div>
	</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

	/*========Edit Single Record==========*/
	function editRec(recId){
       	$.ajax({
            type: "POST",
            url: "<?php echo base_url().'employee/edit'; ?>",
            data: {record_id:recId},
  			dataType: 'JSON',
            success: function(resp){

                $('#full_name').val(resp[0].full_name);
                $('#email').val(resp[0].email);
                $('#phone').val(resp[0].phone);
                $('#record_edit_id').val(resp[0].id);
                $('#mul_images').prop('required',false);
            }
            
       	});
    }
        
    /*====Delete Record======*/
    function deleteRec(recId){
     	var confirmValue=confirm('Are You Sure You want to Delete this Record?');
     	if(confirmValue){
     		$.ajax({
	            type: "POST",
	            url: "<?php echo base_url().'employee/delete'; ?>",
	            data: {record_id:recId},
	            success: function(resp){
	                $('#edit_btn_'+recId).closest("tr").remove();
	                alert(resp);
	            }
        
   			});
     	}
    }

    /*=============Record Insert and Update============*/
	$(document).ready(function() {


		$('input[type="file"]').change(function () {
			
			/*
				// returns file object
				console.log($(this));

				// returns files attributes
				console.log($(this)[0]);

				// returns all files to be uploaded with length attributes
				console.log($(this)[0].files);

				// returns the length of the file
				console.log($(this)[0].files.length);

				// Loop through these files using jquery loop
				// jQuery.each(array, callback)

				var arr = [1, 2, 3, 4];
				$.each(arr , function(index, val) { 
				  console.log(index, val);
				});

				// or for objects it can be used as
				// jQuery.each(object, callback)

				var someObj = { foo: "bar"};

				$.each(someObj, function(propName, propVal) {
				  console.log(propName, propVal);
				});

				$.each(arr_val, function(index, val){
					// below both line returns same output as individual file object
					console.log(arr_val[index]);
					console.log(val);
					
					// we get the file property by using dot operator
					console.log(val.name);
					console.log(val.type);
					console.log(val.size);
				});

			*/

			var arr_val=$(this)[0].files;

			// Checking No of Files to be Uploeded
			var file_count=$(this)[0].files.length;
		  	if(file_count>3 || file_count<=0 ){
		  		alert('Atleast One Image and Maximum 3 Images You can Upload!');
		  	}

		});
			

	    $('form#my_add_form').submit(function(e) {
	    	e.preventDefault();

	    	// getting all records count
	    	var row_count='<?php echo $result_count; ?>';
	        var base_url_val="<?php echo base_url(); ?>";
	        var img_url_val=base_url_val+'assets/uploads/';
	        var old_id=parseInt($('#record_edit_id').val());
	        var formData =new FormData(this);

	        $.ajax({
	            type: "POST",
	            url: base_url_val+'employee/add',
	            data: formData,
	            processData: false,
	            contentType: false,
	  			dataType: 'JSON',
	            success: function(resp){
	         		// console.log(resp);
	         		// alert(resp);
	         		if (resp[0].status!=0) 
	            	{
		            	var id=resp[0].id;
		            	var name=resp[0].full_name;
		            	var email=resp[0].email;
		            	var phone=resp[0].phone;
		            	var image1=resp[0].image1;
		            	var image2=resp[0].image2;
		            	var image3=resp[0].image3;

		            	var last_two_col_str='<td><img style="width:150px;" src="'+img_url_val+image1+'">';

		            	if(image2!=''){
		            		last_two_col_str=last_two_col_str+'<img style="width:150px;" src="'+img_url_val+image2+'">';
		            	}
		            	if(image3!=''){
		            		last_two_col_str=last_two_col_str+'<img style="width:150px;" src="'+img_url_val+image3+'">';
		            	}

		            	last_two_col_str=last_two_col_str+'</td><td>'+
					    			'<a  onclick="editRec('+id+')" href="javascript:void(0);" class="btn btn-primary" id="edit_btn" href="'+'base_url_val'+'edit'+'">Edit</a><a id="edit_btn_'+id+'" onclick="deleteRec('+id+')" class="btn btn-danger" href="javascript:void(0);">Delete</a></td>';
					   	
					    if (old_id!='') {
					    	row_count=parseInt(row_count);
		        			$('#edit_btn_'+old_id).closest("tr").remove();
		        		}else{
		        			row_count=parseInt(row_count)+1;
		        		}   

		        		// Append new Row With Existing Table    					
		            	$('#table_id').append('<tr><td>' + row_count + '</td>' + '<td>' + name + '</td>' + '<td>' + email + '</td>' + '<td>' + phone + '</td>'+last_two_col_str+'</tr>');

		            	// Reset Form Data After Insert or Update
		            	$('form#my_add_form').trigger("reset");
		                alert('Record Saved Successfully!');
		            }
		            else
		            {
		            	if (resp[0].err_message!='') 
		            	{
		            		alert(resp[0].err_message);
		            	}
		            } 
	            }
	       });
	    });

	});

</script>
</body>
</html>