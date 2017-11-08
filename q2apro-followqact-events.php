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

	class q2apro_followqact_events {
	
		// main event processing function	
		function process_event($event, $userid, $handle, $cookieid, $params) {
			
			if(qa_opt('q2apro_followqact_enabled')) {
				// memo: 
				// with the on-site-notifications-plugin enabled, the questioner gets notifications on commments-to-his-question and answers
				// but he does not get notifications for comments on answers-to-his-question
				
				// What the plugin does:
				// 1. get question id
				// 2. check if users have favorited the question id
				// 3. if users are found, send them an email with the question link with anchor
				
				// note: dont inform user about his own post
			
				$plugin_events = array(
					'a_post',
					'c_post',
				 );
				 
				// comments and answers
				if(in_array($event, $plugin_events)) {
				
					$questionid = null;
					$postid = $params['postid'];
					
					// 1. get question id
					// get question id from answer
					if($event == 'a_post') {
						$questionid = $params['parentid'];
					}
					else if($event == 'c_post') {
						// get question id from comment
						$questionid = $params['questionid']; // ? working ?
					}
					
					if(isset($questionid)) {
						
						// 2. check if users have favorited the question id
						// userid (QA)
						$userids_fav = qa_db_read_all_assoc(
											qa_db_query_sub(
												'SELECT userid FROM ^userfavorites 
													WHERE entityid=#
													AND entitytype="Q"
												',
												$questionid
											)
										);
						foreach ($userids_fav as $uid) {
							// 3. if users are found, send them an email with the question link with anchor to a or c
							
							// dont inform user about his own post
							if($userid != $uid['userid']) {
								
								// create correct link to answer or comment
								$qTitle = qa_db_read_one_value( qa_db_query_sub('SELECT title FROM `^posts` WHERE `postid` = # LIMIT 1', $questionid), true);
								if(is_null($qTitle)) {
									$qTitle = '';
								}
								// get correct URL
								$activity_url = qa_path_html(qa_q_request($questionid, $qTitle), null, qa_opt('site_url'), null, null);
								$linkToPost = '';
								if($event == 'a_post') {
									$linkToPost = $activity_url.'?show='.$postid.'#a'.$postid;
								}
								else {
									$linkToPost = $activity_url.'?show='.$postid.'#c'.$postid;								
								}
								
								// send mail to user
								$mail_subject = qa_lang('q2apro_followqact_lang/mail_subject');
								$userinfo = qa_db_select_with_pending(qa_db_user_account_selectspec($uid['userid'], true));
								$poster_handle = 'Gast';
								if(isset($userid)) {
									$poster_handle = qa_db_read_one_value( qa_db_query_sub('SELECT handle FROM `^users` WHERE `userid` = # LIMIT 1', $userid), true);
								}
								
								$emailbody = '<p>'.qa_lang('q2apro_followqact_lang/mail_activity').' <a href="'.$activity_url.'">"'.$qTitle.'"</a></p>';
								if($event == 'a_post') {
									$emailbody .= '<p><a href="'.$linkToPost.'">'.qa_lang('q2apro_followqact_lang/answer').'</a> '.qa_lang('q2apro_followqact_lang/from').' '.$poster_handle.':</p>';
								}
								else {
									$emailbody .= '<p><a href="'.$linkToPost.'">'.qa_lang('q2apro_followqact_lang/comment').'</a> '.qa_lang('q2apro_followqact_lang/from').' '.$poster_handle.':</p>';
								}
								
								// content
								$emailbody .= $params['content'];
								
								qa_send_email(array(
									'fromemail' => qa_opt('mailing_from_email'),
									'fromname' => qa_opt('mailing_from_name'),
									'toemail' => $userinfo['email'],
									'toname' => $userinfo['handle'],
									'subject' => $mail_subject,
									'body' => trim($emailbody),
									'html' => true,
								));

							} // end $userid != $uid
						} // end foreach
						
					} // end isset $questionid
				} // end event in_array
			
			} // end if 'q2apro_followqact_enabled'
		} // end process_event

	} // end class q2apro_followqact_events

	
/*
	Omit PHP closing tag to help avoid accidental output
*/