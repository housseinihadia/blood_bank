
<?php

 $titlepage = 'Cartegories Page';
 
 include 'init.php'; 

 ?>

<div class="container">
		<div class="row">
		<?php

			if(isset($_GET['name'])) {
				$tag = $_GET['name'];
				echo "<h1 class='text-center'>" . $tag. "</h1>";
		

				$itemtags = getall("*", "items", "WHERE tags like '%$tag%'", "AND Approve = 1", "Item_id");
			    
			     foreach($itemtags as $item) { ?>

			     	<div class='col-sm-6 col-md-3'>
				     	<div class='thumbnail item-box'>
				     	<span class="price"><?php echo $item['Price']?></span>
				     	  <img class="imge-responsive" src='User-Default.JPG' />
				     	  <div class="caption">
					     	  	<h3><a href="items.php?itemid=<?php echo $item['Item_id']?>"><?php  echo $item['Name'];?></a></h3>
					     	  	<p><?php echo $item['Description'];?></p>
				     	  </div>

				    	</div>

			    	</div>
			    <?php  }

		} else {

			echo "You Don't Allow You";
		}
		?>	

	</div>
</div>

 <?php include  $tmp1 . "footer.php"; ?>
