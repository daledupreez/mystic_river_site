/*
	JS for schedule display using Team Data plugin.
*/
var schedule = {
	"data": {},
	"fn": {},
	"loc": {}
};

schedule.fn.getLoc = function schedule_fn_getLoc(text)
{
	if ((text !== '') && (typeof schedule.loc[text] != 'undefined')) return schedule.loc[text];
	return text;
}

schedule.fn.render = function schedule_render()
{
	var html = [];
	html.push('<table class="mystic_schedule">');
	html.push('<tr class="mystic_schedule_table_header">');
	html.push('<th>' + schedule.fn.getLoc('Date') + '</th>');
	html.push('<th>' + schedule.fn.getLoc('Time') + '</th>');
	html.push('<th class="mystic_team">' + schedule.fn.getLoc('Team') + '</th>');
	html.push('<th>' + schedule.fn.getLoc('Opposition') + '</th>');
	html.push('<th colspan="2">' + schedule.fn.getLoc('Venue') + '</th>');
	html.push('<th>&nbsp;</th>');
	html.push('<th>&nbsp;</th>');
	html.push('<th>&nbsp;</th>');
	html.push('</tr>');
	
	var currSeason = null;
	var currMonth = null;
	
	html.push('</table>');
}