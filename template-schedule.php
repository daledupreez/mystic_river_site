<?php
/*
Template Name: Schedule
*/

/**
 * The template for displaying schedule pages.
 *
 * This is the template that displays the current schedule.
 *
 */
 
get_header(); ?>

		<div id="primary">
			<div id="content" class="team_data" role="main">
				<article class="hentry">
					<!--<header class="entry-header">
						<h1 class="entry-title">Schedule</h1>
					</header>-->
					<div class="entry-content">

<?php
	if (class_exists('TeamDataAjax') && method_exists('TeamDataAjax','get_matches')) {
		$team_data_ajax = new TeamDataAjax();
		$conditions = array();
		$current_season = $team_data_ajax->get_option('current_season');

		$current_season_val = '';
		if (($current_season != '') && ($current_season != null) && (intval($current_season) > 0)) {
			$conditions['season'] = intval($current_season);
			$current_season_val = $conditions['season'];
		}
		//$conditions['level'] = 1;

		$matches = $team_data_ajax->get_matches($conditions);
		
		$seasons = $team_data_ajax->get_all_seasons();
		$levels = $team_data_ajax->get_all_levels();
?>
		<div style="text-align: center;">
			<div class="mystic_schedule_filter">
				<label for="mystic_season">Season:</label>
				<select id="mystic_season">
<?php
				echo '<option value=""' . ($current_season_val == '' ? ' selected="selected"' : '') . '>All</option>' . "\n";
				foreach($seasons as $season) {
					$selected = ($current_season_val == $season['id'] ? ' selected="selected"' : '');
					echo '<option value="' . $season['id'] . '"' . $selected . '>' . $season['name'] . '</option>' . "\n";
				}
?>
				</select>
			</div>
			<div class="mystic_schedule_filter">
				<label for="mystic_level">Team:</label>
				<select id="mystic_level">
				<option value="" selected="selected">All</option>
<?php
				foreach($levels as $level) {
					echo '<option value="' . $level['id'] . '">' . $level['name'] . '</option>' . "\n";
				}
?>
				</select>
			</div>
		</div>

<script type="text/javascript">
if (schedule) {
<?php
		echo 'schedule.matchList = ' .  json_encode($matches) . ';';
		echo 'if (schedule.filterData) {';
		echo 'schedule.filterData.seasons = ' . json_encode($seasons) . ';';
		echo '}';
?>
}
jQuery(document).ready(function() {
	if (window.schedule) {
		var schedule = window.schedule;
		if (schedule.fn) {
			if (schedule.fn.render) schedule.fn.render();
			if (schedule.fn.fetch) {
				var controls = [ 'season', 'level' ];
				for (var i = 0; i < controls.length; i++) {
					jQuery('#mystic_' + controls[i]).change( schedule.fn.fetch );
				}
			}
		}
	}
} );
</script>
<?php
}
?>
				</article>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>