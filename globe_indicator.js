/**
 * Created with JetBrains PhpStorm.
 * User: duncan.walker
 * Date: 18/06/14
 * Time: 20:15
 * To change this template use File | Settings | File Templates.
 */

$( document ).ready(function() {
    console.log( "ready!" );
    setIndicator();
});


function setIndicator() {
var jqxhr = $.get( "cpdnboinc_status.xml", function(data) {
    alert( "success" );
    if(data.CPDNBOINC_status.status.text ='red') {
        $( "body" )
            .append( '<img src="traffic_light_circle_red.png" />' )

    } else if (data.CPDNBOINC_status.status.text ='green') {
        $( "body" )
            .append( '<img src="traffic_light_circle_green.png" />' )
    }
},'','xml');



// Perform other work here ...

// Set another completion function for the request above
jqxhr.always(function() {
    alert( "second finished" );
});
}