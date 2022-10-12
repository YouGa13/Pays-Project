<?php
require_once("../../bdd/index.php");
try {
    $dbh = new PDO($dsn, $user, $pwd);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'envoi de fichier</title>    
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <header>
        <nav id="entete">
            <ul id="parent">
                <li class="parentLi">
                    <img src="../../logo/logo.jpg" alt="ma photo"> 
                </li>
                <li id="children">
                    <ul id="childrenUl">
                        <li class="childrenLi">
                            <a href="../index.php">Acceuil</a>
                        </li>
                        <li class="childrenLi">
                            <a href="test.html">Envoyer le fichier CSV</a>
                        </li>
                        <li class="childrenLi">
                            <a href="">Envoyer le fichier Zip</a>
                        </li>
                        <li class="childrenLi">
                            <a href="">Liste des pays</a>
                        </li>
                        <li class="childrenLi">
                            <a href="">A propos du site</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <section>
    <div class="form">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="file">Fichier Csv</label>
            <input type="file" name="file"> <br>
            <input type="submit" value="Upload">
        </form>
    </div>
    <?php
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $file_name = $file['name'];
        $file_tmp_name = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $file_type = $file['type'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext)); // end() Positionne le pointeur de tableau en fin de tableau et retourne sa valeur
        $allowed = array('csv');

        $table_name = "pays";
        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 2097152) {
                    $file_name_new = uniqid('', true) . '.' . $file_ext; // uniqid() génère un identifiant unique
                    $file_destination = 'C:\xampp_djibril\htdocs\Pays Project\upload\fileCSV\a' . $file_name_new;
                    if (move_uploaded_file($file_tmp_name, $file_destination)) {
                        try {
                            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                                if ($csv_file = fopen($file_destination, 'r')) {
                                    while ($line = fgetcsv($csv_file, 0, ",")) {
                                        $sql = $dbh->prepare("INSERT INTO $table_name (id, nom, code) VALUES (:id, :nom, :code)");
                                        $sql->execute([
                                            'id' => $line[0],
                                            'nom' => $line[1],
                                            'code' => $line[2],
                                        ]);
                                    }
                                    fclose($csv_file);
                                    unlink($file_destination);
                                } else {
                                    printf('<p class="error">Le fichier <samp>%s</samp> ne peut pas être ouvert en lecture.</p>' . "\n", $file_destination);
                                }
                        } catch (PDOException $myexep) {
                            die(sprintf('<p class="error">la connexion à la base de données à été refusée <em>%s</em></p>' .
                                "\n", htmlspecialchars($myexep->getMessage())));
                        }
                    } else {
                        echo 'Not Uploaded';
                    }
                } else {
                    echo 'File too big';
                }
            } else {
                echo 'There was an error';
            }
        } else {
            echo 'File type not allowed';
        }
    }
    ?>
   </section>
    <footer>
    </footer>
</body>
</html>

<?php

} catch (PDOException $e){
    die(sprintf('<p class="error">Erreur SQL : <em>%s</em></p>' .
        "\n", htmlspecialchars($e->getMessage())));
}

?>