<?php
/**
 * JAKES EDITED FUNCTIONS.PHP
 * 
 */

// custom shortcode template sections
global $breakout_card_grid_cards;
$breakout_card_grid_cards = [];

function breakout_card_shortcode($atts, $content = null) {
	global $breakout_card_grid_cards;

	$atts = shortcode_atts([
		'header' => '',
		'reviews' => '',
		'pid' => '',
	], $atts);

	// Save each card as an array
	$breakout_card_grid_cards[] = [
		'header'  => $atts['header'],
		'reviews'  => $atts['reviews'],
		'pid'  => $atts['pid'],

		'content' => do_shortcode($content),
	];

	return ''; // Don't render here — it will be rendered by the parent
}
add_shortcode('breakout_card', 'breakout_card_shortcode');

function breakout_card_grid_shortcode($atts, $content = null) {
	global $breakout_card_grid_cards;
	$breakout_card_grid_cards = []; // Reset before processing

	$atts = shortcode_atts([
		'image_src'  => '',
		'sub_header' => '',
		'header'     => '',
	], $atts);

	// Process nested shortcodes (collect cards)
	do_shortcode($content);

	ob_start();
?>
<div class="breakout text-center" style="background-image: url('<?php echo esc_url($atts['image_src']); ?>');" id="wrap_container">
	<div class="large-wrapper">
		<?php if (!empty($atts['sub_header'])): ?>
		<b class="spaced"><?php echo esc_html($atts['sub_header']); ?></b>
		<?php endif; ?>

		<?php if (!empty($atts['header'])): ?>
		<h2><?php echo esc_html($atts['header']); ?></h2>
		<?php endif; ?>

		<div class="row container-fluid justify-content-center ">
			<?php foreach ($breakout_card_grid_cards as $card): ?>
			<div class="w-100">
				<div class="wrap">

					<?php if (!empty($card['reviews'])): ?>
					<img src="/wp-content/uploads/google.png" alt="Google" width="40" height="40" class="alignnone size-full brand" />
					<img src="/wp-content/uploads/stars.webp" alt="Stars" width="400" height="38" class="alignnone size-full stars" />
					<?php endif; ?>

					<?php if (!empty($card['header'])): ?>
					<h3><?php echo esc_html($card['header']); ?></h3>
					<?php endif; ?>

					<p><?php echo wp_kses_post($card['content']); ?></p>

					<?php if (!empty($card['pid'])): ?>
					<a class="btn" title="Leave a review!" href="https://search.google.com/local/writereview?placeid=<?php echo esc_html($card['pid']); ?>" target="_blank" rel="noopener noreferrer">Leave a review</a>
					<?php endif; ?>

				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php

	return ob_get_clean();
}
add_shortcode('breakout_card_grid', 'breakout_card_grid_shortcode');

// Register [breakout_half_overlay] shortcode
function breakout_half_overlay_shortcode($atts, $content = null) {
	$atts = shortcode_atts([
		'image_src'  => '',
		'sub_header' => '',
		'header'     => '',
	], $atts);

	ob_start();
?>

<div class="breakout text-center text-md-left bg-img half-overlayed invert" style="background-image: url('<?php echo esc_url($atts['image_src']); ?>');">
	<div class="large-wrapper">
		<div class="row">
			<div class="col-md-6">
				<?php if (!empty($atts['sub_header'])): ?>
				<strong class="spaced"><?php echo esc_html($atts['sub_header']); ?></strong>
				<?php endif; ?>

				<?php if (!empty($atts['header'])): ?>
				<h2><?php echo esc_html($atts['header']); ?></h2>
				<?php endif; ?>

				<?php if (!empty($content)): ?>
				<?php echo do_shortcode(wp_kses_post($content)); ?>
				<?php endif; ?>
			</div>
			<div class="col-md-6">
				<!-- Empty right column (optional use) -->
			</div>
		</div>
	</div>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('breakout_half_overlay', 'breakout_half_overlay_shortcode');


function breakout_iframe_shortcode($atts, $content = null) {
	$atts = shortcode_atts([
		'iframe_src' => '',
		'iframe_title' => '',
	], $atts);

	ob_start();
?>
<div class="breakout p-0">
	<iframe style="border: 0;"
			title="<?php echo $atts['iframe_title']; ?>" 
			src="<?php echo esc_url($atts['iframe_src']); ?>"  
			width="100%" 
			height="400" 
			allowfullscreen="allowfullscreen">
	</iframe>
</div>
<?php
	return ob_get_clean();
}

add_shortcode('breakout_iframe', 'breakout_iframe_shortcode');

function breakout_slider_gn_shortcode($atts, $content = null) {
	$atts = shortcode_atts([
		'image_src'   => '',
		'header'      => '',
		'sub_header'  => '',
	], $atts);

	ob_start();
?>
<div class="breakout p-0">
	<section class="slider-wrapper">
		<ul class="slides-container" id="slides-container">
			<li class="slide" style="background-image: url('<?php echo esc_url($atts['image_src']); ?>')">
				<div class="slider-content d-flex justify-content-center">
					<?php if (!empty($atts['sub_header'])): ?>
					<div class="slide-sub-header"><?php echo esc_html($atts['sub_header']); ?></div>
					<?php endif; ?>

					<?php if (!empty($atts['header'])): ?>
					<div class="slide-header"><?php echo esc_html($atts['header']); ?></div>
					<?php endif; ?>

					<?php if (!empty($content)): ?>
					<div class="all-the-ctas"><?php echo do_shortcode(wpautop($content)); ?></div>
					<?php endif; ?>
				</div>
			</li>
		</ul>
	</section>
</div>
<?php
	return ob_get_clean();
}

add_shortcode('breakout_slider_gn', 'breakout_slider_gn_shortcode');

function breakout_image_half($atts, $content = null) {
	$atts = shortcode_atts([
		'image_src' => '',
		'alt'       => '',
		'sub_title' => '',
		'title'     => '',
	], $atts);

	// Auto-generate alt from filename if none provided
	if (empty($atts['alt']) && !empty($atts['image_src'])) {
		$path_parts = pathinfo($atts['image_src']);
		$filename = $path_parts['filename'] ?? '';
		$auto_alt = ucwords(str_replace(['-', '_'], ' ', $filename));
		$atts['alt'] = $auto_alt;
	}

	ob_start();
?>
<div class="breakout text-md-left text-center">
	<div class="large-wrapper">
		<div class="row">
			<div class="col-md-6 ">
				<div class="bg-img bg-c" style="background-image: url('<?php echo esc_url($atts['image_src']); ?>');"></div>
			</div>
			<div class="col-md-6 px-md-5 mt-md-0 mt-4">
				<?php if (!empty($atts['sub_title'])): ?>
				<b class="spaced"><?php echo esc_html($atts['sub_title']); ?></b>
				<?php endif; ?>

				<?php if (!empty($atts['title'])): ?>
				<h2><?php echo esc_html($atts['title']); ?></h2>
				<?php endif; ?>

				<?php if (!empty($content)): ?>
				<div class="breakout-content">
					<?php echo do_shortcode(wp_kses_post($content)); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php
	return ob_get_clean();
}

add_shortcode('breakout_image_half', 'breakout_image_half');

function breakout_h1_simple($atts, $content = null) {
	$atts = shortcode_atts([
		'sub_title' => '',
		'title' => '',
	], $atts);

	ob_start();
?>
<div class="breakout text-center dk invert">
	<div class="medium-wrapper ">
		<?php if (!empty($atts['sub_title'])): ?>
		<b class="spaced"><?php echo esc_html($atts['sub_title']); ?></b>
		<?php endif; ?>

		<?php if (!empty($atts['title'])): ?>
		<h1><?php echo esc_html($atts['title']); ?></h1>
		<?php endif; ?>

		<?php if (!empty($content)): ?>
		<?php echo do_shortcode($content); ?>
		<?php endif; ?>
	</div>
</div>
<?php
	return ob_get_clean();
}

add_shortcode('breakout_h1_simple', 'breakout_h1_simple');

function breakout_h2_simple($atts, $content = null) {
	$atts = shortcode_atts([
		'sub_title' => '',
		'title' => '',
	], $atts);

	ob_start();
?>
<div class="breakout text-center lt">
	<div class="medium-wrapper ">
		<?php if (!empty($atts['sub_title'])): ?>
		<b class="spaced "><?php echo esc_html($atts['sub_title']); ?></b>
		<?php endif; ?>

		<?php if (!empty($atts['title'])): ?>
		<h2><?php echo esc_html($atts['title']); ?></h2>
		<?php endif; ?>

		<?php if (!empty($content)): ?>
		<?php echo do_shortcode($content); ?>
		<?php endif; ?>
	</div>
</div>
<?php
	return ob_get_clean();
}

add_shortcode('breakout_h2_simple', 'breakout_h2_simple');

//------------------------------------------------------------------------------------------//


function accordion_section_shortcode($atts, $content = null) {
	$atts = shortcode_atts([
		'title' => '',
	], $atts);

	ob_start();
?>

<div class="accordion ">
	<?php if (!empty($atts['title'])): ?>
	<?php echo esc_html($atts['title']); ?>
	<?php endif; ?>
</div>

<div class="panel">
	<div class="inner">               
		<?php if (!empty($content)): ?>
		<?php echo do_shortcode($content); ?>
		<?php endif; ?>
	</div>
</div>

<?php
	return ob_get_clean();
}

add_shortcode('accordion_section', 'accordion_section_shortcode');


//------------------------------------------------------------------------------------------//


function widgets_theme_support() {
	remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'widgets_theme_support' );

add_filter('the_content', 'remove_empty_p', 11);
function remove_empty_p($content){
	$content = force_balance_tags($content);
	//return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
	return preg_replace('#<p></p>#i', '', $content);
}

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function biziq_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on biziq, use a find and replace
		* to change 'biziq' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'biziq', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'biziq' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'biziq_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);



	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$table_name = $wpdb->prefix . 'smart_plugins';
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
	 id INTEGER NOT NULL AUTO_INCREMENT,
	 plugin TEXT NOT NULL,
	 page TEXT NOT NULL,
	 PRIMARY KEY (id)
	 ) $charset_collate;";
	dbDelta( $sql );






}
add_action( 'after_setup_theme', 'biziq_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function biziq_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'biziq_content_width', 640 );
}
add_action( 'after_setup_theme', 'biziq_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

/**
 * Enqueue scripts and styles.
 */
function biziq_scripts() {
	wp_enqueue_style( 'biziq-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'biziq-style', 'rtl', 'replace' );

	wp_enqueue_script( 'biziq-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'biziq_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}





/* Automatically set the image Title and Alt-Text upon upload
 * props to Dominika K. @ wpkraken.io
-----------------------------------------------------------------------*/

add_action( 'add_attachment', 'my_set_image_meta_upon_image_upload' );

function my_set_image_meta_upon_image_upload( $post_ID ) {
	if ( wp_attachment_is_image( $post_ID ) ) {
		$my_image_title = get_post( $post_ID )->post_title;
		$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ', $my_image_title );
		$my_image_title = ucwords( strtolower( $my_image_title ) );

		$my_image_meta = array(
			'ID' => $post_ID,
			'post_title' => $my_image_title,
		);

		update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );
		wp_update_post( $my_image_meta );
	}
}







function logo_init() {

	register_sidebar( array(
		'name'     => 'Logo',
		'id'      => 'logo',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2 class="rounded">',
		'after_title'  => '</h2>',
	) );

}
add_action( 'widgets_init', 'logo_init' );




function phone_init() {

	register_sidebar( array(
		'name'     => 'Phone',
		'id'      => 'phone',
		'before_widget' => '',
		'after_widget' => '',
	) );

}
add_action( 'widgets_init', 'phone_init' );




/*-------desktop top bar------*/
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Desktop Top Bar',
		'id' => 'desktop_top_bar',
		'before_widget' => '',
		'after_widget' => '',
	)
					);




function footer_widget_left() {

	register_sidebar( array(
		'name'     => 'Footer Left',
		'id'      => 'footer_widget_left',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="rounded">',
		'after_title'  => '</h2>',
	) );

}
add_action( 'widgets_init', 'footer_widget_left' );




function footer_widget_center() {

	register_sidebar( array(
		'name'     => 'Footer Center',
		'id'      => 'footer_widget_center',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="rounded">',
		'after_title'  => '</h2>',
	) );

}
add_action( 'widgets_init', 'footer_widget_center' );




function footer_widget_right() {

	register_sidebar( array(
		'name'     => 'Footer Right',
		'id'      => 'footer_widget_right',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="rounded">',
		'after_title'  => '</h2>',
	) );

}
add_action( 'widgets_init', 'footer_widget_right' );



function new_excerpt_more( $more ) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');









function biziq_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'biziq' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'biziq' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'biziq_widgets_init' );










/*
===========================================*/



function smart_plugin_create_db() {

	// global $wpdb;
	// $charset_collate = $wpdb->get_charset_collate();
	// require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	// $table_name = $wpdb->prefix . 'smart_plugins';
	// $sql = "CREATE TABLE IF NOT EXISTS $table_name (
	// id INTEGER NOT NULL AUTO_INCREMENT,
	// plugin TEXT NOT NULL,
	// page TEXT NOT NULL,
	// PRIMARY KEY (id)
	// ) $charset_collate;";
	// dbDelta( $sql );

}

register_activation_hook( __FILE__, 'smart_plugin_create_db' );








function plugin_sideloader_create_menu() {

	add_menu_page('Biziq Plugin', 'Biziq Plugin', 'administrator', "plugin-loader", 'plugin_sideload_page' , plugins_url('/static/imgs/logo.png', __FILE__), 26 );	
}

add_action('admin_menu', 'plugin_sideloader_create_menu');




function plugin_sideload_page(){

	global $wpdb;
	$table_name = $wpdb->prefix . 'smart_plugins';
	$rewrite = false;

	// var_dump( shell_exec("cd $path;cat load.php;") );
	$path = plugin_dir_path( str_replace( "themes/", "",  __DIR__ ) ) . "mu-plugins";
	$dirs = scandir($path);
	$dirs = array_diff(scandir($path), array('.', '..', 'load.php'));

	$loaded_file;

	$plugins = Array();



	// =======================================

	if( isset($_GET['del']) ){

		$sql = "DELETE FROM $table_name WHERE id = " . $_GET['del'];
		$wpdb->query($sql);

		$rewrite = true;


	}


	if(isset($_GET['plugins'])){

		$sql = "INSERT INTO ". $table_name ." set plugin='" . $_GET['plugins'] . "',page='" . $_GET['pages'] . "' ";

		$wpdb->query($sql);

		$rewrite = true;


	}


	if($rewrite){

		$sql = "SELECT * FROM $table_name";
		$results = $wpdb->get_results($sql);

		$sh = "cd $path;";
		$sh .= "echo '<?php' > load.php;";

		foreach( $results as $r ){

			if( $r->page == "home" ){

				$sh .= 'echo "'. 'if(\$_SERVER["REQUEST_URI"]  == \"/\" ){require_once(\"'. $r->plugin .'\");}' . '" >> load.php;' ;

				$sh .= 'echo "'. 'if(strpos(\$_SERVER[\"REQUEST_URI\"],\"wp-admin\") == true && strpos(\$_SERVER[\"REQUEST_URI\"], \"customize.php\") == false){require_once(\"'. $r->plugin .'\");}' . '" >> load.php;' ;

				continue;
			}

			$sh .= 'echo "'. 'if(strpos(\$_SERVER[\"REQUEST_URI\"],\"'. $r->page .'\") == true && strpos(\$_SERVER[\"REQUEST_URI\"], \"customize.php\") == false){require_once(\"'. $r->plugin .'\");}' . '" >> load.php;' ;

			$sh .= 'echo "'. 'if(strpos(\$_SERVER[\"REQUEST_URI\"],\"wp-admin\") == true && strpos(\$_SERVER[\"REQUEST_URI\"], \"customize.php\") == false){require_once(\"'. $r->plugin .'\");}' . '" >> load.php;' ;

		}

		$sh .= 'echo "'. 'if(strpos($_SERVER["REQUEST_URI"],\"json\") == true ){require_once(\"contact-form-7/wp-contact-form-7.php\");require_once(\"invisible-recaptcha/invisible-recaptcha.php\");require_once(\"contact-form-7-honeypot/honeypot.php\");}'  . '" >> load.php;' ;


		$sh .= "cat load.php;";

		shell_exec( $sh);

?><script>location = "/wp-admin/admin.php?page=plugin-loader";</script><?php


	}

	// =======================================


?>

<h1>BizIQ Plugins</h1>

<?php


	foreach($dirs as $dir){

		$files = ( shell_exec("cd " . $path . "/" . $dir . "; ls | grep $dir.php") );

		if( $files == "" ){

			$files = shell_exec("cd " . $path . "/" . $dir . "; ls | grep .php");
			$files = trim(preg_replace('/\s+/', ' ', $files));
			$files = explode(" ", $files);

			if( count($files) > 1 ){
				foreach($files as $file){
					array_push($plugins, "$dir/$file");
				}
			}else{
				array_push($plugins, "$dir/$files[0]");
			}

		}else{

			$loaded_file = $files;
			$tmp =  shell_exec( "cat $path/$dir/$loaded_file" );
			$plugin_data = get_plugin_data( "$path/$dir/$loaded_file" );
			$plugin_name = $plugin_data['TextDomain'];
			array_push($plugins, "$dir/$loaded_file");
		}

	}



	$sql = "SELECT * FROM $table_name";
	$results = $wpdb->get_results($sql);

?>

<table>
	<thead>
		<tr>
			<td>Plugin</td>
			<td>Page</td>
			<td>Action</td>
		</tr>
	</thead>
	<tbody>
		<?php 
	foreach( $results as $r ){
		echo "<tr><td>". explode("/", $r->plugin)[1] ."</td><td>$r->page</td><td><a href='/wp-admin/admin.php?page=plugin-loader&del=$r->id'>delete</a></td></tr>" ;
	}
		?>
	</tbody>
</table>

<style>
	table {
		border: 1px solid #aaa;
		padding: 15px;
		width: 500px;
		margin-bottom: 15px;
	}

	table thead {
		font-weight: 700;
	}

	table tbody tr td {
		padding: 15px 15px 15px 0;
	}

	table tbody tr td a {
		color: red;
		text-decoration: none;
	}

	form {
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-orient: vertical;
		-webkit-box-direction: normal;
		-ms-flex-flow: column;
		flex-flow: column;
		width: 300px;
		max-width: 100%;
	}

</style>



<form action="" method="GET">
	<input type="hidden" name="page" value="plugin-loader">

	<strong>Pages:</strong>
	<select name="pages">
		<?php 
	foreach(get_pages() as $page){
		?>
		<option value="<?php echo $page->post_name; ?>"><?php echo $page->post_title; ?></option>
		<?php
	}
		?>
	</select><br>

	<strong>Plugin Files</strong>
	<select name="plugins">
		<?php 
	foreach($plugins as $plugin){
		$plugin = trim(preg_replace('/\s\s+/', ' ', $plugin));
		?>
		<option value="<?php echo $plugin; ?>"><?php echo explode("/", $plugin)[1]; ?></option>
		<?php
	}
		?>
	</select><br>

	<input type="submit">

</form>


<?php
























}


