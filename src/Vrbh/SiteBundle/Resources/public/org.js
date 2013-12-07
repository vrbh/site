$(document).ready(function() {
    $('[data-save-state=create-new-org]').click(function() {

        $('[data-save-state=create-new-org]').attr('disabled', 'disabled');
        $('[data-save-state=create-new-org-cancel]').attr('disabled', 'disabled');

        removeDisabled = function()
        {
            $('[data-save-state=create-new-org]').removeAttr('disabled');
            $('[data-save-state=create-new-org-cancel]').removeAttr('disabled');
        }

        hideCreateNewOrg = function()
        {
            $('#createNewOrg').modal('hide');

            removeDisabled();
        }

        var name = $('[data-save-state=create-new-org-name]').val();

        if (!name)
        {
            $("#name-error").show();

            setTimeout(function() { $("#name-error").hide(); }, 2000);
            removeDisabled();
        }
        else
        {
            $.ajax({
                type: "POST",
                url: createOrg,
                data: {
                    name: name
                },
                success: function()
                {
                    hideCreateNewOrg();

                    $("#org-list").append($("<a class='list-group-item'>" + name + "</a>"));
                }
            });
        }
    });
});