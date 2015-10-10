<a name="pageTop" title=""></a>
<img class="webArea" src="/wp-content/uploads/2015/09/raw_background.jpg" alt="" width="auto" height="100%">
<div class="spaceScene"></div>
<img class="sunStream" src="/wp-content/themes/looptheme/assets/images/Website_Header_Sunbeam.png" alt="" width="100%" height="auto">
<img class="backgroundTop" src="/wp-content/themes/looptheme/assets/images/BackgroundTop.png" alt="" width="100%" height="auto">
<img class="secLogo" src="/wp-content/themes/looptheme/assets/images/Awebgo_SpaceShip.png" alt="">
<div class="dotArea"></div>
<header class="banner" role="banner">
	<div class="modal-dialog">
		<!-- -->
	</div>
    <div class="container">
        <?php /* <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a> */ ?>
        <a class="brand" href="<?= esc_url(home_url('/')); ?>"><img class="mainLogo hastip" title="[Klick] Gehe zur Startseite" src="/wp-content/themes/looptheme/assets/images/AwebgoLogo.png" alt=""></a>
        <nav role="navigation">
            <?php
			if (has_nav_menu('primary_navigation')) : wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
			endif;
            ?>
        </nav>
    </div>
</header>
