$(document).ready(function () {
    if (rst)
    {
        $('#typeahead').typeahead(
            {
                name: 'organisations',
                remote: rst
            }
        );
    }
    $('[data-save-state=join-org]').click(function () {

        $('[data-save-state=join-org]').attr('disabled', 'disabled');
        $('[data-save-state=join-org-cancel]').attr('disabled', 'disabled');

        var removeJoinOrgDisabled = function () {
            $('[data-save-state=join-org]').removeAttr('disabled');
            $('[data-save-state=join-org-cancel]').removeAttr('disabled');
        };

        var hideJoinOrg = function () {
            $('#joinOrg').modal('hide');

            removeJoinOrgDisabled();
        };

        var name = $('[data-save-state=join-org-name]').val();

        if (!name) {
            $("#join-new-org-name-error").show();

            setTimeout(function () {
                $("#join-new-org-name-error").hide();
            }, 2000);
            removeJoinOrgDisabled();
        }
        else {
            $.ajax({
                type: "POST",
                url: joinOrg,
                data: {
                    name: name
                },
                success: function (data, textStatus, resp) {
                    var id = resp.getResponseHeader("X-new-id");
                    hideJoinOrg();

                    $('#alert-success').html('Request successfull send.');

                    $("#alert-success").show();
                    setTimeout(function () {
                        $('#alert-success').hide();
                    }, 2000);
                }
            });
        }
    });
});