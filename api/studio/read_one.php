<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/studios.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare studio object
$studio = new Studio($db);

// set ID property of record to read
$studio->dancerid = isset($_GET['dancerid']) ? $_GET['dancerid'] : die();

// read the details of item to be edited
$studio->readOne();

if($studio->studioname!=null){
    // create array
    $studio_arr = array(
        "dancerid" =>  $studio->dancerid,
        "studioname" => $studio->studioname,
        "studioid" => $studio->studioid,
        "firstname" => $studio->firstname,
        "lastname" => $studio->lastname,
        "gender" => $studio->gender,
        "dob"   => $studio->dob,
        "datecreated" => $studio->datecreated
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($studio_arr, JSON_PRETTY_PRINT);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user id does not exist
    echo json_encode(array("message" => "Id does not exist."), JSON_PRETTY_PRINT);
}
?>
