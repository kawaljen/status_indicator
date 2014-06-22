/*
Plugin Name:  Wp ccc status indicator
Author: cccoders
Version : 0.1.1
*/
(function ($) {
    $(function() {
        $('.ccc_si_content').each(function () {
            checkService($(this));
        });
    });

    function checkService(el) {
        var config = $(el).data('args');
        $.ajax({
            url: config['status_endpoint'],
            dataType: 'jsonp',
            beforeSend : function () {
                setIndicator(el,'loading')
            },
            success: function (response) {
                setIndicator(el,getStatus(response))
            }
        });
    }

    function setIndicator(el,status) {
        if (status =='loading') {
           el.html('Checking service status...<br><br>');
        }  else {
            try {
                var config = $(el).data('args');
                el.html(
                    $('<img/>').attr('src', config['states'][status]['img'])
                );
            } catch (err) {
                console.log("Could not find an image for the status reported.");
            }
        }
    }

    function getStatus(json) {
        json.status = json.status || 'unknown';
        return json.status;
    }

}(jQuery));
