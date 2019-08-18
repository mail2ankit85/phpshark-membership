<?php
namespace app\admin;

/**
 * The class responsible for Admin Area Options for membsership urls & pages
 */
require_once PHPS_PLUGBASE .  PHPS_INCLUDES . PHPS_APP . 'admin-page-framework/admin-page-framework.php';

if(!class_exists('app\admin\Pages')):

  class Pages extends \PHPShark_AdminPageFramework {
  	public function __construct(){
  		parent::__construct();
  	}

  	public function setup() {
  			// Create a top-level menu.
  			$this->setRootMenuPage( 'Membership Options' );
  			$this->setRootMenuPage(
  				'Membership Options','dashicons-admin-generic'
  			);
  			// Add sub menu items.
  			$this->addSubMenuItems(
  					array(
  							'title'         => __( 'Thank You',  'phpshark-plugin' ),    // page title
  							'page_slug'     => 'thank-you-options',    // page slug
  					),
  					array(
  							'title'         => __( 'Reset Page',  'phpshark-plugin' ),     // page title
  							'page_slug'     => 'reset',    // page slug
  					),
            array(
  							'title'         => __( 'Unsubscribe Page',  'phpshark-plugin' ),     // page title
  							'page_slug'     => 'unsubscribe',    // page slug
  					)
  			);
  	}

  	public function do_form_admin_pages(){
  		?>
  				<h4> Set your Environmental variables here!! </h4>
  		<?php
  	}

  	public function load_thank_you_options() {
  			$this->addSettingSections(
  				array(
  					'section_id'        => 'thank-you',
  					'title'             => 'Thank You Page Settings',
  				)
  			);
  			$this->addSettingFields(
  				'thank-you',   // target section ID
  				array(
  					'field_id'  => 'card_heading',
  					'title'     => 'Card Header',
  					'type'      => 'text',
  					'default'   => 'Thank you for visiting',
  				),
  				array(
  					'field_id'  => 'card_body',
  					'title'     => 'Card Body',
  					'type'      => 'textarea',
  					'default'   => 'Hope to see you back very soon! I hope you find my content informative. Please care to leave a feed back sometimes',
  				),
  				array(
  					'field_id'  => '_submit',
  					'type'      => 'submit',
  					'save'      => false,
  				)
  			);
  	}

  	public function load_reset() {
  		$this->addSettingSections(
  			array(
  				'section_id'        => 'reset',
  				'title'             => 'Reset Settings',
  			)
  		);
  		$this->addSettingFields(
  			'reset',   // target section ID
  			array(
  				'field_id'  => 'error_msg',
  				'title'     => 'Error Message',
  				'type'      => 'textarea',
          'default'   => '<strong>Error!</strong> The Repeat Password does not seem to match!.'
   			),
  			array(
  				'field_id'  => 'success_msg',
  				'title'     => 'Success Message',
  				'type'      => 'textarea',
          'default'   => '<strong>Info!</strong> Good work.'
  			),
  			array(
  				'field_id'  => '_submit',
  				'type'      => 'submit',
  				'save'      => false,
  			)
  		);
  	}

    public function load_unsubscribe() {
  		$this->addSettingSections(
  			array(
  				'section_id'        => 'unsubscribe',
  				'title'             => 'Unsubscribe Settings',
  			)
  		);
  		$this->addSettingFields(
  			'unsubscribe',   // target section ID
  			array(
  				'field_id'  => 'msg',
  				'title'     => 'Error Message',
  				'type'      => 'textarea',
          'default'   => 'your email id has been unsubscribed!'
   			),
  			array(
  				'field_id'  => '_submit',
  				'type'      => 'submit',
  				'save'      => false,
  			)
  		);
  	}

  }

endif;
