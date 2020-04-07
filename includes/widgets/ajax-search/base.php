<?php

class WooVator_Ajax_Search_Base{

	private static $instance = null;
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

	/**
	 * Default Constructor
	 */
	public function __construct() {

		// ajax callback
		add_action( 'wp_ajax_woovator_ajax_search', [ $this, 'ajax_search_callback' ] );
		add_action( 'wp_ajax_nopriv_woovator_ajax_search', [ $this, 'ajax_search_callback' ] );

		//Register Shortcode
		add_shortcode( 'woovatorsearch', [ $this, 'shortcode' ] );

		// register widget
		add_action( 'widgets_init', [ $this, 'register_widget' ] );
	}

	/**
	 * Register Widget
	 */
	function register_widget(){
		require ( __DIR__ . '/widget-product-search-ajax.php' );
		register_widget( 'WooVator_Product_Search_Ajax_Widget' );
	}

	/**
	 * Ajax Callback method
	 */
	public function ajax_search_callback(){
		$s = isset( $_REQUEST['s'] ) ? $_REQUEST['s'] : '';
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 10;

		check_ajax_referer('woovator_psa_nonce', 'nonce');

		$args = array(
		    'post_type'         => 'product',
		    'posts_per_page'    => $limit,
		    's' => $s,
		);
		$query = new WP_Query( $args );

		ob_start();
		echo '<div class="woovator_psa_inner_wrapper">';

			if( $query->have_posts() ):
				while( $query->have_posts() ): $query->the_post();
					echo $this->search_item();
			    endwhile; // main loop
			    wp_reset_query(); wp_reset_postdata();
			else:
				echo '<p class="text-center woovator_psa_wrapper woovator_no_result">'. esc_html__( 'No Results Found', 'woovator' ) .'</p>';
			endif; // have posts

		echo '</div>';
		echo ob_get_clean();
		wp_die();
	}

	/**
	 * Render Search Item.
	 */
	public function search_item(){
		$searchitem = '';
		ob_start();
		?>
			<div class="woovator_single_psa">
				<a href="<?php the_permalink(); ?>">
					<?php if( has_post_thumbnail( get_the_id() ) ): ?>
						<div class="woovator_psa_image">
							<?php the_post_thumbnail('thumbnail'); ?>
						</div>
					<?php endif; ?>
					<div class="woovator_psa_content">
						<h3><?php echo wp_trim_words( get_the_title(), 5 ); ?></h3>
						<?php woocommerce_template_single_price() ?>
					</div>
				</a>
			</div>
		<?php
		$searchitem .= ob_get_clean();
		return apply_filters( 'woovator_ajaxsearch_item', $searchitem );

	}

	/**
	 * Returns the parsed shortcode.
	 */
	public function shortcode( $atts = array(), $content = '' ) {
		
		extract( shortcode_atts( array(
			'limit' => 10,
			'placeholder' => 'Search Products',
		), $atts, 'woovatorsearch' ) );

		$data_settings = array(
			'limit'=>$limit,
			'wvwidget_id'=>'#wvuniq-'.uniqid(),
		);

		ob_start();
        $output = '';
        $output .= '<div class="woovator_widget_psa" id="wvuniq-'.uniqid().'">
	            <form role="search" method="get" action="'.esc_url( home_url( '/' ) ).'" data-settings='.wp_json_encode( $data_settings ).'>
	                <input type="search" placeholder="'.esc_attr__( $placeholder, 'woovator' ).'" value="'.get_search_query().'" name="s" />
	                <input type="hidden" name="post_type" value="product" />
	                <button type="submit" value="'.esc_attr_x( 'Search', 'submit button', 'woovator' ).'">
	                    <i class="sli sli-magnifier"></i>
	                </button>
	                <span class="woovator_widget_psa_clear_icon"><i class="sli sli-close"></i></span>
	                <span class="woovator_widget_psa_loading_icon"><i class="sli sli-refresh"></i></span>
	                <div id="woovator_psa_results_wrapper"></div>
	            </form>
	        </div>';

		$output .= ob_get_clean();
		return apply_filters( 'woovator_ajaxsearch', $output );
	}

}

WooVator_Ajax_Search_Base::instance();