<?php

namespace WebpConverter\Error\Notice;

/**
 * {@inheritdoc}
 */
class LibsWithoutWebpSupportNotice implements ErrorNotice {

	const ERROR_KEY = 'libs_without_webp_support';

	/**
	 * {@inheritdoc}
	 */
	public function get_key(): string {
		return self::ERROR_KEY;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_message(): array {
		return [
			sprintf(
			/* translators: %1$s: open anchor tag, %2$s: close anchor tag */
				__( 'The selected option of "Conversion method" does not support WebP format. Please read %1$sthe plugin FAQ%2$s, specifically question about requirements of plugin. GD or Imagick library is installed on your server, but it does not support the WebP format. This issue is plugin-independent.', 'webp-converter-for-media' ),
				'<a href="https://wordpress.org/plugins/webp-converter-for-media/#faq" target="_blank">',
				'</a>'
			),
			__( 'You can also use "Remote server" option in "Conversion method" field in the plugin settings. This option allows you to convert your images using a remote server, so your server does not have to meet all technical requirements for libraries.', 'webp-converter-for-media' ),
		];
	}
}
