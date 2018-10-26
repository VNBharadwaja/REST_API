<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../../config/database.php';

// instantiate studios object
include_once '../../objects/studios.php';

$database = new Database();
$db = $database->getConnection();

$studio = new Studio($db);

// get posted data
$data = json_decode(file_get_contents(("php://input")));

// make sure that data is not empty
if(
    !empty($data->studioname) &&
    !empty($data->firstname) &&
    !empty($data->lastname) &&
    !empty($data->dob) &&
    !empty($data->gender) &&
    !empty($data->studioid)
){
    // set studio property values
    $studio->studioname = $data->studioname;
    $studio->firstname = $data->firstname;
    $studio->lastname = $data->lastname;
    $studio->dob = $data->dob;
    $studio->gender = $data->gender;
    $studio->studioid = $data->studioid;

    // create item
    if($studio->create()){

        // set response code - 201 created
        http_response_code(201);

        // successfully created an item
        echo json_encode(array("message" => "Item was created."), JSON_PRETTY_PRINT);
    }

    // if unable to create
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // message as unable to create item
        echo json_encode(array("message" => "Unable to create item."));
    }
}

// if the data is incomplete
else{
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create Item. Data is incomplete."));
}
?>
