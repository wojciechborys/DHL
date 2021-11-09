<?php
$target = 'https://www.simplydhl.com/poland/expresspl';

$base = 'https://www.simplydhl.com';

$curl = curl_init($target);

// curl_setopt($curl, CURLOPT_POST, 1);
// curl_setopt($curl, CURLOPT_POSTFIELDS,$_POST);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
// curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0');
curl_setopt($curl, CURLOPT_HTTPHEADER, [
	'Accept-Language: pl,en-US;q=0.7,en;q=0.3',
	'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
	'Accept: text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8',
	'Referer: http://dhl-express.apps-hub.com/'
]);

$data = curl_exec($curl);

if (200 === curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
    include __DIR__ . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

    $html = str_get_html($data);
    $imgs = $html->find('img');
    $iframes = $html->find('iframe');
    $styles = $html->find('style');

    $elems = ['script' => 'src', 'style' => 'src', 'img' => 'src', 'iframe' => 'src', 'link' => 'href', 'a' => 'href'];

    foreach ($elems as $elem => $attr) {
        $items = $html->find($elem);

        foreach ($items as $item) {
            $src = $item->{$attr};

            if (empty($src) || 0 === strpos($src, '//') || 0 === strpos($src, 'http')) {
                continue;
            }

            $src = $base . (0 !== strpos($src, '/') ? '/' : '') . $src;

            $item->{$attr} = $src;
        }
    }

    echo $html;
} else {
    echo $data;
}

die;
