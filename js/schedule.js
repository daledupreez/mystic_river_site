/*
	JS for schedule display using Team Data plugin.
*/

var schedule = {
	"ajaxurl": '',
	"data": {},
	"filterData": {},
	"fn": {},
	"loc": {},
	"matchList": []
};

schedule.fn.getLoc = function schedule_fn_getLoc(text)
{
	if ((text !== '') && (typeof schedule.loc[text] != 'undefined')) return schedule.loc[text];
	return text;
}

schedule.fn.render = function schedule_fn_render()
{
	var articles = [];

	if ((!schedule.matchList) || (schedule.matchList.length == 0)) {
		var article = document.createElement('article');
		article.className = 'hentry mystic_schedule';
		var html = [];
		html.push('<div class="entry-content">');
		html.push('<span>No matches</span>');
		html.push('</div>');
		article.innerHTML = html.join('');
		articles.push(article);
	}
	else {
		var html = [];
		var colCount = 11;
		var resultColCount = 4;
		var isOpen = false;

		var last = {
			"season": null,
			"year": null,
			"month": null,
			"date": null
		};

		for (var i = 0; i < schedule.matchList.length; i++) {
			var match = schedule.matchList[i];
			if (match.season != last.season) {
				if (isOpen) {
					html.push('</table>');
					html.push('</div>');
					var article = document.createElement('article');
					article.className = 'hentry mystic_schedule';
					article.innerHTML = html.join('');
					articles.push(article);
					html = [];
				}
				//html.push('<article class="hentry mystic_schedule">');
				html.push('<div class="entry-content">');
				html.push('<table class="mystic_schedule">');
				isOpen = true;
				html.push('<tr class="mystic_season_row"><td class="mystic_season_cell" colspan="' + colCount + '">' + match.season + '</td></tr>');
				last.season = match.season;

				// Render headers for current season
				// Make sure colCount and resultColCount are updated along with the columns
				html.push('<tr class="mystic_schedule_table_header">');
				html.push('<th>' + schedule.fn.getLoc('Date') + '</th>');
				html.push('<th>' + schedule.fn.getLoc('Time') + '</th>');
				html.push('<th class="mystic_team">' + schedule.fn.getLoc('Team') + '</th>');
				html.push('<th>' + schedule.fn.getLoc('Opposition') + '</th>');
				html.push('<th colspan="2">' + schedule.fn.getLoc('Venue') + '</th>');
				html.push('<th colspan="4" style="text-align: center;">' + schedule.fn.getLoc('Result') + '</th>');
				/*html.push('<th>&nbsp;</th>');
				html.push('<th>&nbsp;</th>');
				html.push('<th>&nbsp;</th>');*/
				html.push('</tr>');
			}
			if ((match._month != last.month) || (match._year != last.year)) {
				html.push('<tr class="mystic_month_row"><td class="mystic_month_cell" colspan="' + colCount + '">' + match._month + '&nbsp;' + match._year + '</td></tr>');
				last.month = match._month;
				last.year = match._year;
			}
			html.push('<tr>');
			var dateContents = '&nbsp;';
			if (match._date != last.date) {
				last.date = match._date;
				dateContents = String(match.day_name).substring(0,3) + '&nbsp;' + match._day;
			}
			html.push('<td>' + dateContents + '</td>');
			html.push('<td>' + String(match._time).substring(0,5) + '</td>');
			html.push('<td class="mystic_level">' + match.level + '</td>');
			html.push('<td class="mystic_opposition">' + (match.tourney_name ? match.tourney_name : match.team) + '</td>');
			html.push('<td>' + (1 == parseInt(match.is_home,10) ? 'H' : 'A') + '</td>');
			html.push('<td>' + match.venue + '</td>');
			if ((match.our_score != null) && (match.their_score != null)) {
				var ours = parseInt(match.our_score,10);
				var theirs = parseInt(match.their_score,10);
				var result = 'W';
				if (theirs > ours) {
					result = 'L';
				}
				else if (theirs == ours) {
					result = 'D';
				}
				html.push('<td class="mystic_result mystic_result_letter">' + result + '</td>');
				html.push('<td class="mystic_result mystic_result_ours">' + match.our_score + '</td>');
				html.push('<td class="mystic_result mystic_result_middle">-</td>');
				html.push('<td class="mystic_result mystic_result_theirs">' + match.their_score + '</td>');
			}
			else if ((match.result != null) && (match.result !== '')) {
				if (match.result.length > 1) {
					html.push('<td class="mystic_result mystic_result_text" colspan="4">' + match.result + '</td>');
				}
				else {
					html.push('<td class="mystic_result mystic_result_letter">' + match.result + '</td>');
					html.push('<td class="mystic_result mystic_result_partial" colspan="' + (resultColCount-1) + '">&nbsp;</td>');
				}
			}
			else {
				html.push('<td class="mystic_result_empty" colspan="' + resultColCount + '">&nbsp;</td>');
			}
			html.push('</tr>');
		}

		if (isOpen) {
			html.push('</table>');
			html.push('</div>');
			var article = document.createElement('article');
			article.className = 'hentry mystic_schedule';
			article.innerHTML = html.join('');
			articles.push(article);
		}
	}
	var content = document.getElementById('content');
	for (var i = content.children.length - 1; i > 0; i--) {
		var child = content.children.item(i);
		content.removeChild(child);
	}
	for (var i = 0; i < articles.length; i++) {
		content.appendChild(articles[i]);
	}
}

schedule.fn.fetch = function schedule_fn_fetch()
{
	var postData = { "action": "team_data_public_get_matches" };
	var controlNames = [ 'season', 'level' ];
	for (var i = 0; i < controlNames.length; i++) {
		var controlName = controlNames[i];
		var val = jQuery('#mystic_' + controlName).val();
		if (val !== '') postData[controlName] = val;
	}
	jQuery.post(schedule_ajax.ajaxurl,postData, function(postResponse) { schedule.fn.handleFetch(postResponse); } );
}

schedule.fn.handleFetch = function schedule_fn_handleFetch(jsonResponse)
{
	schedule.matchList = jsonResponse;
	schedule.fn.render();
}