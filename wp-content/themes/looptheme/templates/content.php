<article <?php post_class(); ?>>
  <header>
    <h2 class="entry-title"><a class="gotoSideRight" href="<?php the_permalink(); ?>">
<?php if(has_post_thumbnail()) {
?>
<div class="indexlist post thumbnail"><?php the_post_thumbnail(); ?></div>
<?php } ?>
    	<?php the_title(); ?></a></h2>
    <?php get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
</article>
