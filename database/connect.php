<?php

$host = "192.168.10.35";
$port = "5432";
$dbname = "petshop";
$user = "postgres";
$password = "28022026";

$conn = pg_connect(
    "host=$host port=$port dbname=$dbname user=$user password=$password"
);

if (!$conn) {
    die("Erro ao conectar com o banco de dados.");
}

?>