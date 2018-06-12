<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


  include_once '../../config/Database.php';
  include_once '../../models/Category.php';
  include_once '../../models/Post.php';

  // if post with certain category exists
  $check = false;

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate post an category object
  $category = new Category($db);
  $post = new Post($db);

  // get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  //set ID
  $category->id = $data->id;

  // Blog post query
  $result = $post->read();
  // get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0){
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      extract($row);
      if ($category_id === $category->id){
        $check = true;
        break;
      }
    }
  }

  // Delete category
  if ($check){
    echo json_encode(
      array('message' => 'Category Cannot Be Deleted. Post(s) with that Category do exist. First repair category in posts, then you can delete it.')
    );
  } else {
    if($category->delete()){
      echo json_encode(
        array('message' => 'Category Deleted')
      );
    } else {
      echo json_encode(
        array('message' => 'Category Not Deleted')
      );
    }
  }
?>
