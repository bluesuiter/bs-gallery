<?php

function bsTestimonialTemplate($atts)
{
	global $post;
	ob_start();

	$count = (isset($atts['count']) ? $atts['count'] : 1);
	$authour = (isset($atts['authour']) ? $atts['authour'] : false);
	$slider = (isset($atts['slider']) ? $atts['slider'] : false);
	$title = (isset($atts['title']) ? $atts['title'] : false);

	$args = array('post_status' => 'publish', 'post_type' => 'testimonial', 'post_count' => $count);
	$wp_query = new WP_Query($args);
	echo '<div class="wrap-bstestimonials">';
		while ($wp_query->have_posts() ) : $wp_query->the_post();
			?>
				<div class="bstestimonial<?php echo $post->ID ?>">
					<?php if($title) { echo '<h3 class="bstestimonial-heading">'.$title.'</h3>'; } ?>
					<?php echo get_the_post_thumbnail($post->ID) ?>
					<div class="testimonial-content">
						<?php the_content() ?>
						<?php if($authour){ ?>
							<div class="testimonial-authour-section">
								<span class="testimonial-authour">
									<?php echo get_post_meta($post->ID, '_authour_name_', true) ?>
								</span>
								<span class="testimonial-designation">
									<?php echo get_post_meta($post->ID, '_service_name_', true) ?>
								</span>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php
		endwhile;
	echo '</div>';

	if($slider)
	{
		add_action('wp_footer', 'bsTestimonialSlider');
	}

	do_action('bstestimonials');
	wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode('bstestimonial', 'bsTestimonialTemplate');


function bsTestimonialSlider()
{
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
		  	jQuery('.wrap-bstestimonials').bxSlider({
		  		auto: true,
		  		controls: false,
		  	});
		});
	</script>
	<?php
}