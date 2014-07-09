# Status Indicator Widget
## Description 
Status Indicator is a Wordpress widget to allow Wordpress administrators to display the status of arbitory web services.
Built by [Climate Change Coders](http://www.cccoders.org/) at a hack evening at [Friends of the Earth's offices](http://www.meetup.com/London-Climate-Change-Coders/events/185855322/).


## Tests 
Tests are written with CasperJS and, for the time being, make some assumptions about your testing environment.
Install [CasperJS](http://docs.casperjs.org/en/latest/installation.html#installing-from-homebrew-osx):

    brew update
    brew install casperjs --devel

To run the tests change to the test directory and tell CasperJS to look for all test file in that directory eg

    cd ~/work/status_indicator
    casperjs test test/*

Note the tests assume that you:
* are running the Wordpress as set up by [VagrantPress](http://vagrantpress.org/)  (ie with username=admin, password=vagrant and base url=http://localhost:8080/)  
* have the widget enabled
* are using the widget in at least one sidebar.

## License and Credits
Contributors: [Climate Change Coders](http://www.cccoders.org/)
Tags: status, boinc
License: GNU






