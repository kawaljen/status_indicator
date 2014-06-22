/*
 *  Fixtures are assuming that you have Wordpress running from Vagrant (http://vagrantpress.org/)
 *  assumes that there is already one status_indicator widget active and tests the first one on widgets page.
 */
var base_url = 'http://localhost:8080/';
var fixtures = {
    'old_src' : 'default',
    'new_src' : 'http://understanding-geek.com/status_indicator/traffic_light_circle_green.png',
    'endpoint': 'http://understanding-geek.com/status_indicator/status.php',
    'wp_user' : 'admin',
    'wp_pass' : 'vagrant'
};

casper.test.begin('Widget Admin functions', 5, function suite(test) {
    var widget_control_id;
    var widget_id_number;
    var widget_id;

    casper.start(base_url+'wp-admin/widgets.php', function() {
        //login
        test.assertExists('form#loginform');
        casper.then(function() {
            this.fill('form#loginform', {
                'log':   fixtures.wp_user,
                'pwd':   fixtures.wp_pass
            }, true);
        });

        // change the up img and endpoint url
        casper.then(function() {
            // there may be many status_indicator widgets, use the first one
            widget_control_id = this.getElementAttribute('div[id*=wp_ccc_status_indicator]:not(.ui-draggable)', 'id');
            widget_id_number = widget_control_id.match(/(\d+)$/gi)[0];
            widget_id = "wp_ccc_status_indicator-"+ widget_id_number;

            fields = {};
            fields['widget-wp_ccc_status_indicator['+widget_id_number+'][up][img]'] = fixtures.new_src;
            fields['widget-wp_ccc_status_indicator['+widget_id_number+'][endpoint]'] = fixtures.endpoint;

            test.assertExists('div#'+widget_control_id +' form');

            this.fill('div#'+widget_control_id+' form', fields, false);
            this.click("#widget-wp_ccc_status_indicator-"+widget_id_number+"-savewidget");

            test.assertField('widget-wp_ccc_status_indicator['+widget_id_number+'][up][img]', fixtures.new_src);
        });

        // go back to homepage
        casper.then(function() {
            this.clickLabel('Visit Site', 'a');
        });

        // check the status image is right
        casper.then(function() {
            this.reload(function() {         // otherwise src doesn't update
                casper.waitForSelector('#'+widget_id+' img', function() {
                    test.assertExists('#'+widget_id+' img');
                    test.assertEquals(
                        this.getElementAttribute('#'+widget_id+' img', 'src'),
                        fixtures.new_src,
                        'Image on homepage is as set in admin'
                    );
                });
            });
        });

    });



    casper.run(function() {
        test.done();
    });
});





