# Status Indicator Widget
## Description 
Result of a CCCoders hack
Status indicator

## Tests 
Tests are written with CasperJS and assume that you have the widget installed on Wordpress a local webserver serving on http://localhost:8080/.

Install [CasperJS](http://docs.casperjs.org/en/latest/installation.html#installing-from-homebrew-osx):

    brew update
    brew install casperjs --devel

To run the tests change to the test directory and tell CasperJS to look for all test file in that directory eg

    cd ~/work/status_indicator/test
    casperjs test test/*

Note the tests assume that you
* are running the Wordpress as set up by [VagrantPress](http://vagrantpress.org/)  (ie with username=admin,password=vagrant and base url=http://localhost:8080/)
* have the widget enabled
* are using the widget in at least one sidebar.

## License and Credits
Contributors: cccoders
Tags: status, boinc, etc
License: GNU






