<div class="wschat-wrapper">
	<div class="d-none no-conversation-alert alert alert-warning m-1">
		<p class="text-danget text-center m-0"><?php echo esc_attr__( 'No conversations found', 'wschat' ); ?></p>
	</div>
	<div class="m-1">
		<div class="container-fluid bg-white g-0 shadow-lg">
			<div class="row g-0">
				<div class="col-md-3 border-end">
					<div class="settings-tray rounded-start text-white">
						<img class="profile-image" src="<?php echo esc_html( get_avatar_url( wp_get_current_user()->ID ) ); ?>" alt="Profile img">
					</div>
					<div class="search-box d-none">
						<div class="input-wrapper">
							<i class="material-icons">search</i>
							<input placeholder="Search here " type="text">
						</div>
					</div>
					<div class="conversation-list">
					</div>
				</div>
				<div class="col-md-9 d-flex flex-column align-items-stretch conversation-wrapper d-none">
					<div class="settings-tray rounded-end chat-panel-header">
						<div class="friend-drawer friend-drawer--grey p-0 d-flex">
							<img class="profile-image" src="https://ui-avatars.com/api/?rounded=true&name=Guest" alt="">
							<div class="text w-100">
								<h6><span class="username"></span> <span class="unread-count badge rounded-pill d-none"></span></h6>
								<p class="status"></p>
							</div>
							<span class="settings-tray--right">
								<i class="material-icons user-meta-info-toggle">info</i>
							</span>
						</div>
					</div>
					<div class="row g-0">
						<div class="col">
							<div class="chat-panel flex-fill d-flex flex-column border-end">
							</div>
						</div>
						<div class="col-4 user-meta-info d-none border-start">
						</div>
					</div>
					<div class="row g-0">
						<div class="col-12">
							<div class="attachment-wrapper">
								<div class="attachment-content">
									<div class="attachments-preview-container d-flex flex-wrap">
									</div>
									<div class="attachment-list fade d-none">
									</div>
								</div>
							</div>
							<?php if ( \WSChat\Utils::is_widget_online() === false ) { ?>
							<div>
								<p class="text-center wschat-notice">
									<?php echo esc_attr__( 'Widget is offline. So, You are not able to reply.', 'wschat' ); ?>
									<a href="<?php echo esc_html( \WSChat\Utils::get_url( 'wschat_settings' ) ); ?>" ><?php echo esc_attr__( 'settings', 'wschat' ); ?></a>
								</p>
							</div>
							<?php } ?>
							<div class="chat-box-tray <?php echo \WSChat\Utils::is_widget_online() ? '' : esc_html( 'd-none' ); ?>">
								<button class="btn btn-sm" id="attachment_picker">
									<i class="material-icons">attachment</i>
								</button>
								<button class="btn btn-sm" id="wschat_emoji_picker">
									<i class="material-icons">sentiment_very_satisfied</i>
								</button>
								<textarea rows="1" id="wschat_message_input" class="w-100 bg-white p-2" placeholder="Type your message here..."></textarea>
								<button class="btn btn-sm" id="wschat_send_message">
									<i class="material-icons">send</i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
