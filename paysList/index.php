<?php
require_once('../bdd/index.php');
try {
    $dbh = new PDO($dsn, $user, $pwd);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $res = $dbh->query("SELECT * FROM pays");
    $countries = $res->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listes des pays</title>
    <style>
        .drapeau_country {
            width: 150px;
        }

        svg {
            width: 150px;
            max-height: 3rem;
        }
    </style>
</head>
<body>
<div class="countries_array">
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Drapeau</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($countries as $country) { ?>
                    <tr>
                        <td>
                            <a class="id_country" href="http://localhost/php/Projet_php/update_country.php?id=<?= $country['id'] ?>" target="_blank"><?= $country['id'] ?></a>
                        </td>
                        <td>
                            <p class="nom_country"> <?= $country['nom'] ?></p>
                        </td>
                        <td>
                            <p class="code_country"> <?= $country['code'] ?></p>
                        </td>
                        <td>
                            <?php 
                                
                                if ($country['drapeau'] == NULL) {echo "pas de drapeau"; } else{
                                $last_file = basename($country['drapeau']);
                                $fileName = explode('.', $last_file);
                                $imgExtension = $fileName[1];
                                if ($imgExtension == "gif") {
                                    echo "cette image est en GIF";
                                } elseif ($imgExtension == "png" ) {
                                    echo "cette image est en PNG";
                                } elseif ($imgExtension == "jpg" ) {
                                    echo "cette image est en JPG";
                                } else {
                            echo file_get_contents( $country['drapeau']) ;}}?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
<?php } catch (PDOException $myexep) {
    die(sprintf('<p class="error">Erreur SQL : <em>%s</em></p>' .
        "\n", htmlspecialchars($myexep->getMessage())));
}
?>
</body>
</html>