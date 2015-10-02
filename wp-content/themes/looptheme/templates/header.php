<img class="webArea" src="/wp-content/uploads/2015/09/raw_background.jpg" alt="" width="auto" height="100%">
<header class="banner" role="banner">
  <img class="backgroundTop" src="/wp-content/themes/looptheme/assets/images/BackgroundTop.png" alt="" width="100%" height="auto">
  <div class="container">
    <?php /* <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a> */ ?>
    <a class="brand" href="<?= esc_url(home_url('/')); ?>"><img class="mainLogo hastip" title="[Klick] Gehe zu Startseite" src="/wp-content/themes/looptheme/assets/images/AwebgoLogo.png" alt=""></a>
    <img class="secLogo" src="/wp-content/themes/looptheme/assets/images/Awebgo_SpaceShip.png" alt="">
    <nav role="navigation">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</header>
