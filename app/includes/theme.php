<?php
// no direct access
defined('ABSPATH') || die();

/**
 * Plugin Theme Class.
 *
 * @class LSDRC_Theme
 * @version    1.0.0
 */
class LSDRC_Theme extends LSDRC_Base
{
    public function register_block_pattern()
    {
        register_block_pattern(
            'listdomer/listdomer-two-buttons-pattern',
            [
                'title' => __('Listdomer Two buttons', 'listdomer-core'),
                'description' => _x('Listdomer Two horizontal buttons, the left button is filled in, and the right button is outlined.', 'Listdomer Two horizontal buttons', 'listdomer-core'),
                'content' => "<!-- wp:buttons {\"align\":\"center\"} -->\n<div class=\"wp-block-buttons wp-listdomer-block-buttons aligncenter\"><!-- wp:button {\"backgroundColor\":\"very-dark-gray\",\"borderRadius\":0} -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link has-background has-very-dark-gray-background-color no-border-radius\">" . esc_html__('Button One', 'listdomer-core') . "</a></div>\n<!-- /wp:button -->\n\n<!-- wp:button {\"textColor\":\"very-dark-gray\",\"borderRadius\":0,\"className\":\"is-style-outline\"} -->\n<div class=\"wp-block-button is-style-outline\"><a class=\"wp-block-button__link has-text-color has-very-dark-gray-color no-border-radius\">" . esc_html__('Button Two', 'listdomer') . "</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->",
            ]
        );
    }

    public function register_block_style()
    {
        register_block_style('core/button', [
            'name' => 'listdomer-button',
            'label' => __('Listdomer Button', 'listdomer-core'),
        ]);

        register_block_style('core/table', [
            'name' => 'listdomer-table',
            'label' => __('Listdomer Table', 'listdomer-core'),
        ]);
    }

    public function header_buttons()
    {
        // General Settings
        $settings = class_exists('LSD_Options') ? LSD_Options::settings() : [];

        // Dashboard Page
        $dashboard_page_id = isset($settings['submission_page']) && $settings['submission_page'] ? $settings['submission_page'] : 0;

        // Language Switcher Status
        $language_switcher_status = LSDRC_Settings::get('listdomer_header_language_switcher');

        // Language Switcher
        if ($language_switcher_status)
        {
            if (function_exists('pll_the_languages'))
            {
                $output = pll_the_languages([
                    'show_flags' => 1,
                    'show_names' => 0,
                    'echo' => 0,
                ]);

                echo '<div class="listdomer-language-switcher"><div class="listdomer-polylang"><ul>' . LSDRC_Base::kses($output) . '</ul></div></div>';
            }
            else
            {
                ob_start();
                do_action('wpml_language_switcher', [
                    'flags' => 1,
                    'native' => 0,
                    'translated' => 0,
                ], '');

                $output = ob_get_clean();
                if (trim($output)) echo '<div class="listdomer-language-switcher listdomer-wpml">' . LSDRC_Base::kses($output) . '</div>';
            }
        }

        // User Buttons Status
        $user_buttons_status = LSDRC_Settings::get('listdomer_header_logister');

        // User Button
        if (is_user_logged_in() && $user_buttons_status)
        {
            if ($dashboard_page_id)
            {
                $url = rtrim(get_permalink($dashboard_page_id), '/ ') . '/?mode=manage';
                echo '<div class="listdomer-user-button"><a class="listdomer-dashboard-link" href="' . esc_url($url) . '"><i class="fas fa-tachometer-alt"></i></a></div>';
            }
        }
        else if ($user_buttons_status)
        {
            echo '<div class="listdomer-user">';
            echo '<button class="listdomer-user-button" id="listdomer-user-button"><span><i class="far fa-user"></i></span></button>';
            echo '<div class="listdomer-user-logister-wrapper">' . LSDRC_Base::kses($this->logister()) . '</div>';
            echo '</div>';
        }

        // Add Listing Status
        $add_listing_status = LSDRC_Settings::get('listdomer_header_add_listing');

        // Add Listing Button
        if ($add_listing_status && $dashboard_page_id)
        {
            $guest_submission = isset($settings['submission_guest']) && $settings['submission_guest'];

            $url = rtrim(get_permalink($dashboard_page_id), '/ ') . '/?mode=form';
            $url = (is_user_logged_in() ? $url : ($guest_submission ? $url : wp_login_url($url)));

            echo '<div class="listdomer-add-listing"><a href="' . esc_url($url) . '">' . esc_html__('Add Listing', 'listdomer-core') . '</a></div>';
        }
    }

    public function logister()
    {
        $defaults = [];

        /**
         * Filters the default login form output arguments.
         *
         * @param array $defaults An array of default login form arguments.
         * @see wp_login_form()
         *
         * @since 3.0.0
         *
         */
        $args = wp_parse_args([], apply_filters('login_form_defaults', $defaults));

        /**
         * Filters content to display at the top of the login form.
         *
         * The filter evaluates just following the opening form tag element.
         *
         * @param string $content Content to display. Default empty.
         * @param array $args Array of login form arguments.
         * @since 3.0.0
         *
         */
        $login_form_top = apply_filters('login_form_top', '', $args);

        /**
         * Filters content to display in the middle of the login form.
         *
         * The filter evaluates just following the location where the 'login-password'
         * field is displayed.
         *
         * @param string $content Content to display. Default empty.
         * @param array $args Array of login form arguments.
         * @since 3.0.0
         *
         */
        $login_form_middle = apply_filters('login_form_middle', '', $args);

        /**
         * Filters content to display at the bottom of the login form.
         *
         * The filter evaluates just preceding the closing form tag element.
         *
         * @param string $content Content to display. Default empty.
         * @param array $args Array of login form arguments.
         * @since 3.0.0
         *
         */
        $login_form_bottom = apply_filters('login_form_bottom', '', $args);

        // Lost Password URL
        $lostpassword_url = wp_lostpassword_url();

        // Registration Status
        $registration_status = get_option('users_can_register');

        $login_redirect_page = LSDRC_Settings::get('listdomer_login_redirect');
        if ($login_redirect_page) $login_redirect = get_permalink($login_redirect_page);
        else $login_redirect = '';

        if (!$login_redirect && isset($args['redirect']) && trim($args['redirect'])) $login_redirect = $args['redirect'];

        $login = '<form name="listdomer-loginform" action="' . esc_url(site_url('wp-login.php', 'login_post')) . '" method="post">
			' . $login_form_top . '
			
			<label for="listdomer_header_login_username" class="screen-reader-text">' . __('Username', 'listdomer-core') . '</label>
			<input type="text" id="listdomer_header_login_username" name="log" placeholder="' . esc_attr__('Username', 'listdomer-core') . '" value="" size="20">
			<label for="listdomer_header_login_password" class="screen-reader-text">' . __('Password', 'listdomer-core') . '</label>
			<input type="password" id="listdomer_header_login_password" name="pwd" placeholder="' . esc_attr__('Password', 'listdomer-core') . '" value="" size="20">
			
			' . $login_form_middle . '
			<div class="listdomer-login-forgot-wrapper">
			    <a class="listdomer-lostpassword" href="' . esc_url($lostpassword_url) . '">' . esc_html__('Lost your password?', 'listdomer-core') . '</a>
				<label class="listdomer-login-remember listdomer-checkbox">' . esc_html__('Remember Me', 'listdomer-core') . '<input name="rememberme" type="checkbox" value="forever"><span class="checkmark"></span></label>
            </div>
			
			<input type="submit" name="wp-submit" value="' . esc_attr__('Sign In', 'listdomer-core') . '">
			<input type="hidden" name="redirect_to" value="' . esc_url($login_redirect) . '">
			
			' . ($registration_status ? '<div class="listdomer-register-wrapper">
				<p>' . esc_html__("Don't have an account?", 'listdomer-core') . '</p>
				<span class="listdomer-login-register-toggle" data-target="register">' . esc_html__('Create Account', 'listdomer-core') . '</span>
			</div>' : '') . '
			' . $login_form_bottom . '
		</form>';

        // Filter Login Form
        $login = apply_filters('lsdrc_header_login_form', $login);

        // Registration is not allowed
        if (!$registration_status) return $login;

        ob_start();
        do_action('register_form');
        $hook = ob_get_clean();

        $register_redirect_page = LSDRC_Settings::get('listdomer_register_redirect');
        if ($register_redirect_page) $register_redirect = get_permalink($register_redirect_page);
        else $register_redirect = '';

        if (!$register_redirect && isset($args['redirect']) && trim($args['redirect'])) $register_redirect = $args['redirect'];

        $register = '<form name="listdomer-registerform" class="listdomer-util-hide" action="' . esc_url(site_url('wp-login.php?action=register', 'login_post')) . '" method="post" novalidate="novalidate">
            
            <label for="listdomer_header_register_username" class="screen-reader-text">' . __('Username', 'listdomer-core') . '</label>
			<input type="text" id="listdomer_header_register_username" name="user_login" value="" size="20" autocapitalize="off" placeholder="' . esc_attr__('Username', 'listdomer-core') . '">
			<label for="listdomer_header_register_email" class="screen-reader-text">' . __('Email', 'listdomer-core') . '</label>
			<input type="email" id="listdomer_header_register_email" name="user_email" value="" size="25" placeholder="' . esc_attr__('Email', 'listdomer-core') . '">
			
			' . $hook . '
			<div class="listdomer-login-info-box">' . esc_html__('Registration confirmation will be emailed to you.', 'listdomer-core') . '</div>
			
			<input type="hidden" name="redirect_to" value="' . esc_url($register_redirect) . '">
			<input type="submit" name="wp-submit" value="' . esc_attr__('Register', 'listdomer-core') . '">
			
			<div class="listdomer-login-wrapper">
				<p>' . esc_html__('Have an account?', 'listdomer-core') . '</p>
				<span class="listdomer-login-register-toggle" data-target="login">' . esc_html__('Signin', 'listdomer-core') . '</span>
			</div>
		</form>';

        // Filter Registration Form
        $register = apply_filters('lsdrc_header_register_form', $register);

        // Social Login
        $social_shortcode = LSDRC_Settings::get('listdomer_social_login_shortcode');

        $social = '';
        if ($social_shortcode)
        {
            $social = '<div class="listdomer-other-signup">
                <div class="listdomer-other-signup-header">
                    <h4>' . esc_html__('Or sign up with', 'listdomer-core') . '</h4>
                </div>
              
                ' . do_shortcode($social_shortcode) . '
            </div>';
        }

        // Filter Social Logins
        $social = apply_filters('lsdrc_header_social_logins', $social);

        return trim($login . $register . $social);
    }
}
