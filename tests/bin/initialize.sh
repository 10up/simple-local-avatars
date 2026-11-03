#!/bin/bash
wp-env run tests-wordpress chmod -c ugo+w /var/www/html
wp-env run tests-cli wp rewrite structure '/%postname%/' --hard
# Subscriber (no upload_files cap) sees the plain avatar file input instead of the media library.
wp-env run tests-cli wp user create subscriber subscriber@example.com --role=subscriber --user_pass=password || true
