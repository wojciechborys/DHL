<?php
use MintMedia\Dhl\Templates;
?>
<article class="container">
    <div class="row justify-content-center">
        <div class="col col-md-10 col-xl-8">
            <?php get_template_part('templates/page', 'header'); ?>

            <div class="page-content page-content--404">
                <p>Kiedy błądziłeś/łaś w internecie, my zdążyliśmy już dostarczyć Twoją ekspresową przesyłkę.</p>

                <p><a href="<?php echo esc_url(home_url('/')); ?>" class="page-content__homepage-link">Strona główna</a></p>
            </div>
        </div>
    </div>
</article>

<?php
Templates\articles_section();
?>
