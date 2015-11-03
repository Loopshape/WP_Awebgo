<a name="pageTop" title=""></a>
<div class="spaceScene"></div>
<div class="laptopArea">
	<img src="http://loop.arcturus.uberspace.de/wp-content/uploads/2015/10/3D_Laptop.png" alt="" width="50%" height="auto" class="hastip" title="[Klick] Static DOM aktivieren">
</div>
<header class="banner" role="banner">
	<div class="modal-dialog">
		<!-- -->
	</div>
    <div class="container">
        <?php /* <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
		 * <?= esc_url(home_url('#gotoTop')); ?>
		 * */ ?>
        <a class="brand" href="#"><img class="mainLogo hastip" title="AWEBGO // WEB DEVELOPMENT<br />ADMIN :: Arjuna Noorsanto" src="/wp-content/themes/looptheme/assets/images/AwebgoLogo.png" alt=""></a>
        <nav role="navigation">
            <?php
			if (has_nav_menu('primary_navigation')) : wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
			endif;
            ?>
        </nav>
    </div>
</header>
