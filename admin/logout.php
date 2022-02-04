<?php

session_start();
session_destroy();

require_once __DIR__ . "/../helpers/functions.php";

redirect("admin/login.php");
