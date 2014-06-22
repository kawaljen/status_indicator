/*
Plugin Name:  Wp ccc status indicator
Author: cccoders
Version : 0.1.1
*/
(function ($) {
    $(function() {
        $('.Wp_ccc_status_indicator').each(function () {
            checkService($(this));
        });
    });

    function checkService(el) {
        var config = $(el).data('args');
        $.ajax({
            url: config['endpoint'],
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
        var indicator = el.children('div');

        if (status =='loading') {
            indicator.html('Checking service status...<br><br>');
        }  else {
            try {
                var config = $(el).data('args');
                indicator.html(
                    $('<img/>').attr('src', config[status]['img'])
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
