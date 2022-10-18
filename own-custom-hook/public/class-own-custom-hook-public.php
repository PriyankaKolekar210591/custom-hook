<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://#
 * @since      1.0.0
 *
 * @package    Own_Custom_Hook
 * @subpackage Own_Custom_Hook/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Own_Custom_Hook
 * @subpackage Own_Custom_Hook/public
 * @author     Priyanka Kolekar <priyankasurve091@gmail.com>
 */
class Own_Custom_Hook_Public {


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Own_Custom_Hook_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Own_Custom_Hook_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/own-custom-hook-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Own_Custom_Hook_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Own_Custom_Hook_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/own-custom-hook-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Create own table shortcode
	 */
	public function register_shortcodes() {
		add_shortcode( 'extend_table_shortcode', array( $this, 'shortcode_function' ) );
	}

	/**
	 * Create shortcode for create table.
	 */
	public function shortcode_function() {
		ob_start();
		$args      = array(
			'post_type'      => 'post',
			'posts_per_page' => -1,
		);
		$all_posts = new WP_Query( $args );
		if ( $all_posts->have_posts() ) :
			do_action( 'custom_poststable_after' ); ?>
			<div class="custom-table-div" style="overflow-x:auto;">
				<table class="table table-bordered custom-table">
					<thead>
						<tr>
							<?php do_action( 'custom_postsheader_before' ); ?>
							<th>Post ID</th>
							<th>Post Thumbnail Image</th>
							<th>Post Title</th>
							<th>Post Excerpt</th>
							<?php do_action( 'custom_postsheader_after' ); ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post();
								?>
								<?php do_action( 'custom_posts_column_content_before' ); ?>
								<td><?php echo esc_html( get_the_ID() ); ?></td>
								<td>
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail();
								} else {
									the_title_attribute(); }
								?>
								</td>
								<td><a href="<?php esc_url( the_permalink() ); ?>"><?php esc_html( the_title() ); ?></a></td>
								<td><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></td>
								<?php do_action( 'custom_posts_column_content_after' ); ?>
						</tr>
					<?php endwhile; ?>
					</tbody>
				</table>
			</div>
			<!-- end of the loop -->
			<?php
			do_action( 'custom_poststable_after' );

		else :
			?>
			<p> <?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php
		endif;
		wp_reset_postdata();
		return ob_get_clean();
	}

	/**
	 * Create Header for table.
	 *
	 * @return void
	 */
	public function add_custom_column() {
		?>
		<th>Post Author Name & Email</th>
		<th></th>
		<?php
	}

	/**
	 * Add Content in custom columns.
	 *
	 * @return void
	 */
	public function custom_column_content() {
		?>

		<td><?php esc_html( the_author() ); ?><br/><?php esc_html( the_author_meta( 'email' ) ); ?></td>
		<td><a href="<?php esc_url( the_permalink() ); ?>"><button class="view-button">View Details</button></td>
		<?php
	}
}
