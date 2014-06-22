casper.test.begin('Widget displays', 3, function suite(test) {
    casper.start('http://localhost:8080/', function() {
        test.assertExists('.ccc_si_content');
        test.assertExists('.ccc_si_content img');
        test.assertEquals(
            this.getElementAttribute('.ccc_si_content img', 'src'),
            "http://understanding-geek.com/status_indicator/traffic_light_circle_green.png"
        );
    }).run(function() {
            test.done();
        });
});

