/* ClubHub admin – shared behaviour */
(function ($) {
    'use strict';

    // Flash toasts: show, then hide after a few seconds
    $('.cb-toast').each(function (i, el) {
        setTimeout(function () { $(el).addClass('show'); }, 100 + i * 150);
        setTimeout(function () { $(el).removeClass('show'); }, 4500 + i * 150);
    });

    // <form data-confirm="Delete this student?"> asks first, using a styled modal
    var pendingForm = null;
    $(document).on('submit', 'form[data-confirm]', function (ev) {
        if (this.dataset.confirmed) return;
        ev.preventDefault();
        pendingForm = this;
        $('#confirmText').text(this.dataset.confirm);
        $('#confirmModal').modal('show');
    });
    $('#confirmOk').on('click', function () {
        if (!pendingForm) return;
        pendingForm.dataset.confirmed = '1';
        $('#confirmModal').modal('hide');
        pendingForm.submit();
    });

    // Searchable, sortable tables
    $('table.js-datatable').each(function () {
        $(this).DataTable({
            pageLength: 10,
            order: [],
            columnDefs: [{ targets: 'no-sort', orderable: false }],
            language: { search: '', searchPlaceholder: 'Search…', emptyTable: 'Nothing here yet.' }
        });
    });

    // Bulk selection: <input class="js-check-all"> toggles .js-check rows,
    // and [data-bulk-count] shows how many are selected.
    function refreshBulk() {
        var n = $('.js-check:checked').length;
        $('[data-bulk-count]').text(n);
        $('.js-bulk').toggleClass('d-none', n === 0);
    }
    $(document).on('change', '.js-check-all', function () {
        $('.js-check').prop('checked', this.checked);
        refreshBulk();
    });
    $(document).on('change', '.js-check', refreshBulk);
    // Copy the checked ids into the bulk form just before it submits
    $(document).on('submit', 'form.js-bulk-form', function () {
        var $f = $(this);
        $f.find('input[name="ids[]"]').remove();
        $('.js-check:checked').each(function () {
            $('<input type="hidden" name="ids[]">').val(this.value).appendTo($f);
        });
    });

    // Copy-to-clipboard buttons: <button data-copy="#inputId">
    $(document).on('click', '[data-copy]', function () {
        var $btn = $(this), input = document.querySelector($btn.data('copy'));
        input.select();
        var done = function () { $btn.html('<i class="fa fa-check"></i> Copied'); setTimeout(function () { $btn.html('<i class="fa fa-clone"></i> Copy'); }, 1800); };
        if (navigator.clipboard) navigator.clipboard.writeText(input.value).then(done, function () { document.execCommand('copy'); done(); });
        else { document.execCommand('copy'); done(); }
    });
})(jQuery);
