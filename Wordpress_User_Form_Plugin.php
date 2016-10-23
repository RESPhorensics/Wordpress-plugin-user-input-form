<?php


/* Wordpress User Input Form With Captcha */

function ui_form() {
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<p>';
	echo 'Your Name: (required) <br/>';
	echo '<input type="text" name="uif-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["uif-name"] ) ? esc_attr( $_POST["uif-name"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Your Email: (required) <br/>';
	echo '<input type="email" name="uif-email" value="' . ( isset( $_POST["uif-email"] ) ? esc_attr( $_POST["uif-email"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Subject: (required) <br/>';
	echo '<input type="text" name="uif-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["uif-subject"] ) ? esc_attr( $_POST["uif-subject"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Your Message: (required) <br/>';
	echo '<textarea rows="10" cols="35" name="uif-message">' . ( isset( $_POST["uif-message"] ) ? esc_attr( $_POST["uif-message"] ) : '' ) . '</textarea>';
	echo '</p>';
	echo '<p><input type="submit" name="uif-submitted" value="Send"></p>';
	echo '</form>';
}

/* Add The Following To functions.php:

	add_filter('ui_form','add_google_captcha');

function add_google_captcha(){
    echo '<div class="g-recaptcha" data-sitekey= "=== Your site key === "></div>';
} /*


function send_mail() {

/* if Submit Button Is Clicked Then Send The Message To Admin Email */
	
	if ( isset( $_POST['uif-submitted'] ) ) {
		

/* declare form values */
		
		$name    = declare_text_field( $_POST["uif-name"] );
		$email   = declare_email( $_POST["uif-email"] );
		$subject = declare_text_field( $_POST["uif-subject"] );
		$message = esc_textarea( $_POST["uif-message"] );
		

/* Fetch Admin Email Address */
		
		$to = get_option( 'admin_email' );

		$headers = "From: $name <$email>" . "\r\n";
		

/* Display Messages */
		
		
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			echo '<div>';
			echo '<p>Thank you for your message. We shall reply soon.</p>';
			echo '</div>';
		} else {
			echo 'An unexpected error occurred';
		}
	}
}

/* Create Form Shortcode */

function uif_shortcode() {
	ob_start();
	send_mail();
	form();

	return ob_get_clean();
}

add_shortcode( 'user_form', 'uif_shortcode' );

?>