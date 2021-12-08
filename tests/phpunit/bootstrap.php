<?php

// First we need to load the composer autoloader so we can use WP Mock
require_once __DIR__ . '/../../vendor/autoload.php';

// Now call the bootstrap method of WP Mock
WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();

define( 'SLA_PLUGIN_BASENAME', basename( __DIR__ . '/../../simple-local-avatars.php' ) );

/**
 * Now we include any plugin files that we need to be able to run the tests. This
 * should be files that define the functions and classes you're going to test.
 */
require_once __DIR__ . '/../../includes/class-simple-local-avatars.php';
