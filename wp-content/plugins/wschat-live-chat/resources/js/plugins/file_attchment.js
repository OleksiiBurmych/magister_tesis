
import { EVENTS } from '../events';


/**
 * File attachments plugin
 */
export class FileAttachmentPlugin {
	/**
	 * Chat core object
	 */
	chat;

	files = [];

	constructor(chat){
		this.chat = chat;
	}

	init() {
		this.chat.on(EVENTS.WSCHAT_BUILD_FORM_DATA, frmData => this.build_form_data(frmData));
		this.chat.on(EVENTS.WSCHAT_ON_SENT_A_MESSAGE, () => this.reset_files());
		this.chat.on(EVENTS.WSCHAT_RENDER_CHAT_CONTENT, message => this.format_content(message));
		this.chat.on(EVENTS.WSCHAT_CAN_SEND_EMPTY_MESSAGE, () => this.files.length > 0);

		const picker = jQuery(BTN_TEMPLATE);

		this.chat.$el.find('.attachment-wrapper .attachment-list').append(picker);

		picker.click(e => this.show_picker());
	}

	show_picker() {
		const file_input = jQuery(FILE_INPUT_TEMPLATE);
		this.chat.$el.find('.attachment-wrapper').prepend(file_input);

		file_input.click();

		file_input.change(e => this.on_input_change(e));
	}

	on_input_change(e) {
		Array.prototype.push.apply( this.files, e.target.files );
		this.render_preview();
	}

	render_preview() {
		const preview_container = this.chat.$el.find('.attachment-wrapper .attachments-preview-container');
		preview_container.find('.file-attachment-preview').remove();

		this.files.forEach((file, i) => {
			const template = jQuery(PREVIEW_TEMPLATE);
			template.find('.preview-content').text(file.name).attr('title', file.name);
			template.data('file-attachment-index', i);

			template.find('.btn-close').click(e => this.remove_file(e));

			preview_container.append(template);
		});
	}

	build_form_data(frmData) {
		this.files.forEach(file => {
			frmData.append('attachments[]', file);
		});

		return frmData;
	}

	remove_file(e) {
		let item = jQuery(e.target).parent().parent();

		const index = item.data('file-attachment-index');

		this.files.splice(index, 1);
		this.render_preview();
	}

	reset_files() {
		this.files = [];
		this.render_preview();
	}

	format_content(message) {
		if (!message.body.attachments) {
			return message;
		}

		let markup = '<div class="attachment-links d-flex flex-wrap">';

		message.body.attachments.forEach(attachment => {
			markup += `<a class="m-1" href="${attachment.url}" title="${attachment.name}" target="_blank" > ${attachment.name} </a>`;
		});

		markup += '</div>';

		message.body.formatted_content = message.body.formatted_content || '';

		message.body.formatted_content += markup;

		return message;
	}
}

export const BTN_TEMPLATE = `
	<button id="wschat_file_attachement_picker" class="btn btn-sm attachment-list-item" title="Upload Files">
		<i class="material-icons">attach_file</i>
	</button>
`;

export const FILE_INPUT_TEMPLATE = `
	<input type="file" multiple name="wschat_file_attachments[]" class="d-none" />
`;

export const PREVIEW_TEMPLATE = `
	<div class="file-attachment-preview m-1">
		<div class="alert alert-light alert-dismissible fade show m-0" role="alert">
		  <div class="preview-content"></div>
  	  	  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	</div>
`;

