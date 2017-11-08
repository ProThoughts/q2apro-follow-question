<?php

/*
	Plugin Name: Follow Question Activities
	Plugin URI: http://www.q2apro.com/plugins/followqact
	Plugin Description: Sends emails to users about activities on questions they have favorited
	Plugin Version: 1.0
	Plugin Date: 2014-10-06
	Plugin Author: q2apro.com
	Plugin Author URI: http://www.q2apro.com
	Plugin Minimum Question2Answer Version: 1.6
	Plugin Update Check URI: http://www.q2apro.com/pluginupdate?id=69
	
	Licence: Copyright © q2apro.com - All rights reserved
	
*/

	class q2apro_followqact_admin {

		function init_queries($tableslc) {
			return null;
		}

		// option's value is requested but the option has not yet been set
		function option_default($option) {
			switch($option) {
				case 'q2apro_followqact_enabled':
					return 1; // true
				default:
					return null;
			}
		}
			
		function allow_template($template) {
			return ($template!='admin');
		}       
			
		function admin_form(&$qa_content){                       

			// process the admin form if admin hit Save-Changes-button
			$ok = null;
			if (qa_clicked('q2apro_followqact_save')) {
				qa_opt('q2apro_followqact_enabled', (bool)qa_post_text('q2apro_followqact_enabled')); // empty or 1
				$ok = qa_lang('admin/options_saved');
			}
			
			// form fields to display frontend for admin
			$fields = array();
			
			$fields[] = array(
				'type' => 'checkbox',
				'label' => qa_lang('q2apro_followqact_lang/enable_plugin'),
				'tags' => 'name="q2apro_followqact_enabled"',
				'value' => qa_opt('q2apro_followqact_enabled'),
			);
			
			$fields[] = array(
				'type' => 'static',
				'note' => '<span style="font-size:75%;color:#789;">'.strtr( qa_lang('q2apro_followqact_lang/contact'), array( 
							'^1' => '<a target="_blank" href="http://www.q2apro.com/plugins/followquestion">',
							'^2' => '</a>'
						  )).'</span>',
			);
			
			return array(           
				'ok' => ($ok && !isset($error)) ? $ok : null,
				'fields' => $fields,
				'buttons' => array(
					array(
						'label' => qa_lang_html('main/save_button'),
						'tags' => 'name="q2apro_followqact_save"',
					),
				),
			);
		}
	}


/*
	Omit PHP closing tag to help avoid accidental output
*/