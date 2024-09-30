<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/public/images/favicon.ico" type="image/x-icon">

    <!-- NOTE: Title is different for this page -->
    <title>Dota 2 - Anti-Mage</title>

    <!-- TODO: Remove CDN link and include Bootstrap files locally -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="/public/stylesheets/styles.css?v=<?php echo time(); ?>">

    <?php
    $url = $_SERVER['REQUEST_URI'];
    $lastPart = strtolower(basename($url));

    $apiUrl = "https://mapi.cegeplabs.qc.ca/web/heroes/$lastPart";
    $response = json_decode(file_get_contents($apiUrl), true);
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
    echo "<script>fetch('$apiUrl').then(response => response.json()).then(data => console.log(data))</script>";

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
    ?>

</head>

<body class="hero-background">
    <!-- 
        Pour cette page, il faut récupérer un paramètre de l'URL de manière à identifier le héro de manière unique (e.g. le "name" dans le JSON)
        À parti de cet identifiant, nous allons pouvoir aller chercher les données du héro pour pouvoir les afficher.

        Nous utiliserons ce site pour obtenir les données, car il contient les descriptions pour les héros.

        https://dotacoach.gg/_next/data/hQex-UdUEDib_3-cqnDNe/en/heroes/anti-mage.json

        - dota.heroes.npc_dota_hero_antimage.npedesc1
        - dota.heroes.npc_dota_hero_antimage.hype

        Vous pouvez récupérer les autres données à partir du fichier heroes.json ou vous pouvez les lire à partir du JSON retourné par l'API).
    -->

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
                        <h1><? echo $lastPart ?></h1>
                        <span class="subheading"><?php echo $response['pageProps']['messages']["dota.heroes.npc_dota_hero_$heroUrlName.npedesc1"]; ?></span>
                    </div>
                    <div>
                        <p>
                            <?php echo $response['pageProps']['messages']["dota.heroes.npc_dota_hero_$heroUrlName.hype"]; ?>
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
                    <?php
                    renderHero($heroUrlName);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-stats">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12 ">
                    <? echo "<img class='w100' src='https://cdn.akamai.steamstatic.com/apps/dota2/images/dota_react/heroes/{$heroUrlName}.png'>" ?>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12 d-flex flex-column align-items-start gap-2 border-end">
                    <?php
                    displayAttributes($attributes, $attributesIcons, $attributesGain);
                    ?>
                </div>
                <!-- TODO: The role bar got to be made -->
                <div class="col-md-7 col-sm-12 col-xs-12 ps-5">
                    <div class="row mb-2">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <span class="role">Carry</span>
                            <div class="role-bar has-role"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <span class="role">Support</span>
                            <div class="role-bar"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <span class="role">Nuker</span>
                            <div class="role-bar has-role"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <span class="role">Disabler</span>
                            <div class="role-bar"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <span class="role">Jungler</span>
                            <div class="role-bar"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <span class="role">Durable</span>
                            <div class="role-bar"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <span class="role">Escape</span>
                            <div class="role-bar has-role"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <span class="role">Pusher</span>
                            <div class="role-bar"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <span class="role">Initiator</span>
                            <div class="role-bar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>