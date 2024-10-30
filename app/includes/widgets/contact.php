<?php
// no direct access
defined('ABSPATH') || die();

/**
 * Listdomer Contact Widget Class.
 *
 * @class LSDRC_Widgets_Contact
 * @version    1.0.0
 */
class LSDRC_Widgets_Contact extends WP_Widget
{
    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct('LSDRC_Widgets_Contact', esc_html__('(Listdomer) Contact', 'listdomer-core'), ['description' => esc_html__('A simple contact details widget to include in footer', 'listdomer-core')]);
    }

    public function widget($args, $instance)
    {
        $email = isset($instance['email']) && is_email($instance['email']) ? $instance['email'] : '';
        $phone = $instance['phone'] ?? '';
        $facebook = $instance['facebook'] ?? '';
        $twitter = $instance['twitter'] ?? '';
        $instagram = $instance['instagram'] ?? '';
        $linkedin = $instance['linkedin'] ?? '';

        // Before Widget
        echo(isset($args['before_widget']) ? LSDRC_Base::kses($args['before_widget']) : '');

        echo '<div class="listdomer-contact-widget">';

        // Print the widget title
        if (!empty($instance['title']))
        {
            echo ($args['before_title'] ?? '') . apply_filters('widget_title', $instance['title']) . ($args['after_title'] ?? '');
        }

        // Logo
        echo '<div class="listdomer-contact-widget-logo-name">
            ' . get_custom_logo() . '
        </div>';

        // Phone & Email
        echo '<ul class="listdomer-contact-widget-info">
            ' . (trim($phone) ? '<li><span>' . esc_html__('Phone', 'listdomer-core') . '</span>' . esc_html($phone) . '</li>' : '') . '
            ' . (trim($email) ? '<li><span>' . esc_html__('Email', 'listdomer-core') . '</span>' . esc_html($email) . '</li>' : '') . '
        </ul>';

        // Social Links
        echo '<ul class="listdomer-contact-widget-social">
            ' . (trim($facebook) ? '<li><a href="' . esc_url($facebook) . '" target="_blank"><i class="fab fa-facebook-f"></i></a></li>' : '') . '
            ' . (trim($twitter) ? '<li><a href="' . esc_url($twitter) . '" target="_blank"><i class="fab fa-twitter"></i></a></li>' : '') . '
            ' . (trim($instagram) ? '<li><a href="' . esc_url($instagram) . '" target="_blank"><i class="fab fa-instagram"></i></a></li>' : '') . '
            ' . (trim($linkedin) ? '<li><a href="' . esc_url($linkedin) . '" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>' : '') . '
        </ul>';

        echo '</div>';

        // After Widget
        echo(isset($args['after_widget']) ? LSDRC_Base::kses($args['after_widget']) : '');
    }

    public function form($instance)
    {
        echo '<div id="' . esc_attr($this->get_field_id('lsdrc_wrapper')) . '">';

        echo '<p>
            <label for="' . esc_attr($this->get_field_id('title')) . '">' . esc_html__('Title', 'listdomer-core') . '</label>
            <input class="widefat" type="text" id="' . esc_attr($this->get_field_id('title')) . '" name="' . esc_attr($this->get_field_name('title')) . '" value="' . (isset($instance['title']) ? esc_attr($instance['title']) : '') . '">
        </p>';

        echo '<p>
            <label for="' . esc_attr($this->get_field_id('email')) . '">' . esc_html__('Email', 'listdomer-core') . '</label>
            <input class="widefat" type="email" id="' . esc_attr($this->get_field_id('email')) . '" name="' . esc_attr($this->get_field_name('email')) . '" value="' . (isset($instance['email']) ? esc_attr($instance['email']) : '') . '">
        </p>';

        echo '<p>
            <label for="' . esc_attr($this->get_field_id('phone')) . '">' . esc_html__('Phone', 'listdomer-core') . '</label>
            <input class="widefat" type="tel" id="' . esc_attr($this->get_field_id('phone')) . '" name="' . esc_attr($this->get_field_name('phone')) . '" value="' . (isset($instance['phone']) ? esc_attr($instance['phone']) : '') . '">
        </p>';

        echo '<p>
            <label for="' . esc_attr($this->get_field_id('facebook')) . '">' . esc_html__('Facebook', 'listdomer-core') . '</label>
            <input class="widefat" type="url" id="' . esc_attr($this->get_field_id('facebook')) . '" name="' . esc_attr($this->get_field_name('facebook')) . '" value="' . (isset($instance['facebook']) ? esc_attr($instance['facebook']) : '') . '">
        </p>';

        echo '<p>
            <label for="' . esc_attr($this->get_field_id('twitter')) . '">' . esc_html__('Twitter', 'listdomer-core') . '</label>
            <input class="widefat" type="url" id="' . esc_attr($this->get_field_id('twitter')) . '" name="' . esc_attr($this->get_field_name('twitter')) . '" value="' . (isset($instance['twitter']) ? esc_attr($instance['twitter']) : '') . '">
        </p>';

        echo '<p>
            <label for="' . esc_attr($this->get_field_id('instagram')) . '">' . esc_html__('Instagram', 'listdomer-core') . '</label>
            <input class="widefat" type="url" id="' . esc_attr($this->get_field_id('instagram')) . '" name="' . esc_attr($this->get_field_name('instagram')) . '" value="' . (isset($instance['instagram']) ? esc_attr($instance['instagram']) : '') . '">
        </p>';

        echo '<p>
            <label for="' . esc_attr($this->get_field_id('linkedin')) . '">' . esc_html__('Linkedin', 'listdomer-core') . '</label>
            <input class="widefat" type="url" id="' . esc_attr($this->get_field_id('linkedin')) . '" name="' . esc_attr($this->get_field_name('linkedin')) . '" value="' . (isset($instance['linkedin']) ? esc_attr($instance['linkedin']) : '') . '">
        </p>';

        echo '</div>';
    }

    public function update($new_instance, $old_instance): array
    {
        $instance = [];
        $instance['title'] = isset($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['email'] = isset($new_instance['email']) && is_email($new_instance['email']) ? sanitize_text_field($new_instance['email']) : '';
        $instance['phone'] = isset($new_instance['phone']) ? sanitize_text_field($new_instance['phone']) : '';
        $instance['facebook'] = isset($new_instance['facebook']) ? esc_url($new_instance['facebook']) : '';
        $instance['twitter'] = isset($new_instance['twitter']) ? esc_url($new_instance['twitter']) : '';
        $instance['instagram'] = isset($new_instance['instagram']) ? esc_url($new_instance['instagram']) : '';
        $instance['linkedin'] = isset($new_instance['linkedin']) ? esc_url($new_instance['linkedin']) : '';

        return $instance;
    }
}
