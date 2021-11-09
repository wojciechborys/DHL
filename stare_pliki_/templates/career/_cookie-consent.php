<?php
namespace MintMedia\Dhl\Templates;

use MintMedia\PolylangT9n\Polylang;

$agreed = !empty($_COOKIE['_cookie-policy-consent']) && '1' === $_COOKIE['_cookie-policy-consent'];
?>

<div class="cookie-consent<?php if ($agreed) : ?> cookie-consent--accepted<?php endif; ?>" data-cookie-consent>
    <div class="container cookie-consent__container">
        <div class="row cookie-consent__row">
            <div class="col-12 cookie-consent__col">
                <button type="button" class="close" aria-label="Zamknij" data-close-cookies>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="col-12 cookie-consent__col">
                <p>Stosujemy pliki cookie na naszej stronie internetowej. Pliki cookie są stosowane do poprawy działania i korzystania z naszej strony Internetowej, a także dla celów analitycznych i reklamowych. Aby dowiedzieć się więcej na temat plików cookie, sposobu ich wykorzystania oraz sposobu zmiany ustawień cookie, dowiedz się więcej <a href="http://www.dhl.com.pl/pl/zasady_korzystania_ze_strony_internetowej.html#privacy" target="_blank" data-close-cookies>tutaj</a>. Korzystając z tej strony bez zmiany ustawień, wyrażasz zgodę na stosowanie plików cookie.</p>
            </div>
        </div>
    </div>
</div>
