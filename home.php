 <?php 
 ob_start();

session_start();

$titlepage = 'الصفحه الرئيسيه';

    include 'init.php'; 

    if(isset($_SESSION['user'])) {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
             $formerrors = array();


                $request_patien    = filter_var($_POST['request_patien'], FILTER_SANITIZE_STRING);
                $request_hospital  = filter_var($_POST['request_hospital'], FILTER_SANITIZE_STRING);
                $request_phone     = filter_var($_POST['request_phone'], FILTER_SANITIZE_NUMBER_INT);
                $request_type      = filter_var($_POST['request_type'], FILTER_SANITIZE_NUMBER_INT);

              // start validate form
            if(strlen($request_patien) < 6) {

                $formerrors[] = 'يجب ان يكون الاسم ثنائي علي الا قل';
            }


            if(empty($request_patien)) {

                $formerrors[] = 'يجب كتابه الاسم ';
            }

            if(empty($request_hospital)) {

                $formerrors[] = 'يجب كنابه اسم المستشفي';
            }

            if(empty($request_phone)) {

                $formerrors[] = 'يجب كنابه رقم التليفون';
            }

            if(empty($request_type)) {

                $formerrors[] = 'يجب اختيار فصيله الدم';
            }

            if(empty($formerrors)) {

   // there is no errors

                $stmt = $con->prepare("INSERT INTO request (pation_name, hospital_name, phone_number, blood_type, Member_id, add_date
                    ) VALUES (:zname, :zhos, :zphone, :ztype, :zmemid, now())");

                $stmt->execute(array(

                    'zname'   => $request_patien,
                    'zhos'    => $request_hospital,
                    'zphone'  => $request_phone,
                    'ztype'   => $request_type,
                    'zmemid'  => $_SESSION['userid']
                    ));

                // sucsess msg
                if($stmt) {

                    $sucsess_msg =  "<div class='sucsess_msg'>لقد تم ارسال طلبك بنجاح وسوف يتم التواصل في اقرب وقت </div>";
                }
            }

            }

}



    ?>


 <!-- start the header -->
        <div class="header">
            
            <div class="logo">
                <h3> شريان </h3>
            </div>

        <ul class="navbar">
            <li><a href="#slider" > الرئيسيه </a></li>
            <li><a href="#form">طلب الدم    </a></li>
            <li><a href="#sponser">نبذه عن الجمعيه  </a> </li>
             <a style="  float: left; padding: 14px;text-decoration: none;" href="logout.php">تسجيل خروج</a>

        </ul>
            <!-- sttar the slide show-->
       </div>
        <div class="slideshow" id="slider">
              <img class="slide" src="imges/first.jpg" >
              <img class="slide" src="imges/second.jpg" >
              <img class="slide" src="imges/third+.jpg" >
              <img class="slide" src="imges/fourth.jpg" >
              <img class="slide" src="imges/fifth.jpg" >
        </div>
          <!-- sttar the form of طلب الدم -->
        <div class="form request" id="form">
            <h3> طلب الدم </h3>
            <form  action="<?php ?>" method="post">
                    <input type="text"    placeholder=" اسم المريض"   name="request_patien"  required><br>
                    <input type="tel"     placeholder=" اسم المستشفى" name="request_hospital"   min="0" required><br>
                    <input type="tel"     placeholder=" رقم تليفون للتواصل" name="request_phone" required><br>
                    <select class="select2" name="request_type">
                            <option value="0" class="active"> فصيله الدم :</option>
                            <option value="1">o+</option>
                            <option value="2">o-</option>
                            <option value="3">A-</option>
                            <option value="4">A+</option>
                            <option value="5"> AB+ </option>
                            <option value="6">AB- </option>
                            <option value="7">B-</option>
                            <option value="8">B+ </option>
                        </select> <br>
                       <input class="button" type="submit"  value="اطلب" />
           </form>
        </div>

 <!-- start print errors -->
 <div class="errors">
                            <?php 

                            if(!empty($formerrors)) {

                                foreach($formerrors as $error) {

                                    echo '<div class="msg">' . $error . '</div>';
                                }

                            } else {
                                if(isset($sucsess_msg)) {
                                    echo $sucsess_msg;
                                } 
                            }


                            ?>
                        </div>
                            <!-- end print errors -->
         



          <!-- sttar the info about sponser-->
        <div class=" sponser" id="sponser">
            <div class="video">
                <video controls width="100%" poster="imges/large-1386674774503958290.jpg">
                  <source src="imges/BLOOD.mp4" type="video/mp4">
                  <source src="imges/BLOOD.webm" type="video/webm">  <!-- to suuport Oper-->                 
                  <source src="imges/BLOOD.ogg" type="video/ogg">    <!-- to suuport FirFox--> 
                  Your browser does not support the video tag.
                </video>
            </div>
             <div class="data">
            <h2> صناع الحياه </h2>
            <p>صناع الحياه هي فكره تهدف لبناء أجيال تدرك وتؤمن بقيمه النتميه قولا وعملا والمساعده في تحقيق تنميه مجتمعيه ملبموسه وتقديم نموذج لحلول عملية للمشكلات التي تواجه المجتمع في قضايا (الفقر -الحهل-المرض)  
                كما ان صناع تهدف لتجميع اكبر عدد من المتبرعين من خلال هذا الموقع وسهوله وصل الدم للمرضى 
            </p>
            <a href="#"></a>
            <a href="#"></a>
             <a href="#"></a>
        </div>
        
            </div>
       
             <div class="pic">
                <div class="pic1">
                    <div class="over">
                    
                    <p>وهنا بنشتغل على نشر ثقافه التبرع بالدم وعمل حملات مساهمه فى بنك الدم</p>
                </div>
                </div>
                <div class="pic2">
                    <div class="over">
                    <p>  ده مشروع هدفه توعيه الشباب ضد اضرار المخدرات على صحتنا </p>
                </div>
                </div>
               
                <div class="pic3">
                    <div class="over">
                    
                    <p>عباره عن مشاريع صغيره تخدم الاسر وتحويلها من اسر غير قادره ل اسر لها دخل دائم </p>
                </div>
                </div>
                <div class="pic4">
                    <div class="over">
                    <p>نهدف لتعليم الشباب فى سن صغير بعض المهارات الحياتيه اللتى تضيق لشخصيته .</p>
                </div>
                </div>
                 <div class="pic5">
                    <div class="over">
                    <p> هدفه نشر ثقافه محو الأميه وأهميه التعليم وتأثيرع على الكبار والصغار</p>
                </div>
                </div>
                 <div class="pic6">
                    <div class="over">
                                             <P> هدفه التركيز على التوعيه الصحيه للأفراد لحمايتهم من الأصابه ببعض الأمراض</P>

                </div>
                </div>
                   </div> 

                           
        <!-- start the footer -->
        <div class="footer">
            <div class=" contact">
                <h2> نبذه عنا</h2>
                <p>  نحن فريق عمل نسعى دائما لمساعده الاخرين وتوفير سبل الراحه له, نحن فريق عمل نسعى دائما لمساعده الاخرين نحن فريق عمل نسعى دائما لمساعده الاخرين وتوفير سبل الراحه لهوتوفير سبل الراحه لهم </p>
                <h3> للتواصل معنا </h3>
            <ul>
                <li> <a href="#"><img src="imges/if_phone_281830%20(1).png"> </a> </li>
                <li>  <a href="#"><img src="imges/if_twitter_281833%20(1).png"></a></li>
                <li> <a href="#"> <img src="imges/if_youtube_281826.png"></a> </li>
                <li> <a href="#"> <img src="imges/if_youtube_281826.png"></a> </li>
            </ul>
            
            </div> 
            <div class=" review">
                <h2> رأيك يهمنا </h2>
                <input type="text" placeholder=" اسمك "> <br>
                <textarea > </textarea>
                    
            </div>
        </div>
        <div class="copyright">
           <span> copyright &copy; 2018 to project team </span>
            
        </div>

 <?php
  include  $tmp1 . "footer.php"; 


 ?>