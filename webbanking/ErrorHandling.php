<?php
// A user-defined error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<b>Error:</b> [$errno]<br>";
    echo "Error Triggered<br>";
}

// Set user-defined error handler function
set_error_handler("myErrorHandler");

?>
