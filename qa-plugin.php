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

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}

	// language file
	qa_register_plugin_phrases('q2apro-followqact-lang-*.php', 'q2apro_followqact_lang');

	// admin
	qa_register_plugin_module('module', 'q2apro-followqact-admin.php', 'q2apro_followqact_admin', 'q2apro Followqact Admin');
   
	// track events
	qa_register_plugin_module('event', 'q2apro-followqact-events.php', 'q2apro_followqact_events', 'q2apro Followqact Events');

	// layer
	qa_register_plugin_layer('q2apro-followqact-layer.php', 'q2apro Followqact Layer');

	// widget
	qa_register_plugin_module('widget', 'q2apro-followqact-widget.php', 'q2apro_followqact_widget', 'q2apro Follow Question Activities Widget');

/*
	Omit PHP closing tag to help avoid accidental output
*/