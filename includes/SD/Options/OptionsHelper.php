<?php
namespace SD\Options;

use Roots\Sage\Assets;

/**
 * Klasa do pobierania opcji. Skonfigurowana do współpracy z CMB2.
 */
class OptionsHelper{

    /**
     * Zawiera prefiks opcji.
     *
     * @var string
     */
    public static $prefix = 'dhlk_';

    /**
     * Zawiera instancję.
     *
     * @var null|SD\Options\OptionsHelper
     */
    protected static $instance = null;

    /**
     * Zawiera domyślne wartości opcji.
     *
     * @var string
     */
    protected $dflts;

    /**
     * Zawiera domyślne wartości opcji.
     *
     * @var array
     */
    protected static $defaults = [
        'general' => [
            // 'front_header' => 'Łączymy ludzi.<br/> Zmieniamy rzeczywistość.',
            // 'front_text' => 'Zacznij swoją podróż z DHL Express.',
            // 'front_button' => 'Poznaj nas bliżej',
            'cookies_consent' => 'Stosujemy pliki cookie na naszej stronie internetowej. Pliki cookie są stosowane do poprawy działania i korzystania z naszej strony Internetowej, a także dla celów analitycznych i reklamowych. Aby dowiedzieć się więcej na temat plików cookie, sposobu ich wykorzystania oraz sposobu zmiany ustawień cookie, dowiedz się więcej <a href="http://www.dhl.com.pl/pl/zasady_korzystania_ze_strony_internetowej.html#privacy" target="_blank" data-close-cookies>tutaj</a>. Korzystając z tej strony bez zmiany ustawień, wyrażasz zgodę na stosowanie plików cookie.',
            'scroll_down' => 'Przejdź dalej',
        ],

        'front_discover' => [
            'title' => 'Poznaj DHL Express',
            'text' => 'Praca w DHL Express? To nie tylko imponujące statystyki doręczonych przesyłek. To również działalność społeczna i realizowanie wspólnych pasji naszych pracowników. Zobacz jak pracujemy i co u nas nowego!',
        ],

        'videos' => [
            'header' => 'To ludzie tworzą niepowtarzalną atmosferę w DHL Express',

            'videos' => [
                0 => [
                    'url' => 'http://www.youtube.com/watch?v=8byVjOsnLNY',
                    'image' => false,
                    'title' => 'I am DHL',
                    'desc' => 'Zobacz, że praca w DHL Express to więcej, niż dostarczanie przesyłek.',
                ],

                1 => [
                    'url' => 'http://www.youtube.com/watch?v=Dh8sz--I8jg',
                    'image' => false,
                    'title' => 'EuroCup',
                    'desc' => 'Zobacz, jak drużyny z&nbsp;całej Europy grają do jednej bramki.',
                ],

                2 => [
                    'url' => 'http://www.youtube.com/watch?v=GWC17HEjDjI',
                    'image' => false,
                    'title' => 'Człowiek Roku',
                    'desc' => 'Zobacz, jak najlepsi z najlepszych chodzą po czerwonym dywanie.',
                ],
            ],
        ],

        'custom_content' => [
            'button_text' => 'Zobacz więcej'
        ],

        'prizes' => [
            'title' => 'Nagrody i wyróżnienia',
            'text' => 'Tworzymy angażujące, przyjazne, uczciwe i atrakcyjne miejsce pracy. Potwierdzają to liczne nagrody i wyróżnienia.',

            'prizes' => [
                0 => [
                    'title' => 'TOP EMPLOYER GLOBAL',
                    'text' => 'DHL Express to  jedyna firma na świecie, która uzyskała ten certyfikat na każdym kontynencie.',
                    'image' => false,
                ],

                1 => [
                    'title' => 'TOP EMPLOYER EUROPE',
                    'text' => 'Certyfikat przyznany za postawę wspierającą rozwój pracowników.',
                    'image' => false,
                ],

                2 => [
                    'title' => 'TOP EMPLOYER POLAND',
                    'text' => 'Certyfikat potwierdzający wyjątkową troskę o pracowników w różnych obszarach.',
                    'image' => false,
                ],

                3 => [
                    'title' => 'Jakość Obsługi 2018',
                    'text' => 'Wybór konsumentów potwierdzający najwyższą dbałość o potrzeby i oczekiwania Klientów.',
                    'image' => false,
                ],

                4 => [
                    'title' => 'Najwyższa Jakość',
                    'text' => 'Złote Godło dla usług celnych w programie Najwyższa Jakość Quality International 2017.',
                    'image' => false,
                ],

                5 => [
                    'title' => 'Marka Godna Zaufania',
                    'text' => 'Pożądany pracodawca w 2016 roku w opinii specjalistów i menadżerów.',
                    'image' => false,
                ],

                6 => [
                    'title' => 'The Best & More',
                    'text' => 'W kategorii Najlepsza Firma wyróżnienie za najwyższą jakość świadczonych usług oraz szeroką działalność CSR.',
                    'image' => false,
                ],
            ],

            // 'prize1_title' => 'TOP EMPLOYER GLOBAL',
            // 'prize1_text' => 'DHL Express to  jedyna firma na świecie, która uzyskała ten certyfikat na każdym kontynencie.',
            // 'prize1_image' => false,
            //
            // 'prize2_title' => 'TOP EMPLOYER EUROPE',
            // 'prize2_text' => 'Certyfikat przyznany za postawę wspierającą rozwój pracowników.',
            // 'prize2_image' => false,
            //
            // 'prize3_title' => 'TOP EMPLOYER POLAND',
            // 'prize3_text' => 'Certyfikat potwierdzający wyjątkową troskę o pracowników w różnych obszarach.',
            // 'prize3_image' => false,
            //
            // 'prize4_title' => 'Jakość Obsługi 2018',
            // 'prize4_text' => 'Wybór konsumentów potwierdzający najwyższą dbałość o potrzeby i oczekiwania Klientów.',
            // 'prize4_image' => false,
            //
            // 'prize5_title' => 'Najwyższa Jakość',
            // 'prize5_text' => 'Złote Godło dla usług celnych w programie Najwyższa Jakość Quality International 2017.',
            // 'prize5_image' => false,
            //
            // 'prize6_title' => 'Marka Godna Zaufania',
            // 'prize6_text' => 'Pożądany pracodawca w 2016 roku w opinii specjalistów i menadżerów.',
            // 'prize6_image' => false,
            //
            // 'prize7_title' => 'The Best & More',
            // 'prize7_text' => 'W kategorii Najlepsza Firma wyróżnienie za najwyższą jakość świadczonych usług oraz szeroką działalność CSR.',
            // 'prize7_image' => false,
        ],

        'offers' => [
            'offers1_title' => 'Pracownicy terminali lotniczych i drogowych',
            'offers1_image' => 'Szukasz miejsca, w którym ceni się pracę zespołową, a&nbsp;klimat firmy tworzą zatrudnieni w niej ludzie?',
            'offers1_text' => 'Szukasz miejsca, w którym ceni się pracę zespołową, a&nbsp;klimat firmy tworzą zatrudnieni w niej ludzie?',
            'offers1_slug' => 'operacyjny',

            'offers2_title' => 'Specjaliści',
            'offers2_image' => 'Szukasz miejsca, w którym każda osoba spotkana przy porannej kawie ma w sobie ,,to coś”?',
            'offers2_text' => 'Szukasz miejsca, w którym każda osoba spotkana przy porannej kawie ma w sobie ,,to coś”?',
            'offers2_slug' => 'specjalistyczny',

            'offers3_title' => 'Menedżerowie',
            'offers3_image' => 'Szukasz miejsca, w którym bycie szefem polega na inspirowaniu innych do działania?',
            'offers3_text' => 'Szukasz miejsca, w którym bycie szefem polega na inspirowaniu innych do działania?',
            'offers3_slug' => 'menedzerski',
        ],

        'form' => [
            'section_title' => 'Masz pytania dotyczące pracy w&nbsp;DHL&nbsp;Express?',
            'url' => 'https://system.erecruiter.pl/FormTemplates/RecruitmentForm.aspx?WebID=a8419692c93b47c3aaf10316468d966f',
            'btn_text' => 'Skontaktuj się z nami',
            // 'email_address' => '',
            // 'email_from' => 'no-reply@kariera.dhlexpress.pl',
            // 'email_fromname' => 'kariera.dhlexpress.pl',
            // 'email_subject' => 'Wiadomość z formularza kontaktowego na stronie kariera.dhlexpress.pl',
            // 'button_text' => 'Skontaktuj się z nami',
            // 'form_header' => 'Skontaktuj się z nami',
            // 'consent_text' => 'Wyrażam zgodę na przetwarzanie moich danych osobowych.',
            // 'thankyou_text' => '<span class="contact-form__thanks-emphasis">Dziękujemy</span> za wysłanie wiadomości.<br />Niedługo się z Tobą skontaktujemy.',
        ],

        'footer' => [
            'text' => '',
            // 'linkedin_url' => 'https://www.linkedin.com/company/dhlexpresspoland/',
            'copyrights' => 'DHL Express. Wszystkie prawa zastrzeżone',
        ]
    ];

    /**
     * Tworzy tablicę ustawień domyślnych.
     *
     * @return void
     */
    protected function createDefaults() {

        $this->dflts = static::$defaults;

        $videos = $this->dflts['videos']['videos'];

        foreach ($videos as $key => &$arr) {
            $i = $key + 1;
            $arr['image'] = Assets\asset_path("images/v{$i}.jpg", 'asset-sources/dhlcareer/dist');
        }

        $this->dflts['videos']['videos'] = $videos;

        // $this->dflts['prizes']['prize1_image'] = Assets\asset_path('images/c-1.png');
        // $this->dflts['prizes']['prize2_image'] = Assets\asset_path('images/c-2.png');
        // $this->dflts['prizes']['prize3_image'] = Assets\asset_path('images/c-3.png');

        $prizes = $this->dflts['prizes']['prizes'];

        foreach ($prizes as $key => &$arr) {
            $i = $key + 1;
            $arr['image'] = Assets\asset_path("images/prizes/p-{$i}.png", 'asset-sources/dhlcareer/dist');
        }

        $this->dflts['prizes']['prizes'] = $prizes;

        // $this->dflts['prizes'][0]['image'] = Assets\asset_path('images/prizes/p-1.png');
        // $this->dflts['prizes'][1]['image'] = Assets\asset_path('images/prizes/p-2.png');
        // $this->dflts['prizes'][2]['image'] = Assets\asset_path('images/prizes/p-3.png');
        // $this->dflts['prizes'][3]['image'] = Assets\asset_path('images/prizes/p-4.png');
        // $this->dflts['prizes'][4]['image'] = Assets\asset_path('images/prizes/p-5.png');
        // $this->dflts['prizes'][5]['image'] = Assets\asset_path('images/prizes/p-6.png');
        // $this->dflts['prizes'][6]['image'] = Assets\asset_path('images/prizes/p-7.png');

        $this->dflts['offers']['offers1_image'] = Assets\asset_path('images/eo-1.jpg', 'asset-sources/dhlcareer/dist');
        $this->dflts['offers']['offers2_image'] = Assets\asset_path('images/eo-2.jpg', 'asset-sources/dhlcareer/dist');
        $this->dflts['offers']['offers3_image'] = Assets\asset_path('images/eo-3.jpg', 'asset-sources/dhlcareer/dist');
    }

    /**
     * Konstruktor.
     */
    protected function __construct() {
        $this->createDefaults();

        \add_filter("cmb2_override_prizes_meta_value", [$this, 'getDefaultGroupsValues'], 10, 4);
        \add_filter("cmb2_override_videos_meta_value", [$this, 'getDefaultGroupsValues'], 10, 4);
    }

    /**
     * Zwraca domyślną wartość opcji.
     *
     * @todo Przerobić, żeby pozwolić na głębsze zagnieżdżanie.
     * @param string $name
     * @param mixed  $default
     */
    public function defaultVal($option, $default = null) {

        $path = static::getOptionPath($option);
        $optionsGroupKey = static::unPrefix($path[0]);

        if (!\array_key_exists($optionsGroupKey, $this->dflts)) {
            return $default;
        }

        $value = $this->dflts[$optionsGroupKey];

        $optionKeys = explode('::', $path[1], 2);

        $oKey = !empty($optionKeys[0]) ? $optionKeys[0] : false;

        if (!$oKey) {
            return $value;
        }

        if (!\is_array($value) || !\array_key_exists($oKey, $value)) {
            return $default;
        }

        $value = $value[$oKey];

        if (empty($optionKeys[1])) {
            return $value;
        }

        $oKey = $optionKeys[1];

        if (!\is_array($value) || !\array_key_exists($oKey, $value)) {
            return $default;
        }

        return $value[$oKey];
    }

    /**
     * Pobiera wartość opcji.
     *
     * @param string $optionsGroup
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function suboption($optionsGroup, $key, $default = null) {

        if (\function_exists('cmb2_get_option')) {
		    $val = \cmb2_get_option($optionsGroup, $key, $default);
	    } else {
            $opts = \get_option($optionsGroup, $default);

	        $val = $default;

	        if ('all' === $key) {
		        $val = $opts;
	        } elseif (\is_array($opts) && \array_key_exists($key, $opts) && false !== $opts[$key]) {
		        $val = $opts[$key];
	        }
        }

	    return $val;
    }

    /**
     * Pobiera wartość opcji.
     *
     * @param string $name
     * @param mixed  $default
     * @return mixed
     */
    public function get($name, $default = null) {

        if (false === \strpos($name, '::')) {
            $name = static::prefix($name);
            return \cmb2_get_option($name, '', $default);
        }

        $path = static::getOptionPath($name);

        if (null === $default) {
            $default = $this->defaultVal($name);
        }

        return $this->suboption($path[0], $path[1], $default);
    }

    /**
     * Zwraca instancję obiektu.
     *
     * @return SD\Options\OptionsHelper
     */
    public static function getInstance() {

        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Tworzy ścieżkę dostępu do opcji.
     *
     * @param string $path
     * @return array
     */
    protected static function getOptionPath($name) {

        $name = static::prefix($name);
        $path = \explode('::', $name, 2);

        if (!isset($path[1])) {
            $path[1] = false;
        }

        return $path;
    }

    /**
     * Pobiera wartość opcji.
     *
     * @param string $name
     * @param mixed  $default
     * @return mixed
     */
    public static function option($name, $default = null) {
        return static::getInstance()->get($name, $default);
    }

    /**
     * Pobiera wartość opcji.
     *
     * @param string $optionsGroup
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public static function getSuboption($optionsGroup, $key, $default = null) {
        return static::getInstance()->suboption($name, $default);
    }

    /**
     * Ustala nazwę opcji.
     *
     * @param string $name
     * @return string
     */
    public static function prefix($name) {

        $name = (string) $name;
        $name = \strtolower($name);

        if (0 !== \strpos($name, static::$prefix)) {
            $name = static::$prefix.$name;
        }

        return $name;
    }

    /**
     * Usuwa prefiks z nazwy opcji.
     *
     * @param string $name
     * @return string
     */
    public static function unPrefix($name) {

        $name = (string) $name;
        $name = \strtolower($name);

        if (0 === \strpos($name, static::$prefix)) {
            $l = \strlen(static::$prefix);
            $name = \substr($name, $l);
        }

        return $name;
    }

    /**
     * Pobiera domyślną wartość opcji.
     *
     * @param string $name
     * @param mixed  $default
     * @return mixed
     */
    public static function getDefault($option, $default = null) {
        return static::getInstance()->defaultVal($option, $default);
    }

    /**
     * Filtruje domyślną wartość pól w grupach ustawień.
     *
     * @param mixed      $value    Wartość, którą powinna zwrócić funkcja get_metadata().
     * @param string     $objectId Identyfikator obiektu.
     * @param array      $args {
     *     Tablica argumentów.
     *
     *     @type string $type     Typ obiektu.
     *     @type string $id       Identyfikator bieżącego obiektu.
     *     @type string $field_id Identyfikator pola
     *     @type bool   $repeat   Czy bieżące pole jest powtarzalne.
     *     @type bool   $single   Czy bieżące pole jest pojedynczym rzędem w bazie.
     * }
     * @param CMB2_Field $field    Obiekt pola
     *
     * @return array Tablica wartosci pola grupowego.
     */
    function getDefaultGroupsValues($value, $objectId, $args, $field) {

        if ('cmb2_field_no_override_val' !== $value || 'options-page' !== $args['type']) {
            return $value;
        }

        $val = \cmb2_options($args['id'])->get($args['field_id']);

        $id = static::unPrefix($objectId);
        $fieldId = $args['field_id'];

        if (!$val && \array_key_exists($id, $this->dflts)) {
            $value = \array_key_exists($fieldId, $this->dflts[$id]) ? $this->dflts[$id][$fieldId] : $value;
        }

        return $value;
    }

}
