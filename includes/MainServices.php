<?php
class MainServices
{
    private $attributes = [
        'Intelligence' => 'int',
        'Strength' => 'str',
        'Universal' => 'uni',
        'Agility' => 'agi'
    ];
    private $search_bar_input;
    private $attr_filter;
    private $attributesIcons = [];
    private $complexity_diamond_src;
    public $heroes;


    public function __construct(string $json_file)
    {

        $this->complexity_diamond_src = 'https://cdn.akamai.steamstatic.com/apps/dota2/images/dota_react/herogrid/filter-diamond.png?';
        $this->search_bar_input = strtolower($this->getFormValue("search-bar-input"));
        $this->attr_filter = $this->getFormValue('attribute-filters[]') == '' ? [''] : $this->getFormValue('attribute-filters[]');

        foreach ($this->attributes as $attribute => $value) {
            $this->attributesIcons[$value] = "filter-{$value}-active.png";
        }
        $this->heroes = json_decode(file_get_contents($json_file));
    }

    public function displayComplexityDiamonds()
    {
        $maxComplexity = 3;

        for ($i = 1; $i <= $maxComplexity; $i++) {
            echo (
                "
            <input type='checkbox' id='image-checkbox-$i' name='complexity-filters[]' value='$i'>
                <label for='image-checkbox-$i'>
                    <img id='$i' class='complexity' src='$this->complexity_diamond_src'>
                </label>
            <style>
                input[type='checkbox']:checked + label img.complexity {
                    filter: none;
                }
            </style>
            "

            );
        };
    }

    public function heroes_table_creation()
    {
        $count = 0;
        foreach ($this->heroes as $hero) {
            $hero_name = strtolower(str_replace(array(' ', "'"), array('-', ''), $hero->localized_name));
            $hero_prim_ability = $hero->primary_attr;

            if (($this->hero_searched_in_bar($hero_name, $this->search_bar_input) && !$this->search_is_empty($this->search_bar_input) ||
                in_array($hero_prim_ability, $this->attr_filter) || $this->forms_are_empty($this->search_bar_input, $this->attr_filter))) {
                checkBeginRow($count);
                echo ("
                <td class='heroes-images px-2 py-2'>
                    <a href='detail.php/{$hero_name}'>
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
                checkEndRow($count, $this->heroes);
            }
        };
    }

    public function attributes_select_row()
    {
        $attributesIcons = $this->get_attr_icons();

        foreach ($attributesIcons as $attribute => $icon) {
            echo (
                "<input type='checkbox' id='image-checkbox-$attribute' name='attribute-filters[]' value='$attribute'>
                <label for='image-checkbox-$attribute'>
                    <img id='$attribute>' class='attributes' src='public/images/$icon'>
                </label>
            <style>
                input[type='checkbox']:checked + label img.attributes {
                    filter: none;
                }
            </style>"
            );
        };
    }

    public function getFormValue(string $form)
    {
        $form = explode('[', $form)[0];

        return isset($_GET[$form]) ? $_GET[$form] : '';
    }
    private function attr_filter_is_empty()
    {
        return $this->attr_filter[0] === '';
    }
    private function search_is_empty()
    {
        return $this->search_bar_input === '';
    }
    private function hero_searched_in_bar($hero_name, $search_bar)
    {
        return str_contains($hero_name, $search_bar);
    }

    private function forms_are_empty()
    {
        return $this->search_is_empty($this->search_bar_input) && $this->attr_filter_is_empty($this->attr_filter);
    }

    public function get_attr_icons()
    {
        return $this->attributesIcons;
    }
    public function get_attributes()
    {
        return $this->attributes;
    }
    public function console_log($value)
    {
        echo "<script>console.log(" . json_encode($value) . ")</script>";
    }
}
