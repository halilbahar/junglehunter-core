(function ($) {
    'use strict';
    $(function () {
        var tableRows = $('#junglehunter-table tbody tr');
        tableRows.each(function () {
            var $this = $(this);
            if ($this.html().replace(/\s|&nbsp;/g, '').length == 0) {
                $this.remove();
            }
        });

        tableRows.click(function () {
            $(this).toggleClass('junglehunter-selected-table').siblings().removeClass('junglehunter-selected-table');
        });

        /////////////////////
        // Route functions //
        /////////////////////
        var createButton = $('#junglehunter-create');
        var saveButton = $('#junglehunter-save');
        var deleteButton = $('#junglehunter-delete');

        $('#junglehunter-route-cancel').click(function () {
            var formDivs = $('#junglehunter-form > div');
            $(formDivs).children('input').val('');
            $(formDivs).children('textarea').val('');
            $(formDivs).children('select').val('');
            createButton.prop('disabled', false);
            saveButton.prop('disabled', true);
            deleteButton.prop('disabled', true);
            tableRows.removeClass('junglehunter-selected-table');
        });

        $('.junglehunter-route-tr').click(function () {
            var tds = getTd($(this).children('td'));
            $('#junglehunter-route-name').val(tds[0]);
            $('#junglehunter-route-start').val(tds[1]);
            $('#junglehunter-route-url').val(tds[2]);
            $('#junglehunter-route-description').val(tds[3]);
            createButton.prop('disabled', true);
            saveButton.prop('disabled', false);
            deleteButton.prop('disabled', false);
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
