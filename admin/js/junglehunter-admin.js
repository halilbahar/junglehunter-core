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

        //////////////////////
        // Common functions //
        //////////////////////
        var createButton = $('#junglehunter-create');
        var saveButton = $('#junglehunter-save');
        var deleteButton = $('#junglehunter-delete');

        saveButton.click(function () {
            $('#junglehunter-method').val('PUT');
        });

        deleteButton.click(function () {
            $('#junglehunter-method').val('DELETE');
        });

        function cancelCommon() {
            $('#junglehunter-original-unique-field').val('');
            // Reset all fields
            $('#junglehunter-form > div').children('input, textarea, select').val('');
            // Toggle the buttons - Create state
            createButton.prop('disabled', false);
            saveButton.prop('disabled', true);
            deleteButton.prop('disabled', true);
            tableRows.removeClass('junglehunter-selected-table');
        }

        function clickCommon(uniqueField) {
            console.log(uniqueField);
            $('#junglehunter-original-unique-field').val(uniqueField);
            createButton.prop('disabled', true);
            saveButton.prop('disabled', false);
            deleteButton.prop('disabled', false);
        }

        /////////////////////
        // Route functions //
        /////////////////////
        $('#junglehunter-route-cancel').click(function () {
            cancelCommon();
        });

        $('.junglehunter-route-tr').click(function () {
            var tds = getTd($(this).children('td'));
            // Load from table
            $('#junglehunter-route-name').val(tds[0]);
            $('#junglehunter-route-start').val(tds[1]);
            $('#junglehunter-route-url').val(tds[2]);
            $('#junglehunter-route-description').val(tds[3]);
            // Toggle the buttons - delete and save state
            clickCommon(tds[0]);
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
