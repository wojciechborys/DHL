<?php
use MintMedia\PolylangT9n\Polylang;
use MintMedia\Dhl\Experiments;

$variation = Experiments\get_variation();

$header = (1 === $variation) ? Polylang\t9n('Chcesz mieć w pełni dopasowaną ofertę?') : Polylang\t9n('Wyślij szybką przesyłkę zagraniczną!');
$info = (1 === $variation) ? Polylang\t9n('Zostaw dane, a my zrobimy resztę!') : Polylang\t9n('Po wpisaniu parametrów przesyłki otrzymasz warianty cenowe.');
$button = (1 === $variation) ? Polylang\t9n('Zostaw kontakt') : Polylang\t9n('Sprawdź warianty cenowe');
?>

<footer class="footer-bottom">
    <div class="footer-bottom__wrapper">
        <div class="container">
            <div class="row">
                <div class="col-10 col-md-7">
                    <h2 class="footer-bottom__header"><?= $header; ?></h2>
                    <p class="footer-bottom__info"><?= $info; ?></p>

                    <p class="footer-bottom__btn-wrapper">
                        <?php

                        $buttonUrl = (0 === $variation) ? home_url('/#calculator') : get_permalink().'#contact-us-form';
                        $ctaLink = get_field('form_link');
                        ?><a href="<?php echo $ctaLink['url']; ?>" class="btn btn-primary btn--footer-bottom"><?php echo $ctaLink['title']; ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php MintMedia\Dhl\Templates\cookie_consent(); ?>
</footer>
