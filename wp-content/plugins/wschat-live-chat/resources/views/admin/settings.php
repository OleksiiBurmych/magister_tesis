<?php do_action( 'wschat_admin_settings_notices' ); ?>
<h1><?php echo esc_attr__( 'Settings', 'wschat' ); ?></h1>
<form method="post">
<?php wp_nonce_field( 'wschat_save_settings', 'wschat_settings_nonce' ); ?>
<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce() ); ?>" />
<table class="form-table">
	<tr>
		<th><?php echo esc_attr__( 'Live Chat', 'wschat' ); ?></th>
		<td>
			<div class="wschat-wrapper">
			<label class="switch">
				<input type="checkbox" onchange="" name="enable_live_chat" <?php echo $wschat_options['enable_live_chat'] ? 'checked' : ''; ?> />
				<span class="slider round"></span>
			</label>
			<span class="d-none switch-label-on"><?php echo esc_attr__( 'On' , 'wschat' ); ?></span>
			<span class="d-none switch-label-off"><?php echo esc_attr__( 'Off' , 'wschat' ); ?></span>
			<p class="description"><?php echo esc_attr__( 'Enable to display a live chat box on your website', 'wschat' ); ?></p>
			</div>
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Widget Status', 'wschat' ); ?></th>
		<td>
			<div class="wschat-wrapper">
			<label class="switch">
				<input type="checkbox" name="widget_status" <?php echo 'online' === $wschat_options['widget_status'] ? 'checked' : ''; ?> />
				<span class="slider round"></span>
			</label>
			<span class="d-none switch-label-on"><?php echo esc_attr__( 'Online' , 'wschat' ); ?></span>
			<span class="d-none switch-label-off"><?php echo esc_attr__( 'Offline' , 'wschat' ); ?></span>
			<p class="description"><?php echo esc_attr__( 'Set Chat Status as Online/Offline. If the status is offline then the agent cannot reply to customer\'s queries.', 'wschat' ); ?></p>
			</div>
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Widget Online Text', 'wschat' ); ?></th>
		<td>
			<input type="text" name="header_online_text" value="<?php echo esc_attr( $wschat_options['header_online_text'] ); ?>"/>
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Widget Offline Text', 'wschat' ); ?></th>
		<td>
			<input type="text" name="header_offline_text" value="<?php echo esc_attr( $wschat_options['header_offline_text'] ); ?>"/>
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Auto Reply Message', 'wschat' ); ?></th>
		<td>
			<textarea name="offline_auto_reply_text" ><?php echo esc_attr( $wschat_options['offline_auto_reply_text'] ); ?></textarea>
			<p class="description"><?php echo esc_attr__( 'The auto reply message while the widget is offline', 'wschat' ); ?></p>
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Header Text', 'wschat' ); ?></th>
		<td>
			<input type="text" name="header_text" value="<?php echo esc_attr( $wschat_options['header_text'] ); ?>"/>
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Alert Tone', 'wschat' ); ?></th>
		<td>
			<select name="alert_tone" >
				<?php foreach ( $tones as $tone ) : ?>
					<option
						value="<?php echo esc_attr( $tone['basename'] ); ?>"
						<?php echo $tone['basename'] === $wschat_options['alert_tone'] ? 'selected' : ''; ?>
					>
						<?php echo esc_attr__( $tone['filename'], 'wschat' ); ?>
					</option>
				<?php endforeach ?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Widget Font', 'wschat' ); ?></th>
		<td>
			<select name="font_family" >
				<option value=""><?php echo esc_attr__( 'auto', 'wschat' ); ?></option>
				<?php foreach ( $fonts as $font ) : ?>
					<option value="<?php echo esc_attr( $font ); ?>" <?php echo $font === $wschat_options['font_family'] ? 'selected' : ''; ?>><?php echo esc_attr__( $font, 'wschat' ); ?></option>
				<?php endforeach ?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Primary Background Color', 'wschat' ); ?></th>
		<td>
			<input type="text" class="jscolor" name="colors[--wschat-bg-primary]" value="<?php echo esc_attr( $wschat_options['colors']['--wschat-bg-primary'] ); ?>"  />
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Primary Text Color', 'wschat' ); ?></th>
		<td>
			<input type="text" class="jscolor" name="colors[--wschat-text-primary]" value="<?php echo esc_attr( $wschat_options['colors']['--wschat-text-primary'] ); ?>"  />
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Secondary Background Color', 'wschat' ); ?></th>
		<td>
			<input type="text" class="jscolor" name="colors[--wschat-bg-secondary]" value="<?php echo esc_attr( $wschat_options['colors']['--wschat-bg-secondary'] ); ?>"  />
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Secondary Text Color', 'wschat' ); ?></th>
		<td>
			<input type="text" class="jscolor" name="colors[--wschat-text-secondary]" value="<?php echo esc_attr( $wschat_options['colors']['--wschat-text-secondary'] ); ?>"  />
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Icon Color', 'wschat' ); ?></th>
		<td>
			<input type="text" class="jscolor" name="colors[--wschat-icon-color]" value="<?php echo esc_attr( $wschat_options['colors']['--wschat-icon-color'] ); ?>"  />
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Info Text Color', 'wschat' ); ?></th>
		<td>
			<input type="text" class="jscolor" name="colors[--wschat-text-gray]" value="<?php echo esc_attr( $wschat_options['colors']['--wschat-text-gray'] ); ?>"  />
		</td>
	</tr>
	<tr>
		<th>
			<?php echo esc_attr__( 'Communication Protocol', 'wschat' ); ?>
		</th>
		<td>
			<label>
				<input type="radio" value="http" name="communication_protocol" <?php echo ( 'http' === $wschat_options['communication_protocol'] ) ? 'checked' : ''; ?> />
				<?php echo esc_attr__( 'HTTP', 'wschat' ); ?>
			</label>
			<label>
				<input type="radio" value="pusher" name="communication_protocol" <?php echo ( 'pusher' === $wschat_options['communication_protocol'] ) ? 'checked' : ''; ?> />
				<?php echo esc_attr__( 'Pusher', 'wschat' ); ?>
			</label>
			<p><?php echo esc_attr__( 'Use HTTP if you don\'t want to use any external servers for communication between the Customer and Agent. It\'s not recommended for slower servers as there is a risk of losing the chat when more customers are on board. Using the WebSocket option will make the communication fail-safe. WebSocket provider charges will be applicable.', 'wschat' ); ?>
 <a target="_blank" href="https://pusher.com/"/><?php echo esc_attr__( 'Click to create free Pusher account', 'wschat' ); ?></a>
			</p>
		</td>
	</tr>
</table>

<div class="pusher_settings hidden" >
<table class="form-table">
	<tr>
		<td colspan="2" class="p-0"><h3><?php echo esc_attr__( 'Pusher Settings', 'wschat' ); ?></h3></td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'App ID', 'wschat' ); ?></th>
		<td>
			<input placeholder="<?php echo esc_attr__( 'Enter app_id' ); ?>" type="text" name="pusher[app_id]" value="<?php echo esc_attr( $wschat_options['pusher']['app_id'] ); ?>"  />
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Key', 'wschat' ); ?></th>
		<td>
			<input placeholder="<?php echo esc_attr__( 'Enter key' ); ?>" type="text" name="pusher[app_key]" value="<?php echo esc_attr( $wschat_options['pusher']['app_key'] ); ?>"  />
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Secret', 'wschat' ); ?></th>
		<td>
			<input placeholder="<?php echo esc_attr__( 'Enter secret' ); ?>" type="text" name="pusher[secret_key]" value="<?php echo esc_attr( $wschat_options['pusher']['secret_key'] ); ?>"  />
		</td>
	</tr>
	<tr>
		<th><?php echo esc_attr__( 'Cluster', 'wschat' ); ?></th>
		<td>
			<input placeholder="<?php echo esc_attr__( 'Enter Cluster' ); ?>" type="text" name="pusher[cluster]" value="<?php echo esc_attr( $wschat_options['pusher']['cluster'] ); ?>"  />
		</td>
	</tr>
</table>
</div>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_attr__( 'Save Changes', 'wschat' ); ?>"></p>
</form>
<script>
(function (){
	var protocol = jQuery('[name=communication_protocol]');
	var pusher_settings = jQuery('.pusher_settings');

	function togglePusher(value) {
		if (value === 'pusher') {
			pusher_settings.removeClass('hidden');
		} else {
			pusher_settings.addClass('hidden');
		}
	}
	protocol.change(function () {
		var value = jQuery('[name=communication_protocol]:checked').val();
		togglePusher(value)
	});

	jQuery('.switch input[type=checkbox]').on('change', function () {
console.log('switch chaged');
		var parent = jQuery(this).parent().parent();
console.log(parent)
		if (this.checked) {
			parent.find('.switch-label-on').removeClass('d-none');
			parent.find('.switch-label-off').addClass('d-none');
		} else {
			parent.find('.switch-label-on').addClass('d-none');
			parent.find('.switch-label-off').removeClass('d-none');
		}
	}).trigger('change');

	protocol.trigger('change')
})()
</script>
