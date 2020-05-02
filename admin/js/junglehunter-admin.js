(function ($) {
    'use strict';
    $(function () {
        $('#junglehunter-table tr').each(function () {
            var $this = $(this);
            if ($this.html().replace(/\s|&nbsp;/g, '').length == 0) {
                $this.remove();
            }
        });

        $('#junglehunter-table tr').click(function () {
            $(this).toggleClass('junglehunter-selected-table').siblings().removeClass('junglehunter-selected-table');
        });

        $('#junglehunter-route-cancel').click(function () {
			$('#junglehunter-form > div > input').val('');
			$('#junglehunter-form > div > textarea').val('');
			$('#junglehunter-form > div > select').val('');
        });
    });
})(jQuery);
