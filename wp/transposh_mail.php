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

/*
 * This file handles functions relevant to specific third party plugins
 */

class transposh_mail {

    /** @var transposh_plugin Container class */
    private $transposh;

    /**
     * Construct our class
     * @param transposh_plugin $transposh
     */
    function __construct(&$transposh) {
        $this->transposh = &$transposh;

        add_action('transposh_human_translation', array(&$this, 'transposh_mail_humantranslation'), 10, 4);
        add_filter('wp_mail', array(&$this, 'transposh_mail_filter'));
        //** FULL VERSION
        add_action('transposh_digest_event', array(&$this, 'run_digest'));
        add_action('transposh_buffered_mail_event', array(&$this, 'run_buffered'));
        //** FULLSTOP 
    }

    /**
     * Whom should we mail?
     * @return string email address
     */
    function get_mail_to() {
        if ($this->transposh->options->mail_to) {
            $to = $this->transposh->options->mail_to;
        } else {
            $to = get_site_option('admin_email');
        }
        return $to;
    }

    /**
     * Send a new mail on a human translation
     * @param string $translation
     * @param string $original
     * @param string $lang
     * @param string $translated_by
     */
    function transposh_mail_humantranslation($translation, $original, $lang, $translated_by) {
        //** FULL VERSION
        if ($this->transposh->options->mail_ignore_admin) {
            $user = new WP_User($translated_by);
            if ($user->has_cap(TRANSLATOR)) {
                tp_logger($user->ID . " is a translator...");
                return;
            }
        }

        if ($this->transposh->options->mail_ontranslate_buffer) {
            wp_clear_scheduled_hook('transposh_buffered_mail_event');
            wp_schedule_single_event(time() + 180, 'transposh_buffered_mail_event'); // mail will be buffered for 3 minutes before it is sent
            if (false === ( $buffered_mail = get_transient('transposh_buffered_mail') )) {
                $buffered_mail = "";
            }
            $buffered_mail .= __('Original string', TRANSPOSH_TEXT_DOMAIN) . ": $original\n<br/>"
                    . __('Translation', TRANSPOSH_TEXT_DOMAIN) . ": $translation\n<br/>"
                    . __('Language', TRANSPOSH_TEXT_DOMAIN) . ": $lang\n<br/>"
                    . __('Translated by', TRANSPOSH_TEXT_DOMAIN) . ": " . transposh_utils::wordpress_user_by_by($translated_by) . "\n<br/>"
                    . __('Translated on', TRANSPOSH_TEXT_DOMAIN) . ": " . date("r") . "\n\n<br/><br/>";

            set_transient('transposh_buffered_mail', $buffered_mail, 1 * HOUR_IN_SECONDS);
            tp_logger("Some mail buffered for later");            
            return;
        }
        //** FULLSTOP 

        $to = $this->get_mail_to();
        $headers = array('Content-Type: text/html; charset=UTF-8'); // html mail...
        $subject = __('A new translation was just posted to your site', TRANSPOSH_TEXT_DOMAIN);
        $body = "<h3>" . __('The following translation was just added to your site', TRANSPOSH_TEXT_DOMAIN) . ".</h3>\n\n"
                . __('Original string', TRANSPOSH_TEXT_DOMAIN) . ": $original\n<br/>"
                . __('Translation', TRANSPOSH_TEXT_DOMAIN) . ": $translation\n<br/>"
                . __('Language', TRANSPOSH_TEXT_DOMAIN) . ": $lang\n<br/>"
                . __('Translated by', TRANSPOSH_TEXT_DOMAIN) . ": " . transposh_utils::wordpress_user_by_by($translated_by) . "\n\n<br/><br/>"
                . __('If you believe that this translation is not good, use the translation editor to modify it', TRANSPOSH_TEXT_DOMAIN) . "\n\n<br/><br/>"
                . "<h2>" . __('Team Transposh', TRANSPOSH_TEXT_DOMAIN) . "</h2>\n\n<br/>"
        ;
        wp_mail($to, wp_specialchars_decode($subject), $body, $headers);
    }

    /**
     * This function should clean mails from stray transposh breakers inserted by locale markings
     * 
     * @param type $args
     * @return type
     */
    function transposh_mail_filter($args) {

        $new_mail = array(
            'to' => $args['to'],
            'subject' => transposh_utils::clean_breakers($args['subject']),
            'message' => transposh_utils::clean_breakers($args['message']),
            'headers' => $args['headers'],
            'attachments' => $args['attachments'],
        );

        return $new_mail;
    }

    //** FULL VERSION

    function generate_digest() {
        $digest = "";
        tp_logger("digest should be generated from:" . $this->transposh->options->transposh_last_mail_digest);
        $rowstosend = $this->transposh->database->get_all_human_translation_history($this->transposh->options->transposh_last_mail_digest, 500);
        if (count($rowstosend)) {
            $digest .= "<table><tr><th>" .
                    __('Original string', TRANSPOSH_TEXT_DOMAIN) . "</th><th>" .
                    __('Language', TRANSPOSH_TEXT_DOMAIN) . "</th><th>" .
                    __('Translated string', TRANSPOSH_TEXT_DOMAIN) . "</th><th>" .
                    __('Translator', TRANSPOSH_TEXT_DOMAIN) . "</th><th>" .
                    __('Date', TRANSPOSH_TEXT_DOMAIN) . "</th></tr>";

            foreach ($rowstosend as $row) {
                $by = transposh_utils::wordpress_user_by_by($row->translated_by);
                $date = date('r', $row->timestamp);
                $orig = esc_html($row->original);
                $tran = esc_html($row->translated);
                $digest .= "<tr>\n<td>\n{$orig}</td>\n<td>\n{$row->lang}</td>\n<td>\n{$tran}</td>\n<td>\n{$by}</td>\n<td>\n{$date}</td>\n</tr>";
            }
            $digest .= "</table>";
        }
        //var_dump($this->transposh->database->get_all_human_translation_history());
        return $digest;
    }

    function run_digest() {
        $digest = $this->generate_digest();
        tp_logger("Trying to digest a mail");
        if (!$digest) {
            tp_logger("Nothing to digest");
            return;
        }
        $to = $this->get_mail_to();
        $headers = array('Content-Type: text/html; charset=UTF-8'/* ,'Content-Transfer-Encoding: 8bit' */); // html mail...
        $subject = __('Daily digest of human translation activities', TRANSPOSH_TEXT_DOMAIN);
        $body = "<h3>" . __('The following translations were made on your site in the last day', TRANSPOSH_TEXT_DOMAIN) . ".</h3>\n"
                . $digest;
        wp_mail($to, wp_specialchars_decode($subject), $body, $headers);
        $this->transposh->options->transposh_last_mail_digest = time();
        $this->transposh->options->update_options();
    }

    function run_buffered() {
        tp_logger("buffered mail outgoing");
        if (false === ( $buffered_mail = get_transient('transposh_buffered_mail') )) {
            tp_logger("nothing buffered - should not happened");
            return;
        }
        $to = $this->get_mail_to();
        $headers = array('Content-Type: text/html; charset=UTF-8'); // html mail...
        $subject = __('Some new translation were just posted to your site', TRANSPOSH_TEXT_DOMAIN);
        $body = "<h3>" . __('The following translations were just added to your site', TRANSPOSH_TEXT_DOMAIN) . ".</h3>\n\n"
                . $buffered_mail
                . __('If you believe that those translations are not good, use the translation editor to modify it', TRANSPOSH_TEXT_DOMAIN) . "\n\n<br/><br/>"
                . "<h2>" . __('Team Transposh', TRANSPOSH_TEXT_DOMAIN) . "</h2>\n\n<br/>"
        ;
        wp_mail($to, wp_specialchars_decode($subject), $body, $headers);
        del_transient('transposh_buffered_mail');
    }

//** FULLSTOP 
}
