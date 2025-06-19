<?php
/**
 * Prompt Card Template
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Get settings
$settings         = $this->get_settings_for_display();
$expanded         = 'yes' === $settings['expanded_by_default'];
$card_id          = 'aiq-prompt-card-' . $this->get_id();
$category_display = $this->get_category_display_name( $settings );
?>

<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
	<?php if ( 'yes' === $settings['is_pro'] ) : ?>
		<div class="aiq-prompt-card__pro-badge" aria-label="<?php esc_attr_e( 'Pro Content', 'aiqengage-child' ); ?>">
			<span class="aiq-prompt-card__pro-badge-text">PRO</span>
			<span class="aiq-prompt-card__pro-badge-icon">🔒</span>
		</div>
	<?php endif; ?>

	<div class="aiq-prompt-card__header">
		<?php if ( ! empty( $settings['card_icon']['value'] ) ) : ?>
			<div class="aiq-prompt-card__icon">
				<?php \Elementor\Icons_Manager::render_icon( $settings['card_icon'], array( 'aria-hidden' => 'true' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="aiq-prompt-card__title-wrapper">
			<h3 class="aiq-prompt-card__title"><?php echo esc_html( $settings['prompt_title'] ); ?></h3>
			<span class="aiq-prompt-card__category aiq-prompt-card__category--<?php echo esc_attr( $settings['category'] ); ?>">
				<?php echo esc_html( $category_display ); ?>
			</span>
		</div>

		<div class="aiq-prompt-card__actions">
			<button type="button" class="aiq-prompt-card__copy-btn"
					aria-label="<?php esc_attr_e( 'Copy prompt to clipboard', 'aiqengage-child' ); ?>"
					data-prompt-id="<?php echo esc_attr( $card_id ); ?>">
				<span class="aiq-prompt-card__copy-icon">
					<i class="fas fa-copy" aria-hidden="true"></i>
				</span>
				<span class="aiq-prompt-card__copy-text"><?php esc_html_e( 'Copy', 'aiqengage-child' ); ?></span>
			</button>

			<button type="button" class="aiq-prompt-card__toggle"
					aria-expanded="<?php echo $expanded ? 'true' : 'false'; ?>"
					aria-controls="<?php echo esc_attr( $card_id ); ?>-content">
				<span class="aiq-prompt-card__toggle-text aiq-prompt-card__toggle-text--expand">
					<?php esc_html_e( 'Show Prompt', 'aiqengage-child' ); ?>
				</span>
				<span class="aiq-prompt-card__toggle-text aiq-prompt-card__toggle-text--collapse">
					<?php esc_html_e( 'Hide Prompt', 'aiqengage-child' ); ?>
				</span>
				<span class="aiq-prompt-card__toggle-icon">
					<i class="fas fa-chevron-down" aria-hidden="true"></i>
				</span>
			</button>
		</div>
	</div>

	<div class="aiq-prompt-card__description">
		<?php echo esc_html( $settings['description'] ); ?>
	</div>

	<div class="aiq-prompt-card__content" id="<?php echo esc_attr( $card_id ); ?>-content">
		<pre class="aiq-prompt-card__prompt"><?php echo esc_html( $settings['prompt_body'] ); ?></pre>

		<?php if ( 'yes' === $settings['show_variables'] && ! empty( $settings['variables'] ) ) : ?>
			<div class="aiq-prompt-card__variables">
				<h4 class="aiq-prompt-card__variables-title"><?php esc_html_e( 'Variables', 'aiqengage-child' ); ?></h4>
				<div class="aiq-prompt-card__variables-table-wrapper">
					<table class="aiq-prompt-card__variables-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Variable', 'aiqengage-child' ); ?></th>
								<th><?php esc_html_e( 'Description', 'aiqengage-child' ); ?></th>
								<th><?php esc_html_e( 'Example', 'aiqengage-child' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $settings['variables'] as $index => $variable ) : ?>
								<tr>
									<td class="aiq-prompt-card__variable-name">
										<button type="button" class="aiq-prompt-card__variable-insert"
												data-variable="<?php echo esc_attr( $variable['variable_name'] ); ?>"
												data-prompt-id="<?php echo esc_attr( $card_id ); ?>">
											<?php echo esc_html( $variable['variable_name'] ); ?>
										</button>
									</td>
									<td><?php echo esc_html( $variable['variable_description'] ); ?></td>
									<td><em><?php echo esc_html( $variable['example_value'] ); ?></em></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<?php if ( ! empty( $settings['usage_tips'] ) ) : ?>
					<div class="aiq-prompt-card__tips">
						<h4 class="aiq-prompt-card__tips-title"><?php esc_html_e( 'Usage Tips', 'aiqengage-child' ); ?></h4>
						<div class="aiq-prompt-card__tips-content">
							<?php echo wp_kses_post( $settings['usage_tips'] ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="aiq-prompt-card__copied-message" aria-live="polite">
		<?php esc_html_e( 'Copied to clipboard!', 'aiqengage-child' ); ?>
	</div>
</div>
