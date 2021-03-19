<?php

include("delete_modal.php");

if(isset($_POST['checkBoxArray']))
{
  foreach($_POST['checkBoxArray'] as $postValueId)
  {
      $bulk_options = $_POST['bulk_options'];

      switch($bulk_options)
      {
        case 'published':
          $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueId ";
          $update_published = mysqli_query($connection, $query); 
          confirmQuery($update_published);
          break;


          case 'draft':
          $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueId ";
          $draft_published = mysqli_query($connection, $query); 
          confirmQuery($draft_published);
          break;


          case 'delete':
          $query = "DELETE FROM  posts  WHERE post_id = $postValueId ";
          $delete_published = mysqli_query($connection, $query); 
          confirmQuery($delete_published);
          break;
    

          case 'clone':
            $query = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
            $select_posts = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_posts))
            {
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_author = $row['post_date'];
                $post_author = $row['post_author'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tag = $row['post_tag'];
                $post_content = $row['post_content'];
             break;  
            }  

            $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tag, post_status) ";
           $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tag}','{$post_status}') ";

           $create_post_query = mysqli_query($connection, $query);
          confirmQuery($create_post_query);
                


      }
  }
}

?>
<form action="" method='post'>
<table class="table table-bordered table-hover">
  <div id="bulkOptionContainer" class="col-xs-4">

    <select class="form-control" name="bulk_options" id="">
      <option value="">Select Options</option>
      <option value="published">Publish</option>
      <option value="draft">Draft</option>
      <option value="delete">Delete</option>
      <option value="clone">Clone</option>


    </select>
  </div>
  <div class="col-xs-4">
  <input type="submit" name="submit" class="btn btn-success" value="Apply">
  <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
</div>
   <thead>
       <tr>
        <th><input id="selectAllBoxes" type="checkbox" ></th>
           <th>id</th>
           <th>Author</th>
           <th>Title</th>
           <th>Category</th>
           <th>Status</th>
           <th>Image</th>
           <th>Tags</th>
           <th>content</th>
           <th>Comments</th>
           <th>Date</th>
           <th>View Post</th>
           <th>Edit</th>
           <th>Delete</th>
           <th>Views</th>
       </tr>
   </thead>
   <tbody>
   </form> 
       

           <?php
              
              
            /*$admin = is_admin();

            if($admin == true)

            {
              $query = "SELECT * FROM posts  ORDER BY post_id DESC ";
            }
             
            else {*/

               if(isLoggedIn())
                  {
                    
                  $cat_user_id = loggedInUserId();

                  }

                  if(is_admin())
                  {
                        $query = "SELECT * FROM posts  ORDER BY post_id DESC ";
                  }
                 

                  else
                  {
                    $query = "SELECT * FROM posts WHERE user_id = $cat_user_id ORDER BY post_id DESC ";
                  }
          
            $select_posts = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_posts))
            {
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tag = $row['post_tag'];
                $post_content = $row['post_content'];
                $post_comment_count = $row['post_comment_count']; 
                $post_date = $row['post_date'];
                $post_views_count = $row['post_views_count'];


                echo "<tr>";
                ?>



                <td><input class='checkBoxes' id='selectAllBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>



                <?php
                echo "<td>$post_id </td>";
                echo "<td>$post_author </td>";
                echo "<td>$post_title </td>";

                $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
                $select_category_id = mysqli_query($connection, $query);


                while($row = mysqli_fetch_assoc($select_category_id))
                {
                  $cat_id = $row['cat_id'];
                  $cat_title = $row['cat_title'];
                  echo "<td>$cat_title </td>";
                }


                echo "<td>$post_status </td>";
                echo "<td><img width=100 src='../images/$post_image' alt='image'></td>";
                echo "<td>$post_tag </td>";
                echo "<td>$post_content </td>";

                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_comment_query = mysqli_query($connection, $query);
                /*$row = mysqli_fetch_array($send_comment_query);
                $comment_id = $row['comment_id'];*/
                $comment_count = mysqli_num_rows($send_comment_query);


                echo "<td><a href='post_comment.php?id=$post_id'>$comment_count</a></td>";

                echo "<td>$post_date </td>";
                echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</a> </td>";
                echo "<td><a class='btn btn-info' href='posts.php?source=edit_posts&p_id={$post_id}'>Edit</a> </td>";

                 ?>
         

                  <form action="" method="post" accept-charset="utf-8">
                    <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                    <?php
                      echo '<td><input type="submit" class="btn btn-danger" name="delete" value="Delete"></td>';
                 ?>
                  </form>

                   
                 <?php

                /*echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";*/
                /*echo "<td><a onClick=\" javacsript: return confirm('Are you sure you want to delete');\" href='posts.php?delete={$post_id}'>Delete</a> </td>";*/
                echo "<td><a  href='posts.php?reset={$post_id}'>$post_views_count </a></td>";
                echo "</tr>";
            } 
           ?>
       
       
   </tbody>
</table>

<?php
if(isset($_POST['delete']))
{
  $the_post_id = $_POST['post_id'];
  $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
  $delete_query = mysqli_query($connection, $query);

  header("Location: posts.php");
}  

if(isset($_GET['reset']))
{
  $the_post_id = $_GET['reset'];
  $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$the_post_id} ";
  $reset_query = mysqli_query($connection, $query);
  if(!$reset_query)
  {
     die("Query Failed" . mysqli_error($connection));
  }

header("Location: posts.php");
}
?>

<script>
  
  $(document).ready(function(){


    $(".delete_link").on('click', function(){

       var id = $(this).attr("rel");
       var delete_url = "posts.php?delete="+ id +" ";
       $(".modal_delete_link").attr("href", delete_url);

       $("#myModal").modal('show')
       

    });



  });


</script>

