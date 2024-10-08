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
    <form method="get" class="heroes-filter d-flex align-items-center justify-content-between mx-auto text-center rounded mb-4">
        <h6>Filter Heroes</h6>
        <div class="d-flex align-items-center ">
            <div class="p-2 pe-3 flex-grow-1">Attributes</div>
            <?php $services->attributes_select_row(); ?>
        </div>
        <div class="d-flex align-items-center ">
            <div class="p-2 pe-3 flex-grow-1">Complexity</div>
            <?php $services->complexity_select_row(); ?>
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