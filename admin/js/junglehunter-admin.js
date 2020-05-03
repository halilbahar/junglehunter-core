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

        $('.junglehunter-route-tr').click(function () {
            var tds = getTd($(this).children('td'));
            $('#junglehunter-route-name').val(tds[0]);
            $('#junglehunter-route-start').val(tds[1]);
            $('#junglehunter-route-url').val(tds[2]);
            $('#junglehunter-route-description').val(tds[3]);
        });

        ////////////////////
        // Help functions //
        ////////////////////

        function getTd(elements) {
            var tdData = [];
            $(elements).each(function () {
                tdData.push($(this).html());
            });
            return tdData;
        }
    });
})(jQuery);
