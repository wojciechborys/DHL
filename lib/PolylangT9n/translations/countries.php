<?php
use MintMedia\ShipmentCalc\Helpers;

(defined('MM_POLYLANG_ACTIVE') and MM_POLYLANG_ACTIVE) or die;

// kraje
$countries = Helpers\OptionsHelper::get_instance()->get_hidden('countries');

foreach ($countries as $country) {
    pll_register_string(
        "Kraje: {$country}",
        $country,
        'DHL - Lista krajów',
        false
    );
}
