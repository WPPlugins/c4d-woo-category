<?php
/*
Plugin Name: C4D Woocommerce Category
Plugin URI: http://coffee4dev.com/
Description: Simple Category Widget
Author: Coffee4dev.com
Author URI: http://coffee4dev.com/
Text Domain: c4d-woo-category
Version: 2.0.0
*/

define('C4DWOOCATEGORY_PLUGIN_URI', plugins_url('', __FILE__));
add_action( 'widgets_init', 'c4d_woo_category_register_widget' );
add_filter( 'plugin_row_meta', 'c4d_woo_category_plugin_row_meta', 10, 2 );

function c4d_woo_category_plugin_row_meta( $links, $file ) {
    if ( strpos( $file, basename(__FILE__) ) !== false ) {
        $new_links = array(
            'visit' => '<a href="http://coffee4dev.com">Visit Plugin Site</<a>',
            'forum' => '<a href="http://coffee4dev.com/forums/">Forum</<a>',
            'premium' => '<a href="http://coffee4dev.com">Premium Support</<a>'
        );
        
        $links = array_merge( $links, $new_links );
    }
    
    return $links;
}

// register Foo_Widget widget
function c4d_woo_category_register_widget() {
    register_widget( 'C4DWOOCATEGORY_Widget' );
}

/**
 * Adds Foo_Widget widget.
 */
class C4DWOOCATEGORY_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'c4d-woo-category', // Base ID
			esc_html__( 'Woo Category', 'c4d-woo-category' ), // Name
			array( 'description' => esc_html__( 'Simple Woocommerce category by C4D', 'c4d-woo-category' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		$params = array(
			'title_li' => '',
			'taxonomy' => 'product_cat',
			'show_count' => !empty($instance['count']) ? $instance['count'] : 0,
			'number' => !empty($instance['limit']) ? $instance['limit'] : ''
		);
		if ($instance['category']) {
			$params['child_of'] = $instance['category'];
		}
		echo '<ul class="c4d-woo-category">';
		wp_list_categories($params);
		echo '</ul>';
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$category = ! empty( $instance['category'] ) ? $instance['category'] : 0;
		$count = ! empty( $instance['count'] ) ? $instance['count'] : 0;
		$limit = ! empty( $instance['limit'] ) ? $instance['limit'] : 5;
		?>
		<p>
			<label><?php esc_attr_e( 'Title:', 'c4d-woo-category' ); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>">
		</p>
		<p>
			<label><?php esc_attr_e( 'Category:', 'c4d-woo-category' ); ?></label> 
			<?php
				wp_dropdown_categories(array('name' => $this->get_field_name('category'), 'selected' => $category, 'class' => 'widefat', 'taxonomy' => 'product_cat', 'hierarchical' => true));
			?>
		</p>
		<p>
			<label><?php esc_attr_e( 'Limit:', 'c4d-woo-category' ); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('limit'); ?>" value="<?php echo $limit; ?>">
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="checkbox" value="1" <?php checked( $count, 1 ); ?> />
						<label for="<?php echo $this->get_field_id('count'); ?>"><?php esc_html_e('Show Count Product', 'c4d-woo-category'); ?></label>
		</p>

		<?php 
	}
} 
