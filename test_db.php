<?php
class Query{
    public $uname;
    public $pw;
    public $email;
    public $vname;
    public $nname;
    public $isadmin;
    public $isldap;
    
    function __construct() {
        $this->uname="another-uname";
        $this->pw="passwort";
        $this->email="anything@example.com";
        $this->vname="vorname";
        $this->nname="nachname";
        $this->isadmin=false;
        $this->isldap=false;
    }
}

$object=new Query;

$configs=include("config.php");
$host=$configs->host;
$db=$configs->db;
$db_user=$configs->db_user;
$db_pass=$configs->db_pass;

$result;

//$dbobject= mysqli_connect($host, $db_user, $db_pass, $db);
$dbobject = new mysqli($host, $db_user, $db_pass, $db);

$pwmd5=md5($object->pw);

//$qr="insert into user (username,pwd,vorname,nachname,email,is_admin,is_ldap) values ('".$object->uname."','"
//        .$pwmd5."','".$object->vname."','".$object->nname."','".$object->email."','".$object->isadmin."','".$object->isldap."')";

$qr='select `username`, `pwd` from user where `username`="'.$object->uname.'" and `pwd`="'.$pwmd5.'"';

$result=$dbobject->query($qr);

if($result && $result->num_rows)
{
    echo "result was true - success";
    while($z=$result->fetch_object())
    {
        echo $z->username." ".$z->pwd;
    }
}
else
{
    echo "result was false";
}
?>

