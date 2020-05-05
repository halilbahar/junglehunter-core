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
            var classes = $(this).attr("class").split(/\s+/);
            // Reset everything
            resetFields();
            // When you find a class that is selected (selected class + row class) set it's fields
            if (classes.length == 2) {
                var tds = getTd($(this).children('td'));
                // set the hidden id - the user is saving or deleting a entry
                idField.val($(tds[0]).attr('data-id'));
                toggleButtons(true);

                if (classes[0] == 'junglehunter-route-tr') {
                    $('#junglehunter-route-name').val(tds[0].html());
                    $('#junglehunter-route-start').val(tds[1].html());
                    $('#junglehunter-route-url').val(tds[2].html());
                    $('#junglehunter-route-description').val(tds[3].html());
                } else if (classes[0] == 'junglehunter-trail-tr') {
                    $('#junglehunter-trail-name').val(tds[0].html());
                    $('#junglehunter-trail-length').val(tds[1].html());
                    $('#junglehunter-trail-route').val(tds[2].attr('data-id'));
                } else if (classes[0] == 'junglehunter-control-point-tr') {
                    $('#junglehunter-control-point-name').val(tds[0].html());
                    $('#junglehunter-control-point-comment').val(tds[1].html());
                    $('#junglehunter-control-point-note').val(tds[2].html());
                    $('#junglehunter-control-point-latitude').val(tds[3].html());
                    $('#junglehunter-control-point-longitude').val(tds[4].html());
                    $('#junglehunter-control-point-trail').val(tds[5].attr('data-id'));
                }
            } else {
                toggleButtons(false);
            }
        });

        //////////////////////
        // Common functions //
        //////////////////////
        var createButton = $('#junglehunter-create');
        var saveButton = $('#junglehunter-save');
        var deleteButton = $('#junglehunter-delete');
        var idField = $('#junglehunter-id');

        saveButton.click(function () {
            $('#junglehunter-method').val('PUT');
        });

        deleteButton.click(function () {
            $('#junglehunter-method').val('DELETE');
        });

        $('#junglehunter-cancel').click(function cancelCommon() {
            $('#junglehunter-original-unique-field').val('');
            resetFields();
            // Toggle the buttons - Create state
            toggleButtons(false);
            tableRows.removeClass('junglehunter-selected-table');
        });

        ////////////////////
        // Help functions //
        ////////////////////

        function getTd(elements) {
            var tdData = [];
            $(elements).each(function () {
                tdData.push($(this));
            });
            return tdData;
        }

        function resetFields() {
            idField.val('');
            var inputRows = $('#junglehunter-form > div.junglehunter-input-row');
            inputRows.children('input, textarea, select').val('').removeClass('junglehunter-red-border');
            inputRows.children('span.junglehunter-error-message').remove();
        }

        function toggleButtons(isCreatingState) {
            if (isCreatingState == undefined) {
                isCreatingState = !$(createButton).is(':disabled');
            }
            createButton.prop('disabled', isCreatingState);
            saveButton.prop('disabled', !isCreatingState);
            deleteButton.prop('disabled', !isCreatingState);
        }

        $('#junglehunter-form > div.junglehunter-input-row').children('input, textarea, select').keydown(function () {
            $(this).removeClass('junglehunter-red-border');
            $(this).parent().children('span.junglehunter-error-message').remove();
        });

        $('.junglehunter-number-input').on('input', function () {
            this.value = this.value.replace(/[^0-9,]/g, '').replace(/(,.*),/g, '$1');
        });
    });
})(jQuery);
