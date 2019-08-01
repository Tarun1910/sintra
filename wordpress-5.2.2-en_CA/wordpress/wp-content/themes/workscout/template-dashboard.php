<?php
/**
 * Template Name: Dashboard Page
 *
 * A page showing WooCommerce dashboard navigation.
 *
 *
 * @package WordPress
 * @subpackage workscout
 * @since workscout 1.0
 */

get_header(); 

    while ( have_posts() ) : the_post(); ?> 
<!-- Titlebar
================================================== -->
<?php 

$titlebar = get_post_meta( $post->ID, 'pp_page_titlebar', true ); 
$submit_job_page = get_option('job_manager_submit_job_form_page_id');
$resume_job_page = get_option('resume_manager_submit_resume_form_page_id');

if($titlebar == 'off') {
    // no titlebar
} else {
    if (!empty($submit_job_page) && is_page($submit_job_page) || !empty($resume_job_page) && is_page($resume_job_page)) { ?>
        <!-- Titlebar
        ================================================== -->
        
        <?php $header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
        if(!empty($header_image)) { ?>
            <div id="titlebar" class="photo-bg single submit-page" style="background: url('<?php echo esc_url($header_image); ?>')">
        <?php } else { ?>
            <div id="titlebar" class="single submit-page">
        <?php } ?>
            <div class="container">

                <div class="sixteen columns">
                    <h2><i class="fa fa-plus-circle"></i> <?php the_title(); ?></h2>
                </div>

            </div>
        </div>
    <?php } else { ?>
        <?php $header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
        if(!empty($header_image)) { ?>
            <div id="titlebar" class="photo-bg single" style="background: url('<?php echo esc_url($header_image); ?>')">
        <?php } else { ?>
            <div id="titlebar" class="single">
        <?php } ?>
            <div class="container">

                <div class="sixteen columns">
                    <h1><?php the_title(); ?></h1>
                    <?php if(function_exists('bcn_display')) { ?>
                    <nav id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                        <ul>
                            <?php bcn_display_list(); ?>
                        </ul>
                    </nav>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php 
    }
}
$layout  = get_post_meta( $post->ID, 'pp_sidebar_layout', true ); if ( empty( $layout ) ) { $layout = 'full-width'; }
$class = ($layout !="full-width") ? "eleven columns woocommerce-account" : "sixteen columns woocommerce-account"; ?>

<div class="container <?php echo esc_attr($layout); ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
<?php if(!is_user_logged_in()){

    $action = !empty( $_POST['register'] ) && $_POST['register'] == 'Register'  ? 'register' : 'login';

    ?>


    <?php do_action( 'woocommerce_before_customer_login_form' ); ?>

    <div id="login-register-password" class="columns six my-account woo-login-form">
        <?php do_action('workscout-before-login'); ?>

    <?php wc_print_notices(); ?>
            <ul class="tabs-nav-o" id="login-tabs">
                <li class="<?php if ($action == 'login') echo 'active'; ?>"><a href="#tab-login"><?php esc_html_e('Login','workscout'); ?></a></li>
            
    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                <li class="<?php if ($action == 'register') echo 'active'; ?>"><a href="#tab-register"><?php esc_html_e('Register','workscout'); ?></a></li>
    <?php endif; ?>
            </ul>

            <div id="tab-login" class="tab-content"  style="<?php if ( $action != 'login' ) echo 'display:none' ?>">
                <form method="post" class="login workscout_form">

                    <?php do_action( 'woocommerce_login_form_start' ); ?>

                    <p class="form-row form-row-wide">
                        <label for="username"><?php _e( 'Username or email address', 'woocommerce', 'workscout' ); ?> <span class="required">*</span>
                        <i class="ln ln-icon-Male"></i><input type="text" class="input-text" name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
                        </label>
                    </p>
                    <p class="form-row form-row-wide">
                        <label for="password"><?php _e( 'Password', 'woocommerce', 'workscout' ); ?> <span class="required">*</span>
                        <i class="ln ln-icon-Lock-2"></i><input class="input-text" type="password" name="password" id="password" />
                        </label>
                    </p>

                    <?php do_action( 'woocommerce_login_form' ); ?>

                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-login' ); ?>
                        <input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'workscout' ); ?>" />
                        <label for="rememberme" class="inline">
                            <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'workscout' ); ?>
                        </label>
                    </p>
                    <p class="lost_password">
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'workscout' ); ?></a>
                    </p>
                    <input type="hidden" name="redirect_to" value="<?php echo get_permalink(get_option( 'job_manager_job_dashboard_page_id')); ?>" />

                    <?php do_action( 'woocommerce_login_form_end' ); ?>

                </form>
            </div>

        <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
            <div id="tab-register" class="tab-content" style="<?php if ( $action != 'register' ) echo 'display:none' ?>">
                <form method="post" class="register workscout_form">

                    <?php do_action( 'woocommerce_register_form_start' ); ?>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_username"><?php _e( 'Username', 'workscout' ); ?> <span class="required">*</span>
                             <i class="ln ln-icon-Male"></i><input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" /></label>
                        </p>

                    <?php endif; ?>

                    <p class="form-row form-row-wide">
                        <label for="reg_email"><?php _e( 'Email address', 'workscout' ); ?> <span class="required">*</span>
                        <i class="ln ln-icon-Mail"></i><input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
                        </label>
                    </p>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_password"><?php _e( 'Password', 'workscout' ); ?> <span class="required">*</span>
                            <i class="ln ln-icon-Lock-2"></i>                   
                            <input type="password" class="input-text" name="password" id="reg_password" />
                            </label>
                        </p>

                    <?php endif; 
                    $recaptcha  = Kirki::get_option( 'workscout','pp_woo_recaptcha', false);
                    if($recaptcha){ ?>
                    
                    <p class="form-row captcha_wrapper">
                        <div class="g-recaptcha" data-sitekey="<?php echo get_option('job_manager_recaptcha_site_key'); ?>"></div>
                    </p>
                    <?php } ?>
                    <!-- Spam Trap -->
                    <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'workscout' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

                    <?php do_action( 'woocommerce_register_form' ); ?>
                    <?php do_action( 'register_form' ); ?>

                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-register' ); ?>
                        <input type="submit" class="button" name="register" value="<?php esc_attr_e( 'Register', 'workscout' ); ?>" />
                    </p>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>

                </form>
            </div>
        <?php endif; ?>

    <?php do_action( 'woocommerce_after_customer_login_form' ); ?>
</article>
    <?php
}  else { ?>
        <?php do_action( 'woocommerce_before_account_navigation' ); ?>
        <nav class="woocommerce-MyAccount-navigation">
            <?php 
            $user = wp_get_current_user();
            if ( in_array( 'candidate', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) :
                wp_nav_menu( array( 'theme_location' => 'candidate', 'menu_id' => 'candidate','container' => false, 'fallback_cb' => false ) );  
            endif;  

            if ( in_array( 'employer', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) :
                wp_nav_menu( array( 'theme_location' => 'employer', 'menu_id' => 'employer','container' => false,  'fallback_cb' => false ) ); 
            endif;

            wp_nav_menu( array( 'theme_location' => 'default_customer', 'menu_id' => 'default_customer','container' => false,  'fallback_cb' => false ) ); 
            

            ?>
            <ul>
            <?php 

          
            if ( class_exists( 'WooCommerce' ) ) {
            ?>
                <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                    <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php } ?>
        </nav>
        <?php do_action( 'woocommerce_after_account_navigation' ); ?>

        <div class="woocommerce-MyAccount-content">
            <?php the_content(); ?>

            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'workscout' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div>

            <footer class="entry-footer">
                <?php edit_post_link( esc_html__( 'Edit', 'workscout' ), '<span class="edit-link">', '</span>' ); ?>
            </footer><!-- .entry-footer -->
    
            <?php
                if(get_option('pp_pagecomments','on') == 'on') {
                    
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                }
            ?>
    </article>

    <?php if($layout !="full-width") { get_sidebar(); }?>
    <?php } ?>
</div> <?php

    endwhile; // End of the loop. 

get_footer(); 

?>

