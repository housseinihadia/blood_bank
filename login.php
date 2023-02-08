<?php

session_start();

$titlepage = 'Login';

if(isset($_SESSION['user'])) {

    header('location: index.php'); // go to homepage page 
}

    include 'init.php'; 

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['login'])) {

            $user = $_POST['username'];

            $pass = $_POST['pass']; 

            $hashpass = sha1($pass); // to hash the password in db

            //chek if user exist in database

            $stmt = $con->prepare('SELECT UserID, Username, Password from users WHERE Username = ? AND Password = ?');

            $stmt->execute(array($user, $hashpass));

            $getid = $stmt->fetch();

            $count = $stmt->rowcount();

            // if count > 0 this mean the database contain record this username
            // check is admine or member conut > 0 GroupID = 1

            if($count > 0) {
                

                $_SESSION['user'] = $user; //keep session from form
               
                $_SESSION['userid'] = $getid['UserID'];   // fetch userid from db and keep it in session 

               header('location: index.php'); // go to homepage page 
                
                 exit();

                
            } 

        }else { // this is post['signup']

            $formerrors = array(); // array to print thr errors

            $username  = $_POST['username'];
            $password  = $_POST['pass'];
            $password2 = $_POST['confirm-pass'];
            $email     = $_POST['email'];


            // srart filter of user name 
            if(isset($username)) {

                    $filteruser = filter_var($username, FILTER_SANITIZE_STRING);

                    if(strlen($filteruser) < 4) {

                        $formerrors[] = ' Must Be Less Than 4 character';
                    }
        }

            //start filter password

             if(isset($password) && isset($password2)) {

                if(empty($_POST['pass'])) {

                    $formerrors[] = 'Not Aallowed Empty Password';
                }

                if(sha1($password) !== sha1($password2)){

                $formerrors[] = 'There Is No Match Password';

            }
         }

         // start fiter of email 

         if(isset($email)) {

            $filteremail = filter_var($email, FILTER_SANITIZE_EMAIL);

            if(filter_var($filteremail, FILTER_VALIDATE_EMAIL) != true) {

                $formerrors [] = 'This Email Not Valid';
            }


         }

                if(empty($formerrors)) { // NO error

                    // use the function is check the if user has this name exist in database or not 

                    $check = checkitem ('Username', 'users', $username);

                    if($check == 1) { // exist username in with the same name

                        $themsg = 'Sorry this Name exist';

                    } else {


                                // insert un the database with info
                                $stmt = $con->prepare('INSERT INTO users (Username, Password, Email, RegStatus, Cur_date) VALUES (:name, :pass, :mail, 0 , now())');
                                $stmt->execute(array(

                                    'name' => $username,
                                    'pass' => sha1($password),
                                    'mail' => $email

                                    ));

                            

                            //echo sucsees message
                            $themsg =  'Congrats You Will Be User';


                  }

                }

        }
        
    }




    ?>

    <div class='container login-page'>

    <!-- start form for login --> 

    <h1 class="text-center">
        	<span class="selected" data-class="login">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Login

            </span> 

            | <span data-class="signup"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign up</span>
    </h1>

    <form class="form-horizontal login" action="<?php echo $_SERVER['PHP_SELF']?>" method='POST' >
	    <div class="form-group form-group-lg">
            	<input class="form-control" type="text" name="username" autocomplete="off" placeholder="Sign Your Name" 
            	required="required"/>
            	<input class="form-control" type="password" name="pass" autocomplete="new-password" placeholder="Sign Your Password" required="required" />
            	<input class="btn btn-primary btn-block" name="login" type="submit" name="submit" value="Login">
        </div>
    </form>

     <!-- end form for login -->

      <!-- strart form for signup --> 
        <form class=" form-horizontal signup" action="<?php echo $_SERVER['PHP_SELF']?>" method='POST'>
           <div class="form-group form-group-lg">
	
        	<input class="form-control" type="text" name="username" autocomplete="off" placeholder="Sign Your Name" 
            pattern=".{3,}" title="Must be 4 chars at Least " required="required" />

        	<input class="form-control" type="email" name="email" autocomplete="off" placeholder="Sign Your Email" 
            required="" />

        	<input minlength="4" class="form-control" type="password" name="pass" autocomplete="new-password" placeholder="Sign Your Password"  required="required" />

        	<input minlength="4" class="form-control" type="password" name="confirm-pass" autocomplete="new-password" placeholder="Confirm Your Password"  required="required" />
        	<input class="btn btn-success btn-block" name='signup' type="submit" name="submit" value="Sign up">
        </div>
    </form>

     <!-- end form for signup -->

         <!-- start echo errors -->

     <div class="errors text-center">
         <?php

         if(!empty($formerrors)) { // there is error

                foreach($formerrors as $error) {

                    echo '<div class="msg">' . $error . '</div>' . "<br>";
                }

         }

         if(isset($themsg)) {

            echo '<div class="msg">' . $themsg . '</div>';
         }

            ?>
     </div> 

      <!-- end echo errors -->
    	
    </div>

 <?php  include  $tmp1 . "footer.php"; 
 ?>