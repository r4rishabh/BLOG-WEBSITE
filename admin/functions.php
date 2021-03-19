
<?php


/* =======  DATABASE HELPER FUNCTIONS ====== */

function redirect($location)
{
   header("Location:" . $location);
    exit;
}


function query($query)
{
  global $connection;
  $result = mysqli_query($connection, $query);
  confirmQuery($result);
  return  $result;
}

function fetchRecords($result)
{
  return mysqli_fetch_array($result);
}



function count_records($result)
{
  return mysqli_num_rows($result);
}





/* === END DATABASE HELPERS ====*/

function get_user_name()
{
  return isset($_SESSION['username']) ? $_SESSION['username'] : 'null';
}

function get_user_post()
{
  return query("SELECT * FROM posts where user_id =".loggedInUserId()."");

}


function get_user_comment()
{
  return  query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id 
    WHERE user_id =".loggedInUserId()."");
}

function get_user_category()
{
  return query("SELECT * FROM categories where user_id =".loggedInUserId()."");
}

function get_user_published_post()
{
  return query("SELECT * FROM posts where user_id =".loggedInUserId()." AND post_status = 'published'");
}


function get_user_draft_post()
{
  return query("SELECT * FROM posts where user_id =".loggedInUserId()." AND post_status = 'draft'");
}


function get_user_appproved_comments()
{
    return  query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id 
    WHERE user_id =".loggedInUserId()." AND comment_status = 'approved'"); 
}



function get_user_unappproved_comments()
{
    return  query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id 
    WHERE user_id =".loggedInUserId()." AND comment_status = 'unapproved'"); 
}






/* =====    AUTHENTICATION HELPER =====    */




function is_admin()
{
  global $connection;

  if(isLoggedIn()){

  $result = query("SELECT user_role FROM users WHERE user_id = ".$_SESSION['user_id']."");
  $row = fetchRecords($result);

  if($row['user_role'] == 'admin')
  {
    return true;
  }

  else
  {
    return false;
  }
}

return false;
}


/* =====    AUTHENTICATION HELPER =====    */



function currentuser()
{
  if(isset($_SESSION['username']))
  {
    return $_SESSION['username'];
  }

  return false;
}


function ifItIsMethod($method=null)
{
  if($_SERVER['REQUEST_METHOD'] == strtoupper($method))
  {
    return true;
  }

  return false;
}

function isLoggedIn(){

    if(isset($_SESSION['user_role'])){
        


        return true;


    }


   return false;

}




function loggedInUserId()
{
  if(isLoggedIn())
  {

    $result = query("SELECT * FROM users WHERE username='" .$_SESSION['username']."'" );
    confirmQuery($result);
    $user = mysqli_fetch_array($result);
    return mysqli_num_rows($result) >=1 ? $user['user_id'] : fales;
  }
 
}






function userLikedThisPost($post_id = '')
{
  $result = query("SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " And post_id = {$post_id}");
  confirmQuery($result);
  return mysqli_num_rows($result) >= 1 ? true : false;
}







function checkIfUserIsLoggedInAndRedirect($redirectLocation=null)
{
  if((isLoggedIn()))
  {
    redirect($redirectLocation);
  }
}

function getPostlikes($post_id){

    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    confirmQuery($result);
    echo mysqli_num_rows($result);

}









function users_online()
{

      global $connection;
      $session = session_id();
      $time = time();
      $time_out_in_seconds = 30;
      $time_out = $time - $time_out_in_seconds;
      

      $query = "SELECT * FROM users_online WHERE session = '$session'";
      $send_query = mysqli_query($connection, $query);
      $count = mysqli_num_rows($send_query);

      if($count == NULL)
      {
        mysqli_query($connection, "INSERT INTO users_online(session, timee) VALUES('$session', '$time')");
      }

      else
      {
         mysqli_query($connection, "UPDATE users_online SET timee = '$time' WHERE session = '$session'");
      }

      $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE timee > '$time_out'");
      return $count_user = mysqli_num_rows($users_online_query);
    
}


function confirmQuery($result)
{
  global $connection;
  if(!$result)
   {
      die("QUERY FAILED" . mysqli_error($connection));
   }

}

function insert_categories()
{

    global $connection;

	if(isset($_POST['submit']))
    {

      if(isLoggedIn())
        {
          
        $cat_user_id = loggedInUserId();

        }

        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title))
        {
            echo "This field should not be empty";
        }  
            else
            {
                $stmt = mysqli_prepare($connection, "INSERT INTO categories(user_id,cat_title)VALUES(?,?) ");
                  if(isLoggedIn())
                  {
                    
                  $cat_user_id = loggedInUserId();

                  }
                mysqli_stmt_bind_param($stmt, 'is', $cat_user_id, $cat_title);
                
                mysqli_stmt_execute($stmt);
                 if(!$stmt)
                {
                    die('QUERY FAILED' . mysqli_error($connection));
                }
              
            }
    }
                               
}






function find_all_categories()
{
	global $connection;
   if(isLoggedIn())
                  {
                    
                  $cat_user_id = loggedInUserId();

                  }
	$query= "SELECT * FROM categories where user_id = $cat_user_id";
    $select_category= mysqli_query($connection, $query);
                                     
    while($row= mysqli_fetch_assoc($select_category))
    {
       $cat_id= $row['cat_id'];
       $cat_title= $row['cat_title'];
       echo "<tr>";
       echo "<td>{$cat_id}</td>"; 
       echo "<td>{$cat_title}</td>";
       echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
       echo "<td><a href='categories.php?edit={$cat_id}'>edit</a></td>";
       echo "</tr>";
    }
}






function delete_categories()
{
	global $connection;
	if(isset($_GET['delete']))
    {
        $the_cat_id= $_GET['delete'];
        $query= "DELETE FROM categories WHERE cat_id={$the_cat_id} ";
        $delete_query= mysqli_query($connection, $query);

     }
}










function username_exists($username)
{
  global $connection;

  $query = "SELECT username FROM users WHERE username = '$username' ";
  $result = mysqli_query($connection, $query);
  confirmQuery($result);

  if(mysqli_num_rows($result) > 0)
  {
    return true;
  }
  else
  {
    return false;
  }
}




function email_exists($email)
{
  global $connection;

  $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
  $result = mysqli_query($connection, $query);
  confirmQuery($result);

  if(mysqli_num_rows($result) > 0)
  {
    return true;
  }
  else
  {
    return false;
  }
}









function register_user($username, $email, $password)
{

    
    global $connection;



    

    $username = mysqli_real_escape_string($connection, $username);
    $email    = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12) );

    $query = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_image ,  user_role, token) ";
    $query .= "VALUES('{$username}', '{$password}', ' ', ' ', '{$email}', ' ',  'subscriber', ' ')";
    $register_user_query = mysqli_query($connection, $query);
   
    confirmQuery($register_user_query);

   
}



function login_user($username, $password)
{

    
    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);

    if(!$select_user_query)
    {
      die("QUERY FAILED" . mysqli_error($connection));
    } 


    while($row = mysqli_fetch_assoc($select_user_query))
    {
      $db_id = $row['user_id'];
      $db_username = $row['username'];
      $db_password = $row['user_password'];
      $db_firstname = $row['user_firstname'];
      $db_lastname = $row['user_lastname'];
      $db_role = $row['user_role'];


    if(password_verify($password,$db_password))
    {
      $_SESSION['user_id']  = $db_id;
      $_SESSION['username'] = $db_username;
      $_SESSION['firstname'] = $db_firstname;
      $_SESSION['lastname'] = $db_lastname;
      $_SESSION['user_role'] = $db_role;

      redirect("/cms/admin");
    }

    else
    {
      return false;
    }

   }
  
   return true; 

}









?>