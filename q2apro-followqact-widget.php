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

class q2apro_followqact_widget {
	
	function allow_template($template) {
		$allow = false;
		
		if($template=='question') {
			$allow = true;			
		}
		
		return $allow;
	}
	
	function allow_region($region) {
		return true;
	}

	function output_widget($region, $place, $themeobject, $template, $request, $qa_content) {
		if(qa_opt('q2apro_followqact_enabled')!=1) {
			return;
		}
		
		// follow question
		$favorite = @$qa_content['favorite'];
		
		if (isset($favorite)) {
			$themeobject->output('<form '.$favorite['form_tags'].'>');
			// add button label
			if(isset($favorite["favorite_add_tags"])){
				$favorite["favorite_add_tags"] .= ' value="'.qa_lang('q2apro_followqact_lang/follow_question').'"';
				// replace title with custom title
				$favorite["favorite_add_tags"] = str_replace(qa_lang('question/add_q_favorites'), qa_lang('q2apro_followqact_lang/favbtn_hover'), $favorite["favorite_add_tags"]);
			}
			else if (isset($favorite["favorite_remove_tags"])){
				$favorite["favorite_remove_tags"] .= ' value="'.qa_lang('q2apro_followqact_lang/following').'"';					
				// replace title with custom title
				$favorite["favorite_remove_tags"] = str_replace(qa_lang('question/remove_q_favorites'), qa_lang('q2apro_followqact_lang/unfavbtn_hover'), $favorite["favorite_remove_tags"]);
			}
			$themeobject->output('<div class="fqact-favoriting" '.@$favorite['favorite_tags'].'>');
			$themeobject->favorite_inner_html($favorite);
			$themeobject->output('</div>');
			
			// JQUERY
			$themeobject->output('<script type="text/javascript">
				$(document).ready(function(){
					$(".fqact-favoriting").on("click", function() { 
						// wait 0.5s until ajax returned new button
						setTimeout(function(){
							$(".fqact-favoriting .qa-favorite-button").val("'.qa_lang('q2apro_followqact_lang/unfollowed').'");
							$(".fqact-favoriting .qa-unfavorite-button").val("'.qa_lang('q2apro_followqact_lang/follow_confirm').'");
						}, 500);
						
					});
				});
			</script>');
		} // end isset favorite
		
	} // end output_widget
}

/*
	Omit PHP closing tag to help avoid accidental output
*/