<?php
// no direct access
defined('ABSPATH') || die();

class LSDRC_Settings_Blog extends LSDRC_Settings
{
    /**
     * Sets the Blog section and fields in Redux Framework.
     * @return void
     */
    public function register()
    {
        Redux::set_section(
            $this->opt_name,
            [
                'title' => esc_html__('Blog', 'listdomer-core'),
                'id' => 'blog',
                'desc' => esc_html__('Blog settings for various elements.', 'listdomer-core'),
                'customizer_width' => '400px',
                'icon' => 'el el-pencil',
                'fields' => $this->get_blog_fields(),
            ]
        );
    }

    /**
     * Returns the fields for the Blog settings.
     * @return array Fields array.
     */
    private function get_blog_fields(): array
    {
        return [
            [
                'id' => 'listdomer_content_color',
                'type' => 'color',
                'title' => esc_html__('Content Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_content_color', '#66686b'),
                'desc' => esc_html__('Color of blog content.', 'listdomer-pro'),
            ],
            [
                'id' => 'listdomer_content_a_color',
                'type' => 'color',
                'title' => esc_html__('A Tag Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_content_a_color', '#8d919c'),
                'desc' => esc_html__('Color of anchor tags.', 'listdomer-pro'),
            ],
            [
                'id' => 'listdomer_content_a_active_color',
                'type' => 'color',
                'title' => esc_html__('Active a Tag Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_content_a_active_color', '#3a3b40'),
                'desc' => esc_html__('Color of active anchor.', 'listdomer-pro'),
            ],
            [
                'id' => 'blog_post_typography',
                'type' => 'typography',
                'title' => esc_html__('Post Title Typography', 'listdomer-core'),
                'subtitle' => esc_html__('Set typography options for the blog post titles.', 'listdomer-core'),
                'google' => true,
                'default' => [
                    'font-family' => 'Roboto',
                    'font-size' => '24px',
                    'color' => '#333',
                ],
                'output' => ['.blog-post-title'],
            ],
            [
                'id' => 'blog_post_meta',
                'type' => 'checkbox',
                'title' => esc_html__('Display Post Meta', 'listdomer-core'),
                'subtitle' => esc_html__('Enable or disable meta information (date, author, comments) for blog posts.', 'listdomer-core'),
                'options' => [
                    'date' => esc_html__('Show Post Date', 'listdomer-core'),
                    'author' => esc_html__('Show Post Author', 'listdomer-core'),
                    'comments' => esc_html__('Show Comment Count', 'listdomer-core'),
                ],
                'default' => [
                    'date' => '1',
                    'author' => '1',
                    'comments' => '1',
                ],
            ],
            [
                'id' => 'blog_read_more_text',
                'type' => 'text',
                'title' => esc_html__('Read More Button Text', 'listdomer-core'),
                'subtitle' => esc_html__('Set the text for the "Read More" button on blog posts.', 'listdomer-core'),
                'default' => esc_html__('Continue Reading', 'listdomer-core'),
            ],
            [
                'id' => 'blog_posts_per_page',
                'type' => 'slider',
                'title' => esc_html__('Number of Posts per Page', 'listdomer-core'),
                'subtitle' => esc_html__('Control how many posts should appear on the blog page.', 'listdomer-core'),
                'default' => 10,
                'min' => 1,
                'max' => 50,
                'step' => 1,
                'display_value' => 'label',
            ],
            [
                'id' => 'blog_excerpt_length',
                'type' => 'slider',
                'title' => esc_html__('Excerpt Length (Words)', 'listdomer-core'),
                'subtitle' => esc_html__('Control how many words should be displayed in the blog post excerpt.', 'listdomer-core'),
                'default' => 40,
                'min' => 10,
                'max' => 100,
                'step' => 5,
                'display_value' => 'label',
            ],
        ];
    }
}
