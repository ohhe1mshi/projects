<?php
require_once('functions.php');



$userName = 'Дмитрий';

const HOST = "localhost";
const USER = "root";
const PASSWORD = "";
const DB = "rsaherya_m2";
$con = mysqli_connect(HOST, USER, PASSWORD, DB);
mysqli_set_charset($con, "utf8");
session_start();
