<?php
class Reservation {
  // (A) PROPERTIES
  private $pdo; // PDO object
  private $stmt; // SQL statement
  public $error; // Error message

  // (B) CONNECT TO DATABASE
  function __construct() {
    try {
      $this->pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      );
    } catch (Exception $ex) { die($ex->getMessage()); }
  }

  // (C) DESTRUCTOR - CLOSE DATABASE CONNECTION
  function __destruct() {
    $this->pdo = null;
    $this->stmt = null;
  }

  // (D) SAVE RESERVATION
  function save ($date, $slot, $name, $email, $tel, $notes="") {
   


    // (D2) DATABASE ENTRY
    try {
      $this->stmt = $this->pdo->prepare(
        "INSERT INTO `reservations` (`res_date`, `res_slot`, `res_name`, `res_email`, `res_tel`, `res_notes`) VALUES (?,?,?,?,?,?)"
      );
      $this->stmt->execute([$date, $slot, $name, $email, $tel, $notes]);
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }

   
  }
  
 
}

// (F) DATABASE SETTINGS

define('DB_HOST', 'localhost');
define('DB_NAME', 'reserve');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// (G) NEW RESERVATION OBJECT
$_RSV = new Reservation();