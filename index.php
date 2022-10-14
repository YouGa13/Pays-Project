<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Liste des pays</title>
</head>

<body>
    <header>
        <nav id="entete">
            <ul id="parent">
                <li class="parentLi">
                    <img src="./logo/logo.jpg" alt="ma photo"> 
                </li>
                <li id="children">
                    <ul id="childrenUl">
                        <li class="childrenLi">
                            <a href="index.php">Acceuil</a>
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
    <main>
        <section>
            <div class="create_database">
                <h2>Création de la base de données</h2>
                <?php
                // include_once("upload_file.php");
                ?>
            </div>
            <div class="upload_flags">
                <h2>Upload des drapeaux venant d'un fichier zip</h2>
                <?php
                // include_once("import_img.php");
                ?>
            </div>
            <div class="search">
                <h2>Rechercher un pays</h2>
                <?php
                // include_once("formulaire.html");
                ?>
            </div>
            <div class="countries_array">
                <h2>Liste des pays</h2>
                <?php
                // include_once("countries_array.php");
                ?>
            </div>
        </section>
    </main>
</body>

</html>