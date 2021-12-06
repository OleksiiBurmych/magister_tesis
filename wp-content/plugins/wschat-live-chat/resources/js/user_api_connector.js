import { EVENTS } from './events';

export class UserApiConnector {

    filters = {
        before: 0,
        after: 0,
    };

    options = {
        endpoint: '',
        interval: 3000,
        wschat_ajax_nonce: '',
        pusher: {
            authEndpoint: '/wp-admin/admin-ajax.php',
            auth: {
                params: {
                    action: 'wschat_pusher_auth'
                }
            },
            broadcaster: 'pusher',
            key: 'fc9df0026d0a3bf24f3a',
            cluster: 'ap2',
            forceTLS: true
        }
    };

    pause = false;

    constructor(chat, options) {
        this.chat = chat;
        options.pusher = options.pusher ? {...this.options.pusher, ...options.pusher} : {};
        this.options = {...this.options, ...options}

        this.start_conversation();
        this.subscribe();
    }

    subscribe() {
        this.chat.on(EVENTS.WSCHAT_ON_SET_CONVERSATION, () => {
            this.pause = false;
            this.get_messages();
        });

        this.chat.on(EVENTS.WSCHAT_ON_SEND_MESSAGE, (data) => {
            this.send_message(data);
        });

        this.chat.on(EVENTS.WSCHAT_ON_READ_ALL_MESSAGE, data => this.read_all(data));

        this.chat.on(EVENTS.WSCHAT_ON_PONG, () => {
            setTimeout(() => this.get_messages(), 1500);
        });
    }

    start_conversation() {
        jQuery.post(this.options.endpoint, {
            action: this.ACTION_START_CONVERSATION,
            current_url: window.location.href
        }, (data) => {
            this.chat.setConversation(data.data);
        });
    }

    get_messages(params) {

        if (this.pause === true) {
            return false;
        }

        params = params || {};
        params = { ...this.filters, ...params };

        const data = {
            ...params,
            action: this.ACTION_GET_MESSAGE,
        };

        data.conversation_id = this.chat.conversation.id,

            jQuery.post(this.options.endpoint, data, (res) => {

                if (typeof res !== 'object') {
                    return;
                }

                this.chat.trigger(EVENTS.WSCHAT_ON_PONG, res.data);
                let mLength = res.data.messages.length;

                if (mLength === 0) {
                    return;
                }

                this.filters.after = this.filters.after < res.data.messages[0].id ?
                    res.data.messages[0].id :
                    this.filters.after;

                res.data.messages.forEach((row, i) => {
                    res.data.messages[i] = this.chat.trigger(EVENTS.WSCHAT_RENDER_CHAT_CONTENT, row, true);
                });

                this.chat.trigger(EVENTS.WSCHAT_ON_FETCH_MESSAGES, res.data);
            });
    }

    send_message(data) {
        data.action = this.ACTION_SEND_MESSAGE;
        data.conversation_id = this.chat.conversation.id;

        let frmData = new FormData();

        for (let key in data) {
            frmData.append(key, data[key]);
        }

        frmData = this.chat.trigger(EVENTS.WSCHAT_BUILD_FORM_DATA, frmData, true);

        jQuery.ajax({
            method: 'post',
            data: frmData,
            url: this.options.endpoint,
            cache: false,
            processData: false,
            contentType: false,
            success: message => {
                this.chat.trigger(EVENTS.WSCHAT_ON_SENT_A_MESSAGE, message);
            }
        });
    }

    read_all(data) {
        data = data || {};
        data.action = this.ACTION_READ_ALL;
        data.conversation_id = this.chat.conversation.id;

        jQuery.post(this.options.endpoint, data);
    }

    reset_filters() {
        this.filters.after = 0;
        this.filters.before = 0;
        this.pause = true;
    }
}

UserApiConnector.prototype.ACTION_SEND_MESSAGE = 'wschat_send_message';
UserApiConnector.prototype.ACTION_GET_MESSAGE = 'wschat_get_messages';
UserApiConnector.prototype.ACTION_READ_ALL = 'wschat_read_all';
UserApiConnector.prototype.ACTION_START_CONVERSATION = 'wschat_start_conversation';
