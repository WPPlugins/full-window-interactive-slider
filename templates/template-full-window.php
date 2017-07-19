<?php
/**
 * Template Name: Full Window TCC
 *
 * Description: A full width page template that will display 4 posts in a block without any sidebars
 *
 * @since 1.0.3
 */
//TODO Añadir configuración para que los usuarios de pago puedan escoger plantilla
include( 'header-full-window.php' ); // include that file on directory pages
//get_header('full-window');
?>
<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
	<div class="header_menus">
		<?php dynamic_sidebar( 'sidebar-5' ); ?>
	</div>
<?php endif; ?>

				<?php
				while ( have_posts() ) : the_post();
					?>
					


					    <div>
						    <?php the_content( __( 'Read more', 'arcade') ); ?>
					    </div><!-- .entry-content -->

					    <?php // get_template_part( 'content', 'footer' ); ?>
					

					<?php
					// comments_template( '', true );
				endwhile;
				?>
<!--</div>
</div>
</body>-->
<?php  
//TODO meter condicional para no ser pantalla completa
get_footer(); ?>