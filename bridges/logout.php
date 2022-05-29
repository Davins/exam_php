<?php 
// start the session, then destroy it and redirect to index page
session_start();
session_destroy();
header('location: ../index.php');
