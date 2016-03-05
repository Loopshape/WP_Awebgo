<a name="pageTop" title=""></a>
<img class="webArea" src="/wp-content/uploads/2015/09/raw_background.jpg" alt="" width="auto" height="100%">
<div class="spaceScene"></div>
<div class="laptopArea">
	<img src="/wp-content/uploads/2015/10/3D_Laptop.png" alt="" width="50%" height="auto" class="hastip" title="[Klick] Static DOM aktivieren">
</div>
<div class="dotArea"></div>
<header class="banner" role="banner">
	<div class="modal-dialog">
		<!-- -->
	</div>
    <div class="container">
        <?php /* <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
		 * <?= esc_url(home_url('#gotoTop')); ?>
		 * */ ?>
        <a class="brand" href="#pageTop"><img class="mainLogo hastip" title="AWEBGO // WEB DEVELOPMENT<br />Administrator :: Arjuna Noorsanto" src="/wp-content/themes/looptheme/assets/images/AwebgoLogo.png" alt=""></a>
        <nav role="navigation">
            <?php
			if (has_nav_menu('primary_navigation')) : wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
			endif;
            ?>
        </nav>
    </div>
</header>
