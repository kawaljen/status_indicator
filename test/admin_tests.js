var old_src = 'http://understanding-geek.com/status_indicator/traffic_light_circle_green.png';
var new_src = 'http://understanding-geek.com/status_indicator/traffic_light_circle_green.png';
var endpoint = 'http://understanding-geek.com/status_indicator/status.php';


casper.test.begin('Admin', 5, function suite(test) {
    casper.start('http://localhost:8080/wp-admin/widgets.php', function() {

        test.assertExists('form#loginform');
        casper.then(function() {
            this.fill('form#loginform', {
                'log':   'admin',
                'pwd':    'vagrant'
            }, true);
        });

        casper.then(function() {
            test.assertExists('div[id*=wp_ccc_status_indicator] form');
            //test.assertExists('#widget-wp_ccc_status_indicator-4-up[img]');
            this.fill('div[id*=wp_ccc_status_indicator-4] form', {
                'widget-wp_ccc_status_indicator[4][up][img]':  new_src,
                'widget-wp_ccc_status_indicator[3][endpoint]': endpoint
            }, false);

            this.click('#widget-wp_ccc_status_indicator-4-savewidget');
            test.assertField('widget-wp_ccc_status_indicator[4][up][img]', new_src);
        });

        casper.then(function() {
            this.clickLabel('Visit Site', 'a');
        });

        casper.then(function() {
            this.reload(function() {         // otherwise src doesn't update
                casper.waitForSelector("#wp_ccc_status_indicator-4 img", function() {
                    test.assertExists('#wp_ccc_status_indicator-4 img');
                    test.assertEquals(
                        this.getElementAttribute('#wp_ccc_status_indicator-4 img', 'src'),
                        new_src,
                        'Shows updated image on homepage'
                    );
                });

            });


        });


    });



    casper.run(function() {
        test.done();
    });
});





