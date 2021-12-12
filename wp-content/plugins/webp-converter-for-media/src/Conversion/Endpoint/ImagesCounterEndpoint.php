<?php

namespace WebpConverter\Conversion\Endpoint;

/**
 * Calculates the number of all images to be converted.
 */
class ImagesCounterEndpoint extends EndpointAbstract {

	/**
	 * {@inheritdoc}
	 */
	public function get_route_name(): string {
		return 'images-counter';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_route_response( \WP_REST_Request $request ) {
		$images_count = number_format(
			count( ( new PathsEndpoint( $this->plugin_data ) )->get_paths( false ) ),
			0,
			'',
			' '
		);

		return new \WP_REST_Response(
			[
				'value_output' => sprintf(
				/* translators: %1$s: images count */
					__( '%1$s for AVIF and %1$s for WebP', 'webp-converter-for-media' ),
					$images_count
				),
			],
			200
		);
	}
}
