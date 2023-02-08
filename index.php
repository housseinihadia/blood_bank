<?php 
session_start();

$titlepage = 'شريان حياه';

if(isset($_SESSION['user'])) {

    header('location: home.php'); // go to homepage page 
}   
    include 'init.php';

     if($_SERVER['REQUEST_METHOD'] == 'POST') {



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

               header('location: home.php'); // go to homepage page 
                
                 exit();

                
            } else {

                $formerrors = array();
               $formerrors [] = 'تاكد من الاسم او كلمه المرور';
            } 

        }


?>
    <div class="content">
            <div class="main">
            
                <div class="info">
                    <h2>
                        شريان
                    </h2>

                    <p> هدفنا هو الوصول لأكبر عدد من المتبرعين وتسهيل وصول الدم للمرضى , لا نستطيع فعل هذا بدون مساعدتكم </p>
                    <a href="signup.php"><button> إنضم إلينا </button></a>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                    <div class=" form">
                        <label > الإسم رباعى</label> <br>
                        <input type="text" name="username"> <br>
                        <label> كلمه المرور</label> <br>
                        <input type="password" name="pass"> <br>
                       <input class="submit" type="submit" name="" value="إدخال">
                        
                    </div>
            </form>

  </div>
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
        
</div>
<?php
  include  $tmp1 . "footer.php"; 


 ?>

