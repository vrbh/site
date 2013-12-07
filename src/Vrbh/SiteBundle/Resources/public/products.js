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

        if (!name) {
            $("#name-error").show();

            setTimeout(function () {
                $("#name-error").hide();
            }, 2000);
            removeDisabledProduct();
        }
        else {
            $.ajax({
                type: "POST",
                url: '',
                data: {
                    name: name
                },
                success: function (data, textStatus, resp) {
                    var id = resp.getResponseHeader("X-new-id");
                    hideCreateNewProduct();


                }
            });
        }
    });
});