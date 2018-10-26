<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/studios.php';

// instantiate database and studios object
$database = new Database();

$db = $database->getConnection();

// initialize object
$studio = new Studio($db);

// query table
$stmt = $studio->read();

$num = $stmt->num_rows;

// check if more than 0 record found
if ($num>0){

    // array of contents
    $studio_arr=array();
    $studio_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop

    while ($row = $stmt->fetch_assoc()){
        extract($row);
        $studio_item=array(
            "studioname" => $studioname,
            "studioid" => $studioid,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "gender" => $gender,
            "dob" => $dob,
            "dancerid" => $dancerid,
            "datecreated" => $datecreated
        );

        array_push($studio_arr["records"], $studio_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show table data in json format
    echo json_encode($studio_arr, JSON_PRETTY_PRINT);
}

else {
    // set response code - 404 Not found
    http_response_code(404);

    // set message as no items found
    echo json_encode(
        array("message" => "No items found."), JSON_PRETTY_PRINT
    );
}
