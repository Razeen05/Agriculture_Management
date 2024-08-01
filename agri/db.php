<?php
$conn = pg_connect("host=localhost dbname=ag user=postgres password=postgres");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
