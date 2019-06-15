<?php

namespace ift\epp;

/* Stops direct visit */
if( ! defined( 'ABSPATH' ) ) {
  exit( 'Go away!' );
}

define( 'NOIMAGELINK', plugins_url( 'inc/missing.png', dirname( __FILE__ ) ) );

class EPP_Widget extends \WP_Widget {

	public function __construct() {

    /* Sets up the widget name and description */
    $widget_options = array(
      'classname' => 'EPP-Widget',
      'description' => 'Your site\'s most popular Posts.'
    );
    parent::__construct( 'popular_posts_Widget', 'Easy Popular Posts', $widget_options );

    /* Hooks the widget and style */
    add_action( 'widgets_init', function () {
      register_widget( __NAMESPACE__.'\EPP_Widget' );
    });
		add_action( 'wp_enqueue_scripts', array( $this, 'EPP_enqueue_styles' ) );

	}

  /* Outputs the options form on admin */
	public function form( $instance ) {
    $title = isset( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : '';
		$number = isset( $instance[ 'number' ] ) ? absint( $instance[ 'number' ] ) : 5;
		$show_date = isset( $instance[ 'show_date' ] ) ? (bool) $instance[ 'show_date' ] : false;
    $show_thumb = isset( $instance[ 'show_thumb' ] ) ? (bool) $instance[ 'show_thumb' ] : false;
    $thumb_width = isset( $instance[ 'thumb_width' ] ) ? absint( $instance[ 'thumb_width' ] ) : 70;
    $default_thumb = isset( $instance[ 'default_thumb' ] ) ? esc_attr( $instance[ 'default_thumb' ] ) : '';
    $thumb_height = isset( $instance[ 'thumb_height' ] ) ? absint( $instance[ 'thumb_height' ] ) : 70;
    $title_length = isset( $instance[ 'title_length' ] ) ? absint( $instance[ 'title_length' ] ) : 20;
    $show_excerpt = isset( $instance[ 'show_excerpt' ] ) ? (bool) $instance[ 'show_excerpt' ] : false;
    $excerpt_length = isset( $instance[ 'excerpt_length' ] ) ? absint( $instance[ 'excerpt_length' ] ) : 20;
    ?>
    <p><strong><?php _e( 'General Settings' ); ?></strong></p>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title of the Widget:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
		<p>
      <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
      <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" style="width: 50px;" />
    </p>
		<p>
      <input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
      <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date' ); ?></label>
    </p>
    <br><p><strong><?php _e( 'Thumbnail Settings' ); ?></strong></p>
    <p>
      <input class="checkbox" type="checkbox"<?php checked( $show_thumb ); ?> id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" />
      <label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php _e( 'Display post thumbnail image' ); ?></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'default_thumb' ); ?>"><?php _e( 'Default thumbnail image link:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'default_thumb' ); ?>" name="<?php echo $this->get_field_name( 'default_thumb' ); ?>" type="text" value="<?php echo $default_thumb; ?>" />
    </p>
    <div class="epp-widget-form-note"></em><?php _e( 'Default thumbnail link should start with http:// or https://' ); ?></em></div>
    <p>
      <label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e( 'Width of thumbnail in pixel:' ); ?></label>
      <input class="tiny-text" id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" type="number" step="1" min="1" max="150" value="<?php echo $thumb_width; ?>" size="3" style="width: 50px;" />
    </p>
    <div class="epp-widget-form-note"></em><?php _e( 'Maximum allowed width is 150' ); ?></em></div>
    <p>
      <label for="<?php echo $this->get_field_id( 'thumb_height' ); ?>"><?php _e( 'Height of thumbnail in pixel:' ); ?></label>
      <input class="tiny-text" id="<?php echo $this->get_field_id( 'thumb_height' ); ?>" name="<?php echo $this->get_field_name( 'thumb_height' ); ?>" type="number" step="1" min="1" max="150" value="<?php echo $thumb_height; ?>" size="3" style="width: 50px;" />
    </p>
    <div class="epp-widget-form-note"></em><?php _e( 'Maximum allowed height is 150' ); ?></em></div>
    <br><p><strong><?php _e( 'Content Settings' ); ?></strong></p>
    <p>
      <label for="<?php echo $this->get_field_id( 'title_length' ); ?>"><?php _e( 'Limit post title to number of words:' ); ?></label>
      <input class="tiny-text" id="<?php echo $this->get_field_id( 'title_length' ); ?>" name="<?php echo $this->get_field_name( 'title_length' ); ?>" type="number" step="1" min="1" max="30" value="<?php echo $title_length; ?>" size="3" style="width: 50px;" />
    </p>
    <div class="epp-widget-form-note"></em><?php _e( 'Maximum allowed number of word is 30' ); ?></em></div>
    <p>
      <input class="checkbox" type="checkbox"<?php checked( $show_excerpt ); ?> id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" />
      <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Display post excerpt' ); ?></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'excerpt_length' ); ?>"><?php _e( 'Limit post excerpt to number of words:' ); ?></label>
      <input class="tiny-text" id="<?php echo $this->get_field_id( 'excerpt_length' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length' ); ?>" type="number" step="1" min="1" max="30" value="<?php echo $excerpt_length; ?>" size="3" style="width: 50px;" />
    </p>
    <div class="epp-widget-form-note"></em><?php _e( 'Maximum allowed number of word is 30' ); ?></em></div>
    <style>
      .epp-widget-form-note {
        font-size: 12px;
        font-style: italic;
        padding: 0 0 -5px;
        margin-top: -10px;
      }
    </style>
    <?php
  }

  /* Processes widget options on save */
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
    $instance[ 'number' ] = (int) $new_instance[ 'number' ];
    $instance[ 'show_date' ] = isset( $new_instance[ 'show_date' ] ) ? (bool) $new_instance[ 'show_date' ] : false;
    $instance[ 'show_thumb' ] = isset( $new_instance[ 'show_thumb' ] ) ? (bool) $new_instance[ 'show_thumb' ] : false;
    $instance[ 'thumb_width' ] = (int) $new_instance[ 'thumb_width' ];
    $instance[ 'thumb_height' ] = (int) $new_instance[ 'thumb_height' ];
    $instance[ 'default_thumb' ] = sanitize_text_field( $new_instance[ 'default_thumb' ] );
    $instance[ 'title_length' ] = (int) $new_instance[ 'title_length' ];
    $instance[ 'show_excerpt' ] = isset( $new_instance[ 'show_excerpt' ] ) ? (bool) $new_instance[ 'show_excerpt' ] : false;
    $instance[ 'excerpt_length' ] = (int) $new_instance[ 'excerpt_length' ];
    return $instance;
  }

	/* Outputs the content of the widget on front-end */
	public $args = array(
    'before_title' => '',
    'after_title' => '',
    'before_widget' => '',
    'after_widget'  => ''
  );
  public function widget( $args, $instance ) {
    $title = ( ! empty( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : __( 'Most Popular Posts' );
    $number = ( ! empty( $instance[ 'number' ] ) ) ? absint( $instance[ 'number' ] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance[ 'show_date' ] ) ? $instance[ 'show_date' ] : false;
    $show_thumb = isset( $instance[ 'show_thumb' ] ) ? $instance[ 'show_thumb' ] : false;
    $default_thumb = ( ! empty( $instance[ 'default_thumb' ] ) ) ? $instance[ 'default_thumb' ] : '';
    $thumb_width = ( ! empty( $instance[ 'thumb_width' ] ) ) ? absint( $instance[ 'thumb_width' ] ) : 70;
		if ( ! $thumb_width ) {
			$thumb_width = 70;
		}
    $thumb_height = ( ! empty( $instance[ 'thumb_height' ] ) ) ? absint( $instance[ 'thumb_height' ] ) : 70;
		if ( ! $thumb_height ) {
			$thumb_height = 70;
		}
    if ( ! $show_thumb ) {
      $text_offset = 0;
    } else {
      $text_offset = $thumb_width + 10;
    }
    $title_length = ( ! empty( $instance[ 'title_length' ] ) ) ? absint( $instance[ 'title_length' ] ) : 20;
    $show_excerpt = isset( $instance[ 'show_excerpt' ] ) ? $instance[ 'show_excerpt' ] : false;
    $excerpt_length = ( ! empty( $instance[ 'excerpt_length' ] ) ) ? absint( $instance[ 'excerpt_length' ] ) : 20;
    // print_r($instance); // For debugging purpose
    $popular_posts_query = new \WP_Query(
			apply_filters(
				'widget_posts_args',
				array(
					'posts_per_page' => $number,
          'meta_key'=> 'hit_count',
          'orderby' => 'meta_value_num',
          'order' => 'DESC',
					'no_found_rows' => true,
					'post_status' => 'publish',
					'ignore_sticky_posts' => true,
				),
				$instance
			)
		);
		if ( ! $popular_posts_query->have_posts() ) {
			return;
		}
		?>
		<?php
    wp_enqueue_style( 'EPP-Widget' );
    echo $args[ 'before_widget' ];
    echo $args[ 'before_title' ] . $title . $args[ 'after_title' ];
    ?>
		<ul>
			<?php foreach ( $popular_posts_query->posts as $popular_post ) : ?>
				<?php
          $current_post_ID = $popular_post->ID;
  				$post_title = get_the_title( $current_post_ID );
  				$title = ( ! empty( $post_title ) ) ? esc_attr( $post_title ) : __( '(no title)' );
				?>
				<li>
          <div class="post-wrap">
            <?php if ( $show_thumb ) : ?>
              <div class="image-column" style="width: <?php echo $thumb_width; ?>px;">
                <a class="thumbnail-link" href="<?php the_permalink( $current_post_ID ); ?>">
                  <?php
                    if ( has_post_thumbnail( $current_post_ID ) ) {
                      $thumbnail_link = get_the_post_thumbnail_url( $current_post_ID, 'thumbnail' );
                    } else {
                      if ( ! empty( $instance[ 'default_thumb' ] ) ) {
                        $thumbnail_link = $instance[ 'default_thumb' ];
                      } else {
                        $thumbnail_link = NOIMAGELINK;
                      }
                    }
                  ?>
                  <img src="<?php echo $thumbnail_link; ?>" alt="<?php echo $title; ?>" style="width: <?php echo $thumb_width; ?>px; height: <?php echo $thumb_height; ?>px;" />
                </a>
              </div>
            <?php endif; ?>
            <div class="text-column" style="margin-left: <?php echo $text_offset; ?>px; min-height: <?php echo $thumb_height; ?>px;">
              <a class="post-title" href="<?php the_permalink( $current_post_ID ); ?>">
                <?php echo epp_truncuate( $title, $title_length ); ?>
              </a>
              <?php if ( $show_excerpt ) : ?>
    						<div class="post-excerpt"><?php echo epp_truncuate( get_the_excerpt( $current_post_ID ), $excerpt_length ); ?></div>
    					<?php endif; ?>
    					<?php if ( $show_date ) : ?>
    						<span class="post-date"><?php echo get_the_date( '', $current_post_ID ); ?></span>
    					<?php endif; ?>
              <div style="display: none;">hit count: <?php echo get_post_meta( $current_post_ID, 'hit_count', true ); ?></div><!-- For debugging purpose -->
            </div>
          </div>
				</li>
			<?php endforeach; ?>
      <?php wp_reset_postdata(); ?>
		</ul>
		<?php
    echo $args['after_widget'];
  }

  /* Adds the widget stylesheet */
	public function EPP_enqueue_styles() {
    wp_register_style( 'EPP-Widget', plugins_url( 'css/widget.css', dirname( __FILE__ ) ) );
	}

}

$start_widget = new EPP_Widget();