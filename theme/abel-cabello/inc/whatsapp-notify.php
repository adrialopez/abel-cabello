<?php
/**
 * Sends a WhatsApp notification to Abel via CallMeBot whenever the
 * booking form (CF7 id 111) is submitted — a backup channel alongside
 * email, since it doesn't depend on SMTP working.
 *
 * Setup: message +34 698 27 71 40 on WhatsApp with
 * "I allow callmebot to send me messages" to get an API key, then set
 * AC_CALLMEBOT_PHONE / AC_CALLMEBOT_APIKEY below (or in wp-config.php).
 */

if ( ! defined( 'AC_CALLMEBOT_PHONE' ) ) {
    define( 'AC_CALLMEBOT_PHONE', '' ); // e.g. '34629220296' (no +, no spaces)
}
if ( ! defined( 'AC_CALLMEBOT_APIKEY' ) ) {
    define( 'AC_CALLMEBOT_APIKEY', '' );
}

add_action( 'wpcf7_mail_sent', function ( $contact_form ) {
    if ( 111 !== $contact_form->id() ) {
        return;
    }
    if ( ! AC_CALLMEBOT_PHONE || ! AC_CALLMEBOT_APIKEY ) {
        return;
    }

    $submission = WPCF7_Submission::get_instance();
    if ( ! $submission ) {
        return;
    }
    $data = $submission->get_posted_data();

    $message  = "📩 Nueva solicitud de booking\n";
    $message .= "Nombre: " . ( $data['your-name'] ?? '-' ) . "\n";
    $message .= "Tel: " . ( $data['your-phone'] ?? '-' ) . "\n";
    $message .= "Email: " . ( $data['your-email'] ?? '-' ) . "\n";
    $message .= "Tipo: " . ( $data['event-type'] ?? '-' ) . "\n";
    $message .= "Fecha: " . ( $data['event-date'] ?? '-' ) . "\n";
    $message .= "Lugar: " . ( $data['event-location'] ?? '-' ) . "\n";
    if ( ! empty( $data['your-message'] ) ) {
        $message .= "Mensaje: " . mb_strimwidth( $data['your-message'], 0, 200, '…' );
    }

    $url = add_query_arg( [
        'phone'  => AC_CALLMEBOT_PHONE,
        'text'   => rawurlencode( $message ),
        'apikey' => AC_CALLMEBOT_APIKEY,
    ], 'https://api.callmebot.com/whatsapp.php' );

    wp_remote_get( $url, [ 'timeout' => 8, 'blocking' => false ] );
} );
