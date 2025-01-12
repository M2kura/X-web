<?php

session_start();
/**
 * Redirecting to the home page if session is active
 */
function isSessionDown() {
    if (!isset($_SESSION['login'])) {
        header("Location: /~teterheo/");
        exit();
    }
}

/**
 * Redirecting to the login page if session is down
 */
function isSessionUp() {
    if (isset($_SESSION['login'])) {
        header("Location: /~teterheo/home");
        exit();
    }
}
