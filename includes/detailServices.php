<?
class detailServices
{
    private $apiUrl;
    private $response;
    private $roles = [

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
    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->response = $this->call_api($this->apiUrl);
    }
    public function get_hero_description(){
        return $this->response['pageProps']['messages']["dota.heroes.npc_dota_hero_".$this->get_hero_url_name().".npedesc1"];
    }

    private function call_api()
    {
        return json_decode(file_get_contents($this->apiUrl), true);
    }
    public function get_hero_hype(){
        return $this->response['pageProps']['messages']["dota.heroes.npc_dota_hero_".$this->get_hero_url_name().".hype"];
    }
    public function get_roles_list()
    {
        return $this->roles;
    }
    public function get_json_heroes()
    {
        return json_decode(file_get_contents('includes/data/heroes.json'), true);
    }
    public function get_hero_url_name()
    {
        return $this->response['pageProps']['pageProps']['gameData']['npcShortName'];
    }
    public function get_hero_prim_ability()
    {
        return explode('.', $this->response['pageProps']['pageProps']['gameData']['primary_attr'])[1];
    }
    public function get_hero_attack_type()
    {
        return explode('DOTA_Chat_', $this->response['pageProps']['pageProps']['gameData']['attack_type'])[1];
    }
    public function get_attr_gains()
    {
        return array(
            $this->response['pageProps']['pageProps']['gameData']['strength_gain'],
            $this->response['pageProps']['pageProps']['gameData']['intelligence_gain'],
            $this->response['pageProps']['pageProps']['gameData']['agility_gain']
        );
    }
    public function get_hero_attributes()
    {
        return array(
            $this->response['pageProps']['pageProps']['gameData']['strength_base'],
            $this->response['pageProps']['pageProps']['gameData']['intelligence_base'],
            $this->response['pageProps']['pageProps']['gameData']['agility_base']
        );
    }
    public function get_attr_icons()
    {
        return array(
            '/public/images/str-icon.png' => 'Strength',
            '/public/images/int-icon.png' => 'Intelligence',
            '/public/images/agi-icon.png' => 'Agility'
        );
    }
    public function get_hero_roles(): array
    {
        $heroRoles = $this->response['pageProps']['pageProps']['gameData']['roles'];
        foreach ($heroRoles as $key => $value) {
            $newKey = explode('DOTA_HeroRole_', $key)[1];
            $heroRoles[$newKey] = $heroRoles[$key];
            unset($heroRoles[$key]);
        }
        return $heroRoles;
    }
    public function console_log($value)
    {
        echo "<script>console.log(" . json_encode($value) . ")</script>";
    }
    public function renderHero($heroUrlName)
    {
        echo '<video class="hero-render" poster="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/' . $heroUrlName . '.png" autoplay="" preload="auto" loop="" playsinline="">';
        echo '<source type="video/mp4; codecs=hvc1" src="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/' . $heroUrlName . '.mov">';
        echo '<source type="video/webm" src="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/' . $heroUrlName . '.webm">';
        echo '<img src="https://cdn.akamai.steamstatic.com/apps/dota2/videos/dota_react/heroes/renders/' . $heroUrlName . '.png">';
        echo '</video>';
    }
    public function displayAttributes($attributes, $attributesGain)
    {
        $count = 0;
        foreach ($attributes as $key => $attribute) {
            $icon = array_keys($this->get_attr_icons())[$key];
            $alt = $this->get_attr_icons()[$icon];
            echo '<div class="d-flex align-items-center gap-2">';
            echo '<img src="' . $icon . '" width="38" height="38" alt="' . $alt . '">';
            echo '<span class="stat">' . $attribute . '</span>';
            echo '<span class="stat-increase">+' . $attributesGain[$count] . '</span>';
            echo '</div>';
            $count++;
        }
    }
    public function displayRoles($roles, $heroRoles)
    {
        for ($i = 0; $i < count($roles); $i++) {
            $width = '0';
            $roleName = $roles[$i]['name'];

            if (isColumnDebut($i)) {
                echo '<div class="row mb-2">';
            }
            echo '<div class="col-md-4 col-sm-4 col-xs-6">';
            echo '<span class="role">' . $roleName . '</span>';
            if (array_key_exists($roleName, $heroRoles)) {
                $width = $this->calculateWidth($heroRoles[$roleName]);
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

    public function getLocalized_name($heroUrlName)
    {
        foreach ($this->get_json_heroes() as $hero) {
            if (str_contains(explode('npc_dota_hero_', $hero['name'])[1], $heroUrlName)) {
                return $hero['localized_name'];
            }
        }
    }
    function displayHeroType($primaryAbility)
    {
        echo "<img src='/public/images/" . substr($primaryAbility, 0, 3) . "-icon.png' width='32' height='32' alt='$primaryAbility'>";
        echo "<span> $primaryAbility</span>";
    }
    function displayAttackType($attackType)
    {
        echo "<img src='/public/images/" . strtolower($attackType) . ".svg' width='32' height='32' alt='$attackType'>";
        echo "<span class = 'ps-2'>$attackType </span>";
    }
    private function calculateWidth($rating)
    {
        return floor(($rating / 3) * 100);
    }
}
