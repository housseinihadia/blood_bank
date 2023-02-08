<?php 

/*
=======================
=== mange memberment page
=== you can add/ edit/ delete
===================================
*/
	session_start();

	$titlepage = 'صفحه الاعضاء';


	if(isset($_SESSION['username'])) {


		include 'init.php';

		// content of page

		  if(isset($_GET['do'])) { // move between pages through $do 

			$do = $_GET['do'];

		}
		 else {

			$do = 'mange';
		}

		// start mange page
		if($do == 'mange') { 

			$query = '';

			if(isset($_GET['page']) && $_GET['page'] == 'pending') {

				$query = 'AND RegStatus = 0';
			}


			//$qurey => variable to use the same statement in pending page   

			// select all records except admin

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");

			$stmt->execute();

			$rows = $stmt->fetchall();

			if(! empty($rows)) {

			?> 

			<h1 class="text-center">الاعضاء المشتركه</h1>

			<div class="container">
				<div class="table-reponsive">
					<table class="table text-center mange-member table table-bordered">
						<tr>
							<td>#التسلسل</td>
							<td>#الصوره</td>
							<td>اسم العضو</td>
							<td>البريد الالكترونى</td>
							<td>السن</td>
							<td>الجنس</td>
							<td>اخر موعد للتبرع</td>
							<td>تاريخ الاشتراك</td>
							<td>التحكم</td>
						</tr>

				
							
							<?php

								foreach($rows as $row) {

									echo "<tr>";
										echo "<td>" . $row['UserID'] .  "</td>";
										echo "<td>";
										if(empty($row["avatar"])) {
											echo "<img src='uploads/avatars/User-Default.jpg' alt=''/>";
										} else {
										           echo "<img src='uploads/avatars/" . $row["avatar"] . "' alt=''/>";
							             }
										echo "</td>";
										echo "<td>" . $row['Username'] .  "</td>";
										echo "<td>" . $row['Email'] .  "</td>";
										echo "<td>" . $row['age'] .  "</td>";
										echo "<td>";
										if($row['gender'] ==1) {
											echo "ذكر";
										}else {
											echo 'انثي';
										} 
											echo "</td>";
										echo "<td>";
										   if($row['last_doniation'] == 1) {
										   	 echo 'اقل من شهر';
										   }elseif($row['last_doniation'] == 2) {
										   	echo 'اقل من شهرين';
										   } 
										   elseif($row['last_doniation'] == 3) {
										   	echo 'اقل من ثلاثه اشهر';
										   } 
										   elseif($row['last_doniation'] == 4) {
										   	echo 'لن اتبرع ابدا';
										   }  
										 "</td>";
										echo "<td>" . $row['Cur_date'] . "</td>";
										echo "<td>

										<a href='members.php?do=edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>تعديل</a>
										<a href='members.php?do=delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>حذف</a>";


										 echo "</td>";


									echo "</tr>";

								}


							?>
			</table>
				</div>

					<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>  اضافه عضو</a>

			
			</div> <?php } else {
				           echo "<div class='container text-center'>";

							        echo  '<div class="alert alert-danger">No Pending Members here </div>';
							        echo '<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>  New member</a>';


					        echo "</div>";
			            } ?>

		<?php }

		elseif($do == 'add') { // in add page 

			$titlepage = 'اضافه عضو';

			?>



			  <h1 class="text-center">اضافه عضو جديد</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">
				<!--sart username-->
				<div class="form-group form-group-lg">
						<label style="float: right;"  class="col-sm-2 label-control">اسم العضو</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" placeholder=" اسم العضو" autocomplete="off" required='required'/>	
						</div>
				</div>
				<!--end username-->

					<!--sart Password-->
				<div class="form-group form-group-lg">
						<label style="float: right;"  class="col-sm-2 label-control">كلمه المرور</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="Password" name="pass" class="password form-control" placeholder="كلمه اسر" required='required'>
						<i class="show-pass fa fa-eye fa-2x"></i>	
						</div>
				</div>
				<!--end Password-->

					<!--sart Email-->
				<div class="form-group form-group-lg">
						<label style="float: right;" class="col-sm-2 label-control">البريد الالكنرونى</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="Email" name="email" placeholder="Type your Email" autocomplete="off" class="form-control" required='required'>	
						</div>
				</div>
				<!--end Email-->

				<!--sart age-->
				<div class="form-group form-group-lg">
						<label style="float: right;" class="col-sm-2 label-control">السن</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="text" name="age" placeholder="السن" autocomplete="off" class="form-control" required='required'>	
						</div>
				</div>
				<!--end age-->

				<!--sart phone-->
				<div class="form-group form-group-lg">
						<label style="float: right;" class="col-sm-2 label-control">رقم التليفون</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="text" name="phone" placeholder="رقم التليفون" autocomplete="off" class="form-control" required='required'>	
						</div>
				</div>
				<!--end phone-->


				<!--sart image user-->
				<div class="form-group form-group-lg">
						<label style="float: right;"  class="col-sm-2 label-control">صوره العضو</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="file" name="avatar" class="form-control">	
						</div>
				</div>
				<!--end image user-->


								<!--sart gender-->
			<div class="form-group form-group-lg">
						<label  style="float: right;"   class="col-sm-2 label-control">النوع</label>
						<div class="col-sm-10  col-md-6">
							<select style="width:800px;"  name="gender" class="status">
								<option value="">...</option>
								<option value="0">انثي</option>
								<option value="1">ذكر</option>
								
							</select>	
						</div>
				</div>
				<!--end gender-->

			<!--sart lastdoniation-->
			<div class="form-group form-group-lg">
						<label  style="float: right;"   class="col-sm-2 label-control">اخر موعد للتبرع</label>
						<div class="col-sm-10  col-md-6">
							<select name='lastdoniation' style="width:800px;"  name="select-stat" class="status">
							<option value="0">...</option>
                            <option value="1"> أقل من شهر</option>
                            <option value="2">أقل من شهرين </option>
                            <option value="3"> أقل من ثلاثه أشهر </option>
                              <option value="4">  لم أتبرع من قبل </option>
								
							</select>	
						</div>
				</div>
				<!--end lastdoniation-->

					<!--sart submit-->
				<div class="form-group">
							<div class="btn btn-block">
							     <input type="submit" value="اضف عضو" class="btn btn-primary ">
							</div>
						</div>
				
				<!--end submit-->



					
				</form>


			</div>

		<?php } 

		elseif($do == 'insert') {// insert page


			

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>اضافه عضو</h1>";

			    echo "<div class='container'>";

			    // Upload Files Variables

			   $file_name = $_FILES['avatar']['name']; //file name
			   $file_type = $_FILES['avatar']['type']; //file type
			   $file_temp = $_FILES['avatar']['tmp_name']; //path file
			   $file_size = $_FILES['avatar']['size'];    // file size

			   // list of permosion to Upload file
			   $file_allow_extention = array("jpg", "png", "gif");

			   //get file
			   $filt_extintion = strtolower(end(explode(".", $file_name)));



				$name  = $_POST['username'];
				$pass  = $_POST['pass'];
				$email  = $_POST['email'];
				$age    = $_POST['age'];
				$phone    = $_POST['phone'];
				$sex     = $_POST['gender'];
				$lastdoniation = $_POST['lastdoniation'];
				$avatar = $_POST['avatar'];

				$hashpass = sha1($pass);


				//pass trick

	
				// validate form 

				$formerrors = array();

				if(strlen($name) < 4) {

					$formerrors[] = ' يجب ام يحتوي الاسم اكثر من  <storng> 4 </storng>حروف';
				}

				if(empty($name)) {

					$formerrors[] = 'الاسم لا يجب ان يكون<storng>فارغ</storng>';
				}

				if(empty($email)) {

					$formerrors[] = 'الايميل لا يجب ان يكون <storng>فارغ</storng>';
				}

				if(empty($sex)) {

					$formerrors[] = 'النوع لا يجب ان يكون <storng>فارغ</storng>';
				}
				if(empty($phone)) {

					$formerrors[] = 'التليفون لا يجب ان يكون <storng>فارغ</storng>';
				}
				if(empty($lastdoniation)) {

					$formerrors[] = 'اخر موعد للتبرع لا يجب ان يكون <storng>فارغ</storng>';
				}

			    if(empty($pass)) {

					$formerrors[] = 'المرور لا يجب ان يكون <storng>فارغ</storng>';
				}

				if(!empty($file_name) && !in_array($filt_extintion, $file_allow_extention)) {

					$formerrors[] = 'يجب اختيار <storng>الصوره</storng>';
				}
				if(empty($file_name)) {

					$formerrors[] = 'الملف الصوره لا يجب ان يكون<storng>فارغ</storng>';

				}

				if($file_size > 45900259) { // size with miga byte mg

					$formerrors[] = 'الصوره اكبر من  <storng>4mg</storng>';

				}

				foreach ($formerrors as $errors) {
					echo '<div class="alert alert-danger">' . $errors . '</div>';

				}

				if(empty($formerrors)) { // NO error

					$avatar = rand(0, 1000000) . '_' . $file_name;

					move_uploaded_file($file_temp, "uploads\avatars\\" . $avatar); 

			

					// use the function is check the if user has this name exist in database or not 

					$check = checkitem ('Username', 'users', $name);

					if($check == 1) { // exist username in with the same name

						$themsg = '<div class="alert alert-danger text-center">عذرا عذا الاسم موجود مسبقا</div>';

						redirecthome ($themsg, 'back', 5);

					} else {


								// insert un the database with info
								$stmt = $con->prepare('INSERT INTO users (Username, Password, Email,age,
								phone,last_doniation, gender, Cur_date, avatar) VALUES (:name, :pass, :mail,:age,
								:phone, :last, :sex,  now(), :avatar)');
								$stmt->execute(array(

									'name'   => $name,
									'pass'   => $hashpass,
									'mail'   => $email,
									'age'    =>$age,
									'phone'  =>$phone,
									'last'    =>$lastdoniation,
									'sex'    =>$sex,
									'avatar' => $avatar
									

									));

							

							//echo sucsees message
							$themsg =  "<div class='alert alert-success text-center'>" . $stmt->rowcount() . ' تم اضافع العضو بنجاح </div>';

							redirecthome ($themsg);


				  }

				}

				

			
			} else { // if you dont coming throgh post request

				echo "<div class='container text-center'>";

					$themsg =  '<div class="alert alert-danger">عذرا سوف يقوم بتحويلك الي الرئيسيه</div>';

					redirecthome($themsg, 'back');

				echo "</div>";
			}

			echo "</div>";
		}
		

		elseif($do == 'edit') { //edit page 

					// check if request get is numeric value 

			     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;  //if condition 

			     // seleect on data depend on userid request

				$stmt = $con->prepare('SELECT * from users WHERE UserID = ? LIMIT 1 ');

				//execute this query on this check => $userid

		    	$stmt->execute(array($userid));

		    	//fetch the data

		        $row = $stmt->fetch(); //to get data from database on array

		    	$count = $stmt->rowcount();

		    	 //if there is data with this id show the form 
 	
		    	if($count > 0) { ?>

             <h1 class="text-center">تعديل الاعضاء</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=update" method="POST">
				<input type="hidden" name="userid" value="<?php echo $userid; ?>"> <!--transfer the data to update page by using hidden input-->

				<!--sart username-->
				<div class="form-group form-group-lg">
						<label style="float: right;"  class="col-sm-2 label-control">اسم العضو</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" placeholder=" اسم العضو" autocomplete="off" value="<?php echo $row['Username']?>" required='required'/>	
						</div>
				</div>
				<!--end username-->

									<!--sart Email-->
				<div class="form-group form-group-lg">
						<label style="float: right;" class="col-sm-2 label-control">البريد الالكنرونى</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="Email" name="email" placeholder="Type your Email" autocomplete="off" class="form-control" value="<?php echo $row['Email']?>" required='required'>	
						</div>
				</div>
				<!--end Email-->
				<!--sart Password-->
				<div class="form-group form-group-lg">
						<label  style="float: right;"   class="col-sm-2 label-control">كلمه المرور</label>
						<div class="col-sm-10 col-md-6">
						<input type="hidden" name="old-pass" value="<?php echo $row['Password']?>">
						<input type="Password" name="new-pass" class="form-control" placeholder="اكتب الباسورد ان اردت عديله" autocomplete="new-password">	
						</div>
				</div>
				<!--end Password--



				<!--sart age-->
				<div class="form-group form-group-lg">
						<label style="float: right;" class="col-sm-2 label-control">السن</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="text" name="age" placeholder="السن" autocomplete="off" class="form-control" value="<?php echo $row['age']?>" required='required'>	
						</div>
				</div>
				<!--end age-->
				<!--sart phone-->
				<div class="form-group form-group-lg">
						<label style="float: right;" class="col-sm-2 label-control">الموبايل</label>
						<div style="width:800px;" class="col-sm-10 col-md-6">
						<input type="text" name="phone" placeholder="الموبايل" autocomplete="off" class="form-control" value="<?php echo $row['phone']?>" required='required'>	
						</div>
				</div>
				<!--end phone-->



			<!--sart gender-->
			<div class="form-group form-group-lg">
						<label  style="float: right;"   class="col-sm-2 label-control">النوع</label>
						<div class="col-sm-10  col-md-6">
							<select style="width:800px;"  name="gender" class="status">
								<option value="0" <?php if($row['gender'] == 0){echo "selected";}?>>انثي</option>
								<option value="1"<?php if($row['gender'] == 1){echo "selected";}?> >ذكر</option>
								
							</select>	
						</div>
				</div>
				<!--end gender-->

			<!--sart lastdoniation-->
			<div class="form-group form-group-lg">
						<label  style="float: right;"   class="col-sm-2 label-control">اخر موعد للتبرع</label>
						<div class="col-sm-10  col-md-6">
							<select style="width:800px;"  name="lastdoniation" class="status">
                            <option value="1"<?php if($row['last_doniation'] == 1){echo "selected";}?>> أقل من شهر</option>
                            <option value="2" <?php if($row['last_doniation'] == 2){echo "selected";}?>>أقل من شهرين </option>
                            <option value="3" <?php if($row['last_doniation'] == 3){echo "selected";}?>> أقل من ثلاثه أشهر </option>
                              <option value="4" <?php if($row['last_doniation'] == 4){echo "selected";}?>>  لم أتبرع من قبل </option>
								
							</select>	
						</div>
				</div>
				<!--end lastdoniation-->

					<!--sart submit-->
				<div class="form-group">
							<div class=" col-sm-offset-6 col-sm-6 ">
							     <input type="submit" value="حفظ" class="btn btn-primary ">
							</div>
						</div>
				</div>
				<!--end submit-->



					
				</form>


			</div>



		    	<?php
		    	// else if not exist and less 0 
		    	  } else {

		    	  	echo "<div class='container text-center'>";

			    		$themsg =  '<div class="alert alert-danger">NO id in your selections </div>';

			    		redirecthome($themsg);

		    		echo "</div>";


		    	}

			?>
		
		<?php }

		elseif($do == 'update') { // update page

			echo "<h1 class='text-center'>Update member</h1>";

			echo "<div class='container'>";

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				$id = $_POST['userid']; // hidden input his value = old id
				$name  = $_POST['username'];
				$email  = $_POST['email'];
				$age    = $_POST['age'];
				$phone    = $_POST['phone'];
				$sex       = $_POST['gender'];
				$lastdoniation = $_POST['lastdoniation'];

				//pass trick

				$pass = '';

				if(empty($_POST['new-pass'])) { // no update in password field

					$pass = $_POST['old-pass'];

				} else {

					$pass = sha1($_POST['new-pass']);


				}

				// validate form 

				$formerrors = array();

				if(strlen($name) < 4) {

					$formerrors[] = ' يجب ام يحتوي الاسم اكثر من  <storng> 4 </storng>حروف';
				}

				if(empty($name)) {

					$formerrors[] = 'الاسم لا يجب ان يكون<storng>فارغ</storng>';
				}

				if(empty($email)) {

					$formerrors[] = 'الايميل لا يجب ان يكون <storng>فارغ</storng>';
				}

				if(empty($sex)) {

					$formerrors[] = 'النوع لا يجب ان يكون <storng>فارغ</storng>';
				}
				if(empty($phone)) {

					$formerrors[] = 'التليفون لا يجب ان يكون <storng>فارغ</storng>';
				}
				if(empty($lastdoniation)) {

					$formerrors[] = 'اخر موعد للتبرع لا يجب ان يكون <storng>فارغ</storng>';
				}

			    if(empty($pass)) {

					$formerrors[] = 'المرور لا يجب ان يكون <storng>فارغ</storng>';
				}

				foreach ($formerrors as $errors) {
					echo '<div class="alert alert-danger">' . $errors . "</div>";
				}

				if(empty($formerrors)) { //NO error

					// special check if we update the username is as the same name id db
					
					$stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");

					$stmt2->execute(array($name, $id));

					$count = $stmt2->rowcount();

					if($count == 1) {

						$themsg =  "<div class='alert alert-danger'>there is username this with name</div>";
						redirecthome($themsg, 'back');

					} else {


					// upadate the database with info

				$stmt = $con->prepare('UPDATE  users SET Username = ?, Email = ?, Password = ?, age = ?, phone = ?,
				 gender = ?, last_doniation = ? WHERE UserID = ? ');
				$stmt->execute(array($name, $email, $pass, $age, $phone, $sex, $lastdoniation, $id));

				//echo sucsees message
				$themsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'تم التعديل بنجاح </div>';

				redirecthome($themsg, 'back');

					} 	
				}

				

				echo "</div>";

			
			} else {

				$themsg = '<div class="alert alert-danger text-center">Sorry you cant update this page</div>';

				redirecthome($themsg);
			}
			
		} elseif($do == 'delete') { // delete page

				// check if request get is numeric value 

			     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;  //if condition 

		    	 //check if the user exist in database 

		    	 $check = checkitem ('userid', 'users', $userid);
 	
		    	if($check > 0) { 

		    		$stmt = $con->prepare('DELETE FROM users WHERE UserID = :zuser');
		    		$stmt->bindparam(':zuser', $userid); // connect with $user
		    		$stmt->execute();

		    		$themsg =  "<div class='alert alert-success text-center'  style='margin-top:30px;'>" . $stmt->rowcount() . 'تم الحذف بنجاح </div>';

		    		redirecthome($themsg);


		    	} else {

		    		$themsg =  '<div class="alert alert-danger text-center"  style="margin-top:30px;">No Username in the Database</div>';

		    		redirecthome($themsg);
		    	}


		} 


		include $tmp1 . "footer.php";


	} else {

		header('location: index.php');

		exit();
	}
