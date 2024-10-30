<?php
// no direct access
defined('ABSPATH') || die();

/** @var LSD_Shortcodes_Taxonomy $this */

$grid = $this->atts['grid'] ?? 2;
?>
<div class="lsd-taxonomy-shortcode-wrapper lsd-taxonomy-shortcode-clean lsd-font-m">
    <?php if(!count($this->terms)): ?>
        <?php echo LSD_Base::alert(esc_html__('No item found!', 'listdom'), 'warning'); ?>
    <?php else: ?>

        <?php $i = 1; foreach($this->terms as $term): $have_icon = false; ?>

        <?php if($i == 1): ?><div class="lsd-row"><?php endif; ?>

        <div class="lsd-col-<?php echo (12/$grid); ?>">
            <a href="<?php echo esc_url(get_term_link($term->term_id)); ?>">
                <?php if(!isset($this->atts['show_icon']) || $this->atts['show_icon']): $icon = LSD_Taxonomies::icon($term->term_id); $color = get_term_meta($term->term_id, 'lsd_color', true); ?>
                    <?php if(trim($icon)): $have_icon = true; ?>
                    <div class="lsd-term-circle" style="background-color: <?php echo esc_attr(LSD_Color::lighter($color, 80)); ?>;">
                        <div class="lsd-icon" style="color: <?php echo esc_attr($color); ?>;"><?php echo $icon; ?></div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="lsd-title<?php if(!$have_icon) echo ' lsd-title-full'; ?>">
                    <?php echo esc_html($term->name); ?>
                    <?php if(isset($this->atts['show_count']) && $this->atts['show_count']): ?>
                        <span class="lsd-count"><?php echo sprintf(esc_html__('%s Listings', 'listdomer-core'), $term->count); ?></span>
                    <?php endif; ?>
                </div>
            </a>

            <?php if($this->hierarchical && $children = $this->get_terms($term->term_id)): ?>
            <ul class="lsd-children">
                <?php foreach($children as $child): ?>
                <li>
                    <a href="<?php echo esc_url(get_term_link($child->term_id)); ?>">
                        <div class="lsd-title">
                            <?php echo esc_html($child->name); ?>
                            <?php if(isset($this->atts['show_count']) && $this->atts['show_count']): ?>
                                <span class="lsd-count"><?php echo sprintf(esc_html__('%s Listings', 'listdomer-core'), $child->count); ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <?php if($i == $grid): $i = 0; ?></div><?php endif; ?>

        <?php $i++; endforeach; ?>

        <?php if($i != 1 && $i <= $grid) echo '<div class="lsd-col-transparent lsd-col-'.(12/$grid).'"></div></div>'; ?>

    <?php endif; ?>
</div>
