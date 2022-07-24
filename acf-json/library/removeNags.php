<?php

global $current_user;
wp_get_current_user();
if($current_user->user_login == 'mike@ifeelfree.co.nz'):
	//echo 'Username: ' . $current_user->user_login . "\n";
	//echo 'User display name: ' . $current_user->display_name . "\n";
else:
	add_filter('pre_site_transient_update_core','remove_core_updates');
	add_filter('pre_site_transient_update_plugins','remove_core_updates');
	add_filter('pre_site_transient_update_themes','remove_core_updates');
endif;