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
				<article id="mystic-schedule" class="hentry">
					<header class="entry-header">
						<!--<h1 class="entry-title">Schedule</h1>-->
					</header>
					<div class="entry-content">
<?php
	global $wpdb;
	
	/*
	$match_table = $wpdb->prefix . 'mystic_match';
	$team_table = $wpdb->prefix . 'mystic_team';
	$venue_table = $wpdb->prefix . 'mystic_venue';
	*/
	$match_table = $wpdb->prefix . 'team_data_match';
	$team_table = $wpdb->prefix . 'team_data_opposition';
	$venue_table = $wpdb->prefix . 'team_data_venue';
	$level_table = $wpdb->prefix . 'team_data_level';
	$dates_sql = "SELECT DATE As match_date, DAYOFMONTH(DATE) As match_day, DAYNAME(DATE) As match_dayname, MONTHNAME(DATE) As match_month, YEAR(DATE) As match_year, venue_id, MIN(time) As first_time
		FROM $match_table GROUP BY match_date, venue_id
		ORDER BY match_date ASC, first_time ASC";

	$dates = $wpdb->get_results($dates_sql);
	
	if (count($dates) < 1) {
		echo 'No results found';
	}
	else {
		echo '<table class="team_data_schedule">';
		echo '<tr class="team_data_table_header">';
		echo '<th>Date</th>';
		echo '<th>Time</th>';
		echo '<th class="team_data_level">Team</th>';
		echo '<th class="team_data_home">Home</th>';
		echo '<th>&nbsp;</th>';
		echo '<th>&nbsp;</th>';
		echo '<th>&nbsp;</th>';
		echo '<th>Away</th>';
		echo '<th>Venue</th>';
		echo '</tr>';
		$last = array(
			'date' => '',
			'day' => '',
			'month' => '',
			'venue' => ''
		);
		$date_count = count($dates);
		foreach ($dates as $date) {
			$current = array(
				'date' => $date->match_date,
				'day' => $date->match_day,
				'month' => $date->match_month,
				'venue_id' => $date->venue_id
			);
			if ($last['month'] != $current['month']) {
				echo '<tr class="team_data_month_row"><td class="team_data_month_cell" colspan="9">' . $current['month'] . '&nbsp;' . $date->match_year . '</td></tr>';
			}
			$match_sql = "SELECT m.time AS match_time, IF(level.abbreviation = '', level.name, level.abbreviation) AS level_name, 
				IF(venue.abbreviation = '', venue.name, venue.abbreviation) AS venue_name, IF(team.abbreviation = '', team.name, team.abbreviation) AS team_name, m.our_score, m.opposition_score, (venue.is_home = 1) AS venue_is_home
				FROM $match_table m, $team_table team, $venue_table venue, $level_table level 
				WHERE m.opposition_id = team.id AND m.venue_id = " . $current['venue_id'] . " AND m.date = '" . $current['date'] . "' AND venue.id = " . $current['venue_id'] .
				' AND m.level_id = level.id ORDER BY m.time ASC';
			$matches = $wpdb->get_results($match_sql);
			$match_count = count($matches);
			foreach ($matches as $match) {
				$home_score = '&nbsp;&nbsp;';
				$away_score = '&nbsp;&nbsp;';
				$middle_col = 'v';
				if (($match->our_score !== null) && ($match->opposition_score !== null)) {
					$home_score = ($match->venue_is_home ? $match->our_score : $match->opposition_score);
					$away_score = ($match->venue_is_home ? $match->opposition_score : $match->our_score);
					$middle_col = '-';
				}

				echo '<tr>';
				// Date
				echo '<td>';
				echo '<!-- last date = "' . $last['date'] . '" | current date = "' . $current['date'] . '" -->';
				if ($last['date'] != $current['date']) {
					echo substr($date->match_dayname,0,3) . '&nbsp;' . $current['day'] . '&nbsp;' . substr($current['month'],0,3);
				}
				else {
					echo '&nbsp;';
				}
				echo '</td>';
				echo '<td>' . substr($match->match_time,0,5) . '</td>';
				echo '<td class="team_data_level">' . $match->level_name . '</td>';
				echo '<td class="team_data_home">' . ( $match->venue_is_home ? '<strong>Mystic River</strong>' : $match->team_name ) . '</td>';
				echo '<td class="team_data_home_result team_data_result">' . $home_score . '</td>';
				echo '<td class="team_data_middle_col team_data_result">' . $middle_col . '</td>';
				echo '<td class="team_data_away_result team_data_result">' . $away_score . '</td>';
				echo '<td class="team_data_away">' . ( $match->venue_is_home ? $match->team_name : '<strong>Mystic River</strong>') . '</td>';
				/*
				echo '<th>Home</th>';
		echo '<th>&nbsp;</th>';
		echo '<th>Away</th>';
		echo '<th>Venue</th>';
		
				*/
				echo '<td>' . $match->venue_name . '</td>';
				/*
				echo '<td>' . $match->team_name . '</td>';
				echo "<!--mystic_score: $match->mystic_score || opposition_score: $match->opposition_score -->";
				$match_hasScore = ($match->mystic_score !== null) && ($match->opposition_score !== null);
				if ($match_hasScore) {
					$match_result = 'W';
					if ($match->mystic_score < $match->opposition_score) {
						$match_result = 'L';
					}
					elseif ($match->mystic_score == $match->opposition_score) {
						$match_result = 'D';
					}
					echo '<td>' . $match_result . '&nbsp;' . $match->mystic_score . '&nbsp;-&nbsp;' . $match->mystic_score . '</td>';
				}
				else {
					echo '<td>&nbsp;</td>';
				}
				*/
				echo "</tr>\n";
				$last['date'] = $current['date'];
				$last['day'] = $current['day'];
				$last['month'] = $current['month'];
				$last['venue_id'] = $current['venue_id'];
			}
			
		}
		echo '</table>';
	}
?>
					</div>
				</article>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>