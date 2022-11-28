<?php
require("../index.php");
try {
    $dbh = new PDO($dsn, $user, $pwd);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->exec("DROP TABLE IF EXISTS pays");     
    $dbh->exec("CREATE TABLE IF NOT EXISTS pays (id INT AUTO_INCREMENT PRIMARY KEY,
                                   nom VARCHAR(250),
                                   code VARCHAR(240),
                                   drapeau VARCHAR(1000))");

} catch(PDOException $e){
    die(sprintf('<p class="error">Erreur SQL : <em>%s</em></p>' .
        "\n", htmlspecialchars($e->getMessage())));
};
?>