import {WSChat, formatDate} from './chat';
import { UserApiConnector } from './user_api_connector';
import { UserPusherConnector } from './user_pusher_connector';
import { EVENTS } from './events';
import { EmojiButton } from '@joeattardi/emoji-button';

import  Cookies from 'js-cookie';

jQuery(document).ready(function () {

    const wrapper = jQuery('.wschat-wrapper');

    if (wrapper.length === 0) {
    	return;
    }

    const CHAT_BUBBLE_TEMPLATE = `
		  <div class="row g-0 w-100 message-item" data-message-id="{{MESSAGE_ID}}">
			<div class="col-md-9 {{OFFSET}}">
			  <div class="chat-bubble chat-bubble--{{POS}}">
                {{CONTENT}}
			  </div>
              <span class="time small">{{TIMESTAMP}}</span>
			</div>
		  </div>`;

    const BUBBLE_TEMPLATE_DEFAULTS = {
        '{{OFFSET}}': '',
        '{{POS}}': 'left',
        '{{CONTENT}}': '',
        '{{TIMESTAMP}}': '',
        '{{MESSAGE_ID}}': '',
    };

    jQuery.ajaxSetup({
        data: {
            wschat_ajax_nonce: wschat_ajax_obj.nonce
        }
    });

    var chat = new WSChat(jQuery('.wschat-wrapper'), {
        connector: wschat_ajax_obj.settings.communication_protocol === 'pusher' ? UserPusherConnector : UserApiConnector,
        api: {
            endpoint: wschat_ajax_obj.ajax_url,
            interval: 3000,
            wschat_ajax_nonce: wschat_ajax_obj.nonce,
            pusher: {
				key: wschat_ajax_obj.settings.pusher.app_key,
				cluster: wschat_ajax_obj.settings.pusher.cluster,
			}
        },
        alert: {
        	url: wschat_ajax_obj.settings.alert_tone_url
        },
        header: {
        	status_text: wschat_ajax_obj.settings.widget_status === 'online' ? wschat_ajax_obj.settings.header_online_text : wschat_ajax_obj.settings.header_offline_text,
        }
    });

    const chat_popup = chat.$el.find('.wschat-popup');
    const chat_panel = chat.$el.find('.chat-panel');
    const chat_panel_header = chat.$el.find('.chat-panel-header');
    const chat_tray_box = chat.$el.find('.chat-box-tray');
    const message_input = jQuery('#wschat_message_input');
    const MESSAGE_INFO = {
        min: 0,
        max: 0,
    };
    let PAST_REQUEST_IS_PENDING = false;
    let SCROLL_PAUSED = false;
    let DISABLE_SCROLL_LOCK = false;
    const SCROLL_OFFSET = 100;

    chat_panel_header.find('.status').text(chat.options.header.status_text);

    if (wschat_ajax_obj.settings) {
		for(let key in wschat_ajax_obj.settings.colors) {
			key && chat.$el.get(0).style.setProperty(key,  '#' +wschat_ajax_obj.settings.colors[key]);
		}

		if (wschat_ajax_obj.settings.font_family) {
			chat.$el.css({'font-family': wschat_ajax_obj.settings.font_family})
		}

		chat_panel_header.find('.username').text(wschat_ajax_obj.settings.header_text);
    }


    // TODO: Update this to match user case
    chat.on(EVENTS.WSCHAT_ON_SET_CONVERSATION, (data) => {
        message_input.focus();
        MESSAGE_INFO.min = 0;
        MESSAGE_INFO.max = 0;
        DISABLE_SCROLL_LOCK = true;

        setTimeout(() => DISABLE_SCROLL_LOCK = false, 1000);
    });

    chat.on(EVENTS.WSCHAT_ON_FETCH_MESSAGES, (data) => {
        for (let i = 0; i < data.messages.length; i++) {
            let row = data.messages[i];

            if (row.is_agent === false) {
                BUBBLE_TEMPLATE_DEFAULTS['{{OFFSET}}'] = 'offset-md-3';
                BUBBLE_TEMPLATE_DEFAULTS['{{POS}}'] = 'right';
            } else {
                BUBBLE_TEMPLATE_DEFAULTS['{{OFFSET}}'] = '';
                BUBBLE_TEMPLATE_DEFAULTS['{{POS}}'] = 'left';
            }

            BUBBLE_TEMPLATE_DEFAULTS['{{MESSAGE_ID}}'] = row.id;
            BUBBLE_TEMPLATE_DEFAULTS['{{CONTENT}}'] = row.body.formatted_content;
            BUBBLE_TEMPLATE_DEFAULTS['{{TIMESTAMP}}'] = formatDate(row.created_at);

            let row_template = CHAT_BUBBLE_TEMPLATE;

            row_template = row_template.replace(new RegExp(Object.keys(BUBBLE_TEMPLATE_DEFAULTS).join('|'), 'g'), match => BUBBLE_TEMPLATE_DEFAULTS[match]);

            if (MESSAGE_INFO.min === 0) {
                chat_panel.append('<span data-message-id="0"></span>');
            }

            if (MESSAGE_INFO.min > row.id) {
                chat_panel.find('[data-message-id='+MESSAGE_INFO.min+']').before(row_template);
                MESSAGE_INFO.min = row.id;
            }

            if (MESSAGE_INFO.max === 0 || MESSAGE_INFO.max < row.id) {
                chat_panel.find('[data-message-id='+MESSAGE_INFO.max+']').after(row_template);
                MESSAGE_INFO.max = row.id;
                scrollIfNotPaused();
            }

            if (MESSAGE_INFO.min === 0) {
               scrollIfNotPaused();
            }

            MESSAGE_INFO.min = MESSAGE_INFO.min || row.id;
            MESSAGE_INFO.max = MESSAGE_INFO.max || row.id;
        }

        if (DISABLE_SCROLL_LOCK === true) {
            scrollIfNotPaused();
        }

    });

    chat.on(EVENTS.WSCHAT_ON_SENT_A_MESSAGE, (data) => {
    	if (data.data.offline_reply) {
            BUBBLE_TEMPLATE_DEFAULTS['{{OFFSET}}'] = 'mb-2';
            BUBBLE_TEMPLATE_DEFAULTS['{{POS}}'] = 'left';
            BUBBLE_TEMPLATE_DEFAULTS['{{MESSAGE_ID}}'] = data.data.id;
            BUBBLE_TEMPLATE_DEFAULTS['{{CONTENT}}'] = data.data.offline_reply;
            BUBBLE_TEMPLATE_DEFAULTS['{{TIMESTAMP}}'] = '';

            let row_template = CHAT_BUBBLE_TEMPLATE;

            row_template = row_template.replace(new RegExp(Object.keys(BUBBLE_TEMPLATE_DEFAULTS).join('|'), 'g'), match => BUBBLE_TEMPLATE_DEFAULTS[match]);

            setTimeout(() => {
            	chat_panel.append(row_template);
            	scrollIfNotPaused();
            }, 1000);
    	}
    });

    chat.on(EVENTS.WSCHAT_ON_PONG, (data) => {
        let drawer = chat_panel_header.find('.friend-drawer');
		let header_unread_count = chat.$el.find('.unread-count');

        header_unread_count.text(data.unread_count);

        if (data.unread_count) {
            header_unread_count.removeClass('d-none');
        } else {
            header_unread_count.addClass('d-none');
        }

        if (data.is_online) {
            drawer.addClass('online');
        } else {
            drawer.removeClass('online');
        }
    });

    const scrollIfNotPaused = () => {
        if (SCROLL_PAUSED === false || DISABLE_SCROLL_LOCK === true) {
            chat_panel[0].scrollTop = chat_panel[0].scrollHeight;
        }
    }

    const send_btn = jQuery('#wschat_send_message').on('click', function() {
        let msg = message_input.val();

        if (msg.trim() === '' && chat.trigger(EVENTS.WSCHAT_CAN_SEND_EMPTY_MESSAGE, false, true) === false) {
            return false;
        }

        chat.sendMessage({
            // Type is text by default now, it needs to changed based on the selection content
            wschat_ajax_nonce: wschat_ajax_obj.nonce,
            type: 'text',
            'content[text]': message_input.val()

        });

        message_input.val('').focus().trigger('change');
    });

    message_input.keyup(function(e) {
        e.key === 'Enter' && send_btn.click();
    });

    message_input.on('focus', function() {
        let unread_count = chat_panel_header.find('.unread-count').text();

        if (parseInt(unread_count) > 0) {
        	chat.trigger(EVENTS.WSCHAT_ON_READ_ALL_MESSAGE);
        }
    });

    chat_panel.on('scroll', function () {
        if (DISABLE_SCROLL_LOCK) {
            SCROLL_PAUSED = false;
            return;
        }
        if (this.scrollTop < SCROLL_OFFSET) {
            if (PAST_REQUEST_IS_PENDING === false) {
                PAST_REQUEST_IS_PENDING = true;
                chat.connector.get_messages({
                    after: 0,
                    before: MESSAGE_INFO.min
                });
                setTimeout(() => PAST_REQUEST_IS_PENDING = false, 500);
            }
        }

        if (this.offsetHeight + this.scrollTop >= this.scrollHeight - SCROLL_OFFSET) {
            SCROLL_PAUSED = false;
        } else {
            SCROLL_PAUSED = true;
        }
    });

    const toggle = jQuery('.wschat-chat-toggle').click(function (e) {
		e.preventDefault();
        toggleChat();
    });
    const resizeChat = () => {
		const BREAKPOINT = 576;
		const window_height = jQuery(window).innerHeight();

		if (jQuery(window).width() <= BREAKPOINT) {
			const height = window_height - (
                chat_panel_header.height()*2 + chat_tray_box.height() + chat_popup.find('.powered-by-tag').height()
            );

			chat_panel.css({
				'min-height': height + 'px'
			});
		} else {
			chat_panel.css({
				'min-height': (window_height/2) + 'px'
			});
		}
    };

    jQuery(window).resize(() => resizeChat());

    const toggleChat = () => {
		chat_popup.toggleClass('show-on');
        resizeChat();
        if (chat_popup.hasClass('show-on')) {
            Cookies.set('wschat_widget_is_open', 'open');
        } else {
            Cookies.set('wschat_widget_is_open', 'closed');
        }
    };

    const is_chat_open = Cookies.get('wschat_widget_is_open');

    if (is_chat_open === 'open') {
        toggleChat();
    }

    const emojiPicker = document.getElementById('wschat_emoji_picker');
    const emoji = new EmojiButton({
        style: 'twemoji',
        rootElement: emojiPicker.parentElement,
        position: 'top',
    });


    emojiPicker.addEventListener('click', function() {
        emoji.togglePicker();
    });

    emoji.on('emoji', function(selection) {
        message_input.val(message_input.val() + selection.emoji).focus();
        setTimeout(() => message_input.focus(), 500)
    });

    // Attachment toggler
    chat.$el.find('#attachment_picker').click(function (e) {
        e.preventDefault();
        const list = chat.$el.find('.attachment-list').toggleClass('d-none');
        list.find('.attachment-list-item').each((i, item) => {
            setTimeout( () => jQuery(item).toggleClass('show'), i*100)
        });
    });

    chat.$el.find('.attachment-list').on('click','button', function () {
        chat.$el.find('#attachment_picker').click();
    });
});
