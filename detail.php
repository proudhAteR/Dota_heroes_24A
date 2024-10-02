<?php
$url = $_SERVER['REQUEST_URI'];
$lastPart = strtolower(basename($url));

$PAGE_ATTRIBUTES = [
    'title' => "Dota 2 | $lastPart",
];
$apiUrl = "https://mapi.cegeplabs.qc.ca/web/heroes/$lastPart";
$response = json_decode(file_get_contents($apiUrl), true);
$JSON_heroes = json_decode(file_get_contents('includes/data/heroes.json'), true);
$heroUrlName = $response['pageProps']['pageProps']['gameData']['npcShortName'];
$primaryAbility = explode('.', $response['pageProps']['pageProps']['gameData']['primary_attr'])[1];
$attackType = explode('DOTA_Chat_', $response['pageProps']['pageProps']['gameData']['attack_type'])[1];
$attributes = array(
    $response['pageProps']['pageProps']['gameData']['strength_base'],
    $response['pageProps']['pageProps']['gameData']['intelligence_base'],
    $response['pageProps']['pageProps']['gameData']['agility_base']
);
$attributesIcons = array(
    '/public/images/str-icon.png' => 'Strength',
    '/public/images/int-icon.png' => 'Intelligence',
    '/public/images/agi-icon.png' => 'Agility'
);
$attributesGain = array(
    $response['pageProps']['pageProps']['gameData']['strength_gain'],
    $response['pageProps']['pageProps']['gameData']['intelligence_gain'],
    $response['pageProps']['pageProps']['gameData']['agility_gain']
);
$render = $response['pageProps']['pageProps']['pathname'];

$heroRoles = $response['pageProps']['pageProps']['gameData']['roles'];
foreach ($heroRoles as $key => $value) {
    $newKey = explode('DOTA_HeroRole_', $key)[1];
    $heroRoles[$newKey] = $heroRoles[$key];
    unset($heroRoles[$key]);
}
$roles = [

    ['name' => 'Carry'],
    ['name' => 'Support'],
    ['name' => 'Nuker'],
    ['name' => 'Disabler'],
    ['name' => 'Jungler'],
    ['name' => 'Durable'],
    ['name' => 'Escape'],
    ['name' => 'Pusher'],
    ['name' => 'Initiator'],

];

console_log($response);

function console_log($value)
{
    echo "<script>console.log(" . json_encode($value) . ")</script>";
}
function renderHero($heroUrlName)
{
    echo '<video class="hero-render" poster="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/' . $heroUrlName . '.png" autoplay="" preload="auto" loop="" playsinline="">';
    echo '<source type="video/mp4; codecs=hvc1" src="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/' . $heroUrlName . '.mov">';
    echo '<source type="video/webm" src="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/' . $heroUrlName . '.webm">';
    echo '<img src="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/' . $heroUrlName . '.png">';
    echo '</video>';
}
function displayAttributes($attributes, $attributesIcons, $attributesGain)
{
    $count = 0;
    foreach ($attributes as $key => $attribute) {
        $icon = array_keys($attributesIcons)[$key];
        $alt = $attributesIcons[$icon];
        echo '<div class="d-flex align-items-center gap-2">';
        echo '<img src="' . $icon . '" width="38" height="38" alt="' . $alt . '">';
        echo '<span class="stat">' . $attribute . '</span>';
        echo '<span class="stat-increase">+' . $attributesGain[$count] . '</span>';
        echo '</div>';
        $count++;
    }
}
function displayRoles($roles, $heroRoles)
{
    for ($i = 0; $i < count($roles); $i++) {
        $width = '0';
        $roleName = $roles[$i]['name'];
        
        if (isColumnDebut($i)) {
            echo '<div class="row mb-2">';
        }
        echo '<div class="col-md-4 col-sm-4 col-xs-6">';
        echo '<span class="role">'.$roleName.'</span>';
        if (array_key_exists($roleName , $heroRoles)) {
            $width = calculateWidth($heroRoles[$roleName] );
        }
        echo '<div class="role-bar-wrapper">';
        echo "<div class='role-bar" . ($width != 0 ? " has-role" : "") . "' style='width: {$width}%'></div>";
        echo '</div>';
        echo '</div>';
        if (isColumnEnd($i, $roles)) {
            echo '</div>';
        }
    }
}
function getLocalized_name($JSON_heroes, $heroUrlName){
    foreach($JSON_heroes as $hero){
        if(str_contains(explode('npc_dota_hero_',$hero['name'])[1], $heroUrlName)){
            return $hero['localized_name'];
        }
        
    }
}
function calculateWidth($rating){
    return floor(($rating / 3) * 100);
}
function isColumnDebut($index){
    return $index % 3 == 0 ;
}
function isColumnEnd($index, $array){
    return $index % 3 == 2 || $index == count($array) - 1;
}
?>
<?php require_once 'includes/shared/head.php'?>
    <div>
        <div class="hero-background-gradient"></div>
        <div class="container">
            <div class="row">
                <div class="col-6 gy-5">
                    <div class="mb-5">

                        <a href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                    <div class="hero-type | mb-2">
                        <?php
                        echo "<img src='/public/images/" . substr($primaryAbility, 0, 3) . "-icon.png' width='32' height='32' alt='$primaryAbility'>";
                        echo "<span> $primaryAbility</span>"
                        ?>

                    </div>
                    <div class="mb-3">
                        <h1><?= getLocalized_name($JSON_heroes, $heroUrlName) ?></h1>
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
                            echo "<img src='/public/images/" . strtolower($attackType) . ".svg' width='32' height='32' alt='$attackType'>";
                            echo "<span class = 'ps-2'>$attackType </span>"
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <?php renderHero($heroUrlName);?>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-stats">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12 ">
                    <?="<img class='w100' src='https://cdn.akamai.steamstatic.com/apps/dota2/images/dota_react/heroes/{$heroUrlName}.png'>" ?>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12 d-flex flex-column align-items-start gap-2 border-end">
                    <?php displayAttributes($attributes, $attributesIcons, $attributesGain);?>
                </div>
        
                <div class="col-md-7 col-sm-12 col-xs-12 ps-5">
                    <?php displayRoles($roles, $heroRoles);?>
                </div>

            </div>
        </div>
    </div>
</body>

</html>