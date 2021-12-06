import {UserApiConnector} from './user_api_connector';

import {EVENTS} from './events';

export class AdminApiConnector extends UserApiConnector {

    start_conversation() {
        jQuery.post(this.options.endpoint, {
            action: this.ACTION_GET_CONVERSATIONS,
        }, (data) => {
            if (data.data.length === 0) {
                this.chat.trigger(EVENTS.WSCHAT_ON_NO_CONVERSATIONS);
                return;
            }
            this.chat.trigger(EVENTS.WSCHAT_ON_FETCH_CONVERSATIONS, data.data);
        });
    }

    join_conversation(id) {
        this.reset_filters();

        jQuery.post(this.options.endpoint, {
            action: this.ACTION_JOIN_CONVERSATION,
            conversation_id: id
        }, (data) => {
            this.chat.setConversation(data.data);
        });
    }
}

AdminApiConnector.prototype.ACTION_SEND_MESSAGE = 'wschat_admin_send_message';
AdminApiConnector.prototype.ACTION_GET_MESSAGE = 'wschat_admin_get_messages';
AdminApiConnector.prototype.ACTION_READ_ALL = 'wschat_admin_read_all';
AdminApiConnector.prototype.ACTION_GET_CONVERSATIONS = 'wschat_admin_get_conversations';
AdminApiConnector.prototype.ACTION_JOIN_CONVERSATION = 'wschat_admin_join_conversation';
