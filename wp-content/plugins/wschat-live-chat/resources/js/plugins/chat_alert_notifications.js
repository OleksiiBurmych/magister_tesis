import { EVENTS } from '../events';


/**
 * Chat alert notification plugin
 *
 * You can customize chat ringtone using chat settings like below
 *
 * `options: {
 *      ...
 *      alert: {
 *        url: 'https://domain.tdl/path/to/tone'
 *      }
 *  }`
 */
export class ChatNotificationAlertPlugin {
	/**
	 * Chat core object
	 */
	chat;

    url ='https://dobrian.github.io/cmp/topics/sample-recording-and-playback-with-web-audio-api/freejazz.wav';

    unread_count = 0;

	constructor(chat){
		this.chat = chat;
	}

	init() {
        if (this.chat.options.alert && this.chat.options.alert.url) {
            this.url = this.chat.options.alert.url;
        }

        jQuery(window).click(() => {
            this.setup_player();
        });

		this.chat.on(EVENTS.WSCHAT_ON_PONG, data => this.on_pong(data));
		this.chat.on(EVENTS.WSCHAT_ON_READ_ALL_MESSAGE, () => this.reset_unread_count());
		this.chat.on(EVENTS.WSCHAT_ON_SET_CONVERSATION, () => this.reset_unread_count());
		this.chat.on(EVENTS.WSCHAT_PLAY_NOTIFICATION_TONE, () => this.play());
	}

	setup_player() {
	    if (this.player) {
	        return;
	    }

        this.player = new Audio(this.url);
        this.player.volume = 0.5;
	}

	reset_unread_count() {
	    this.unread_count = 0;
	}

	on_pong(data) {

	    if (data.unread_count == 0 || !this.player || this.player.error || this.unread_count == data.unread_count) {
	        return false;
	    }

	    this.unread_count = data.unread_count;

	    this.player.play();
	}

	play() {
	    this.player && this.player.play();
	}
}

