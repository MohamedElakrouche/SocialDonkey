<?php
session_start();
session_unset(); 
session_destroy(); 


header("Location: connection_website.php");

exit();
