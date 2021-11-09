<?php use Roots\Sage\Titles; ?>

<div class="page-header">
    <h1 class="page-header__title <?php if (is_404()) : ?>page-header__title--404<?php endif; ?>"><?= Titles\title(); ?></h1>

    <?php
    if (is_404()) :
        ?><p class="page-header__subtitle page-header__subtitle--404">Przykro nam &ndash; to adres bez strony :)</p><?php
    endif;
    ?>
</div>
