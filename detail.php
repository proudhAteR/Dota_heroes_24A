<?php
require 'includes/detailServices.php';

$url = $_SERVER['REQUEST_URI'];
$lastPart = strtolower(basename($url));
$PAGE_ATTRIBUTES = [
    'title' => "Dota 2 | $lastPart",
];
$apiUrl = "https://mapi.cegeplabs.qc.ca/web/heroes/$lastPart";
$service = new detailServices($apiUrl);
$response = json_decode(file_get_contents($apiUrl), true);;
$JSON_heroes = $service->get_json_heroes();
$heroUrlName = $service->get_hero_url_name();
$primaryAbility = $service->get_hero_prim_ability();
$attackType = $service->get_hero_attack_type();
$attributes = $service->get_hero_attributes();
$attributesGain = $service->get_attr_gains();


$heroRoles = $service->get_hero_roles();
$roles = $service->get_roles_list();


function isColumnDebut($index)
{
    return $index % 3 == 0;
}
function isColumnEnd($index, $array)
{
    return $index % 3 == 2 || $index == count($array) - 1;
}

?>


<?php require_once 'includes/shared/head.php' ?>
<div>
    <div class="hero-background-gradient"></div>
    <div class="container">
        <div class="row">
            <div class="col-6 gy-5">
                <div class="mb-5">

                    <a href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>
                </div>
                <div class="hero-type | mb-2">
                    <?php $service->displayHeroType($primaryAbility) ?>
                </div>
                <div class="mb-3">
                    <h1><?= $service->getLocalized_name($heroUrlName) ?></h1>
                    <span class="subheading"><?= $response['pageProps']['messages']["dota.heroes.npc_dota_hero_$heroUrlName.npedesc1"]; ?></span>
                </div>
                <div>
                    <p>
                        <?= $response['pageProps']['messages']["dota.heroes.npc_dota_hero_$heroUrlName.hype"]; ?>
                    </p>
                </div>
                <div>
                    <div class="secondary">Attack Type</div>
                    <div class="d-flex justify-evenly">
                        <?php
                        $service->displayAttackType($attackType)
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <?php $service->renderHero($heroUrlName); ?>
            </div>
        </div>
    </div>
</div>

<div class="hero-stats">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12 ">
                <?= "<img class='w100' src='https://cdn.akamai.steamstatic.com/apps/dota2/images/dota_react/heroes/{$heroUrlName}.png'>" ?>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12 d-flex flex-column align-items-start gap-2 border-end">
                <?php $service->displayAttributes($attributes, $attributesGain); ?>
            </div>

            <div class="col-md-7 col-sm-12 col-xs-12 ps-5">
                <?php $service->displayRoles($roles, $heroRoles); ?>
            </div>

        </div>
    </div>
</div>
</body>

</html>