<?php
/*
Template Name: Register Template
*/

/**
 * The template for registering new members.
 *
 */
 
get_header();
$email_lists = array();
$field_list = array( 'comments' );
$required_list = array(
	'first_name' => __( 'First name', 'team_data' ),
	'last_name' => __( 'Last name', 'team_data' ),
	'email' => __( 'Email', 'team_data' ),
);
$fields = array(
	'left' => array(
		'first_name' => array(
			'label' => __( 'First name', 'team_data' ),
			'type' => 'text',
		),
		'last_name' => array(
			'label' => __( 'Last name', 'team_data' ),
			'type' => 'text',
		),
		'email' => array(
			'label' => __( 'Email', 'team_data' ),
			'type' => 'email',
		),
		'address1' => array(
			'label' => __( 'Address', 'team_data' ),
			'type' => 'text'
		),
		/*
		'address2' => array(
			'label' => __( 'Address 2', 'team_data' ),
			'type' => 'text'
		),
		*/
		'city' => array(
			'label' => __( 'City', 'team_data' ),
			'type' => 'text'
		),
		'state' => array(
			'label' => __( 'State', 'team_data' ),
			'type' => 'text'
		),
		'postal_code' => array(
			'label' => __( 'Zip', 'team_data' ),
			'type' => 'text'
		),
	),
	'right' => array(
		'cell' => array(
			'label' => __( 'Cell', 'team_data' ),
			'type' => 'tel'
		),
		/*
		'tel_home' => array(
			'label' => __( 'Home', 'team_data' ),
			'type' => 'tel'
		),
		'tel_work' => array(
			'label' => __( 'Work', 'team_data' ),
			'type' => 'tel'
		),
		*/
		'date_of_birth' => array(
			'label' => __( 'Date of Birth', 'team_data' ),
			'type' => 'date'
		),
		'height' => array(
			'label' => __( 'Height', 'team_data' ),
			'type' => 'text'
		),
		'weight' => array(
			'label' => __( 'Weight', 'team_data' ),
			'type' => 'text'
		),
		'college_or_school' => array(
			'label' => __( 'School/Year', 'team_data' ),
			'type' => 'text'
		),
		'position' => array(
			'label' => __( 'Position(s)', 'team_data' ),
			'type' => 'text'
		),
		'past_clubs' => array(
			'label' => __( 'Past Club(s)', 'team_data' ),
			'type' => 'text'
		),
	),
);
 
 ?>

		<div id="primary">
			<div id="content" class="team_data" role="main">
				<article class="hentry page">
					<header class="entry-header">
						<h1 class="entry-title">Register with Mystic River</h1>
					</header>
					<div class="entry-content">
						<div id="mystic_alert_div" style="display: none;"></div>
						<div>
							<span style="font-size: 1.2em;"><strong>NOTE: Youth and Rookie Rugby registration will be using TeamSnap for summer 2015. This sign-up is intended for people interested in getting information about Mystic River college and adult programs.</strong></span>
						</div>
						<form id="mystic_register_form" action="<?php echo esc_url(get_home_url()); ?>">
<?php
	echo '<div class="mystic_register_email_lists">';
	echo '<h3>' . esc_html( __( 'Membership Type', 'team_data' ) ) . '</h3>';
	$list_table = $wpdb->prefix . 'team_data_list';
	$lists = $wpdb->get_results( "SELECT IF(display_name <> '', display_name, name) AS name, auto_enroll FROM $list_table WHERE admin_only = 0" );
	foreach ($lists as $list_pos => $list) {
		$control_id = 'mystic_register_email_list_' . $list_pos;
		$email_lists[$list->name] = $list_pos;
		echo '<div class="mystic_register_email_pair">';
		echo '<input id="' . $control_id . '" type="checkbox" name="register_list__' . $list_pos . '"' . ($list->auto_enroll == '1' ? ' checked="checked"' : '') . ' listname="' . esc_attr($list->name) . '" />';
		echo '<label for="' . $control_id . '">' . esc_html($list->name) . '</label>';
		echo '</div>';
	}
	echo '<div class="mystic_hint">Note: Mystic River uses the above selections to control what kinds of email we send you.<br/>If you have any questions about your options, please email us directly at <a href="mailto:info@mysticrugby.com">info@mysticrugby.com</a>.</div>';
	echo '</div>';

	foreach ($fields as $pos => $curr_list) {
		echo '<div class="mystic_register_' . $pos . '">';
		foreach ($curr_list as $field => $field_data) {
			$field_list[] = $field;
			$field_required = isset($required_list[$field]);
			echo '<div class="mystic_register_pair">';
			echo '<label for="mystic_register__' . $field . '"' . ($field_required ? ' class="mystic_register_required"' : '') . '>' . esc_html($field_data['label']) . ( $field_required ? '*' : '') . '</label>';
			echo '<input id="mystic_register__' . $field . '" type="' . $field_data['type'] . '" name="' . $field . '" ' . ( $field_required ? 'required' : '') . ' />';
			echo '</div>';
		}
		echo '</div>';
	}
?>
							<div class="mystic_register_pair">
								<label for="mystic_register_comments" class="mystic_register_textarea_label"><?php echo esc_html( __('Comments', 'team_data') ); ?></label>
								<textarea id="mystic_register__comments" rows="4" cols="50"></textarea>
							</div>
							<div style="display: none;">
								<input id="mystic_register_leave_empty" name="leave_empty" value="" />
							</div>
							<div class="mystic_register_submit">
								<input type="button" class="mystic_register_button" onclick="mystic_register_member();" value="<?php echo esc_attr( __( 'Join', 'team_data') ); ?>" />
							</div>
						</form><!-- #mystic_register_form -->
					</div><!-- div.entry-content -->
				</article>
			</div><!-- #content -->
		</div><!-- #primary -->

<script type="text/javascript">
if (typeof window.mystic_register_member != 'function') {
	window.mystic_register_member = function() {
		var form = document.getElementById('mystic_register_form');
		if (!form) return;
		var leaveEmpty = document.getElementById('mystic_register_leave_empty');
		<?php /* Assume spam if leaveEmpty is populated */ ?>
		if (leaveEmpty && (leaveEmpty.value != '')) return;
		var nonce = "<?php echo esc_js(wp_create_nonce('team_data_nonce')); ?>";
		var ajaxURL = "<?php echo esc_js(admin_url( 'admin-ajax.php' )); ?>";
		var postData = { "action": "team_data_register_member", "nonce": nonce, "list_names": {} };
		var fieldList = <?php echo json_encode($field_list); ?>;
		var requiredFields = <?php echo json_encode($required_list); ?>;
		for (var i = 0; i < fieldList.length; i++) {
			var fieldName = fieldList[i];
			var field = document.getElementById('mystic_register__' + fieldName);
			if (field) {
				var value = field.value;
				if ((requiredFields[fieldName] != null) && (value == '')) {
					mystic.util.alert('<strong>' + requiredFields[fieldName] + '</strong> is required.','A required value is missing', function() { if (field) field.focus(); } );
					return;
				}
				postData[fieldName] = value;
			}
		}
		var emailLists = <?php echo json_encode($email_lists); ?>;
		for (var listName in emailLists) {
			var elID = 'mystic_register_email_list_' + emailLists[listName];
			var checkbox = document.getElementById(elID);
			if (checkbox) {
				var checked = (checkbox.checked ? '1' : '0');
				postData.list_names[listName] = checked;
			}
		}
		jQuery.post(ajaxURL,postData,window.mystic_register_member_handler);
	};
	window.mystic_register_member_handler = function(response) {
		if (!response) return;
		if (response.result == 'error') {
			var msg = 'There was an error processing your registration.<br/>';
			if (typeof response.error_message == 'string') {
				msg += '<span class="mystic_dialog_error">' + response.error_message + '</span>';
			}
			msg += 'Please email <a href="info@mysticrugby.com">info@mysticrugby.com</a> if you continue to have problems.';
			mystic.util.alert(msg,'Error');
		}
		else {
			var msg = "<?php echo esc_js('Thank you for registering with the Mystics. We will be in touch soon.'); ?>";
			mystic.util.alert(msg, 'Thank you', function() { document.location = "<?php echo esc_js(get_home_url()); ?>"; } );
		}
	};
}
</script>
<?php get_footer(); ?>