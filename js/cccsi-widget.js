/*
Plugin Name:  Wp ccc status indicator
Author: cccoders
Version : 0.1.1
*/


var widget_config = {
    'image_id':'status_indicator',
    'states': {
        "down":{"img":"http://understanding-geek.com/status_indicator/traffic_light_circle_red.png"},
        "unknown":{"img":"disable.png"},
        "up":{"img":"http://understanding-geek.com/status_indicator/traffic_light_circle_green.png"}
    },
'status_endpoint':'http://understanding-geek.com/status_indicator/status.php'
}

function setStatusIndicator(status) {
    status = status || 'unknown';
    $('#'+widget_config['image_id'])
    .attr('src', widget_config['states'][status]['img'])
    }


$(document).ready(function(){
    $.ajax({
        url: widget_config['status_endpoint'],
        dataType: 'jsonp',
        success: function(json) {
            try {
                setStatusIndicator([json.status]);
            } catch (err) {
    console.log("Could not find an image for the status reported.");
    }
},
error: function(json) {
    setStatusIndicator();
    }
});
});

