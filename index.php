<?php
require 'includes/MainServices.php';
$datas = 'includes/data/heroes.json';
$services = new mainServices($datas);
$PAGE_ATTRIBUTES = [
    'title' => 'Dota 2 Heroes',
];
$count = 0;
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

?>
<?php require_once 'includes/shared/head.php';?>
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
    <form method="get" class="heroes-filter d-flex align-items-center justify-content-between mx-auto text-center rounded mb-4">
        <h6>Filter Heroes</h6>
        <div class="d-flex align-items-center ">
            <div class="p-2 pe-3 flex-grow-1">Attributes</div>
            <?php $services->attributes_select_row(); ?>
        </div>
        <div class="d-flex align-items-center ">
            <div class="p-2 pe-3 flex-grow-1">Complexity</div>
            <?php $services->displayComplexityDiamonds(); ?>
        </div>
        <div data-bs-theme='dark' class="input-group w-25">
            <input id="search-bar-input" name="search-bar-input" type="search" class="form-control" placeholder="Search..." value="<?= $services->getFormValue('search-bar-input')?>">
            <button class="btn" type="submit" id="search-bar-button">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>
    <div>
        <table class="heroes-table  mb-4">
            <?php $services->heroes_table_creation(); ?>
        </table>
    </div>
    <div>
    </div>
</div>
</body>

</html>