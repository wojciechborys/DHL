<?php
namespace SD\Template\Embeds;

/**
 * Zmienia domyślne wartości parametrów osadzania.
 *
 * @param array  $args
 * @param string $url
 * @return array
 */
function embedDefaults($args, $url) {

	if (\preg_match('@vimeo|youtube|youtu\.be@i', $url)) {
		$args['width'] = 760;
	}

	return $args;
}
\add_filter('embed_defaults', __NAMESPACE__.'\\embedDefaults', 10, 2);

/**
 * Może przetwarzać ramkę oEmbed w zależności od argumentów shortcode'u.
 *
 * @param string   $html Kod HTML ramki.
 * @param stdClass $data Parametry zwrócone przez dostawcę.
 * @param string   $url  URL do osadzenia.
 */
function oembedDataparse($html, $data, $url) {

    # znajdź dostawcę
	if ( 0 === \strpos(\trim($html), '<iframe') && \preg_match('@vimeo|youtube|youtu\.be@i', $url, $m)) {
		$m[0] = \strtolower($m[0]);

    	if ('youtu.be' === $m[0]) {
    		$provider = 'youtube';
    	} else {
    		$provider = $m[0];
    	}

    	$urlParams = getIframeParams($provider);

		\preg_match('@src\s*=\s*(["\']([^"\']+)?["\']|[^>]+)@i', $html, $sm);

		$prevUrl = $sm[2];
		$query = \parse_url($prevUrl, PHP_URL_QUERY);

		if ($query) {
			\parse_str($query, $queryArgs);

            # jeśli użytkownik coś ustawił, niech ma
			foreach ($queryArgs as $qa => $qv) {
				unset($urlParams[$qa]);
			}
		}

        # wstawienie spreparowanego URL-a
		$url = \add_query_arg($urlParams, $prevUrl);
		$html = \str_replace($prevUrl, $url, $html);

        $count = \preg_match('@<iframe(?:.*?)class=(?:"|\')(.*?)(?:\'|")(?:.*?)>@mi', $html, $hm); // 1 | 0

        # ustawienie klasy iframe'a
        $wrapperClass = 'embed-responsive embed-'.\sanitize_html_class($provider);

        if (!empty($data->width) && !empty($data->height)) {
            $ratio = (int) $data->width / (int) $data->height;
            $ratios = ['1by1' => 1, '4by3' => 4 / 3, '16by9' => 16 / 9, '21by9' => 21 / 9];

            $wrapperSuffix = $closest = null;

            foreach ($ratios as $sx => $rnum) {
                if ($closest === null || abs($ratio - $closest) > abs($rnum - $ratio)) {
                    $wrapperSuffix = $sx;
                    $closest = $rnum;
                }
            }
        } else {
            $wrapperSuffix = '16by9';
        }

        $wrapperClass .= " embed-responsive-{$wrapperSuffix}";

        if (!empty($hm[1])) {
            $classes = \explode(' ', $hm[1]);
            $classes[] = 'embed-responsive-item';
            $classes = \array_unique($classes);
            $classes = \array_filter($classes);

            $cls = \implode(' ', $classes);

            $html = \str_replace($hm[1], $cls, $count);
        } else {
            $html = \str_replace('<iframe', '<iframe class="embed-responsive-item"', $html);
        }

		$html = \sprintf( '<div class="embed-responsive-wrapper"><div class="embed-responsive %1$s">%2$s</div></div>',
			$wrapperClass, $html
		);
	}

	return $html;
}
\add_filter('oembed_dataparse', __NAMESPACE__.'\\oembedDataparse', 10, 3);

/**
 * Może przetwarzać ramkę oEmbed w zależności od argumentów shortcode'u.
 *
 * @param string $html
 * @param string $url
 * @param array  $args
 */
//function oembed_result($html, $url, $args) {
//    return $html;
//}
//\add_filter('oembed_result', __NAMESPACE__.'\\oembed_result', 10, 3);

/**
 * Zwraca argumenty dla ramki z filmem.
 *
 * @param string $provider Nazwa serwisu wideo. Obsługuje: 'youtube' lub 'vimeo'.
 * @return array Parametry do dołączenia do filmu.
 */
function getIframeParams($provider = 'vimeo') {

	$provider = \strtolower($provider);

	if ('youtube' === $provider) {
		return [
			'enablejsapi' => '1',
			'autoplay' => '0',
			'controls' => '0',
			'rel'      => '0',
			'showinfo' => '0',
		];
	} elseif ('vimeo' === $provider) { // Vimeo
        return [
    		'byline'   => '0',
    		'badge'    => '0',
    		'color'    => '000',
    		'portrait' => '0',
    		'title'    => '0'
    	];
    }

	return [];
}
