$(document).ready(function() {
    $('[data-org-select=select-org]').click(function(){
        clickOrg(this);
        return false;
    });

    var clickOrg = function(click)
    {
        var id = $(click).attr('data-org-id');

        console.log("Going to id " + id);

        var loc = goToOrg.replace("0", id);

        location.href=loc;
    }


    $('[data-save-state=create-new-org]').click(function() {

        $('[data-save-state=create-new-org]').attr('disabled', 'disabled');
        $('[data-save-state=create-new-org-cancel]').attr('disabled', 'disabled');

        removeDisabledOrg = function () {
            $('[data-save-state=create-new-org]').removeAttr('disabled');
            $('[data-save-state=create-new-org-cancel]').removeAttr('disabled');
        }

        hideCreateNewOrg = function()
        {
            $('#createNewOrg').modal('hide');

            removeDisabledOrg();
        }

        var name = $('[data-save-state=create-new-org-name]').val();

        if (!name)
        {
            $("#name-error").show();

            setTimeout(function() { $("#name-error").hide(); }, 2000);
            removeDisabledOrg();
        }
        else
        {
            $.ajax({
                type: "POST",
                url: createOrg,
                data: {
                    name: name
                },
                success: function(data, textStatus, resp)
                {
                    var id = resp.getResponseHeader("X-new-id");
                    hideCreateNewOrg();

                    var el = $("<a href='#' data-org-select='select-org' data-org-id='" + id + "' class='list-group-item'>" + name + "</a>");
                    el.click(function()
                    {
                        clickOrg(this);
                        return false;
                    });
                    $("#add-org").parent().append(el);
                }
            });
        }
    });
});