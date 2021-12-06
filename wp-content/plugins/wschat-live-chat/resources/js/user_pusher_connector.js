import 'pusher-js';
import Echo from 'laravel-echo';
import {EVENTS} from './events';
import { UserApiConnector } from './user_api_connector'

export class UserPusherConnector extends UserApiConnector {

    subscribe() {
        this.chat.on(EVENTS.WSCHAT_ON_SET_CONVERSATION, () => {
            this.pause = false;
            this.get_messages();

            this.subscribe_pusher();
        });

        this.chat.on(EVENTS.WSCHAT_ON_SEND_MESSAGE, (data) => {
            this.send_message(data);
        });

        this.chat.on(EVENTS.WSCHAT_ON_READ_ALL_MESSAGE, data => this.read_all(data));
    }

    subscribe_pusher() {
        this.options.pusher.authEndpoint = this.options.endpoint;
        this.options.pusher.auth.params.wschat_ajax_nonce = this.options.wschat_ajax_nonce;
        this.options.pusher.auth.params.action = this.pusher_auth_action;

        this.Echo = this.Echo || new Echo(this.options.pusher);

        if (this.echo_channel) {
            this.Echo.leaveChannel(this.channel_name);
        }

        this.channel_name = 'conversation_' + this.chat.conversation.id;

        this.echo_channel = this.Echo.join('conversation_' + this.chat.conversation.id);

        this.echo_channel.listen('.message', (data) => {
            data.messages.forEach((row, i) => {
                data.messages[i] = this.chat.trigger(EVENTS.WSCHAT_RENDER_CHAT_CONTENT, row, true);
            });

            this.chat.trigger(EVENTS.WSCHAT_ON_PONG, data);
            this.chat.trigger(EVENTS.WSCHAT_ON_FETCH_MESSAGES, data);
            this.chat.trigger(EVENTS.WSCHAT_PLAY_NOTIFICATION_TONE, data);
        });
    }
}
UserPusherConnector.prototype.pusher_auth_action = 'wschat_pusher_auth';
