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

	class qa_html_theme_layer extends qa_html_theme_base
	{
		
		function head_script(){
			qa_html_theme_base::head_script();
			
			if(qa_opt('q2apro_followqact_enabled') && qa_is_logged_in())
			{
				$this->output('<style type="text/css">
				.fqact-favoriting {
					position:static;
				}			
				.fqact-favoriting .qa-favorite-image, .fqact-favoriting .qa-favorite-button, .fqact-favoriting .qa-unfavorite-button { 
					display:inline-block;
					min-width:130px;
					min-height:30px;
					padding:5px 5px 5px 25px;
					margin:40px 0;
					color:#666;
					overflow:visible;
					background:#EEE;
					background:#EEE url("'.QA_HTML_THEME_LAYER_URLTOROOT.'followicon.png") no-repeat; /* fallback */
					background-image:url("'.QA_HTML_THEME_LAYER_URLTOROOT.'followicon.png") no-repeat, linear-gradient(to bottom,rgba(255,255,255,1) 0,rgba(220,220,225,1) 100%);
					cursor:pointer;
					text-decoration:none !important;
					font-size:11px;
					letter-spacing:150%;
					border:1px solid #AAA;
					outline:0;
					border-radius:0.2em;
				}
				.fqactivated {
					width:30px !important;
					min-width:auto !important;
				}
				.fqact-favoriting .qa-favorite-button, .fqact-favoriting .qa-unfavorite-button { 
					background-position: 5px 8px;
					opacity:0.8;
				}
				.fqact-favoriting .qa-favorite-button:hover, .fqact-favoriting .qa-unfavorite-button:hover { 
					opacity:1.0;
					color:#333;
				}
				.fqact-favoriting .qa-favorite-image {
					vertical-align:middle;
					display:inline-block;
					margin:0 5px;
					cursor:default;
				}		
				/* hide original favorite icon */
				.qa-main .qa-favoriting .qa-favorite-button {
					display:none;
				}
				</style>');
			} // end if enabled
			
		} // end head_script
			
	} // end qa_html_theme_layer
	

/*
	Omit PHP closing tag to help avoid accidental output
*/