<?php

/*
 * Transposh v%VERSION%
 * http://transposh.org/
 *
 * Copyright %YEAR%, Team Transposh
 * Licensed under the GPL Version 2 or higher.
 * http://transposh.org/license
 *
 * Date: %DATE%
 */

// This magic value will cause the option to be set from post
namespace BetterTransposh;

use BetterTransposh;
use BetterTransposh\Core\Constants;
use ip;
use transposh_option;


/**
 * Used properties for code completion - we'll try to keep them in same order as admin screens
 *
 * Language tab
 * @property string $default_language      Option defining the default language
 * @property \BetterTransposh\transposh_option $default_language_o
 * @property string $viewable_languages    Option defining the list of currently viewable languages
 * @property \BetterTransposh\transposh_option $viewable_languages_o
 * @property string $sorted_languages      Option defining the ordered list of languages @since 0.3.9
 * @property \BetterTransposh\transposh_option $sorted_languages_o
 *
 * Settings
 * //** WPORG VERSION
 * @property boolean $allow_full_version_upgrade    Option to allow to upgrade to full version
 * @property \BetterTransposh\transposh_option $allow_full_version_upgrade_o
 * //** WPORGSTOP
 * @property boolean $allow_anonymous_translation   Option defining whether anonymous translation is allowed
 * @property \BetterTransposh\transposh_option $allow_anonymous_translation_o
 * @property boolean $enable_default_translate      Option to enable/disable default language translation
 * @property \BetterTransposh\transposh_option $enable_default_translate_o
 * @property boolean $enable_search_translate       Option to enable/disable default language translation @since 0.3.6
 * @property \BetterTransposh\transposh_option $enable_search_translate_o
 * @property boolean $transposh_gettext_integration Make the gettext interface optional (@since 0.6.4)
 * @property \BetterTransposh\transposh_option $transposh_gettext_integration_o
 * @property boolean $transposh_locale_override     Allow override for default locale (@since 0.7.5)
 * @property \BetterTransposh\transposh_option $transposh_locale_override_o
 *
 * @property boolean $enable_permalinks             Option to enable/disable rewrite of permalinks
 * @property \BetterTransposh\transposh_option $enable_permalinks_o
 * @property boolean $enable_footer_scripts         Option to enable/disable footer scripts (2.8 and up)
 * @property \BetterTransposh\transposh_option $enable_footer_scripts_o
 * @property boolean $enable_detect_redirect        Option to enable detect and redirect language @since 0.3.8
 * @property \BetterTransposh\transposh_option $enable_detect_redirect_o
 * @property boolean $enable_geoip_redirect         Option to enable language redirection based on geoip detection @since 1.0.2
 * @property \BetterTransposh\transposh_option $enable_geoip_redirect_o
 * @property boolean $transposh_collect_stats       Should I allow collecting of anonymous stats (@since 0.7.6)
 * @property \BetterTransposh\transposh_option $transposh_collect_stats_o
 * @property string $mail_to                    Option defining recipient (Admin if empty) (@since 1.0.3)
 * @property \BetterTransposh\transposh_option $mail_to_o
 * @property boolean $mail_ontranslate           Should I send mail immediately on human translation (@since 1.0.3)
 * @property \BetterTransposh\transposh_option $mail_ontranslate_o
 * //** FULL VERSION
 * @property boolean $mail_ontranslate_buffer    Should I buffer immediate human translation (@since 1.0.3)
 * @property \BetterTransposh\transposh_option $mail_ontranslate_buffer_o
 * @property boolean $mail_digest                Should I send a daily digest of translations today (@since 1.0.3)
 * @property \BetterTransposh\transposh_option $mail_digest_o
 * @property boolean $mail_ignore_admin          Ignore translations made by the admin (@since 1.0.3)
 * @property \BetterTransposh\transposh_option $mail_ignore_admin_o
 * //** FULLSTOP
 *
 * @property int $transposh_backup_schedule     Stores the schedule for the backup service, 0-none, 1-daily, 2-live (backup @since 0.5.0)
 * @property \BetterTransposh\transposh_option $transposh_backup_schedule_o
 * @property string $transposh_key                 Stores the site key to transposh services (backup @since 0.5.0)
 * @property \BetterTransposh\transposh_option $transposh_key_o
 * //** FULL VERSION
 * @property boolean $enable_superproxy             Enable superproxy
 * @property \BetterTransposh\transposh_option $enable_superproxy_o
 * @property string $superproxy_key                Stores the superproxy key
 * @property \BetterTransposh\transposh_option $superproxy_key_o
 * @property string $superproxy_ips                Stores the site allow proxy ips
 * @property \BetterTransposh\transposh_option $superproxy_ips_o
 * //** FULLSTOP
 *
 *  Engines
 *
 * @property boolean $enable_autotranslate          Option to enable/disable auto translation
 * @property \BetterTransposh\transposh_option $enable_autotranslate_o
 * @property boolean $enable_autoposttranslate      Option to enable/disable auto translation of posts
 * @property \BetterTransposh\transposh_option $enable_autoposttranslate_o
 * @property string $msn_key                       Option to store the msn API key
 * @property \BetterTransposh\transposh_option $msn_key_o
 * @property string $google_key                    Option to store the Google API key
 * @property \BetterTransposh\transposh_option $google_key_o
 * @property string $yandex_key                    Option to store the Yandex API key
 * @property \BetterTransposh\transposh_option $yandex_key_o
 * @property string $preferred_translators         Option to store translator preference @since 0.4.2 (changed to string and plural @since 0.9.8)
 * @property \BetterTransposh\transposh_option $preferred_translators_o
 * @property string $oht_id                        Option to store the oht ID
 * @property \BetterTransposh\transposh_option $oht_id_o
 * @property string $oht_key                       Option to store the oht key;
 * @property \BetterTransposh\transposh_option $oht_key_o
 *
 * Widget
 *
 * @property boolean $widget_progressbar            Option allowing progress bar display
 * @property \BetterTransposh\transposh_option $widget_progressbar_o
 * @property boolean $widget_allow_set_deflang      Allows user to set his default language per #63 @since 0.3.8
 * @property \BetterTransposh\transposh_option $widget_allow_set_deflang_o
 * //** FULL VERSION
 * @property boolean $widget_remove_logo            Allows removing of transposh logo in exchange for an ad @since 0.6.0
 * @property \BetterTransposh\transposh_option $widget_remove_logo_o
 * //** FULLSTOP
 * @property string $widget_theme                  Allows theming of the progressbar and edit window @since 0.7.0
 * @property \BetterTransposh\transposh_option $widget_theme_o
 *
 * Advanced
 *
 * @property boolean $enable_url_translate          Option to enable/disable url translation @since 0.5.3
 * @property \BetterTransposh\transposh_option $enable_url_translate_o
 * @property string $jqueryui_override             Option to override the jQueryUI version @since 0.9.1
 * @property \BetterTransposh\transposh_option $jqueryui_override_o
 * @property boolean $dont_add_rel_alternate        Option to disable the rel=alternate adding to the page @since 0.9.2
 * @property \BetterTransposh\transposh_option $dont_add_rel_alternate_o
 * //** FULL VERSION
 * @property boolean $full_rel_alternate            Option to create fully qualified rel=alternate @since 1.0.1
 * @property \BetterTransposh\transposh_option $full_rel_alternate_o
 * //** FULLSTOP
 * @property boolean $parser_dont_break_puncts      Option to allow punctuations such as , . ( not to break @since 0.9.0
 * @property \BetterTransposh\transposh_option $parser_dont_break_puncts_o
 * @property boolean $parser_dont_break_numbers     Option to allow numbers not to break @since 0.9.0
 * @property \BetterTransposh\transposh_option $parser_dont_break_numbers_o
 * @property boolean $parser_dont_break_entities    Option to allow html entities not to break @since 0.9.0
 * @property \BetterTransposh\transposh_option $parser_dont_break_entities_o
 * @property boolean $debug_enable Option to enable debug
 * @property \BetterTransposh\transposh_option $debug_enable_o
 * @property int $debug_loglevel Option holding the level of logging
 * @property \BetterTransposh\transposh_option $debug_loglevel_o
 * @property string $debug_logfile Option holding a filename to store debugging into
 * @property \BetterTransposh\transposh_option $debug_logfile_o
 * @property ip $debug_remoteip Option that limits remote firePhp debug to a certain IP
 * @property \BetterTransposh\transposh_option $debug_remoteip_o
 *
 * Hidden
 *
 * @property \BetterTransposh\transposh_option $transposh_admin_hide_warnings Stores hidden warnings (@since 0.7.6)
 * //** FULL VERSION
 * @property \BetterTransposh\transposh_option $transposh_last_mail_digest Stores date of last digest (@since 1.0.3)
 * //** FULLSTOP
 *
 */
class Plugin_Options {

	/** @var array storing all our options */
	private $options = array();

	/** @var boolean set to true if any option was changed */
	private $changed = false;
	private $vars = array();

	function set_default_option_value( $option, $value = '' ) {
		if ( ! isset( $this->options[ $option ] ) ) {
			$this->options[ $option ] = $value;
		}
	}

	// private $vars array() = (1,2,3);

	function register_option( $name, $type, $default_value = '' ) {
		if ( ! isset( $this->options[ $name ] ) ) {
			$this->options[ $name ] = $default_value;
		}
		// can't log...     BetterTransposh\Core\Logger($name . ' ' . $this->options[$name]);
		$this->vars[ $name ] = new BetterTransposh\Option( $name, $this->options[ $name ], $type );
	}

	function __get( $name ) {
		if ( str_ends_with( $name, "_o" ) ) {
			return $this->vars[ substr( $name, 0, - 2 ) ];
		}

		// can't!? BetterTransposh\Core\Logger($this->vars[$name]->get_value(), 5);
		return $this->vars[ $name ]->get_value();
	}

	function __set( $name, $value ) {
		if ( $value == TP_FROM_POST ) {
			if ( isset( $_POST[ $name ] ) ) {
				$value = $_POST[ $name ];
			} else {
				$value = '';
			}
		}

		if ( TP_OPT_BOOLEAN == $this->vars[ $name ]->get_type() ) {
			$value = ( $value ) ? 1 : 0;
		}

		if ( $this->vars[ $name ]->get_value() !== $value ) {
			tp_logger( "option '$name' value set: $value" );
			$this->vars[ $name ]->set_value( $value );
			$this->changed = true;
		}
	}

	function __construct() {

		// can't      BetterTransposh\Core\Logger("creating options");
		// load them here
		$this->options = get_option( TRANSPOSH_OPTIONS );
//        BetterTransposh\Core\Logger($this->options);

		$this->register_option( 'default_language', TP_OPT_STRING ); // default?
		$this->register_option( 'viewable_languages', TP_OPT_STRING );
		$this->register_option( 'sorted_languages', TP_OPT_STRING );

		if ( ! defined( 'FULL_VERSION' ) ) { //** WPORG VERSION
			$this->register_option( 'allow_full_version_upgrade', TP_OPT_BOOLEAN, 0 );
		} //** WPORGSTOP
		$this->register_option( 'allow_anonymous_translation', TP_OPT_BOOLEAN, 1 );
		$this->register_option( 'enable_default_translate', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'enable_search_translate', TP_OPT_BOOLEAN, 1 );
		$this->register_option( 'transposh_gettext_integration', TP_OPT_BOOLEAN, 1 );
		$this->register_option( 'transposh_locale_override', TP_OPT_BOOLEAN, 1 );

		$this->register_option( 'enable_permalinks', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'enable_footer_scripts', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'enable_detect_redirect', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'enable_geoip_redirect', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'transposh_collect_stats', TP_OPT_BOOLEAN, 1 );

		$this->register_option( 'mail_to', TP_OPT_STRING );
		$this->register_option( 'mail_ontranslate', TP_OPT_BOOLEAN, 0 );
		//** FULL VERSION
		$this->register_option( 'mail_ontranslate_buffer', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'mail_digest', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'mail_ignore_admin', TP_OPT_BOOLEAN, 0 );
		//** FULLSTOP

		$this->register_option( 'transposh_backup_schedule', TP_OPT_OTHER, 2 );
		$this->register_option( 'transposh_key', TP_OPT_STRING );
		if ( defined( 'FULL_VERSION' ) ) { //** FULL VERSION
			$this->register_option( 'enable_superproxy', TP_OPT_BOOLEAN, 0 );
			$this->register_option( 'superproxy_key', TP_OPT_STRING );
			$this->register_option( 'superproxy_ips', TP_OPT_STRING );
		} //** FULLSTOP

		$this->register_option( 'enable_autotranslate', TP_OPT_BOOLEAN, 1 );
		$this->register_option( 'enable_autoposttranslate', TP_OPT_BOOLEAN, 1 );
		$this->register_option( 'msn_key', TP_OPT_STRING );
		$this->register_option( 'google_key', TP_OPT_STRING );
		$this->register_option( 'yandex_key', TP_OPT_STRING );
		$this->register_option( 'baidu_key', TP_OPT_STRING );
		$this->register_option( 'preferred_translators', TP_OPT_STRING, 'g,b,y,a,u' );
		$this->register_option( 'oht_id', TP_OPT_STRING );
		$this->register_option( 'oht_key', TP_OPT_STRING );


		$this->register_option( 'widget_progressbar', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'widget_allow_set_deflang', TP_OPT_BOOLEAN, 0 );
		if ( defined( 'FULL_VERSION' ) ) { //** FULL VERSION
			$this->register_option( 'widget_remove_logo', TP_OPT_BOOLEAN, 0 );
		} //** FULLSTOP
		$this->register_option( 'widget_theme', TP_OPT_STRING, 'ui-lightness' );
		$this->register_option( 'enable_url_translate', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'jqueryui_override', TP_OPT_STRING );
		$this->register_option( 'dont_add_rel_alternate', TP_OPT_BOOLEAN, 0 );
		if ( defined( 'FULL_VERSION' ) ) { //** FULL VERSION
			$this->register_option( 'full_rel_alternate', TP_OPT_BOOLEAN, 0 );
		} //** FULLSTOP
		$this->register_option( 'parser_dont_break_puncts', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'parser_dont_break_numbers', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'parser_dont_break_entities', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'debug_enable', TP_OPT_BOOLEAN, 0 );
		$this->register_option( 'debug_loglevel', TP_OPT_OTHER, 3 );
		$this->register_option( 'debug_logfile', TP_OPT_STRING, '' );
		$this->register_option( 'debug_remoteip', TP_OPT_IP, '' );


		$this->register_option( 'transposh_admin_hide_warnings', TP_OPT_OTHER );
		//** FULL VERSION
		$this->register_option( 'transposh_last_mail_digest', TP_OPT_OTHER );
		//** FULLSTOP


		// Fix default language if needed, only done once now, and since this was being done constantly, we gain
		//BetterTransposh\Core\Logger($this->default_language->get_value());

		if ( ! isset( Constants::$languages[ $this->default_language ] ) ) {
			if ( defined( 'WPLANG' ) && isset( Constants::$languages[ WPLANG ] ) ) {
				$this->default_language = WPLANG;
			} else {
				$this->default_language = "en";
			}
		}

		// can't log...   BetterTransposh\Core\Logger($this->options, 4);
	}

	/**
	 * Get a user sorted language list
	 * @return array sorted list of languages, pointing to names and flags
	 * @since 0.3.9
	 */
	function get_sorted_langs() {
		if ( $this->sorted_languages ) {
			tp_logger( $this->sorted_languages, 5 );

			return array_merge( array_flip( explode( ",", $this->sorted_languages ) ), Constants::$languages );
		}

		return Constants::$languages;
	}

	/**
	 * Get a user sorted translation engines list
	 * @return array sorted list of translation engines
	 * @since 0.9.8
	 */
	function get_sorted_engines() {
		if ( $this->preferred_translators ) {
			tp_logger( $this->preferred_translators, 3 );

			return array_merge( array_flip( explode( ",", $this->preferred_translators ) ), Constants::$engines );
		}

		return Constants::$engines;
	}

	function get_transposh_admin_hide_warning( $id ) {
		return str_contains( $this->transposh_admin_hide_warnings, $id . ',' );
	}

	function set_transposh_admin_hide_warning( $id ) {
		if ( ! $this->get_transposh_admin_hide_warning( $id ) ) {
			$this->transposh_admin_hide_warnings = $this->transposh_admin_hide_warnings . $id . ',';
		}
	}

	/**
	 * Updates options at the wordpress options table if there was a change
	 */
	function update_options() {
		if ( $this->changed ) {
			foreach ( $this->vars as $name => $var ) {
				$this->options[ $name ] = $var->get_value();
			}
			update_option( TRANSPOSH_OPTIONS, $this->options );
			$this->changed = false;
		} else {
			tp_logger( "no changes and no updates done", 3 );
		}
	}

	/**
	 * Resets all options except keys
	 */
	function reset_options() {
		$this->options = array();
		foreach ( array( 'msn_key', 'google_key', 'oht_id', 'oht_key', 'transposh_key' ) as $key ) {
			$this->options[ $key ] = $this->vars[ $key ]->get_value();
		}
		update_option( TRANSPOSH_OPTIONS, $this->options );
	}

	/**
	 * Determine if the given language code is the default language
	 *
	 * @param string $language
	 *
	 * @return boolean Is this the default language?
	 */
	function is_default_language( $language ) { // XXXX
		return ( $this->default_language == $language || '' == $language );
	}

	/**
	 * Determine if the given language in on the list of active languages
	 * @return boolean Is this language viewable?
	 */
	function is_active_language( $language ) {
		if ( $this->is_default_language( $language ) ) {
			return true;
		}

		return ( str_contains( $this->viewable_languages . ',', $language . ',' ) );
	}

}