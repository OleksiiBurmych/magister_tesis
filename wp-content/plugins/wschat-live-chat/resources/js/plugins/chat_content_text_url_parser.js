import { EVENTS } from '../events';

export class ChatMessageTextUrlParserPlugin {
	/**
	 * Chat core object
	 */
	chat;

	constructor(chat){
		this.chat = chat;
	}

	init() {
		this.chat.on(EVENTS.WSCHAT_RENDER_CHAT_CONTENT, content => this.parse_url(content));
	}

	parse_url(content) {
		if (content.type !== 'text') {
			return content;
		}

		content.body.formatted_content = content.body.formatted_content || '';

		content.body.formatted_content = this.replaceUrl(content.body.text);

		return content;
	}

	/**
	 * Replace links with anchor tags
	 *
	 * https://stackoverflow.com/a/7123542
	 */
	replaceUrl(text) {
		// http://, https://, ftp://
        var urlPattern = /\b(?:https?|ftp):\/\/[a-z0-9-+&@#\/%?=~_|!:,.;]*[a-z0-9-+&@#\/%=~_|]/gim;

        // www. sans http:// or https://
        var pseudoUrlPattern = /(^|[^\/])(www\.[\S]+(\b|$))/gim;

        // Email addresses
        var emailAddressPattern = /[\w.]+@[a-zA-Z_-]+?(?:\.[a-zA-Z]{2,6})+/gim;

        return text
            .replace(urlPattern, '<a target="_blank" href="$&">$&</a>')
            .replace(pseudoUrlPattern, '$1<a target="_blank" href="http://$2">$2</a>')
            .replace(emailAddressPattern, '<a target="_blank" href="mailto:$&">$&</a>');
	}
}

