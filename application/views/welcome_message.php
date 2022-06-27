<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="Description" content="Enter your description here" />
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
	<!-- Toastr CSS -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<!-- Datatables CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.css" />
	<title>PRODUCTS</title>
	<link rel="icon" type="image/x-icon" href="https://www.pngitem.com/pimgs/m/325-3256236_products-icon-vector-product-icon-png-transparent-png.png">
	<link rel="stylesheet" href="<?php echo base_url('/assets/css/main.css') ?>">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12 mt-5 tops">
				<h1 class="text-left"><a href="<?php echo base_url();?>"><img width="100px" src="https://www.pngitem.com/pimgs/m/325-3256236_products-icon-vector-product-icon-png-transparent-png.png"></a>PRODUCT</h1>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			    <div class="col-md-12 text-right">
    				<!-- Button trigger modal -->
    				<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addRecords">
    					Add Product
    				</button>
               </div>
				<!-- Add Records Modal -->
				<div class="modal fade" id="addRecords" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">

								<!-- Add Record Form -->
								<form id="addRecordForm" enctype="multipart/form-data">

									<!-- product_name -->
									<div class="input-group mb-3">
										<input type="text" class="form-control" id="product_name" placeholder="Product Name" aria-label="product_name">
									</div>

									<!-- product_price -->
									<div class="input-group mb-3">
										<input type="text" class="form-control" id="product_price" placeholder="Product Price" aria-label="product_price">
									</div>
									<!-- product_description -->
									<div class="input-group mb-3">
										<input type="text" class="form-control" id="product_description" placeholder="Product Description" aria-label="product_description">
									</div>
									<!-- product_image -->
									<div class="custom-file input-group mb-3">
										<input type="file" class="custom-file-input" id="product_images">
										<label class="custom-file-label" for="customFile">Product Image</label>
									</div><br>
									<!-- product_image -->
									<div class="uploadmultiple">
									    <label>Upload Multiple Images</label>
										<input type="file"  id="product_image" name="product_image[]" multiple="multiple">
									</div>

								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

								<!-- Insert Button -->
								<button type="button" class="btn btn-primary" id="add">Add Product</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Edit Records Modal -->
				<!-- Modal -->
				<div class="modal fade" id="editRecords" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="container-fluid">
									<div class="row text-center">
										<div class="col-md-12 my-3">
											<div id="show_img"></div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">

											<!-- Edit Record Form -->
											<form id="editForm" enctype="multipart/form-data">

												<!-- ID -->
												<input type="hidden" id="edit_record_id">

												<!-- Name -->
												<div class="input-group mb-3">
													<input type="text" class="form-control" id="edit_product_name" placeholder="Product Name" aria-label="Product Name" aria-describedby="basic-addon1">
												</div>

												<!-- Email -->
												<div class="input-group mb-3">
													<input type="text" class="form-control" id="edit_product_price" placeholder="Product Price">
												</div>

												<!-- Mobile -->
												<div class="input-group mb-3">
													<input type="text" class="form-control" id="edit_product_description" placeholder="Product Description">
												</div>
                                
												<!-- Image -->
												<div class="custom-file input-group mb-3">
													<input type="file" class="custom-file-input" id="edit_product_images">
													<label class="custom-file-label" for="customFile">Product Images</label>
												</div><br>
												
												<div class="uploadmultiple">
            									    <label>Upload Multiple Images</label>
            										<input type="file"  id="edit_product_image" name="product_image[]" multiple="multiple">
            									</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

								<!-- Update Button -->
								<button type="button" class="btn btn-primary" id="update">Update Product</button>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row my-4">
			<div class="col-md-12 mx-auto">
				<table class="table table-bordered table-hover"  id="recordTable" >
                    <thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>Product Name</th>
							<th>Product Price</th>
							<th>Product Description</th>
							<th>Product Image</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

	<input type="hidden" value="<?php echo base_url(); ?>" id="base_url">
	<!-- Jquery -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Toastr JS -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<!-- Datatables JS -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.js"></script>
	<!-- Sweetalert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- Main JS -->
	<script src="<?php echo base_url('/assets/js/main.js') ?>"></script>
</body>
</html>