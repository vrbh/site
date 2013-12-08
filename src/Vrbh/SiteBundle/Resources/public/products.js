$(document).ready(function () {

    $('[data-save-state=create-new-product]').click(function () {

        $('[data-save-state=create-product-org]').attr('disabled', 'disabled');
        $('[data-save-state=create-product-org-cancel]').attr('disabled', 'disabled');

        var removeDisabledProduct = function () {
            $('[data-save-state=create-product-org]').removeAttr('disabled');
            $('[data-save-state=create-new-product-cancel]').removeAttr('disabled');
        }
        var hideCreateNewProduct = function () {
            $('#createNewProduct').modal('hide');

            removeDisabledProduct();
        }

        var name = $('[data-save-state=create-new-product-name]').val();
        var desc = $('[data-save-state=create-new-product-description]').val();
        var stockunit = $('[data-save-state=create-new-product-stock-unit] option:selected').text();
        var orderunit = $('[data-save-state=create-new-product-order-unit] option:selected').text();
        var minstock = $('[data-save-state=create-new-product-min-stock]').val();
        var maxstock = $('[data-save-state=create-new-product-max-stock]').val();

        var show_error = function (id) {
            console.log(id);
            $(id).show();

            setTimeout(function () {
                $(id).hide();
            }, 5000);
            error = true;
        }

        var error = false;
        if (!name) {
            show_error("#product-name-error");
        }
        if (!desc) {
            show_error("#product-description-error");
        }
        if (!stockunit || stockunit == "stock unit") {
            show_error("#product-stockunit-error");
        }
        if (!orderunit || orderunit == "order unit") {
            show_error("#product-orderunit-error");
        }
        if (!minstock) {
            show_error("#product-min-stock-error");
        }
        if (!maxstock) {
            show_error("#product-max-stock-error");
        }

        if (error) {
            removeDisabledProduct();
        } else {

            /*
             $name = $request->request->get('name');
             $description = $request->request->get('description');
             $orderNumber = $request->request->get('orderNumber');
             $ean = $request->request->get('ean');
             $stockUnit = $request->request->get('stockUnint');
             $orderUnit = $request->request->get('orderUnit');
             $minStock = $request->request->get('minStock');
             $maxStock = $request->request->get('maxStock');
             */
            $.ajax({
                type: "POST",
                url: createProduct,
                data: {
                    name: name,
                    description: desc,
                    stockUnit: stockunit,
                    orderUnit: orderunit,
                    minStock: minstock,
                    maxStock: maxstock
                },
                success: function (data, textStatus, resp) {
                    var id = resp.getResponseHeader("X-new-id");

                    if (!id)
                    {
                        alert('Something went wrong...');
                    }

                    hideCreateNewProduct();
                }
            });
        }
    });
});