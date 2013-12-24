/**
 * Created by paul_000 on 24-12-13.
 */
$(document).ready(function () {
    $('[data-request=handle]').click(function () {

        var action = $(this).attr('data-action');

        if (action == 'approve')
        {
            var url = approveRequest;
            var method = "POST";
        }
        else if (action == 'deny')
        {
            var url = denyRequest;
            var method = "DELETE";
        }
        else
        {
            // Should not happen!
            console.log("Incorrect action");
            return;
        }
        var id = $(this).attr('data-request-id');
        url = url.replace('0', id);

        $('[data-request-id=' + id + ']').attr('disabled', 'disabled');

        $.ajax({
            type: method,
            url: url,
            error: function()
            {
                alert('Something went wrong...');
                $('[data-request-id=' + id + ']').removeAttr('disabled');
            },

            success: function (data, textStatus, resp) {
                $('[data-block-id=' + id + ']').hide()
            }
        });

    });
});
