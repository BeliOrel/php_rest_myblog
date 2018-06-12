<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog Category object
  $category = new Category($db);

  // Blog post query
  $result = $category->read();
  // get row count
  $num = $result->rowCount();

  // Check if any categories
  if($num > 0){
    // Category array
    $category_arr = array(); // blank array for data from DB & other data
    $category_arr['data'] = array(); // actual DB data

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      extract($row);

      $category_item = array(
        'id' => $id,
        'name' => $name
      );

      // push to "data"
      array_push($category_arr['data'], $category_item);
    }

    // Turn to JSON & output
    echo json_encode($category_arr);
  } else {
    // No categories
    echo json_encode(
      array('message' => 'No categories found')
    );
  }
?>
