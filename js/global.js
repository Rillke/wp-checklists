/**
 * This file is part of the WordPress Check lists plugin
 *
 * @author Rainer Rillke <rainer@rillke.com>
 * @version 1.6.0.0
 */

(function($) {
	'use strict';

	function addCheckBox($list, html) {
		var $li = $('<li>'),
			$label = $('<label>')
				.html('&nbsp;' + html)
				.appendTo($li),
			$checkbox = $('<input type="checkbox">')
				.prependTo($label);
		$list.append($li);
	}

	$(function() {
		var $checklists = $('.wpcl-checklist')
			.removeClass('wpcl-checklist')
			.addClass('wpcl-checklist-processed');

		$checklists
			.each(function(i, div) {
				var $list = $(div),
					$semanticList = $('<ul>'),
					$uls = $list.children('ul'),
					$lis = $uls.children('li'),
					$ps = $list.children('p');

				$lis.each(function(j, li) {
					var $li = $(li);
					addCheckBox($semanticList, $li.html());
				});
				$uls.remove();

				$ps.each(function(j, p) {
					var $p = $(p);
					addCheckBox($semanticList, $p.html());
				}).remove();

				$list.append($semanticList);
			});
	});
}(jQuery));
