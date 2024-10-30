<?php
// no direct access
defined('ABSPATH') || die();

use Elementor\Controls_Manager;

/**
 * Elementor Posts Widget.
 *
 * @class LSDRC_Elementor_Posts
 * @version    1.0.0
 */
class LSDRC_Elementor_Posts extends LSDRC_Elementor_Base
{
    public function get_name()
    {
        return 'lsdrc-posts';
    }

    public function get_title()
    {
        return __('Posts', 'listdomer-core');
    }

    public function get_icon()
    {
        return 'eicon-document-file';
    }

    public function get_categories()
    {
        return ['listdomer'];
    }

    protected function register_controls()
    {
        // Start Section
        $this->start_controls_section(
            'lsdrc_content_section',
            [
                'label' => __('Content', 'listdomer-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Post Type Control
        $this->add_post_type_control();

        // End Section
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $PT = isset($settings['post_type']) && trim($settings['post_type']) ? $settings['post_type'] : 'post';

        // Query
        $query = new WP_Query([
            'post_type' => $PT,
            'posts_per_page' => 3,
            'meta_query' => [
                [
                    'key' => '_thumbnail_id',
                    'compare' => 'EXISTS'
                ],
            ]
        ]);

        // Nothing Found
        if (!$query->have_posts())
        {
            // Reset Query
            wp_reset_postdata();

            return;
        }

        echo '<ul class="listdomer-posts-widget listdomer-font-m">';
        while ($query->have_posts())
        {
            $query->the_post();

            $post = get_post();
            $categories = get_the_category();

            echo '<li>
				<div class="listdomer-pw-wrapper">
					<div class="listdomer-pw-featured-image"><a href="' . esc_url(get_the_permalink()) . '">' . get_the_post_thumbnail($post, [300, 200]) . '</a></div>
					<div class="listdomer-pw-content">
						<div class="listdomer-pw-content-top">
							<div class="listdomer-pw-date">' . get_the_date() . '</div>
							<div class="listdomer-pw-category">' . (($categories && count($categories)) ? $categories[0]->name : '') . '</div>
						</div>
						<h5><a href="' . esc_url(get_the_permalink()) . '">' . get_the_title() . '</a></h5>
						<div class="listdomer-pw-content-bottom">
							<div class="listdomer-pw-author"><img alt="' . esc_attr(get_the_author()) . '" src="' . esc_url(get_avatar_url($post->post_author)) . '">' . get_the_author() . '</div>
						</div>
					</div>
				</div>
            </li>';
        }

        echo '</ul>';

        // Reset Query
        wp_reset_postdata();
    }
}
