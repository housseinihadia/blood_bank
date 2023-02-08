<?php 

/*
=======================
=== Items  page
===================================
*/
	ob_start();

	session_start();

	$titlepage = 'طلبات الدم';


	if(isset($_SESSION['username'])) {


		include 'init.php';

		// content of page

		  $do = (isset($_GET['do'])) ? $_GET['do'] : 'mange'; // move between pages through $do

		  if($do == 'mange') {
		  				
		  			$stmt = $con->prepare("SELECT request.*,
		  			                                    users.Username AS User_request
		  			                                       from request

							
												INNER JOIN users ON  users.UserID = request.Member_id 
												ORDER BY request_id DESC ");
		  			$stmt->execute();

		  			$items = $stmt->fetchall();

		  			if(! empty ($items)) { 
		  			 ?>
		  			

		  			<h1 class="text-center">اداره طلبات الدم</h1>
		  			<div class="container">
		  				
		  				<div class="table-reponsive">
		  					<table class="table text-center table table-bordered">

		  						<tr>
		  							<td>التسلسل</td>
		  							<td>الاسم المريض</td>
		  							<td>اسم المستشفي</td>
		  							<td>رقم التليفون</td>
		  							<td>نوع الدم</td>
		  							<td>اسم العضو</td>
		  							<td>التاريخ</td>
		  							<td>التحكم</td>
		  						</tr>
		  						<?php

		  							foreach($items as $item) {

		  								echo "<tr>";

		  									echo "<td>" . $item['request_id'].  "</td>";
		  									echo "<td>" . $item['pation_name'].  "</td>";
		  									echo "<td>" . $item['hospital_name'].  "</td>";
		  									echo "<td>" . $item['phone_number'].  "</td>";
		  									echo "<td>";

		  								 if($item['blood_type'] == 1) {

		  								 	echo "+O";
		  								 }elseif($item['blood_type'] == 2) {
		  								 		echo "-O";
		  								 }
		  								 elseif($item['blood_type'] == 3) {
		  								 	echo "-A";
		  								 }
		  								 elseif($item['blood_type'] == 4) {
		  								 	echo "+A";
		  								 }
		  								 elseif($item['blood_type'] == 5) {
		  								 	echo "+AB";
		  								 }

		  								 elseif($item['blood_type'] == 6) {
		  								 	echo "-AB";
		  								 }
		  								 elseif($item['blood_type'] == 7) {
		  								 	echo "-B";
		  								 }
		  								 elseif($item['blood_type'] == 8) {
		  								 	echo "+B";
		  								 }
		  								 
		  								 echo '</td>';
		  								 
		  									echo "<td>" . $item['User_request'].  "</td>";
		  									echo "<td>" . $item['add_date'].  "</td>";
		  									echo "<td>

		  											<a href='items.php?do=edit&itemid=" . $item['request_id'] . "'class='btn btn-success'><i class='fa fa-edit'></i>تعديل</a>
		  											<a href='items.php?do=delete&itemid=" . $item['request_id'] . "'class='btn btn-danger'><i class='fa fa-close'></i>حذف</a>";

		  								  echo "</td>";

		  								echo "</tr>";
		  							}


		  						 ?>
		  						
		  					</table>
		  				</div>

		  					<a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> اضافه طلب دم</a>

		  			</div>
					<?php } else {
				           echo "<div class='container text-center'>";

							        echo  '<div class="alert alert-danger">لايوجد طلبات للدم </div>';
							        echo '<a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>  اضافه طلب جديد</a>';

					        echo "</div>";

					} ?>



		  	 <?php }

		  elseif($do == 'add') { ?>

		  	<h1 class="text-center">اضافه طلب جديد</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=insert" method="POST">
				<!--sart name-->
				<div class="form-group form-group-lg">
						<label   style="float: right;"    class="col-sm-2 label-control">اسم المريض</label>
						<div  style="width:800px;" class="col-sm-10 col-md-6">
						  <input type="text" name="name" class="form-control" placeholder="اسم المريض" required />	
						</div>
				</div>
				<!--end name-->

					<!--sart request_hospital-->
				<div class="form-group form-group-lg">
						<label   style="float: right;"   class="col-sm-2 label-control">اسم المستشفي</label>
						<div  style="width:800px;"  class="col-sm-10  col-md-6">
						<input type="text" name="request_hospital" class="form-control" placeholder="اسم المستشفي" required/>
						
						</div>
				</div>
				<!--end request_hospital-->

					<!--sart request_phone-->
				<div class="form-group form-group-lg">
						<label   style="float: right;"    class="col-sm-2 label-control">رقم التليفون</label>
						<div  style="width:800px;"  class="col-sm-10  col-md-6">
						<input type="text" name="request_phone" placeholder="رقم التليفون" class="form-control" required/>	
						</div>
				</div>
				<!--end request_phone-->

					<!--sart blood_type-->
			<div class="form-group form-group-lg">
						<label   style="float: right;"    class="col-sm-2 label-control">فصيله الدم</label>
						<div  style="width:800px;"  class="col-sm-10  col-md-6">
							<select name="blood_type" class="status" required>
							<option value="">...</option>
                            <option value="1">o+</option>
                            <option value="2">o-</option>
                            <option value="3">A-</option>
                            <option value="4">A+</option>
                            <option value="5"> AB+ </option>
                            <option value="6">AB- </option>
                            <option value="7">B-</option>
                            <option value="8">B+ </option>
								
							</select>	
						</div>
				</div>
				<!--end blood type-->

			<!--sart submit-->
				<div class="form-group form-group-lg">
							<div class=" col-sm-offset-3 col-sm9 ">
								<i class='fa fa-plus icon-add-item'></i>
							     <input type="submit" value="اضافه طلب" class="btn btn-primary btn-lg">
							   
							</div>
						</div>
			
				<!--end submit-->
					
				</form>

			</div>


		<?php  }elseif($do == 'insert') {


				if($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>اضافه طلب الدم</h1>";

			    echo "<div class='container'>";

				$name               = $_POST['name'];
				$request_hospital   = $_POST['request_hospital'];
				$request_phone      = $_POST['request_phone'];
				$blood_type         = $_POST['blood_type'];
	
				// validate form 

				$formerrors = array();

				if(empty($name)) {

					$formerrors[] = ' يجب ان لا يكون اسم المرض <storng> فارغ</storng>';
				}

				if(empty($request_hospital)) {

					$formerrors[] = ' يجب ان لا يكون اسم المستشفي  <storng>فارغ</storng>';
				}

				if(empty($request_phone)) {

					$formerrors[] = 'يجب ان لا يكون رقم المحمول <storng>فارغ</storng>';
				}

			    if(empty($blood_type)) {

					$formerrors[] = 'يجب ان لا يكون فصيله الدم <storng>فارغه</storng>';
				}



				foreach ($formerrors as $errors) {

					echo '<div class="alert alert-danger">' . $errors . '</div>';
				}

				if(empty($formerrors)) { // NO error


								// insert un the database with info
								$stmt = $con->prepare('INSERT INTO request (pation_name, hospital_name, phone_number, blood_type,Member_id, Add_date 
									) VALUES (:name, :hosname, :phone, :btype, 1, now())');
								$stmt->execute(array(

									'name'   => $name,
									'hosname'    => $request_hospital,
									'phone'  => $request_phone,
									'btype'    => $blood_type

									));

							

							//echo sucsees message
							$themsg =  "<div class='alert alert-success text-center'>" . $stmt->rowcount() . ' تم اضافه طلب الدم بنجاح </div>';

							redirecthome ($themsg, 'back');
	
				}

				

			
			} else { // if you dont coming throgh post request

				echo "<div class='container text-center'>";

					$themsg =  '<div class="alert alert-danger">عذرا سموف يتم تحويلك الي الرئيسيه</div>';

					redirecthome($themsg, 'back');

				echo "</div>";
			}

			echo "</div>";


		}

		  elseif($do == 'edit') { 

		  		// check if request get is numeric value 

			     $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;  //if condition 

			     // seleect on data depend on itemid request

				$stmt = $con->prepare("SELECT * from request WHERE request_id = ?");

				//execute this query on this check => $userid

		    	$stmt->execute(array($itemid));

		    	//fetch the data

		        $items = $stmt->fetch(); //to get data from database on array

		    	$count = $stmt->rowcount();

		    	 //if there is data with this id show the form 
 	
		    	if($count > 0) { ?>


		    <h1 class="text-center">تعديل طلب الدم</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=update" method="POST">
				<input type="hidden" name="itemid" value="<?php echo $itemid; ?>"> 
				<!--sart name-->
				<div class="form-group form-group-lg">
						<label   style="float: right;"    class="col-sm-2 label-control">اسم المريض</label>
						<div  style="width:800px;" class="col-sm-10 col-md-6">
						  <input type="text" name="name" class="form-control" placeholder="اسم المريض" value="<?php echo $items['pation_name']?>" required />	
						</div>
				</div>
				<!--end name-->

					<!--sart request_hospital-->
				<div class="form-group form-group-lg">
						<label   style="float: right;"   class="col-sm-2 label-control">اسم المستشفي</label>
						<div  style="width:800px;"  class="col-sm-10  col-md-6">
						<input type="text" name="request_hospital" class="form-control" placeholder="اسم المستشفي" value="<?php echo $items['hospital_name']?>" required/>
						
						</div>
				</div>
				<!--end request_hospital-->

					<!--sart request_phone-->
				<div class="form-group form-group-lg">
						<label   style="float: right;"    class="col-sm-2 label-control">رقم التليفون</label>
						<div  style="width:800px;"  class="col-sm-10  col-md-6">
						<input type="text" name="request_phone" placeholder="رقم التليفون" class="form-control" required value="<?php echo $items['phone_number']?>"/>	
						</div>
				</div>
				<!--end request_phone-->

									<!--sart blood_type-->
			<div class="form-group form-group-lg">
						<label   style="float: right;"    class="col-sm-2 label-control">فصيله الدم</label>
						<div  style="width:800px;"  class="col-sm-10  col-md-6">
							<select name="blood_type" class="status" required>
                            <option value="1" <?php if($items['blood_type'] == 1){echo "selected";}?>>o+</option>
                            <option value="2"  <?php if($items['blood_type'] == 2){echo "selected";}?>>o-</option>
                            <option value="3"  <?php if($items['blood_type'] == 3){echo "selected";}?>>A-</option>
                            <option value="4"  <?php if($items['blood_type'] == 4){echo "selected";}?>>A+</option>
                            <option value="5"  <?php if($items['blood_type'] == 5){echo "selected";}?>> AB+ </option>
                            <option value="6"  <?php if($items['blood_type'] == 6){echo "selected";}?>>AB- </option>
                            <option value="7"  <?php if($items['blood_type'] == 7){echo "selected";}?>>B-</option>
                            <option value="8"  <?php if($items['blood_type'] == 8){echo "selected";}?>>B+ </option>
								
							</select>	
						</div>
				</div>
				<!--end blood type-->



			<!--sart submit-->
				<div class="form-group form-group-lg">
							<div class=" col-sm-offset-3 col-sm9 ">
								<i class='fa fa-plus icon-add-item'></i>
							     <input type="submit" value="حفظ التعديل" class="btn btn-primary btn-lg">
							   
							</div>
						</div>
			
				<!--end submit-->
					
				</form> 
				<?php 

			// select all records except admin

			$stmt = $con->prepare("SELECT 
				                      comments.*,  
				                        users.Username AS username 
				                          FROM 
				                          comments 
			                               INNER JOIN 
			                                 users 
			                                   ON 
			                                   users.UserID = comments.user_id
			                                   WHERE item_id = ?

			                                   ");

			$stmt->execute(array($itemid));

			$rows = $stmt->fetchall();

			if(! empty($rows)) {

					?> 

					<h1 class="text-center">manage[ <?php echo  $items['Name']?> ] comments</h1>

					<div class="container">
							<div class="table-reponsive">
								<table class="table text-center table table-bordered">
									<tr>
										
										<td>Comment</td>
										<td>Date</td>
										<td>User</td>
										<td>Control</td>

									</tr>

							
										
										<?php

											foreach($rows as $row) {

												echo "<tr>";
													
													echo "<td>" . $row['comment'] .  "</td>";
													echo "<td>" . $row['comment_date'] .  "</td>";
													echo "<td>" . $row['username'] . "</td>"; // from as .... query
													echo "<td>

													<a href='comments.php?do=edit&commid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
													<a href='comments.php?do=delete&commid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

													if($row['status'] == 0) { // the user not activate

													 echo "<a href='comments.php?do=approve&commid=" . $row['c_id'] . "' class='btn btn-info act'><i class='fa fa-plus-circle'></i>Activate</a>";

													}


													 echo "</td>";


												echo "</tr>";

											}


										?>
						         </table>
							</div>

						<?php } ?>
				
				     </div>

			</div>



		  	<?php }

 }

		  elseif($do == 'update') { //update page

		  	echo "<h1 class='text-center'>تعديل الطلب</h1>";

			echo "<div class='container'>";

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

			    echo "<div class='container'>";
			    $id       = $_POST['itemid'];
				$name               = $_POST['name'];
				$request_hospital   = $_POST['request_hospital'];
				$request_phone      = $_POST['request_phone'];
				$blood_type         = $_POST['blood_type'];
	
				// validate form 

				$formerrors = array();

				if(empty($name)) {

					$formerrors[] = ' يجب ان لا يكون اسم المرض <storng> فارغ</storng>';
				}

				if(empty($request_hospital)) {

					$formerrors[] = ' يجب ان لا يكون اسم المستشفي  <storng>فارغ</storng>';
				}

				if(empty($request_phone)) {

					$formerrors[] = 'يجب ان لا يكون رقم المحمول <storng>فارغ</storng>';
				}

			    if(empty($blood_type)) {

					$formerrors[] = 'يجب ان لا يكون فصيله الدم <storng>فارغه</storng>';
				}



				foreach ($formerrors as $errors) {

					echo '<div class="alert alert-danger">' . $errors . '</div>';
				}

				if(empty($formerrors)) { // NO error



					// upadate the database with info

				$stmt = $con->prepare(" UPDATE request SET pation_name = ?, hospital_name = ?, phone_number = ?, blood_type = ?  WHERE request_id = ? ");
				$stmt->execute(array($name, $request_hospital, $request_phone, $blood_type, $id));

				//echo sucsees message
				$themsg = "<div class='alert alert-success'>" . $stmt->rowcount() . ' تم التعديل بنجاح </div>';

				redirecthome($themsg, 'back');

				}

				echo "</div>";

			
			} else {

				$themsg = '<div class="alert alert-danger text-center">Sorry you cant update this page</div>';

				redirecthome($themsg);
			}

              }elseif($do == 'delete') { // delete page

					// check if request get is numeric value 

			     $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;  //if condition 

		    	 //check if the user exist in database 

		    	 $check = checkitem ('request_id', 'request', $itemid);
 	
		    	if($check > 0) { 

		    		$stmt = $con->prepare('DELETE FROM request WHERE request_id = :zid');
		    		$stmt->bindparam(':zid', $itemid); // connect with $user
		    		$stmt->execute();

		    		$themsg =  "<div class='alert alert-success text-center'  style='margin-top:30px;'>" . $stmt->rowcount() . ' تم الحذف بنجاح</div>';

		    		redirecthome($themsg, 'back');


		    	} else {

		    		$themsg =  '<div class="alert alert-danger text-center"  style="margin-top:30px;">No Userid in the Database</div>';

		    		redirecthome($themsg);
		    	}


		}



		  include  $tmp1 . "footer.php";


		}else{

			header('location:index.php');
		}

		ob_end_flush();

		?>
