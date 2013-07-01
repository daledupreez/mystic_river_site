/* Test JS additions to sort out positioning of fixed background. */
/* Written by Dale du Preez using the mystic namespace. */

var mystic = { "util": {}, "handler": {}, "layout": {} };

mystic.util.addSidebarHandlers = function mystic_util_addSidebarHandlers()
{
	var secondaryDiv = document.getElementById('secondary');
	if (secondaryDiv) {
		var asides = secondaryDiv.getElementsByTagName('aside');
		for (var i = 0; i < asides.length; i++) {
			var aside = asides[i];
			if (aside && (aside.className.toString().indexOf('widget') > -1)) {
				var titles = aside.getElementsByClassName('widget-title');
				if (titles && (titles.length >= 1)) {
					var header = titles[0];
					if (header) header.setAttribute('onclick','mystic.layout.toggleSidebarList("'+aside.id+'");');
				}
				//aside.addEventListener('click',function(){mystic.layout.toggleSidebarList(this);},false);
			}
		}
	}
}

mystic.layout.toggleSidebarList = function mystic_layout_toggleSidebarList(asideID)
{
	var aside = document.getElementById(asideID);
	if (aside) {
		var closedPos = -1;
		var asideClasses = aside.className.toString().split(' ');
		for (var i = 0; i < asideClasses.length; i++) {
			if (asideClasses[i] == 'closed') {
				closedPos = i;
				break;
			}
		}
		if (closedPos == -1) {
			asideClasses.push('closed');
		}
		else {
			asideClasses.splice(closedPos,1);
		}
		aside.className = asideClasses.join(' ');
	}
}

mystic.handler.load = function mystic_handler_load()
{
	mystic.util.addSidebarHandlers();
}

mystic.util.alert = function mystic_util_alert(text,title,postFunction) {
	if (!text) return;
	var localFunc = postFunction;
	var dialog = jQuery('#mystic_dialog_div');
	if (typeof dialog.dialog != 'function') {
		var tempDiv = jQuery('<div>').html(text);
		alert(tempDiv.text());
		if (typeof postFunction == 'function') postFunction(); 
		return;
	}
	title = (typeof title != 'string' ? '' : title);
	dialog.prop('title', title);
	dialog.html('<div class="mystic_dialog_content">'+ text + '</div>');
	dialog.dialog({
		buttons: {
			'OK': function() {
				jQuery( this ).dialog( 'close' );
			}
		},
		close: function(evt,ui) {
			if (typeof localFunc == 'function') localFunc();
		},
		dialogClass: 'wp-dialog',
		modal: true
	});
}