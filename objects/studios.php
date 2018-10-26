<?php

class Studio {

    private $conn;
    private $tableName = "tblStudios";

    public $studioname;
    public $studioid;
    public $firstname;
    public $lastname;
    public $gender;
    public $dob;
    public $dancerid;
    public $datecreated;

    public function __construct($db) {
        $this->conn = $db;
    }

    function read(){

        // select all query
        $query = "SELECT studioname, studioid, firstname, lastname, gender, dob, dancerid, datecreated FROM $this->tableName";

        // prepare query statement
        $stmt = $this->conn->query($query);

        return $stmt;
    }

    function readOne(){

        // query to read single record
        $query = "SELECT studioname, studioid, firstname, lastname, gender, dob, dancerid, datecreated
                    FROM $this->tableName WHERE dancerid= ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of dancerid to be updated
        $stmt->bind_param("i", $this->dancerid);

        // execute query
        $stmt->execute();

        $result = $stmt->get_result();
        // get retrieved row
        $row = $result->fetch_assoc();

        // set values to object properties
        $this->studioname = $row['studioname'];
        $this->studioid = $row['studioid'];
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->gender = $row['gender'];
        $this->dob = $row['dob'];
    }

    // create item
    function create(){

        // query to insert record
        $query ="INSERT INTO
                    $this->tableName
                SET studioname= ?, studioid= ?, firstname= ?,
                    lastname= ?, gender=?, dob=?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->studioname=htmlspecialchars(strip_tags($this->studioname));
        $this->studioid=htmlspecialchars(strip_tags($this->studioid));
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->gender=htmlspecialchars(strip_tags($this->gender));
        $this->dob=htmlspecialchars(strip_tags($this->dob));

        // bind values
        $stmt->bind_param('sissss', $this->studioname, $this->studioid, $this->firstname, $this->lastname, $this->gender, $this->dob);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

}
