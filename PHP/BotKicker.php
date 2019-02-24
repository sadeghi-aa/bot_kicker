<?php
	//code
	$token = "Replace with your bot token!";
	$update = urldecode(file_get_contents('php://input'));
	$update = json_decode($update, true);
	$adder_kicked = false;
	
	if(array_key_exists('message', $update)) {
		$message = $update['message'];
		$message_id = $message['message_id'];
		if(array_key_exists('new_chat_members', $message)) {		
			$new_chat_members = $message['new_chat_members'];
			for ($i = 0; $i < sizeof($new_chat_members); $i++) {
				$member = $new_chat_members[$i];
				if($member['is_bot']) {
					$bot_id = $member['id'];
					$ch = curl_init();    					
					$chat_id = $message['chat']['id'];
					if($adder_kicked == false) {
						$adder_id = $message['from']['id'];
						curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$token/kickChatMember?chat_id=$chat_id&user_id=$adder_id");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_exec($ch);		    
						$adder_kicked = true;
					}
					curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$token/kickChatMember?chat_id=$chat_id&user_id=$bot_id");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_exec($ch);		
				}
			}
		}
	}	
?>
