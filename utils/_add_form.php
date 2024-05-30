<div class="collapse container" id="collapseExample">
  <form id="add-comment" method="post" action="<?php $_SERVER['REQUEST_URI']; ?>">
    <input type="hidden" name="action" value="add-comment">
    <div class="form-floating m-4">
      <input type="text" class="form-control border border-1 border-dark" name="title" id="floatingInputGroup1" placeholder="Title">
      <label for="floatingInputGroup1">Title</label>
    </div>
    <div class="form-floating m-4">
      <textarea class="form-control border border-1 border-dark" name="concern" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
      <label for="floatingTextarea2">Your Concern</label>
    </div>
    <div class="container text-center">
      <input type="submit" class="btn btn-success" style="width: 20%;" value="Post">
    </div>

  </form>
</div>

<?php
require "utils/_db_connect.php";

$username = $_SESSION['username'];
function get_id($username,$mysql)
{
  $query = $mysql->prepare('SELECT * FROM `users` WHERE `username`=?');
  $query->bind_param('s', $username);
  $query->execute();
  $row = $query->get_result()->fetch_assoc();
  return $row['user_id'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


  if ($_POST['action'] == 'add-comment') {

    $title = $_POST['title'];
    $concern = $_POST['concern'];
    $category_id = $_GET['category_id'];
    $user_id = get_id($_SESSION['username'],$mysql);
    $query = $mysql->prepare('INSERT INTO `threads` (`thread_title`,`thread_desc`,`thread_cat_id`,`thread_user_id`) VALUES (?,?,?,?)');
    $query->bind_param('ssss', $title, $concern,$category_id, $user_id);
    $result = $query->execute();
    if($result){
      echo '<div class="alert alert-success alert-dismissible fade show fixed-top" role="alert">
      <strong>Success!</strong> Post Added Successfully
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show fixed-top" role="alert">
      <strong>System Error!</strong> Try Again !!!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
  }
}



?>