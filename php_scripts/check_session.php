<?php

session_start();

function isSessionDown() {
    if (!isset($_SESSION['login'])) {
        header("Location: /~teterheo/");
        exit();
    }
}

function isSessionUp() {
    if (isset($_SESSION['login'])) {
        header("Location: /~teterheo/home");
        exit();
    }
}