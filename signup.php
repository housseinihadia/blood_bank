   <?php 
session_start();

$titlepage = 'تسجيل الدخول';

if(isset($_SESSION['user'])) {

    header('location: index.php'); // go to homepage page 
}

   include 'init.php'; 

if($_SERVER['REQUEST_METHOD'] == 'POST') { 



// this is post['signup']

            $formerrors = array(); // array to print thr errors

            $username  = $_POST['username'];
            $email     = $_POST['email'];
            $password  = $_POST['pass'];
            $phone     = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
            $age       = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
            $region    = $_POST['region'];
            $lastdonaition       = $_POST['lastdonaition'];
            $gender               = $_POST['gender'];



              // srart filter of user name 

            if(isset($username)) {

           if(empty($username)) {
            $formerrors [] = 'يجب كتابه  الاسم';
         }

                    $filteruser = filter_var($username, FILTER_SANITIZE_STRING);

                    if(strlen($filteruser) < 10) {

                        $formerrors[] = 'يجب ان يكون الاسم ثلاثي';
                    }
        }

            //start filter password

        
                if(empty($_POST['pass'])) {

                    $formerrors[] = 'يجب املاء كتابه المرور';
                }

         // start fiter of email 

         if(isset($email)) {

            $filteremail = filter_var($email, FILTER_SANITIZE_EMAIL);

            if(filter_var($filteremail, FILTER_VALIDATE_EMAIL) != true) {

                $formerrors [] = 'بريد الكترونى غير صالح';
            }

         }
        // strat Filter Phone

         if(empty($phone)) {
            $formerrors [] = 'يجب كتابه رقم الهاتف';
         }

        // strat Filter age
         if(empty($age)) {
            $formerrors [] = 'يجب كتابه السن';
         }

        // strat Filter region
         if(empty($region)) {
            $formerrors [] = 'يجب اختيار المنطقع';
         }
        // strat Filter lastdonaition
         if(empty($lastdonaition)) {
            $formerrors [] = 'يجب اختيار اخر موعد للتبرع';
         }
    


          if(empty($formerrors)) { // NO error

                // use the function is check the if user has this name exist in database or not 

                    $check = checkitem ('Username', 'users', $username);

                    if($check == 1) { // exist username in with the same name

                        $themsg = 'هذا الاسم موجود مسبقا';

                    } else {

                         // insert un the database with info
                                $stmt = $con->prepare('INSERT INTO users (Username, Email, Password, phone, age,
                                region, last_doniation ,gender, Cur_date) VALUES (:name, :mail, :pass, :phone ,:age ,:region, :last_doniation, :gender, now())');
                                $stmt->execute(array(

                                    'name'   => $username,
                                    'mail'   => $email,
                                    'pass'   => sha1($password),
                                    'phone'  => $phone,
                                    'age'    => $age,
                                    'region' => $region,
                                    'last_doniation'=> $lastdonaition,
                                    'gender' => $gender  

                                    ));


                             //echo sucsees message
                            $themsg =  'تهانيانا لقد اصبحت عضو معنا';


                    }

          }





        }



   ?>



 <div class=" sign-up">
            <div class="form">
                <form  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <input  class="data" type="text" placeholder="إسمك ثلاثى "  name="username" ><br>
                        <input class="data" type="email" placeholder=" الايميل "     name="email" required ><br>
                        <input class="data" type="password" placeholder=" كلمه المرور" name="pass"  required ><br>
                        <input class="data"  type="tel" placeholder=" رقم التليفون"  name="phone" required><br>
                        <input class="data" type="text" placeholder=" السن "       name="age" required ><br>
                        <select class="select2" name="region">
                            <option value="0" class="active">  المنطقه :</option>
                            <option value="1">الزقازيق</option>
                            <option value="2">ههيا</option>
                            <option value="3">فاقوس</option>
                            <option value="4">أبوكبير</option>
                            <option value="5">مينيا القمح</option>
                            <option value="6">كفر صقر </option>
                            <option value="7">أولاد صقر</option>
                            <option value="8">أبوحماد</option>
                            <option value="9">ديرب نجم</option>
                            <option value="10">مشتول السوق</option>
                        </select>
                         <select class="select2" name="lastdonaition">
                            <option value="0" class="active">   متى آخر مره قمت بالتبرع ؟  </option>
                            <option value="1"> أقل من شهر</option>
                            <option value="2">أقل من شهرين </option>
                            <option value="3"> أقل من ثلاثه أشهر </option>
                              <option value="4">  لم أتبرع من قبل </option>
                        </select> <br>
                        <input class="radio1"  type="radio" name="gender" value="0"><p class="gander">انثي</p> 
                        <input class="radio2"  type="radio" name='gender' value="1"><p class="gander">ذكر</p> <br>
                         <input type="submit" name="" class="submit" value="انضم الينا">
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

      <!-- end echo errors -->




        </div>