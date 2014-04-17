<?php
/*
 * Plugin Name: Navis Media Credit
 * Plugin URI: http://argoproject.org/
 * Description: Adds support for credit fields on media stored in WordPress
 * Version: 0.1
 * Author: Project Argo
 * Author URI: http://argoproject.org/
 * License: GPLv2
 * */

define( 'MEDIA_CREDIT_POSTMETA_KEY', '_media_credit' );

function navis_get_media_credit( $id ) {
    // XXX: do we need to get the post->ID or can we just use this ID??
    $post = get_post( $id );
    $creditor = new Media_Credit( $post->ID );
    return $creditor;
}


class Navis_Media_Credit {
    function __construct() {
        add_filter( 'navis_media_credit_for_attachment',
            'get_media_credit_for_attachment', 10, 2
        );

        add_filter(
            'img_caption_shortcode',
            array( &$this, 'caption_shortcode' ), 10, 3
        );

        if ( ! is_admin() )
            return;

        add_action(
            'admin_init',
            array( &$this, 'admin_init' )
        );

        add_filter(
            'attachment_fields_to_save',
            array( &$this, 'save_media_credit' ), 10, 2
        );
        add_filter(
            'attachment_fields_to_edit',
            array( &$this, 'add_media_credit' ), 10, 2
        );

        add_filter(
            'image_send_to_editor',
            array( &$this, 'add_caption_shortcode' ), 19, 8
        );

        // Custom plugin only works for TinyMCE 3
        global $tinymce_version;
        if ( ! version_compare( $tinymce_version, '4018-20140303' ) ) {
            add_filter(
                'mce_external_plugins',
                array( &$this, 'plugins_monkeypatching' )
            );
        }
    }

    function admin_init() {
        remove_filter( 'image_send_to_editor', 'image_add_caption', 20, 8 );
    }

    function get_media_credit_for_attachment( $text = '', $id ) {
        $creditor = navis_get_media_credit( $id );
        return $text . $creditor->to_string();
    }


    function add_media_credit( $fields, $post ) {
        $creditor = navis_get_media_credit( $post );
        $fields[ 'media_credit' ] = array(
            'label' => 'Credit',
            'input' => 'text',
            'value' => $creditor->credit,
        );

        $fields[ 'navis_media_credit_org' ] = array(
            'label' => 'Organization',
            'input' => 'text',
            'value' => $creditor->org
        );

        $can_distribute = $creditor->can_distribute;
        $checked = $can_distribute ? 'checked="checked"' : "";
        $distfield = 'attachments[' . $post->ID . '][navis_media_can_distribute]';
        $fields[ 'navis_media_can_distribute' ] = array(
            'label' => 'Can distribute?',
            'input' => 'html',
            'html'  => '<input id="' . $distfield . '" name="' . $distfield . '" type="checkbox" value="1" ' . $checked . ' />'
        );
        return $fields;
    }


    function save_media_credit( $post, $attachment ) {
        $creditor = new Media_Credit( $post['ID'] );
        $fields = array( 'media_credit', 'navis_media_credit_org', 'navis_media_can_distribute' );

        foreach ( $fields as $field ) {
            if ( $_POST['attachments'] && isset( $_POST['attachments'][$post['ID']][$field] ) ) {
                $input = sanitize_text_field( $_POST['attachments'][$post['ID']][$field] );
            }
            else {
                // XXX: not sure if this branch is ever followed
                if ( isset( $_POST[ $field ] ) ) {
                    $input = sanitize_text_field( $_POST[ $field ] );
                } else if ( isset( $_POST[ "attachments[" . $post['ID'] . "][" . $field . "]" ] ) ) {
                    $input = sanitize_text_field( $_POST[ "attachments[" . $post['ID'] . "][" . $field . "]" ] );
                } else {
                    $input = '';
                }
            }
            $creditor->update( $field, $input );
        }
        return $post;
    }


    /**
     * navis_add_caption_shortcode(): replaces the built-in caption shortcode
     * with one that supports a credit field.
     */
    function add_caption_shortcode( $html, $id, $caption, $title, $align, $url, $size, $alt = '' ) {
        $creditor = navis_get_media_credit( $id );

        if ( empty( $caption ) && !$creditor->to_string()) {
            return $html;
        };

        $id = ( 0 < (int) $id ) ? 'attachment_' . $id : '';
        if ( ! preg_match( '/width="([0-9]+)/', $html, $matches ) )
            return $html;

        $width = $matches[1];

        // XXX: not sure what this does
        $html = preg_replace( '/(class=["\'][^\'"]*)align(none|left|right|center)\s?/', '$1', $html );
        if ( empty($align) )
            $align = 'none';

        $shcode = '[caption id="' . $id . '" align="align' . $align .
            '" width="' . $width . '" caption="' . addslashes( $caption ) .
            '"';
        // Our custom plugin doesn't work with TinyMCE
        global $tinymce_version;
        if ( ! version_compare( $tinymce_version, '4018-20140303' ) ) {
            $shcode .= ' credit="' . addslashes( $creditor->to_string() ) . '"';
        }
        $shcode .= ']' .  $html . '[/caption]';
        return $shcode;
    }

    /**
     * navis_image_shortcode(): renders caption shortcodes with our layout
     * and credit field.
     */
    function caption_shortcode( $text, $atts, $content ) {
        $atts = shortcode_atts( array(
            'id' => '',
            'align' => 'alignnone',
            'width' => '',
            'credit' => '',
            'caption' => '',
        ), $atts );
        $atts = apply_filters( 'navis_image_layout_defaults', $atts );
        extract( $atts );

        if ( $id && ! $credit ) {
            $post_id = str_replace( 'attachment_', '', $id );
            $creditor = navis_get_media_credit( $post_id );
            $credit = $creditor->to_string();
        }

        if ( $id ) {
            $id = 'id="' . esc_attr($id) . '" ';
        }

        // XXX: maybe remove module and image classes at some point
        $out = sprintf( '<div %s class="wp-caption module image %s" style="max-width: %spx;">%s', $id, $align, $width, do_shortcode( $content ) );
        if ( $credit ) {
            $out .= sprintf( '<p class="wp-media-credit">%s</p>', $credit );
        }
        if ( $caption ) {
            $out .= sprintf( '<p class="wp-caption-text">%s</p>', $caption );
        }
        $out .= "</div>";

        return $out;
    }


    function plugins_monkeypatching( $plugins ) {
        $plugins[ 'argo_wpeditimage' ] = get_stylesheet_directory_uri() . '/lib/navis-media-credit/js/media_credit_editor_plugin.js';
        return $plugins;
    }

}

new Navis_Media_Credit;


class Media_Credit {
    function __construct( $post_id ) {
        $this->post_id = $post_id;
        $this->credit = get_post_meta( $post_id,
            MEDIA_CREDIT_POSTMETA_KEY, true
        );
        $this->org = get_post_meta( $post_id,
            '_navis_media_credit_org', true
        );
        $this->can_distribute = get_post_meta( $post_id,
            '_navis_media_can_distribute', true
        );
    }

    function to_string() {
        if ( $this->credit && $this->org ) {
            return sprintf( "%s / %s", esc_attr( $this->credit ),
                            esc_attr( $this->org ) );
        } elseif ( $this->credit ) {
            return esc_attr( $this->credit );
        } elseif ( $this->org ) {
            return esc_attr( $this->org );
        }
    }

    function update( $field, $value ) {
        return update_post_meta( $this->post_id, '_' . $field, $value );
    }
}
