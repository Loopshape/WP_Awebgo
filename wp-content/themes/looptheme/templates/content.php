<article <?php post_class(); ?>>
  <header>
    <h2 class="entry-title"><a class="gotoSideRight" href="<?php the_permalink(); ?>">
	<?php the_title(); ?></a></h2>
	<?php if(has_post_thumbnail()) {
	?>
	<div class="indexlist post thumbnail">
	<?php //the_post_thumbnail();
		echo get_the_post_thumbnail( $page->ID, 'medium' );
	?>
	</div>
	<?php } ?>
    <?php get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
</article>
