var fixtures = {
    'src' : 'http://understanding-geek.com/status_indicator/traffic_light_circle_green.png'
};

casper.test.begin('Widget display on homepage', 2, function suite(test) {
    casper.start('http://localhost:8080/', function() {
        test.assertExists('.Wp_ccc_status_indicator img');
        test.assertEquals(
            this.getElementAttribute('.Wp_ccc_status_indicator img', 'src'),
            fixtures.src,
            'Shows correct image'
        );
    });

    casper.run(function() {
        test.done();
    });
});