<?php
$maxComplexity = 3;
$datas = file_get_contents('./data/heroes.json');
$heroes = json_decode($datas);
$count = 0;
$attributes = [
    'Intelligence' => 'int',
    'Strength' => 'str',
    'Universal' => 'uni',
    'Agility' => 'agi'
];
$attributesIcons = [
    'int' => "filter-{$attributes['Intelligence']}-active.png",
    'str' => "filter-{$attributes['Strength']}-active.png",
    'agi' => "filter-{$attributes['Agility']}-active.png",
    'uni' => "filter-{$attributes['Universal']}-active.png",
];
function createHeroesTable($heroes)
{
    $inputValue = strtolower(getFormValue());
    $count = 0;
    foreach ($heroes as $hero) {
        $heroName = strtolower(str_replace(array(' ', "'"), array('-', ''), $hero->localized_name));
        if (strpos($heroName, $inputValue) !== false || $inputValue === '') {
            checkBeginRow($count);
            echo ("
                <td class='heroes-images px-2 py-2'>
                    <a href='detail.php/{$heroName}'>
                        <div class='image-overlay'>
                            <img src='https://cdn.akamai.steamstatic.com/{$hero->img}'>
                            <div class='overlay justify-content-start'>
                                <div class='overlay-elements d-flex justify-content-start gap-2 align-items-center'>
                                    <img src='public/images/{$hero->primary_attr}-icon.png'>
                                    <span>{$hero->localized_name}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </td>
            ");
            $count++;
            checkEndRow($count, $heroes);
        }
    };
}
function displayAttributes($attributesIcons)
{
    $id = 0;
    foreach ($attributesIcons as $icon) {
        echo (
            "   
                <div>
                    <img id='attribute-$id' role='button' tabindex='-1' aria-pressed='false'class='img-fluid attributes' src='public/images/{$icon}'>
                </div>"
        );
        $id++;
    };
}

function displayComplexityDiamonds($maxComplexity)
{
    for ($i = 0; $i < $maxComplexity; $i++) {
        echo (
            "<div><img role='button' id ='complexity-$i' tabindex='$i' aria-pressed='false' class='img-fluid complexity' src='https://cdn.akamai.steamstatic.com/apps/dota2/images/dota_react/herogrid/filter-diamond.png?'></div>"
        );
    };
}

function checkBeginRow($count)
{
    if ($count % 5 == 0) {
        echo "<tr>";
    }
}
function checkEndRow($count, $heroes)
{
    if ($count % 5 == 0 || $count == count(get_object_vars($heroes))) {
        echo "</tr>";
    }
}
function console_log($value)
{
    echo "<script>console.log(" . $value . ")</script>";
}
function getFormValue()
{
    return isset($_GET['search-bar-input']) ? $_GET['search-bar-input'] : '';
}

?>


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            Une fois le fonctionnement est fait sans le JavaScript, nous pouvons intégrer la librairie HTMX pour un côté dynamique pour un rafraîchissement partiel de la page.
        -->
        <div class="heroes-filter d-flex align-items-center justify-content-between mx-auto text-center rounded mb-4">
            <h6>Filter Heroes</h6>
            <div class="d-flex attributes align-items-center ">
                <div class="p-2 pe-3 flex-grow-1">Attributes</div>
                <?php displayAttributes($attributesIcons); ?>
            </div>
            <div class="d-flex attributes align-items-center ">
                <div class="p-2 pe-3 flex-grow-1">Complexity</div>
                <!--TODO : Change the css for the complexity so it does not affect the attributes and make it cumulative-->
                <?php displayComplexityDiamonds($maxComplexity); ?>
            </div>
            <form method="get" data-bs-theme='dark' class="input-group w-25 ">
                <button class="btn" type="submit" id="search-bar-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input id="search-bar-input" name="search-bar-input" type="search" class="form-control" placeholder="Search..." autocomplete="off">
            </form>
        </div>
        <div>
            <table class="heroes-table  mb-4">
                <?php createHeroesTable($heroes); ?>
            </table>
        </div>
        <div>

        </div>
    </div>
</body>

</html>