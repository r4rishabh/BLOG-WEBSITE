<?php 



if(isset($_POST['create_post']))
{


  if(isLoggedIn())
{
  
$post_user_id = loggedInUserId();

}
 
	$post_title = $_POST['title'];
	$post_author = $_POST['author'];
	$post_category_id = $_POST['post_category'];
  
	$post_status = $_POST['post_status'];
	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];
	$post_tag = $_POST['post_tag'];
  
	$post_content = $_POST['post_content'];
	$post_date = date('d-m-y');
	

	move_uploaded_file($post_image_temp, "../images/$post_image");

   $query = "SELECT * FROM categories WHERE cat_title = '{$post_title}' ";
  $send_query = mysqli_query($connection, $query);
  while($row= mysqli_fetch_array($send_query))
  {
    $post_category_id = $row['cat_id'];
  }


   $query = "INSERT INTO posts(post_category_id, user_id, post_title, post_author, post_date, post_image, post_content, post_tag, post_comment_count, post_status, post_views_count, likes) ";
   $query .= "VALUES({$post_category_id}, {$post_user_id}, '{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tag}', 0, '{$post_status}', 0, 0) ";

   $create_post_query = mysqli_query($connection, $query);
   

   confirmQuery($create_post_query);
   
   $the_post_id = mysqli_insert_id($connection);

   echo "<p class='bg-success'> Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>Edit More Post </a></p>";

}

?>
<form action="" method="post" enctype="multipart/form-data">


   <div class="form-group">
   	<label for="title">Post Title</label>
   	<input type="text" class="form-control" name="title">
   </div>

   
    <div class="form-group">
      <label for="categroy">Category</label>
      <select name="post_category" id="post_category">
        
<?php
  $query = "SELECT * FROM categories";
  $select_categories = mysqli_query($connection, $query);
  confirmQuery($select_categories);
  while($row = mysqli_fetch_assoc($select_categories)){
     $cat_id = $row['cat_id'];
     $cat_title = $row['cat_title'];

     echo "<option value='{$cat_id}'>{$cat_title}</option>";
  

}
   
?>
         
      </select>
   </div>





 
    <div class="form-group">
      <label for="users">Users</label>
      <select name="post_category" id="post_category">
        
<?php
  $query = "SELECT * FROM users";
  $select_categories = mysqli_query($connection, $query);
  confirmQuery($select_categories);
  while($row = mysqli_fetch_assoc($select_categories)){
     $user_id = $row['user_id'];
     $username = $row['username'];

     echo "<option value='{$user_id}'>{$username}</option>";
   }


   
?>
         
      </select>
      
   </div>

   







   <div class="form-group">
   	<label for="title">Post Author</label>
   	<input type="text" class="form-control" name="author">
   </div>












   <div class="form-group">
   	
    <select name="post_status">
      <option value="draft">Post Status</option>
      <option value="published">Publish</option>
      <option value="draft">Draft</option>
      
    </select>
   	
   </div>

   <div class="form-group">
   	<label for="post_image">Post Image</label>
   	<input type="file"  name="image">
   </div>


   <div class="form-group">
   	<label for="post_tag">Post Tags</label>
   	<input type="text" class="form-control" name="post_tag">
   </div>
 
   <div class="form-group">
   	<label for="post_content">Post Content</label>
   	<textarea type="text" class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
   </div>


   <div class="form-group">

   	<input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
   	
   </div>
</form>