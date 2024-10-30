<?php
// no direct access
defined('ABSPATH') || die();

/** @var array $times */
/** @var array $bookables */
/** @var string $checkin_formatted */
/** @var string $checkout_formatted */
/** @var string $type */
/** @var WP_Post $listing */
/** @var LSD_Main $listdom */

$nights = LSD_Base::diff($times[0], $times[1]);

// Current User
$user = null;
if(get_current_user_id()) $user = get_userdata(get_current_user_id());
?>
<div class="lsd-booking-bookables">

    <form class="lsd-booking-form">
        <div class="lsd-row">
            <div class="lsd-col-12">
				<div class="lsd-booking-bookables-info">
					<ul>
						<li><span><?php esc_html_e('Checkin', 'listdom-booking'); ?>: </span><?php echo LSD_Base::datetime($times[0].' '.$checkin_formatted); ?></li>
						<li><span><?php esc_html_e('Checkout', 'listdom-booking'); ?>: </span><?php echo LSD_Base::datetime($times[1].' '.$checkout_formatted); ?></li>
						<li><span><?php esc_html_e('Period', 'listdom-booking'); ?>: </span><?php echo sprintf(_n('%s night', '%s nights', $nights, 'listdom-booking'), $nights); ?></li>
					</ul>
					<p class="description"><?php esc_html_e('Click total price to see price details.', 'listdom-booking'); ?></p>
				</div>
            </div>
        </div>
        <div class="lsd-row">
            <div class="lsd-col-12">
				<div class="lsd-booking-bookables-items">
					<ul>
						<?php foreach($bookables as $b): ?>
						<?php
                            // Bookable Object
							$bookable = new LSDADDBOK_Bookable($b['id']);

                            // Event Bookable
                            if($type === 'event')
                            {
                                $start = $bookable->start();
                                $end = $bookable->end();

                                // Don't show the bookable if past
                                if(strtotime($start) <= strtotime(current_time('Y-m-d'))) continue;

                                $times = [$start, $end];
                            }

							$pricing = $bookable->pricing($times);

							$availability = $bookable->availability($times);
							$status = $availability['status'] ?? false;
							$overlap = isset($availability['overlap']) && is_array($availability['overlap']) ? $availability['overlap'] : [];
						?>
						<li id="lsd_bookable_<?php echo esc_attr($bookable->id()); ?>">
							<div class="lsd-row">
								<div class="lsd-col-8">

                                    <?php if($type == 'event' && $status): ?>
									<input type="number" name="booking[items][<?php echo esc_attr($bookable->id()); ?>]" value="0" min="0" step="1" max="<?php echo esc_attr($bookable->slots()); ?>">
                                    <?php elseif($type != 'event'): ?>
                                    <input type="checkbox" name="booking[items][]" value="<?php echo $bookable->id(); ?>" <?php echo (!$status ? 'disabled' : ''); ?>>
                                    <?php endif; ?>

									<h5><?php echo esc_html($bookable->title()); ?> <span class="lsd-bookable-status lsd-bookable-status-<?php echo ($status ? 'available' : 'not-available'); ?>"><?php echo ($status ? __('Available', 'listdom-booking') : ($type == 'event' ? __('Soldout', 'listdom-booking') : __('Not Available', 'listdom-booking'))); ?></span></h5>

                                    <?php if($type == 'property'): ?>
                                    <span class="lsd-bookable-adults"><?php echo esc_html($bookable->adults()); ?></span>
                                    <span class="lsd-bookable-children"><?php echo esc_html($bookable->children()); ?></span>
                                    <?php endif; ?>

                                    <?php if($type == 'event'): $slots = $bookable->slots(); ?>
                                    <span class="lsd-bookable-start"><?php echo esc_html(LSD_Base::date($bookable->start())); ?></span>
                                    <span class="lsd-bookable-end"><?php echo esc_html(LSD_Base::date($bookable->end())); ?></span>
                                    <?php if($slots): ?><span class="lsd-bookable-free-slots"><?php echo sprintf(_n('Only %s slot remained.', '%s slots remained.', $slots, 'listdom-booking'), '<strong>'.number_format_i18n($slots).'</strong>'); ?></span><?php endif; ?>
                                    <?php endif; ?>

								</div>
								<div class="lsd-col-4 lsd-price">
									<h6 class="lsd-color-m-txt <?php echo ($type == 'event' ? '' : 'lsd-toggle'); ?>" data-for="#lsd_bookable_<?php echo esc_attr($bookable->id()); ?> .lsd-price-details"><?php echo esc_html($pricing['total']['rendered']); ?></h6>
								</div>
							</div>
							<div class="lsd-row">
								<div class="lsd-col-6">
									<div class="lsd-price-details lsd-util-hide">
										<ul>
											<?php foreach($pricing['details'] as $d => $p): ?>
												<li><span><?php echo $listdom->date($d); ?></span> <span class="lsd-price lsd-color-m-txt"><?php echo $p['rendered']; ?></span></li>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
								<div class="lsd-col-6">

									<?php if(!$status && count($overlap)): ?>
									<p class="lsd-bookable-not-available-reason"><?php echo sprintf(__("Not available from %s to %s", 'listdom-booking'), LSD_Base::date(strtotime($overlap['start'])), LSD_Base::date(strtotime($overlap['end']))); ?></p>
									<?php endif; ?>

									<?php echo LSD_Kses::element($bookable->description()); ?>

								</div>
							</div>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
            </div>
        </div>
        <div class="lsd-row lsd-row-form">
            <div class="lsd-col-4">
                <label for="lsdaddbok_booking_fullname"><?php esc_html_e('Full Name', 'listdom-booking'); ?> <span class="lsd-required">*</span></label>
                <?php echo LSD_Form::text([
                    'id' => 'lsdaddbok_booking_fullname',
                    'name' => 'booking[name]',
                    'required' => true,
                    'value' => ($user ? trim($user->first_name.' '.$user->last_name) : ''),
                    'placeholder' => esc_html__('Enter your name', 'listdom-booking'),
                ]); ?>
            </div>
            <div class="lsd-col-4">
                <label for="lsdaddbok_booking_phone"><?php esc_html_e('Phone', 'listdom-booking'); ?> <span class="lsd-required">*</span></label>
                <?php echo LSD_Form::tel([
                    'id' => 'lsdaddbok_booking_phone',
                    'name' => 'booking[phone]',
                    'required' => true,
                    'value' => '',
                    'placeholder' => esc_html__('Enter your phone number', 'listdom-booking'),
                ]); ?>
            </div>
            <div class="lsd-col-4">
                <label for="lsdaddbok_booking_email"><?php esc_html_e('Email', 'listdom-booking'); ?> <span class="lsd-required">*</span></label>
                <?php echo LSD_Form::email([
                    'id' => 'lsdaddbok_booking_email',
                    'name' => 'booking[email]',
                    'required' => true,
                    'value' => ($user ? $user->user_email : ''),
                    'placeholder' => esc_html__('Enter your email address', 'listdom-booking'),
                ]); ?>
            </div>
        </div>
        <div class="lsd-row lsd-row-form">
            <div class="lsd-col-12">
                <label for="lsdaddbok_booking_message"><?php esc_html_e('Optional Message', 'listdom-booking'); ?></label>
                <?php echo LSD_Kses::form(LSD_Form::textarea([
                    'id' => 'lsdaddbok_booking_message',
                    'name' => 'booking[message]',
                    'rows' => 6,
                ])); ?>
            </div>
        </div>
        <div class="lsd-row lsd-row-form">
            <div class="lsd-col-10">
                <?php echo LSD_Kses::form(LSD_Main::grecaptcha_field()); ?>
            </div>
            <div class="lsd-col-2 lsd-booking-submit-wrapper">
                <input type="hidden" name="booking[period]" value="<?php esc_attr_e(implode(' - ', $times)); ?>">
                <input type="hidden" name="booking[listing_id]" value="<?php esc_attr_e($listing->ID); ?>">
                <?php wp_nonce_field('lsdaddbok_booking_'.$listing->ID); ?>
                <input type="hidden" name="action" value="lsdaddbok_booking">
                <button type="submit" class="lsd-form-submit lsd-color-m-bg <?php echo esc_attr($listdom->get_text_class()); ?>"><?php _e('Book', 'listdom-booking'); ?></button>
            </div>
        </div>
    </form>

    <div class="lsd-row lsd-row-form">
        <div class="lsd-col-12">
            <div class="lsd-booking-form-alert"></div>
        </div>
    </div>

</div>
