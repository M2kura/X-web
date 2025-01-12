<?php
/**
 * Logouts the user by destroing his session
 */
session_start();
session_unset();
session_destroy();
header("Location: /~teterheo/");
exit();
