<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./public/images/favicon.ico" type="image/x-icon">

    <!-- NOTE: Title is different for this page -->
    <title>Dota 2 - Anti-Mage</title>

    <!-- TODO: Remove CDN link and include Bootstrap files locally -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./public/stylesheets/styles.css">

    <!-- 
        TODO: Ce code JavaScript doit être enlevé. Le code est pour vous montrer l'exemple du fetch et des propriétés à utiliser pour accéder aux descriptions 
              Vous devez faire le call à l'API en PHP directement et non en JavaScript (e.g. le code ci-dessous doit être migré dans l'équivalent en PHP).
     -->
    <script type="module">
        fetch("https://dotacoach.gg/_next/data/hQex-UdUEDib_3-cqnDNe/en/heroes/anti-mage.json")
            .then(response => response.json())
            .then(data => {
                console.log(data.pageProps.messages["dota.heroes.npc_dota_hero_antimage.npedesc1"]);
                console.log(data.pageProps.messages["dota.heroes.npc_dota_hero_antimage.hype"])
            });
    </script>

</head>

<body class="hero-background">
    <!-- 
        Pour cette page, il faut récupérer un paramètre de l'URL de manière à identifier le héro de manière unique (e.g. le "name" dans le JSON)
        À parti de cet identifiant, nous allons pouvoir aller chercher les données du héro pour pouvoir les afficher.

        Nous utiliserons ce site pour obtenir les données, car il contient les descriptions pour les héros.

        https://dotacoach.gg/_next/data/hQex-UdUEDib_3-cqnDNe/en/heroes/anti-mage.json

        - dota.heroes.npc_dota_hero_antimage.npedesc1
        - dota.heroes.npc_dota_hero_antimage.hype

        Vous pouvez récupérer les autres données à partir du fichier heroes.json (ou vous pouvez les lire à partir du JSON retourné par l'API).
    -->

    <div>
        <div class="hero-background-gradient"></div>

        <div class="container">
            <div class="row">
                <div class="col-6 gy-5">
                    <div class="mb-5">
                        
                        <a href="index.php"><i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                    <div class="hero-type | mb-2">
                        <img src="./public/images/agi-icon.png" width="32" height="32" alt="Agility">
                        <span>Agility</span>
                    </div>
                    <div class="mb-3">
                        <h1>Anti-Mage</h1>
                        <span class="subheading">Slashes his foes with mana-draining attacks</span>
                    </div>
                    <div>
                        <p>
                            Should Anti-Mage have the opportunity to gather his full strength, few can stop his
                            assaults. Draining mana from enemies with every strike or teleporting short distances to
                            escape an ambush, cornering him is a challenge for any foe.
                        </p>
                    </div>
                    <div>
                        <div class="secondary">Attack Type</div>
                        <img src="./public/images/melee.svg" width="24" height="24">
                        <span>Melee</span>
                    </div>
                </div>
                <div class="col-6">
                    <video class="hero-render"
                        poster="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/antimage.png"
                        autoplay="" preload="auto" loop="" playsinline="">
                        <source type="video/mp4; codecs=hvc1"
                            src="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/antimage.mov">
                        <source type="video/webm"
                            src="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/antimage.webm">
                        <img
                            src="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/antimage.png">
                    </video>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-stats">
        <div class="container py-5">
            <div class="row">
                <div class="col-3">
                    <img src="https://cdn.akamai.steamstatic.com/apps/dota2/images/dota_react/heroes/antimage.png">
                </div>
                <div class="col-2 d-flex flex-column align-items-start gap-2 border-end">
                    <div class="d-flex align-items-center gap-2">
                        <img src="./public/images/str-icon.png" width="38" height="38" alt="Strength">
                        <span class="stat">19</span>
                        <span class="stat-increase">+1.6</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <img src="./public/images/agi-icon.png" width="38" height="38" alt="Agility">
                        <span class="stat">24</span>
                        <span class="stat-increase">+2.8</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <img src="./public/images/int-icon.png" width="38" height="38" alt="Intelligence">
                        <span class="stat">12</span>
                        <span class="stat-increase">+1.8</span>
                    </div>
                </div>
                <div class="col-4 ps-5">
                    <div class="row mb-2">
                        <div class="col-4">
                            <span class="role">Carry</span>
                            <div class="role-bar has-role"></div>
                        </div>
                        <div class="col-4">
                            <span class="role">Support</span>
                            <div class="role-bar"></div>
                        </div>
                        <div class="col-4">
                            <span class="role">Nuker</span>
                            <div class="role-bar has-role"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <span class="role">Disabler</span>
                            <div class="role-bar"></div>
                        </div>
                        <div class="col-4">
                            <span class="role">Jungler</span>
                            <div class="role-bar"></div>
                        </div>
                        <div class="col-4">
                            <span class="role">Durable</span>
                            <div class="role-bar"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <span class="role">Escape</span>
                            <div class="role-bar has-role"></div>
                        </div>
                        <div class="col-4">
                            <span class="role">Pusher</span>
                            <div class="role-bar"></div>
                        </div>
                        <div class="col-4">
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