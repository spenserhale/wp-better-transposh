<?php

namespace BetterTransposh;

use BetterTransposh\Core\Utilities;
use BetterTransposh\Logging\LogService;

class Ajax_Controller {
	public static function allow_cors() {
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS' );
		header( 'Access-Control-Allow-Headers: X-Requested-With' );
		header( 'Access-Control-Max-Age: 86400' );
	}

	public function __construct(private readonly Plugin $plugin) {
		add_action( 'wp_ajax_tp_history', [ $this, 'handle_translation_history' ] );
	}

	/**
	 * getting translation history
	 *
	 * @return void
	 */
	public function handle_translation_history() {
		header( 'Transposh: v-' . TRANSPOSH_PLUGIN_VER . ' db_version-' . DB_VERSION );
		self::allow_cors();
		if ( isset( $_POST['timestamp'] ) ) {
			$result = $this->plugin->database->del_translation_history(
				stripslashes( $_POST['token'] ), $_POST['lang'], $_POST['timestamp']
			);
			if ( $result ) {
				wp_send_json_success();
			} else {
				wp_send_json_error();
			}
		} else {
			$this->get_translation_history(stripslashes( $_POST['token'] ), $_POST['lang']);
		}
	}
	
	private function get_translation_history($token, $lang): void {
		$ref = getenv( 'HTTP_REFERER' );
		//$original = BetterTransposh\Core\transposh_utils::base64_url_decode($token);
		LogService::legacy_log( "Inside history for ($token)", 4 );

		// check params
		LogService::legacy_log( "Enter " . __FILE__ . " Params:  $token, $lang, $ref", 3 );
		if ( ! isset( $token, $lang ) ) {
			LogService::legacy_log( "Enter " . __FILE__ . " missing params: $token, $lang," . $ref, 1 );

			wp_send_json_error( 'missing params' );
		}
		LogService::legacy_log( "Passed check for $lang", 4 );

		// Check permissions, first the language must be on the edit list. Then either the user
		// is a translator or automatic translation if it is enabled.
		if ( ! ( $this->plugin->options->is_active_language( $lang ) && $this->plugin->is_translator() ) ) {
			LogService::legacy_log( 
				"Unauthorized history request " . Utilities::get_clean_server_var( 'REMOTE_ADDR' ),
				1
			);
			wp_send_json_error( 'Unauthorized history', 401 );
		}
		LogService::legacy_log( 'Passed check for editable and translator', 4 );

		wp_send_json($this->plugin->database->get_translation_history( $token, $lang ));
	}
}