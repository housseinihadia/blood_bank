<?php 
    ob_start();

    session_start();
    
    $titlepage = 'Show Items';
   
    include 'init.php';

    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    $stmt = $con->prepare("SELECT items.*, categories.Name AS category_name, users.Username AS member_name
                                FROM items
                                    INNER JOIN
                                    categories
                                    ON 
                                    categories.ID = items.Cat_id
                                    INNER JOIN
                                    users
                                    ON
                                    users.UserID = items.Member_id

                                   WHERE Item_id = ?
                                   AND 
                                   Approve = 1");

    $stmt->execute(array($itemid));

    $count = $stmt->rowcount();

    if($count > 0) { // there is id

    $item = $stmt->fetch();
?>

<h1 class="text-center"><?php echo $item['Name']?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">

        <img class="img-responsive img-thumbnail" src='User-Default.JPG' />
            
        </div>

         <div class="col-md-9">
         <ul class="list-group item-details">
                <li class="list-group-item list-group-item-info"><i class="fa fa-star" aria-hidden="true"></i>
                 Name of product : <span><?php echo $item['Name'] ?></span></li>

                <li class="list-group-item"><div><i class="fa fa-tag" aria-hidden="true"></i> Description : <span><?php echo $item['Description'] ?></span></div></li>

                <li class="list-group-item list-group-item-info"><i class="fa fa-calendar" aria-hidden="true"></i> Date : 
                <span> <?php echo $item['Add_date']?></span></li>

                <li class="list-group-item"><div><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                Price : <span> $<?php echo $item['Price']?></span></div></li>

                 <li class="list-group-item list-group-item-info"><div> <i class="fa fa-flag" aria-hidden="true"></i> Country Made : <span><?php echo $item['Country_made']?></span></div></li>

                 <li class="list-group-item"><div>
                 <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 
                   Category Name :<span><a href="categories.php?catid=<?php echo $item['Cat_id']?>"><?php echo $item['category_name']?></span></a></div></li>

                 <li class="list-group-item list-group-item-info"><div> <i class="fa fa-address-card-o" aria-hidden="true"></i>
                  Member Name : <span><?php echo $item['member_name']?></span></div>

                  </li>
                 <li class="list-group-item list-group-item-info"><div> <i class="fa fa-address-card-o" aria-hidden="true"></i>
                  Tags: <span>
                  <?php 
                    $alltags = explode(",", $item['tags']);

                    foreach($alltags as $tag) {

                      $tag = str_replace(' ', '', $tag);

                      $lowertage = strtolower($tag);
                      if(!empty($tag)) {

                      echo "<a class='tag-link' href='tags.php?name={$lowertage}' >". $tag . "</a> ";
                     }
                  }

                  ?>
                    
                  </span></div>

                  </li>

            </ul>
            <a class="btn btn-default" href="#">Edit Portofolio</a>
            
        </div>
    </div>
    <hr class="custom-hr">
         <!--start add comment -->
      <?php
     if(isset($_SESSION['user'])) { 

     ?>
    <div class="row">
        <div class="col-md-offset-3">
            <div class="add-comm">
                <h3><i class="fa fa-comments-o"></i> Add Comment</h3> 
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_id'] ?>" method='POST'>
                    <textarea class="form-control" name="comment"></textarea>
                    <input class="btn btn-primary btn-lg" type="submit" value="Add Comment">
                </form>
                <?php 
                if($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                    $itemid  =  $item['Item_id'];
                    $itemuser = $_SESSION['userid'];

                    if(!empty($comment)) {

                        $stmt = $con->prepare("INSERT INTO comments (comment, status, comment_date, item_id, user_id) 
                            VALUES (:zcomm, 0, now(), :zitemid, :zuserid)");

                        $stmt->execute(array(

                                'zcomm'    => $comment,
                                'zitemid'  =>$itemid,
                                'zuserid'  =>$itemuser
                            ));

                        if($stmt) {

                            echo '<div class="alert alert-success msg-suc"> You Added Comment Successfuly</div';
                        }
                }


                }


                ?>
            </div>
        </div>

    </div>

    <?php }else {

    echo '<a href="login.php">Login</a> or <a href="login.php"> Register</a> To Add Comment';
  }
?>

     <hr class="custom-hr">
         <?php 

       $stmt = $con->prepare("SELECT comments.*,  users.Username AS member_name
                                FROM comments
                                    INNER JOIN
                                    users
                                    ON 
                                    users.UserID = comments.user_id

                                    WHERE 
                                    item_id = ? 
                                    AND
                                    status = 0

                                     ORDER BY 
                                    c_id DESC
                                                      ");

    $stmt->execute(array($item['Item_id']));

    $comments = $stmt->fetchall();




    ?>
    <?php foreach($comments as $comm ) { ?>
    <div class="box-comment">   
        <div class="row">
            <div class="col-sm-2 text-center">
                <img class="img-responsive img-thumbnail img-circle center-block" src='User-Default.JPG' />
                <?php echo $comm['member_name']?>
            </div>
            <div class="col-sm-10">
            <p class="lead"><?php echo $comm['comment']?></p>

            </div>
            
        </div>
    </div>

    <?php } ?>

     <!--end add comment -->



		


<?php 

}else {

    echo 'There Is No Such ID Or item Not Activate ';
}

  include  $tmp1 . "footer.php"; 

  ob_end_flush();


 ?>