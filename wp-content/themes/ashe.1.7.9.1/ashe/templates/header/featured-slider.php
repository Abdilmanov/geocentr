<?php

$slider_navigation 	= ashe_options( 'featured_slider_navigation' );
$slider_pagination 	= ashe_options( 'featured_slider_pagination' );

$slider_data = '{';

	$slider_data .= '"slidesToShow":1, "fade":true';

	if ( !$slider_navigation ) {
		$slider_data .= ', "arrows":false';
	}

	if ( $slider_pagination ) {
		$slider_data .= ', "dots":true';
	}


$slider_data .= '}';

?>

<!-- Wrap Slider Area -->
<div class="featured-slider-area<?php echo ashe_options( 'general_slider_width' ) === 'boxed' ? ' boxed-wrapper': ''; ?>">

<!-- Featured Slider -->
<div id="featured-slider" class="<?php echo esc_attr(ashe_options( 'general_slider_width' )) === 'boxed' ? 'boxed-wrapper': ''; ?>" data-slick="<?php echo esc_attr( $slider_data ); ?>">

	<?php

	// Query Args
	$args = array(
		'post_type'		      	=> array( 'post' ),
	 	'orderby'		      	=> 'date', //сортировка по 'date'
		'order'			      	=> 'ASC', //по возрастанию
		'posts_per_page'      	=> ashe_options( 'featured_slider_amount' ), //номер поста для отображения на странице
		'ignore_sticky_posts'	=> 1, //игнорировать липкость постов
		'meta_query' 			=> array(
			array(
				'key' 		=> '_thumbnail_id',//ключ поля
				'compare' 	=> 'EXISTS'//оператор проверки, сравнивает
			)
		),
	);

	if ( ashe_options( 'featured_slider_display' ) === 'category' ) {
		$args['cat'] = ashe_options( 'featured_slider_category' );
	}

	//использовать если нужно самому выбрать изображение
	// if ( ashe_is_preview() ) {
	// 	array_pop($args);
	// 	$preview_count  = 0;
	// 	$preview_images = array(
	// 		get_template_directory_uri() .'/assets/images/Astana.jpg',
	// 		get_template_directory_uri() .'/assets/images/Almaty.jpg',
	// 		get_template_directory_uri() .'/assets/images/Kokshetau.jpg'
	// 	);
	// }


	$sliderQuery = new WP_Query();
	$sliderQuery->query( $args );

	// Loop Start
	if ( $sliderQuery->have_posts() ) :

	while ( $sliderQuery->have_posts() ) : $sliderQuery->the_post();

		if ( ashe_is_preview() ) {
		//  чтоб выходили изображения из $preview_images
		// 	$featured_image = $preview_images[$preview_count];
		// 	$preview_count++;
		// } else {
			$featured_image = get_the_post_thumbnail_url();
		}

	?>

	<div class="slider-item">

		<div class="slider-item-bg" style="background-image:url(<?php echo esc_url($featured_image); ?>);"></div>

		<div class="cv-container image-overlay">
			<div class="cv-outer">
				<div class="cv-inner">
					<div class="slider-info">

						<?php $category_list = get_the_category_list( ', ' ); ?>

						<?php if ( $category_list ) : ?>
						<div class="slider-categories">
							<?php echo '' . $category_list; ?>
						</div>
						<?php endif; ?>

						<h2 class="slider-title">
							<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
						</h2>

						<div class="slider-content"><?php ashe_excerpt( 30 ); ?></div>

						<div class="slider-read-more">
							<a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Узнать больше','ashe' ); ?></a>
						</div>

						<div class="slider-date"><?php the_time( get_option('date_format') ); ?></div>

					</div>
				</div>
			</div>
		</div>

	</div>

	<?php

	endwhile; // Loop end
	endif;

	?>

</div><!-- #featured-slider -->

</div><!-- .featured-slider-area -->
