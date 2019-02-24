from flask import Flask
from flask import request
import requests
import json

app = Flask(__name__)

token = "Replace with your own token!"
urlStart = "https://api.telegram.org/bot" + token + "/"

@app.route('/BotKicker', methods = ['POST'])
def bot_kicker():
    update = json.loads(request.get_data(cache=False))
    adder_kicked = False

    if 'message' in update:
        message = update['message']
        chat_id = message['chat']['id']
        if 'new_chat_members' in message:
            new_chat_members = message['new_chat_members']
            for member in new_chat_members:
                if member['is_bot']:
                    bot_id = member['id']
                    chat_id = message['chat']['id']
                    if not adder_kicked:
                        adder_id = message['from']['id']
                        payload = {'chat_id': chat_id, 'user_id': adder_id}
                        requests.get(urlStart + "kickChatMember", params=payload)
                        adder_kicked = True
                    payload = {'chat_id': chat_id, 'user_id': bot_id}
                    requests.get(urlStart + "kickChatMember", params=payload)
    return json.dumps({'success':True}), 200, {'ContentType':'application/json'}
