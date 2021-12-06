import {WSChat, formatDate} from './chat';
import { AdminApiConnector } from './admin_api_connector';
import { AdminPusherConnector } from './admin_pusher_connector';
import { EVENTS } from './events';
import { EmojiButton } from '@joeattardi/emoji-button';
import UserMetaInfo from './components/user_meta_info.html'

jQuery(document).ready(function() {

    const wrapper = jQuery('.wschat-wrapper');

    if (wrapper.length === 0) {
    	return;
    }

    const CONVERSATION_TEMPLATE = `
		<div class="friend-drawer friend-drawer--onhover" data-conversation-id="{{CONVERSATION_ID}}">
		  <img class="profile-image" src="https://ui-avatars.com/api/?rounded=true&name=Guest" alt="">
		  <div class="text">
			<h6>{{NAME}}</h6>
			<p class="last-message text-truncate">{{LAST_MESSAGE}}</p>
		  </div>
		  <span class="time small d-none">{{TIMESTAMP}}</span>
		  <span class="unread-count badge rounded-pill align-self-center">{{UNREAD_COUNT}}</span>
		</div>
		<hr>`;

    const CHAT_BUBBLE_TEMPLATE = `
		  <div class="row g-0 w-100 message-item" data-message-id="{{MESSAGE_ID}}">
			<div class="col-xs-10 col-md-9 col-lg-6 {{OFFSET}}">
			  <div class="chat-bubble chat-bubble--{{POS}}">
                {{CONTENT}}
			  </div>
              <span class="time">{{TIMESTAMP}}</span>
			</div>
		  </div>`;

    const CONVERSATION_TEMPLATE_DEFAULTS = {
        '{{CONVERSATION_ID}}': '',
        '{{LAST_MESSAGE}}': 'left',
        '{{TIMESTAMP}}': '',
        '{{NAME}}': '',
    };

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
        connector: wschat_ajax_obj.settings.communication_protocol === 'pusher' ? AdminPusherConnector : AdminApiConnector,
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

    if (wschat_ajax_obj.settings) {
		for(let key in wschat_ajax_obj.settings.colors) {
			key && chat.$el.get(0).style.setProperty(key,  '#' +wschat_ajax_obj.settings.colors[key]);
		}
    }

    setInterval(() => {
        chat.connector.start_conversation();
    }, 5000);

    const chat_panel = chat.$el.find('.chat-panel');
    const conversation_panel = chat.$el.find('.conversation-list');
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


    const replaceConversation = (conversation) => {
        let item = conversation_panel.find('[data-conversation-id='+conversation.id+']');
        if (item.length === 0 ) {
            return false;
        }

        item.find('.time').text(conversation.updated_at);
        item.find('.last-message').text( conversation.recent_message ? conversation.recent_message.body.text : '');
		item.find('.unread-count').text(conversation.unread_count || '');

        if (conversation.is_user_online) {
        	item.addClass('online');
        } else {
        	item.removeClass('online');
        }

        return true;
    };

    const sortConversation = () => {
        const new_conversation_panel = conversation_panel.clone();
        const items = [];

        new_conversation_panel.find('[data-conversation-id]').each(function (i, item) {
            items.push(item);
        });

        items.sort((a, b) => {
            let timestamp1 = jQuery(a).find('.time').html();
            let timestamp2 = jQuery(b).find('.time').html();

            return strToDate(timestamp2) - strToDate(timestamp1);
        });

        new_conversation_panel.html('');

        items.forEach((item) => {
            new_conversation_panel.append(item);
        });

        conversation_panel.html(new_conversation_panel.html());
    };

    const strToDate = (timestamp) => {
        let [date1, time1] = timestamp.split(' ');
        date1 = date1.split('-');
        time1 = time1.split(':');

        return parseInt(date1.join('') + time1.join(''));
    };

    const showNoConversation = () => {
        const no_conversation_alert = jQuery('.no-conversation-alert');
        conversation_panel.append(no_conversation_alert.removeClass('d-none'));
    }

    chat.on(EVENTS.WSCHAT_ON_NO_CONVERSATIONS, () => {
        showNoConversation();
    });
    chat.on(EVENTS.WSCHAT_ON_FETCH_CONVERSATIONS, (conversations) => {

        conversations.forEach(conversation => {
            if (replaceConversation(conversation)) {
                return;
            }

            CONVERSATION_TEMPLATE_DEFAULTS['{{CONVERSATION_ID}}'] = conversation.id;
            CONVERSATION_TEMPLATE_DEFAULTS['{{NAME}}'] = conversation.user.meta.name;
            CONVERSATION_TEMPLATE_DEFAULTS['{{TIMESTAMP}}'] = formatDate(conversation.updated_at);
            CONVERSATION_TEMPLATE_DEFAULTS['{{LAST_MESSAGE}}'] = conversation.recent_message ? conversation.recent_message.body.text : '';
            CONVERSATION_TEMPLATE_DEFAULTS['{{UNREAD_COUNT}}'] = conversation.unread_count || '';

            let row_template = CONVERSATION_TEMPLATE;

            row_template = row_template.replace(new RegExp(Object.keys(CONVERSATION_TEMPLATE_DEFAULTS).join('|'), 'g'), match => CONVERSATION_TEMPLATE_DEFAULTS[match]);

            row_template = jQuery(row_template);

            if (conversation.is_user_online) {
            	row_template = row_template.addClass('online');
            }

            if (conversation.user && conversation.user.meta.avatar) {
				row_template.find('img.profile-image').attr('src', conversation.user.meta.avatar)
            }
            conversation_panel.append(row_template);
        });

        sortConversation();

        setTimeout(() => {
            let activeItem = conversation_panel.find('.active[data-conversation-id]').length
            activeItem === 0 && conversation_panel.find('[data-conversation-id]').eq(0).click();
        }, 1000);
    });

    chat.on(EVENTS.WSCHAT_ON_SET_CONVERSATION, (data) => {
        data.user &&
            chat_panel_header.find('.username').text(data.user.meta.name);
        let info = chat.$el.find('.user-meta-info').html(UserMetaInfo);

        chat_panel_header.parent().removeClass('d-none')

		info.find('.name').html(data.user.meta.name);
		info.find('.browser').html(data.user.meta.browser);
		info.find('.os').html(data.user.meta.os);
		info.find('.device').html(data.user.meta.device);
		info.find('.url').html(data.user.meta.current_url);

        message_input.focus();
        MESSAGE_INFO.min = 0;
        MESSAGE_INFO.max = 0;
        DISABLE_SCROLL_LOCK = true;
        resizeChat();

        setTimeout(() => DISABLE_SCROLL_LOCK = false, 1000);
    });

    chat.on(EVENTS.WSCHAT_ON_FETCH_MESSAGES, (data) => {
        for (let i = 0; i < data.messages.length; i++) {
            let row = data.messages[i];

            if (row.is_agent === true) {
                BUBBLE_TEMPLATE_DEFAULTS['{{OFFSET}}'] = 'offset-lg-6 offset-md-3 offset-xs-2';
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

    chat.on(EVENTS.WSCHAT_ON_PONG, (data) => {
        let drawer = chat_panel_header.find('.friend-drawer');
		let row_template = conversation_panel.find('[data-conversation-id='+data.id+']');
		let row_unread_count = row_template.find('.unread-count');
		let header_unread_count = chat_panel_header.find('.unread-count');

        chat_panel_header.find('.status').text(data.status);
        header_unread_count.text(data.unread_count);
		row_unread_count.text(data.unread_count || '');

        if (data.unread_count) {
            header_unread_count.removeClass('d-none');
        } else {
            header_unread_count.addClass('d-none');
        }

        if (data.is_online) {
            drawer.addClass('online');
            row_template.addClass('online');
        } else {
            drawer.removeClass('online');
            row_template.removeClass('online');
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
        message_input.val('').focus();
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

    chat_panel_header.on('click', '.user-meta-info-toggle', function () {
    	chat.$el.find('.conversation-wrapper .user-meta-info').toggleClass('d-none');
    });

    conversation_panel.on('click', '[data-conversation-id]', function() {
        chat_panel.html('');
        let item = jQuery(this);
        let converssation_id = item.data('conversation-id');
        conversation_panel.find('[data-conversation-id]').removeClass('active');
        item.addClass('active')
        chat.connector.join_conversation(converssation_id);
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

    const resizeChat = () => {
		const window_height = jQuery(window).height() - chat.$el.offset().top;

		const height = window_height - (
            chat_panel_header.height()*2 + chat_tray_box.height()
        );

		conversation_panel.css({
			'min-height': height + 'px'
		});

		chat_panel.css({
			'min-height': height + 'px'
		});
    };

    jQuery(window).resize(() => resizeChat());
    resizeChat();

    const emojiPicker = document.getElementById('wschat_emoji_picker');
    const emoji = new EmojiButton({
        style: 'twemoji',
        rootElement: emojiPicker.parentElement,
        position: 'top'
    });


    emojiPicker.addEventListener('click', function() {
        emoji.togglePicker();
    });

    emoji.on('emoji', function(selection) {
    	console.log(selection)
        message_input.val(message_input.val() + selection.emoji).focus();
        setTimeout(() => message_input.focus(), 500)
    });


    // Attachment toggler
    chat.$el.find('#attachment_picker').click(function (e) {
        e.preventDefault();
        chat.$el.find('.attachment-list').toggleClass('show d-none');
    });
    chat.$el.find('.attachment-list').on('click','button', function () {

        chat.$el.find('#attachment_picker').click();
    });

});
