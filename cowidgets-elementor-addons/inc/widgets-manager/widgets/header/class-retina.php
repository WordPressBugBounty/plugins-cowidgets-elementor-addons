<?php
/**
 * Elementor Classes.
 *
 * @package header-footer-elementor
 */

namespace COWIDGETS\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * CE Retina widget
 *
 * CE widget for Retina Image.
 *
 * @since 1.0.0
 */
class Retina extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'retina';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Retina Image', 'cowidgets' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'ce-icon-retina-image';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ce-header-widgets' ];
	}

	/**
	 * Register Retina Logo controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->register_content_retina_image_controls();
		$this->register_retina_image_styling_controls();
		$this->register_retina_caption_styling_controls();
		$this->register_helpful_information();
	}

	/**
	 * Register Retina Logo General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_content_retina_image_controls() {
		$this->start_controls_section(
			'section_retina_image',
			[
				'label' => __( 'Retina Image', 'cowidgets' ),
			]
		);
		$this->add_control(
			'retina_image',
			[
				'label'   => __( 'Choose Default Image', 'cowidgets' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'real_retina',
			[
				'label'   => __( 'Choose Retina Image', 'cowidgets' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'retina_image',
				'label'   => __( 'Image Size', 'cowidgets' ),
				'default' => 'medium',
			]
		);
		$this->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'cowidgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'cowidgets' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'cowidgets' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'cowidgets' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .ce-retina-image-container, {{WRAPPER}} .ce-caption-width' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_source',
			[
				'label'   => __( 'Caption', 'cowidgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'   => __( 'None', 'cowidgets' ),
					'custom' => __( 'Custom Caption', 'cowidgets' ),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'caption',
			[
				'label'       => __( 'Custom Caption', 'cowidgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'Enter your image caption', 'cowidgets' ),
				'condition'   => [
					'caption_source' => 'custom',
				],
				'dynamic'     => [
					'active' => true,
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'link_to',
			[
				'label'   => __( 'Link', 'cowidgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => __( 'None', 'cowidgets' ),
					'custom' => __( 'Custom URL', 'cowidgets' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'cowidgets' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'cowidgets' ),
				'condition'   => [
					'link_to' => 'custom',
				],
				'show_label'  => false,
			]
		);
		$this->end_controls_section();
	}
	/**
	 * Register Retina Image Style Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_retina_image_styling_controls() {
		$this->start_controls_section(
			'section_style_retina_image',
			[
				'label' => __( 'Retina Image', 'cowidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label'          => __( 'Width', 'cowidgets' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units'     => [ '%', 'px', 'vw' ],
				'range'          => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .ce-retina-image img' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ce-retina-image .wp-caption .widget-image-caption' => 'width: {{SIZE}}{{UNIT}}; display: inline-block;',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label'          => __( 'Max Width', 'cowidgets' ) . ' (%)',
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units'     => [ '%' ],
				'range'          => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .ce-retina-image img' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wp-caption-text'      => 'max-width: {{SIZE}}{{UNIT}}; display: inline-block; width: 100%;',
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'retina_image_border',
			[
				'label'       => __( 'Border Style', 'cowidgets' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'label_block' => false,
				'options'     => [
					'none'   => __( 'None', 'cowidgets' ),
					'solid'  => __( 'Solid', 'cowidgets' ),
					'double' => __( 'Double', 'cowidgets' ),
					'dotted' => __( 'Dotted', 'cowidgets' ),
					'dashed' => __( 'Dashed', 'cowidgets' ),
				],
				'selectors'   => [
					'{{WRAPPER}} .ce-retina-image-container .ce-retina-img' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'retina_image_border_size',
			[
				'label'      => __( 'Border Width', 'cowidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'    => '1',
					'bottom' => '1',
					'left'   => '1',
					'right'  => '1',
					'unit'   => 'px',
				],
				'condition'  => [
					'retina_image_border!' => 'none',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-retina-image-container .ce-retina-img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'retina_image_border_color',
			[
				'label'     => __( 'Border Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'condition' => [
					'retina_image_border!' => 'none',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ce-retina-image-container .ce-retina-img' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'cowidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ce-retina-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'exclude'  => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .ce-retina-image img',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab(
			'normal',
			[
				'label' => __( 'Normal', 'cowidgets' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'     => __( 'Opacity', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ce-retina-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .ce-retina-image img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => __( 'Hover', 'cowidgets' ),
			]
		);
		$this->add_control(
			'opacity_hover',
			[
				'label'     => __( 'Opacity', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ce-retina-image:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .ce-retina-image:hover img',
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'cowidgets' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);
		$this->add_control(
			'background_hover_transition',
			[
				'label'     => __( 'Transition Duration', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ce-retina-image img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	/**
	 * Register Caption style Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_retina_caption_styling_controls() {
		$this->start_controls_section(
			'section_style_caption',
			[
				'label'     => __( 'Caption', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption_source!' => 'none',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				],
			]
		);

		$this->add_control(
			'caption_background_color',
			[
				'label'     => __( 'Background Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .widget-image-caption',
				'scheme'   => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'caption_text_shadow',
				'selector' => '{{WRAPPER}} .widget-image-caption',
			]
		);

		$this->add_responsive_control(
			'caption_padding',
			[
				'label'      => __( 'Padding', 'cowidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .widget-image-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'caption_space',
			[
				'label'     => __( 'Caption Top Spacing', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: 0px;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_helpful_information() {
			$this->start_controls_section(
				'section_helpful_info',
				[
					'label' => __( 'Helpful Information', 'cowidgets' ),
				]
			);

			$this->add_control(
				'help_doc_1',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'cowidgets' ), '<a href="https://uaelementor.com/docs/introducing-retina-image-widget/" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'ce-editor-doc',
				]
			);

			$this->end_controls_section();
	}

	/**
	 * Check if the current widget has caption
	 *
	 * @access private
	 * @since 1.0.0
	 *
	 * @param array $settings returns settings.
	 *
	 * @return boolean
	 */
	private function has_caption( $settings ) {
		return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );
	}

	/**
	 * Get the caption for current widget.
	 *
	 * @access private
	 * @since 1.0.0
	 * @param array $settings returns the caption.
	 *
	 * @return string
	 */
	private function get_caption( $settings ) {
		$caption = '';
		if ( 'custom' === $settings['caption_source'] ) {
			$caption = ! empty( $settings['caption'] ) ? $settings['caption'] : '';
		}
		return $caption;
	}

	/**
	 * Render Retina Image output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['retina_image']['url'] ) ) {
			return;
		}

		$has_caption = $this->has_caption( $settings );

		$this->add_render_attribute( 'wrapper', 'class', 'ce-retina-image' );
		$link = $this->get_link_url( $settings );

		if ( $link ) {
			$this->add_render_attribute(
				'link',
				[
					'href' => $link['url'],
				]
			);

			if ( Plugin::$instance->editor->is_edit_mode() ) {
				$this->add_render_attribute(
					'link',
					[
						'class' => 'elementor-clickable',
					]
				);
			}

			if ( ! empty( $link['is_external'] ) ) {
				$this->add_render_attribute( 'link', 'target', '_blank' );
			}

			if ( ! empty( $link['nofollow'] ) ) {
				$this->add_render_attribute( 'link', 'rel', 'nofollow' );
			}
		}

		?>
		<div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
			<?php if ( $has_caption ) : ?>
				<figure class="wp-caption">
			<?php endif; ?>
			<?php if ( $link ) : ?>
					<a <?php echo wp_kses_post($this->get_render_attribute_string( 'link' )); ?>>
			<?php endif; ?>
			<?php
			$size = $settings[ 'retina_image' . '_size' ];
			$demo = '';

			if ( 'custom' !== $size ) {
				$image_size = $size;
			} else {
				require_once ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php';

				$image_dimension = $settings[ 'retina_image' . '_custom_dimension' ];

				$image_size = [
					// Defaults sizes.
					0           => null, // Width.
					1           => null, // Height.

					'bfi_thumb' => true,
					'crop'      => true,
				];

				$has_custom_size = false;
				if ( ! empty( $image_dimension['width'] ) ) {
					$has_custom_size = true;
					$image_size[0]   = $image_dimension['width'];
				}

				if ( ! empty( $image_dimension['height'] ) ) {
					$has_custom_size = true;
					$image_size[1]   = $image_dimension['height'];
				}

				if ( ! $has_custom_size ) {
					$image_size = 'full';
				}
			}
			$retina_image_url = $settings['real_retina']['url'];

			$image_url = $settings['retina_image']['url'];

			$image_data = wp_get_attachment_image_src( $settings['retina_image']['id'], $image_size, true );

			$retina_data = wp_get_attachment_image_src( $settings['real_retina']['id'], $image_size, true );

			$retina_image_class = 'elementor-animation-';

			if ( ! empty( $settings['hover_animation'] ) ) {
				$demo = $settings['hover_animation'];
			}
			if ( ! empty( $image_data ) ) {
				$image_url = $image_data[0];
			}
			if ( ! empty( $retina_data ) ) {
				$retina_image_url = $retina_data[0];
			}
			$class_animation = $retina_image_class . $demo;

			$image_unset         = site_url() . '/wp-includes/images/media/default.png';
			$placeholder_img_url = Utils::get_placeholder_image_src();

			if ( $image_unset === $retina_image_url ) {
				if ( $image_unset !== $image_url ) {
					$retina_image_url = $image_url;
				} else {
					$retina_image_url = $placeholder_img_url;
				}
			}

			if ( $image_unset === $image_url ) {
				$image_url = $placeholder_img_url;
			}

			if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Chrome' ) !== false ) {
				$date             = new \DateTime();
				$timestam         = $date->getTimestamp();
				$image_url        = $image_url . '?' . $timestam;
				$retina_image_url = $retina_image_url . '?' . $timestam;
			}

			?>
				<div class="ce-retina-image-set">
					<div class="ce-retina-image-container">
						<img class="ce-retina-img <?php echo esc_attr($class_animation); ?>"  src="<?php echo esc_url($image_url); ?>" srcset="<?php echo esc_url($image_url) . ' 1x' . ',' . esc_url($retina_image_url) . ' 2x'; ?>"/>
					</div>
				</div>
			<?php if ( $link ) : ?>
					</a>
			<?php endif; ?>
			<?php
			if ( $has_caption ) :
				$caption_text = $this->get_caption( $settings );
				?>
				<?php if ( ! empty( $caption_text ) ) : ?>
					<div class="ce-caption-width"> 
						<figcaption class="widget-image-caption wp-caption-text"><?php echo esc_html($caption_text); ?></figcaption>
					</div>
				<?php endif; ?>
				</figure>
			<?php endif; ?>
		</div> 
		<?php
	}

	/**
	 * Retrieve Retina image widget link URL.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param array $settings returns settings.
	 * @return array|string|false An array/string containing the link URL, or false if no link.
	 */
	private function get_link_url( $settings ) {
		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}
			return $settings['link'];
		}
	}
}
