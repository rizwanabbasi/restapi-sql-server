# restapi-sql-server
REST API Using PHP Slim Microframework and SQL Server
The following guideline is to set up the environment on localhost using any tool like XAMPP or WAMP
(I have followed this guideline https://www.programmableweb.com/news/how-to-create-rest-api-using-slim-framework/how-to/2017/02/28 to make it work with MySQL)

1. Follow all the steps mentioned in the above URL e.g,
  a. Download and install composer https://getcomposer.org/download/ Windows Installer
  b. Install Slim with Composer (Slim is a micro php framework) https://github.com/slimphp/Slim-      Documentation/blob/master/docs/start/installation.md
	  Next, require the Composer autoloader into your PHP script.
	    <?php
	    require 'vendor/autoload.php';
      
2. I faced problems when it came to configure PHP with SQL Server, It gave me a tough time to install PDO drivers for MS SQL Server. Use phpinfo() to know the version of php you are using and then you need to download respective files. I am using PHP 7.4 so I have download thread safe versions 74 (analogy for PHP 7.4 version) for x64 bit installation of php.
  |a. Download SQL Server Driver for PHP from this Official URL: https://docs.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server?view=sql-server-ver15
  b. Add the following lines to php.ini files and add the respective files to your php ext directory e.g, c>xampp>>php>>ext 
     extension=php_pdo_sqlsrv_74_ts_x64.dll
     extension=php_sqlsrv_74_ts_x64.dll
     
3. Verify the installation by running phpinfo() again and 
  a. Search for 'Registered PHP Streams' and then look for 'sqlsrv' in these     available streams. 
  b. Search for 'PDO drivers' and then look for 'sqlsrv' in available drivers.
  c. Also check if 'sqlsrv support' is Enabled under 'sqlsrv' heading.
  
4. Congratulations, you have successfully set up PHP with MS SQL Server. 
