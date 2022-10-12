<?php
require_once("/bdd/index.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    
</body>
</html>