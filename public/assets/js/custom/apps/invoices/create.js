// Class definition
var KTAppInvoicesCreate = function () {
    var form; // Private functions

    var handleEmptyState = function handleEmptyState() {
        if (form.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]').length === 0) {
            var item = form.querySelector('[data-kt-element="empty-template"] tr').cloneNode(true);
            form.querySelector('[data-kt-element="items"] tbody').appendChild(item);
        } else {
            KTUtil.remove(form.querySelector('[data-kt-element="items"] [data-kt-element="empty"]'));
        }
    };

    var handeForm = function handeForm(element) {
        // Add item
        form.querySelector('[data-kt-element="items"] [data-kt-element="add-item"]').addEventListener('click', function (e) {
            e.preventDefault();
            var item = form.querySelector('[data-kt-element="item-template"] tr').cloneNode(true);
            form.querySelector('[data-kt-element="items"] tbody').appendChild(item);
            handleEmptyState();
        }); // Remove item

        KTUtil.on(form, '[data-kt-element="items"] [data-kt-element="remove-item"]', 'click', function (e) {
            e.preventDefault();
            KTUtil.remove(this.closest('[data-kt-element="item"]'));
            handleEmptyState();
        }); // Handle price and quantity changes

        KTUtil.on(form, '[data-kt-element="items"] [data-kt-element="quantity"], [data-kt-element="items"] [data-kt-element="price"]', 'change', function (e) {
            e.preventDefault();
        });
    };

    return {
        init: function init(element) {
            form = document.querySelector('#kt_invoice_form');
            handeForm();
        }
    };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
    KTAppInvoicesCreate.init();
});
