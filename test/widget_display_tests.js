casper.test.begin('Widget displays', 5, function suite(test) {
    casper.start('http://localhost:8080/', function() {
        test.assertExists('.ccc_si_content');
        test.assertExists('.ccc_si_content img');
        test.assertEquals(
            this.getElementAttribute('.ccc_si_content img', 'src'),
            old_src,
            'Shows correct image'
        );
    });

    casper.then(function() {
        test.assertExists('#wp_ccc_status_indicator-4 img');
        test.assertEquals(
            this.getElementAttribute('#wp_ccc_status_indicator-4 img', 'src'),
            old_src,
            'Shows correct image'
        );
    });


    casper.run(function() {
        test.done();
    });
});