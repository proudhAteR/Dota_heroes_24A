<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./public/images/favicon.ico" type="image/x-icon">
    <title>Dota 2 Heroes</title>

    <!-- TODO: Remove CDN link and include Bootstrap files locally -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="./public/stylesheets/styles.css">
</head>
<body class="hero-background">
    <div class="container">
        <div class="text-center py-5">
            <h1>Choose your Hero</h1>
            <p>From magical tacticians to fierce brutes and cunning rogues, Dota 2's hero pool is massive and limitlessly diverse. Unleash incredible abilities and devastating ultimates on your way to victory.</p>
        </div>
        <!--
            Pour cette page, refaite un layout similaire à: https://www.dota2.com/heroes
                1) Titre Choose your Hero
                2) Paragraphe de texte
                3) La barre de filtres
                4) La liste des héros
                5) Un effet de hover pour afficher le nom et l'attribut principal du héro (Force, Agilité, Intelligence, Universel)
        -->

        <!--
            Pour les filtres, il faudra ajouter un formulaire contenant :
                1) Des cases à cocher (checkbox) pour les attributs (Force, Agilité, Intelligence, Universel)
                2) Un champ de texte pour pouvoir entre du texte (e.g. le nom d'un héro)
                3) Un bouton pour pouvoir faire la recherche
            La recherche se fera côté serveur en PHP. Il faudra récupérer les attributs qu'on veut filtrer (Force, Agilité, Intelligence, Universel) et le nom du héro à filter.
                1) Si aucun filtre n'est sélectionné et que rien n'est entré dans le champ de texte, on affiche tous les héros (affichage par défaut)
                2) Si un ou plusieurs filtres sont sélectionnés, nous faisons le filtre sur ces éléments :
                    - Si nous avons une valeur dans le champ de texte, nous filtrons sur le nom des héros et affichons tous les héros ayant la valeur dans leur nom (e.g. ard ==> Arc Warden)
                    - Si nous sélectionnons un ou des attributs, nous faisons un filtre par OU (e.g. si on choisit Force et Intelligence, nous affichons les héros sont de type Force ou Intelligence)
                    - Les deux filtres se combinent (e.g. le nom et les attributs).
            ATTENTION: Toute la logique des filtres doit fonctionner sans aucun JavaScript! Tout doit être fait côté serveur en PHP.
            Une fois le fonctionnement est fait sans le JavaScript, nous pouvons intégrer la librairie HTMX pour un côté dynamique pour un rafraichissement partiel de la page.
        -->
        <div>
            FILTERS
        </div>

        <div>
            <table class="heroes-table m-auto" >
                <?php
                    $datas = file_get_contents('./data/heroes.json');
                    $heroes = json_decode($datas);

                    $count = 0;
                    foreach($heroes as $hero){
                        checkBeginRow($count);
                        echo "<td class ='heroes-images px-2 py-2' ><a href='detail.php'><img src='https://cdn.akamai.steamstatic.com/{$hero->img}'></a></td>";
                        $count++;
                        checkEndRow($count, $heroes);
                    };
                    function checkBeginRow($count){
                        if ($count % 5 == 0) {
                            echo "<tr>";
                        }
                    }
                    function checkEndRow($count, $heroes){
                        if ($count % 5 == 0 || $count == count(get_object_vars($heroes))) {
                            echo "</tr>";
                        }
                    }
                ?>
            </table>            
        </div>
        <div>
            
        </div>
    </div>
</body>
</html>