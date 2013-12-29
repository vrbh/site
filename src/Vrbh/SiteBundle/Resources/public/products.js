$(document).ready(function () {

    var currentItemStock = null;

    $('[data-row=stock]').click(function () {
        currentItemStock = this;

        var id = $(this).attr('data-row-stock');
        var name = $(this).attr('data-row-name');

        $('[data-change-stock=table]').hide();

        $('[data-change-stock=title]').text('Change stock for ' + name);

        $('[data-change-stock=form]').show();

        $('[data-change-stock=info-' + id + ']').show();

    });

    var closeStockField = function () {
        if (currentItemStock == null) {
            console.log("Tried closing item, but no field was open?!");
            return;
        }

        var id = $(currentItemStock).attr('data-row-stock');

        $('[data-change-stock=table]').show();

        $('[data-change-stock=form]').hide();

        $('[data-change-stock=info-' + id + ']').hide();
        $('[data-new-stock-error=' + id + ']').hide(); // Make sure the error is hidden when closing the field ;).

        currentItemStock = null;
    };

    $('[data-save-state=save-current-product]').click(function () {
        if (currentItemStock == null) {
            console.log("Clicked save, but no current item.");
            return;
        }
        var id = $(currentItemStock).attr('data-row-stock');
        var stock = $('[data-new-stock=' + id + ']').val();

        if (isNaN(parseInt(stock)) || parseInt(stock) < 0) {
            $('[data-new-stock-error=' + id + ']').show();
            setTimeout(function () {
                $('[data-new-stock-error=' + id + ']').hide();
            }, 5000);

            return;
        }
        $('[data-row-loading=' + id + ']').show();
        $(currentItemStock).addClass('active');
        $(currentItemStock).removeClass('warning');

        var saving = currentItemStock;

        $('[data-new-stock=' + id + ']').html(stock);

        console.log("New stock: " + stock);

        var errorHandler = function () {
            if (!saving) {
                console.log("Missing saving var?!?");
                return;
            }
            $(saving).addClass('danger');
            $(saving).removeClass('active');
        };
        $.ajax({
            type: "POST",
            url: createStock.replace(999, id),
            data: {
                amount: stock
            },
            error: function () {
                console.log("error!");
                $('[data-row-loading=' + $(saving).attr('data-row-stock') + ']').hide();
                errorHandler();
            },
            success: function (data, textStatus, resp) {

                $('[data-row-loading=' + $(saving).attr('data-row-stock') + ']').hide();

                var id = resp.getResponseHeader("X-new-id");

                if (!id) {
                    errorHandler();
                    return;
                }
                $(saving).removeClass('active');
                $(saving).removeClass('danger');
                $(saving).addClass('success');
            }
        });

        closeStockField();
    });

    $('[data-save-state=cancel-current-product]').click(function () {
        closeStockField();
    });

    var currentItemOrder = null;

    $('[data-row=order]').click(function () {
        currentItemOrder = this;

        var id = $(this).attr('data-row-order');
        var name = $(this).attr('data-row-name');

        $('[data-change-order=table]').hide();

        $('[data-change-order=title]').text('Change order for ' + name);

        $('[data-change-order=form]').show();

        $('[data-change-order=info-' + id + ']').show();

    });

    var closeStockField = function () {
        if (currentItemOrder == null) {
            console.log("Tried closing item, but no field was open?!");
            return;
        }

        var id = $(currentItemOrder).attr('data-row-order');

        $('[data-change-order=table]').show();

        $('[data-change-order=form]').hide();

        $('[data-change-order=info-' + id + ']').hide();
        $('[data-new-order-error=' + id + ']').hide(); // Make sure the error is hidden when closing the field ;).

        currentItemOrder = null;
    };

    $('[data-save-state=save-current-order]').click(function () {
        if (currentItemOrder == null) {
            console.log("Clicked save, but no current item.");
            return;
        }
        var id = $(currentItemOrder).attr('data-row-order');
        var order = $('[data-new-order=' + id + ']').val();

        if (isNaN(parseInt(order)) || parseInt(order) < 0) {
            $('[data-new-order-error=' + id + ']').show();
            setTimeout(function () {
                $('[data-new-order-error=' + id + ']').hide();
            }, 5000);

            return;
        }
        $('[data-row-loading=' + id + ']').show();
        $(currentItemOrder).addClass('active');
        $(currentItemOrder).removeClass('warning');

        var saving = currentItemOrder;

        $('[data-new-order=' + id + ']').html(order);

        console.log("New order: " + order);

        var errorHandler = function () {
            if (!saving) {
                console.log("Missing saving var?!?");
                return;
            }
            $(saving).addClass('danger');
            $(saving).removeClass('active');
        };
        $.ajax({
            type: "POST",
            url: createOrder.replace(999, id),
            data: {
                amount: order
            },
            error: function () {
                console.log("error!");
                $('[data-row-loading=' + $(saving).attr('data-row-order') + ']').hide();
                errorHandler();
            },
            success: function (data, textStatus, resp) {

                $('[data-row-loading=' + $(saving).attr('data-row-order') + ']').hide();

                var id = resp.getResponseHeader("X-new-id");

                if (!id) {
                    errorHandler();
                    return;
                }
                $(saving).removeClass('active');
                $(saving).removeClass('danger');
                $(saving).addClass('success');
            }
        });

        closeStockField();
    });

    $('[data-save-state=cancel-current-order]').click(function () {
        closeStockField();
    });

    /**
     * Create a new product.
     */
    $('[data-save-state=create-new-product]').click(function () {

        $('[data-save-state=create-product-org]').attr('disabled', 'disabled');
        $('[data-save-state=create-product-org-cancel]').attr('disabled', 'disabled');

        var removeDisabledProduct = function () {
            $('[data-save-state=create-product-org]').removeAttr('disabled');
            $('[data-save-state=create-new-product-cancel]').removeAttr('disabled');
        };
        var hideCreateNewProduct = function () {
            $('#createNewProduct').modal('hide');

            removeDisabledProduct();
        };

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
        };

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

                    if (!id) {
                        alert('Something went wrong...');
                    }

                    hideCreateNewProduct();
                    //noinspection SillyAssignmentJS
                    location.href = location.href;
                }
            });
        }
    });
});