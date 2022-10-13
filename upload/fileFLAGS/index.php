<?php
require_once("../../bdd/index.php");
try {
    $dbh = new PDO($dsn, $user, $pwd);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
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
            <label for="file">Fichier Zip</label>
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
        $allowed = array('zip');

        $table_name = "pays";
        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 2097152) {
                    $file_name_new = uniqid('', true) . '.' . $file_ext; // uniqid() génère un identifiant unique
                    $file_destination = __DIR__."&#92;flags&#92;" . $file_name_new;
                    if (move_uploaded_file($file_tmp_name, $file_destination)) {
                        $zip = new ZipArchive();
                        if ($zip->open($file_destination)) {
                            $zip->extractTo('flags');
                            $zip->close();

                            $files = scandir(__DIR__."\\flags\\flags"); // Liste les fichiers et dossiers dans un dossier
                            foreach ($files as $file) {
                                if ($file != '.' && $file != '..') {
                                    $file_path = __DIR__ . '\\flags\\flags\\' . $file;
                                    $fileName = explode('.', basename($file_path));
                                    $contryCode = $fileName[0];
                                    $img = file_get_contents($file_path);
                                    if (isset($img)){
                                        $sql = $GLOBALS['dbh']->prepare("UPDATE $table_name SET drapeau = ? WHERE code = ?");
                                        $sql->execute([$img, $contryCode]);
                                    }
                                }
                            }
                            echo "<p class='success'>Le fichier $file_name a été uploadé avec succès</p>";
                            unlink($file_destination);
                            array_map('unlink', glob("flags/*.*"));
                            rmdir('flags\\flags');
                        } else {
                            printf('<p class="error">Le fichier <samp>%s</samp> ne peut pas être ouvert en lecture.</p>' . "\n", $file_destination);
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