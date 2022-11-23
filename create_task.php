<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
header('Content-Type: application/json');
/*
 * Following code will create a new task row
 * All task details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
$postdata = json_decode(file_get_contents("php://input"), true);
$name = $postdata['name'];
$amount = $postdata['amount'];
$description = $postdata['description'];

// check for required fields
//if (isset($_POST['name']) && isset($_POST['description'])) {
 if (isset($name) && isset($description) && isset($amount)) {

    /*
    $name = $_POST['name'];
    $description = $_POST['description'];
    */
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
 
    // mysql inserting a new row
    $result = mysqli_query($db->connect(),"INSERT INTO data(name, amount, description) VALUES('$name','$amount','$description')");
 
    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Task successfully created.";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
 
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>