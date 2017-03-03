## Live example

http://holidayapi.riccardoravaro.com/

## Installation

install virtualbox and vagrant on your machine.

https://www.virtualbox.org/wiki/Downloads

https://www.vagrantup.com/docs/installation/

Clone the repository and run the virtual machine :

        git clone https://github.com/riccardoravaro/holidayapi.git
        cd holidayapi
        vagrant up
 
add 192.168.10.10 holidayapi.app in your host file 
 
website url http://holidayapi.app/

##  Database data importer

				vagrant ssh
                cd /vagrant/docroot
                php artisan migrate
                php artisan db:seed --class=HolidaysSeeder

Now you can visit the API http://holidayapi.app/api/v1/holidays?country=US&year=2017&month=03

		Parameters
        Required
        countryISO 3166-1 alpha-2 format (BE, BG, BR, CA, CZ, DE, ES, FR, GB, GT, NL, NO, PL, SI, SK or US)
        yearISO 8601 format (CCYY)
        Optional

        month1 or 2 digit month (1-12)
        day1 or 2 digit day (1-31 depending on the month)
        previousreturns the previous holidays based on the date
        upcomingreturns the upcoming holidays based on the date
        prettyprettifies returned results
        bank_holidayshow only official bank holidays
                
## Unit tests
				vagrant ssh
                cd /vagrant/docroot
                touch database/database.sqlite
                phpunit
                
                
