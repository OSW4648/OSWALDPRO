<?php
session_name("INV");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>