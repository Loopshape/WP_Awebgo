<?php if(has_post_thumbnail()) {
?>
<div class="single post thumbnail"><?php the_post_thumbnail(); ?></div>
<?php } ?>
<?php get_template_part('templates/content-single', get_post_type()); ?>
