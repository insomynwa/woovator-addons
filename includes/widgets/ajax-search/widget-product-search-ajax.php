<?php
/**
*  Class Ajax Search Widgets
*/
class WooVator_Product_Search_Ajax_Widget extends WP_Widget{
        
    /**
    * Default Constructor
    */
    public function __construct() {
        $widget_options = array(
            'description' => esc_html__('WooVator Ajax Product Search Widget', 'woovator')
        );
        parent::__construct( 'woovator_widget_psa', __('WooVator: Product Search Ajax', 'woovator'), $widget_options );
    }

    /**
    * Output
    */
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance[ 'title' ] );
        echo $args['before_widget'];
        if( !empty( $instance['title'] ) ){ echo $args['before_title'] . $title . $args['after_title']; }
        $shortcode_atts = [
            'limit' => 'limit="'.$instance[ 'limit' ].'"',
        ];
        echo do_shortcode( sprintf( '[woovatorsearch %s]', implode(' ', $shortcode_atts ) ) );
        echo $args['after_widget'];
    }

    /**
    * Form
    */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $limit = ! empty( $instance['limit'] ) ? $instance['limit'] : ''; ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__( 'Title:', 'woovator' ) ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php echo esc_html__( 'Show Number of Product:', 'woovator' ) ?></label>
            <input type="number" class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo esc_attr( $limit ); ?>" />
        </p>
        <?php
    }

    /**
    * Update
    */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'limit' ] = strip_tags( $new_instance[ 'limit' ] );
        return $instance;
    }

}