<?php

// Create custom widget class extending WPH_Widget
class Ca_My_Recent_Posts_Widget extends WPH_Widget {

	/**
	 * Initialize the widget
	 * 
	 * @return void
	 */
	function __construct() {
		// Configure widget array
		$args = array(
			'label' => __( 'My Recent Posts Example', CA_TEXTDOMAIN ),
			'description' => __( 'My Recent Posts Widget Description', CA_TEXTDOMAIN ),
		);

		// Configure the widget fields
		// Example for: Title ( text ) and Amount of posts to show ( select box )
		$args[ 'fields' ] = array(
			// Title field
			array(
				// Field name/label									
				'name' => __( 'Title', CA_TEXTDOMAIN ),
				// Field description					
				'desc' => __( 'Enter the widget title.', CA_TEXTDOMAIN ),
				// Field id		
				'id' => 'title',
				// Field type ( text, checkbox, textarea, select, select-group, taxonomy, taxonomyterm, pages, hidden )
				'type' => 'text',
				// Class, rows, cols								
				'class' => 'widefat',
				// Default value						
				'std' => __( 'Recent Posts', CA_TEXTDOMAIN ),
				/**
				  Set the field validation type/s

				  'alpha_dash'
				  Returns FALSE if the value contains anything other than alpha-numeric characters, underscores or dashes.

				  'alpha'
				  Returns FALSE if the value contains anything other than alphabetical characters.

				  'alpha_numeric'
				  Returns FALSE if the value contains anything other than alpha-numeric characters.

				  'numeric'
				  Returns FALSE if the value contains anything other than numeric characters.

				  'boolean'
				  Returns FALSE if the value contains anything other than a boolean value ( true or false ).

				  ----------

				  You can define custom validation methods. Make sure to return a boolean ( TRUE/FALSE ).
				  Example:

				  'validate' => 'my_custom_validation',

				  Will call for: $this->my_custom_validation( $value_to_validate );
				 */
				'validate' => 'alpha_dash',
				/**
				  Filter data before entering the DB

				  strip_tags ( default )
				  wp_strip_all_tags
				  esc_attr
				  esc_url
				  esc_textarea
				 */
				'filter' => 'strip_tags|esc_attr'
			),
			// Taxonomy Field
			array(
				// Field name/label									
				'name' => __( 'Taxonomy', CA_TEXTDOMAIN ),
				// Field description					
				'desc' => __( 'Set the taxonomy.', CA_TEXTDOMAIN ),
				// Field id		
				'id' => 'taxonomy',
				'type' => 'taxonomy',
				// Class, rows, cols								
				'class' => 'widefat',
			),
			// Taxonomy Field
			array(
				// Field name/label									
				'name' => __( 'Taxonomy terms', CA_TEXTDOMAIN ),
				// Field description					
				'desc' => __( 'Set the taxonomy terms.', CA_TEXTDOMAIN ),
				// Field id		
				'id' => 'taxonomyterm',
				'type' => 'taxonomyterm',
				'taxonomy' => 'category',
				// Class, rows, cols								
				'class' => 'widefat',
			),
			// Pages Field
			array(
				// Field name/label									
				'name' => __( 'Pages', CA_TEXTDOMAIN ),
				// Field description					
				'desc' => __( 'Set the page.', CA_TEXTDOMAIN ),
				// Field id		
				'id' => 'pages',
				'type' => 'pages',
				// Class, rows, cols								
				'class' => 'widefat',
			),
			// Post type Field
			array(
				// Field name/label									
				'name' => __( 'Post type', CA_TEXTDOMAIN ),
				// Field description					
				'desc' => __( 'Set the post type.', CA_TEXTDOMAIN ),
				// Field id		
				'id' => 'posttype',
				'type' => 'posttype',
				'posttype' => 'post',
				// Class, rows, cols								
				'class' => 'widefat',
			),
			// Amount Field
			array(
				'name' => __( 'Amount' ),
				'desc' => __( 'Select how many posts to show.', CA_TEXTDOMAIN ),
				'id' => 'amount',
				'type' => 'select',
				// Selectbox fields			
				'fields' => array(
					array(
						// Option name
						'name' => __( '1 Post', CA_TEXTDOMAIN ),
						// Option value			
						'value' => '1'
					),
					array(
						'name' => __( '2 Posts', CA_TEXTDOMAIN ),
						'value' => '2'
					),
					array(
						'name' => __( '3 Posts', CA_TEXTDOMAIN ),
						'value' => '3'
					)

				// Add more options
				),
				'validate' => 'my_custom_validation',
				'filter' => 'strip_tags|esc_attr',
			),
			// Output type checkbox
			array(
				'name' => __( 'Output as list', CA_TEXTDOMAIN ),
				'desc' => __( 'Wraps posts with the <li> tag.', CA_TEXTDOMAIN ),
				'id' => 'list',
				'type' => 'checkbox',
				// Checked by default: 
				'std' => 1, // 0 or 1
				'filter' => 'strip_tags|esc_attr',
			),
			// Add more fields
		);
		// Create widget
		$this->create_widget( $args );
	}

	/**
	 * Custom validation for this widget 
	 * 
	 * @param string $value The text.
	 * 
	 * @return boolean 
	 */
	function my_custom_validation( $value ) {
		if ( strlen( $value ) > 1 ) {
			return false;
		}
		return true;
	}

	/**
	 * Output function
	 * 
	 * @param array $args     The argument shared to the output from WordPress.
	 * @param array $instance The settings saved.
	 * 
	 * @return void
	 */
	function widget( $args, $instance ) {
		$out = $args[ 'before_widget' ];
		// And here do whatever you want
		$out .= $args[ 'before_title' ];
		$out .= $instance[ 'title' ];
		$out .= $args[ 'after_title' ];

		// Here you would get the most recent posts based on the selected amount: $instance['amount'] 
		// Then return those posts on the $out variable ready for the output
		$out .= '<p>Hey There! </p>';

		$out .= $args[ 'after_widget' ];
		echo $out;
	}

}

// Register widget
if ( !function_exists( 'ca_my_register_widget' ) ) {

	/**
	 * Initialize the widget
	 * 
	 * @return void
	 */
	function ca_my_register_widget() {
		register_widget( 'Ca_My_Recent_Posts_Widget' );
	}

	add_action( 'widgets_init', 'ca_my_register_widget', 1 );
}
