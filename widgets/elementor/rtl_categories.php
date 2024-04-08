<?php

class RTL_Categories extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'rtl_categories';
	}

	public function get_title()
	{
		return esc_html__('Rtl woocommerce categories', 'textdomain');
	}

	public function get_icon()
	{
		return 'eicon-code';
	}

	public function get_custom_help_url()
	{
		return 'https://go.elementor.com/widget-name';
	}

	public function get_categories()
	{
		return ['woocommerce-elements'];
	}

	public function get_keywords()
	{
		return ['keyword', 'keyword'];
	}

	public function get_script_depends()
	{
		return ['rtl-categories-script-handle'];
	}

	public function get_style_depends()
	{
		return ['rtl-categories-style-handle'];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Settings', 'textdomain'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'count',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => esc_html__('Categories Count', 'textdomain'),
				'min' => 0,
				'max' => 18,
				'step' => 1,
				'default' => 18,
			]
		);

		$this->add_control(
			'first_closed',
			[
				'label' => esc_html__('Close Mode First Time', 'textdomain'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'textdomain'),
				'label_off' => esc_html__('No', 'textdomain'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__('Style', 'textdomain'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'close_size',
			[
				'label' => esc_html__('Max Height In Close Mode', 'textdomain'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => '125',
				'selectors' => [
					'{{WRAPPER}} .rtl-subcategories .rtl-categories.rtl-hide-extra-categories' => 'max-height: {{VALUE}}px',
				],
			]
		);

		$this->add_control(
			'open_size',
			[
				'label' => esc_html__('Max Height In Open Mode', 'textdomain'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => '400',
				'selectors' => [
					'{{WRAPPER}} .rtl-subcategories .rtl-categories' => 'max-height: {{VALUE}}px',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render()
	{
		$count = $this->get_settings_for_display('count');
		$hide_extra_categories = $this->get_settings_for_display('first_closed') == 'yes';

		$product_categories = get_terms([
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'number' => $count
		]);
		if (count($product_categories) > 0) {
			?>
			<div class="rtl-categories-wrapper">
				<?php
				$main_categories = array_slice($product_categories, 0, 3); // Elements from index 0 to 3
				$other_categories = array_slice($product_categories, 3);
				if (count($main_categories) > 0) {
					?>
					<div class="rtl-categories rtl-main-categories">
						<?php
						foreach ($main_categories as $category) {
							$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
							$thumbnail_url = wp_get_attachment_url($thumbnail_id);
							$term_link = get_term_link($category->term_id);
							?>
							<a href="<?php echo $term_link ?>">
								<div class="rtl-category-box">
									<img class="rtl-category-image" src="<?php echo $thumbnail_url; ?>"
										 alt="<?php echo $category->name; ?>">
									<h2 class="rtl-category-title"><?php echo $category->name; ?></h2>
								</div>
							</a>
							<?php
						}
						?>
					</div>
					<?php
				}
				if (count($other_categories) > 0) {
					?>
					<div class="rtl-subcategories">
						<div
							class="rtl-categories <?php echo $hide_extra_categories ? 'rtl-hide-extra-categories' : ''; ?>">
							<?php
							foreach ($other_categories as $index => $category) {
								$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
								$thumbnail_url = wp_get_attachment_url($thumbnail_id);
								$term_link = get_term_link($category->term_id);
								?>
								<a class="rtl-category-link"
								   href="<?php echo $term_link ?>">
									<div class="rtl-category-box">
										<img class="rtl-category-image" src="<?php echo $thumbnail_url; ?>"
											 alt="<?php echo $category->name; ?>">
										<h2 class="rtl-category-title"><?php echo $category->name; ?></h2>
									</div>
								</a>
								<?php
							}
							?>
						</div>
						<a class="rtl-toggle-categories" href="#">
							<span><?php echo $hide_extra_categories ? __('Show More Categories','rtl-categories') : __('Show Less Categories','rtl-categories'); ?></span>
							<?php if ($hide_extra_categories) { ?>
								<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
									 height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
									<g>
										<path fill="none" d="M0 0h24v24H0z"></path>
										<path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
									</g>
								</svg>
							<?php } else { ?>
								<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
									 height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
									<g>
										<path fill="none" d="M0 0h24v24H0z"></path>
										<path
											d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z"></path>
									</g>
								</svg>
							<?php } ?>
						</a>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}
