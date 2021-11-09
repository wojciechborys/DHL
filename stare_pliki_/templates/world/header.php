<header class="main-header" data-banner>
    <div class="container">
        <div class="row">

            <nav class="navbar navbar-expand-md navbar-dark main-header__navbar">
                <a class="navbar-brand main-header__brand" href="<?= esc_url(home_url('/')); ?>" rel=”nofollow”><?php bloginfo('name'); ?></a>

                <?php
            if (has_nav_menu('primary_navigation')) :
                $navID = esc_attr(uniqid('nav-'));
                ?><button class="navbar-toggler nav-primary__toggler" type="button" data-toggle="collapse" data-target="#<?= $navID; ?>" aria-controls="<?= $navID; ?>" aria-expanded="false" aria-label="Przełącz nawigację">
                    <span class="navbar-toggler-icon nav-primary__toggler_icon"></span>
                </button>

                <div class="collapse navbar-collapse nav-primary" id="<?= $navID; ?>">

                    <?php
                        wp_nav_menu([
                            'container'      => false,
                            'theme_location' => 'primary_navigation',
                            'menu_class'     => 'nav-primary__list navbar-nav',
                            'walker'         => new SD\Walkers\NavPrimary(),
                            'link_before'    => '<span class="nav-primary__link-text">',
                            'link_after'     => '</span>',
                        ]);
                    ?>

                </div><?php
            endif;
                ?>

            </nav>

        </div>
    </div>
</header>
