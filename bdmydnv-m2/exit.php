<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["userId"]);
header("Location: /");