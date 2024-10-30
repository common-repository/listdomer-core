<?php
// no direct access
defined('ABSPATH') || die();

// Listing
global $post;

$team = get_post_meta($post->ID, 'lsd_team', true);
if(!is_array($team)) $team = [];

// No Team
if(!count($team)) return;

// Social Networks
$SN = new LSD_Socials();

// Social Options
$networks = LSD_Options::socials();

// Display Options
$display_tel = !isset($args['display_tel']) || $args['display_tel'];
$display_email = !isset($args['display_email']) || $args['display_email'];
$display_mobile = !isset($args['display_mobile']) || $args['display_mobile'];
$display_website = isset($args['display_website']) && $args['display_website'];
$display_fax = !isset($args['display_fax']) || $args['display_fax'];
?>
<div class="lsd-team">

    <ul>
        <?php foreach($team as $user_id): $user = get_user_meta($user_id); ?>
        <li <?php echo lsd_schema()->scope()->type('https://schema.org/Person', null); ?>>
			<div class="lsd-user-top-wrapper">
				<div class="lsd-user-image-wrapper">
					<?php echo get_avatar($user_id, 120); ?>
				</div>
				<div class="lsd-user-information-part-1">
					<h4 class="lsd-user-name" <?php echo lsd_schema()->name(); ?>><?php echo esc_html(get_the_author_meta('display_name', $user_id)); ?></h4>

					<?php if(isset($user['lsd_job_title'][0]) && trim($user['lsd_job_title'][0])): ?>
					<div class="lsd-user-job-title" <?php echo lsd_schema()->jobTitle(); ?> ><?php echo esc_html($user['lsd_job_title'][0]); ?></div>
					<?php endif; ?>

					<?php
					$socials = '';
					foreach($networks as $network=>$values)
					{
						$obj = $SN->get($network, $values);

						// Social Network is not Enabled
						if(!$obj || !$obj->option('profile')) continue;

						$link = isset($user['lsd_'.$obj->key()][0]) && trim($user['lsd_'.$obj->key()][0]) ? $user['lsd_'.$obj->key()][0] : '';

						// Social Network is not filled
						if(trim($link) == '') continue;

						$socials .= '<li>'.$obj->owner($link).'</li>';
					}
					?>
					<?php if(trim($socials) != ''): ?>
					<div class="lsd-user-social-networks">
						<ul><?php echo LSD_Kses::element($socials); ?></ul>
					</div>
					<?php endif; ?>
				
				</div>

				<?php if(isset($user['description'][0]) && trim($user['description'][0])): ?>
				<div class="lsd-user-biography" <?php echo lsd_schema()->description(); ?>><?php echo esc_html($user['description'][0]); ?></div>
				<?php endif; ?>
			</div>
            <div class="lsd-user-information-part-2">
                <?php if($display_tel && isset($user['lsd_phone'][0]) && trim($user['lsd_phone'][0])): ?>
                <div class="lsd-user-phone" title="<?php esc_attr_e('Phone', 'listdom-team'); ?>" <?php echo lsd_schema()->telephone(); ?> >
					<i class="lsd-icon fas fa-phone-alt"></i> 
					<a href="tel:<?php echo esc_html($user['lsd_phone'][0]); ?>"><?php echo esc_html($user['lsd_phone'][0]); ?></a>
				</div>
                <?php endif; ?>

                <?php if($display_email): ?>
                <div class="lsd-user-email" title="<?php esc_attr_e('Email', 'listdom-team'); ?>" <?php echo lsd_schema()->email(); ?> >
					<i class="lsd-icon fa fa-envelope"></i> 
					<a href="mailto:<?php echo esc_html(get_the_author_meta('email', $user_id)); ?>"><?php echo esc_html(get_the_author_meta('email', $user_id)); ?></a>
				</div>
                <?php endif; ?>

                <?php if($display_mobile && isset($user['lsd_mobile'][0]) && trim($user['lsd_mobile'][0])): ?>
                <div class="lsd-user-mobile" title="<?php esc_attr_e('Mobile', 'listdom-team'); ?>" <?php echo lsd_schema()->telephone(); ?> >
					<i class="lsd-icon fa fa-mobile"></i> 
					<a href="tel:<?php echo esc_html($user['lsd_mobile'][0]); ?>"><?php echo esc_html($user['lsd_mobile'][0]); ?></a>
				</div>
                <?php endif; ?>

                <?php if($display_website && isset($user['lsd_website'][0]) && trim($user['lsd_website'][0])): ?>
                <div class="lsd-owner-website" title="<?php esc_attr_e('Website', 'listdom-team'); ?>">
                    <i class="lsd-icon fas fa-link"></i>
                    <a href="<?php echo esc_url($user['lsd_website'][0]); ?>"><?php echo esc_html(LSD_Base::remove_protocols($user['lsd_website'][0])); ?></a>
                </div>
                <?php endif; ?>

                <?php if($display_fax && isset($user['lsd_fax'][0]) && trim($user['lsd_fax'][0])): ?>
                <div class="lsd-user-fax" title="<?php esc_attr_e('Fax', 'listdom-team'); ?>" <?php echo lsd_schema()->faxNumber(); ?> ><i class="lsd-icon fa fa-fax"></i> <?php echo esc_html($user['lsd_fax'][0]); ?></div>
                <?php endif; ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>

</div>
