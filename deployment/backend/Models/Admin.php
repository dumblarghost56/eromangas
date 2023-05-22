<?php
namespace Model;

class Admin extends ActiveRecord{
  public $email;
  public $userpass;
  public static $role=1;

  public function __construct($email,$userpass){
    $this->email = $email;
    $this->userpass = $userpass;
  }

  public function setAdmin(){
    $query = "SELECT * FROM users WHERE userRole=1";
    $result = self::$db->query($query);
    if($result->num_rows){
      $query = "DELETE FROM users WHERE userRole=1";
      self::$db->query($query);
    }
    $email = $this->email;
    $userpass = $this->userpass;
    $userpass = password_hash($userpass,PASSWORD_DEFAULT);
    $query = "INSERT INTO users (email,userpass,userRole) VALUES ('$email','$userpass',1)";
    self::$db->query($query);
  }

  public function validate(){
    $email = $this->email;
    $userpass = $this->userpass;
    $errs = [];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = self::$db->query($query);
    if(!$result->num_rows){
      $errs[] = "El email no esta registrado.";
      return $errs;
    }
    $hash = $result->fetch_assoc()["userpass"];
    if(!password_verify($userpass,$hash)) $errs[] = "El password no concuerda";
    return $errs;
  }
}
