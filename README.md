# Costing Resource Calculators Plugin
## Run the unit tests
First, download PHPUnit and create the autoloader file (assuming [composer](http://getcomposer.org) is already installed):

```
$ composer install
```

Then, run the unit tests:

```
$ ./vendor/bin/phpunit
PHPUnit 3.7.26 by Sebastian Bergmann.

Configuration read from /Users/coreymcmahon/Sites/CostingResource/phpunit.xml

.....................................................

Time: 248 ms, Memory: 6.00Mb

OK (53 tests, 184 assertions)
```


## Install the plugin
To install the plugin, save the folder contents to the following path under your Wordpress installation:

```
(wordpress folder)/wp-content/plugins/CostingResource
```


Note: the following files and folders **should be omitted** when performing the upload: `.git/`, `tests/`, `vendor/`, `.gitignore`, `README.md`, `composer.lock`, `composer.json`, `phpunit.xml`.


You should then navigate to the **Plugins** menu in the Wordpress administration dashboard, and click **Activate** next to the cutting calculator in the list.


## Using the plugin
Once the plugin is activated, you can use it on a page or post by using the shortcode:

```
[costing_resource_calculators]
```

Make sure the template has enough horizontal space to accommodate the calculator.


## Project layout

```
/             : Root level of the project.
front.php     : The "front controller". All requests for the plugin are passed 
                through here.
index.php     : The Wordpress Plugin metadata file. Creates the shortcode.
bootstrap.php : The bootstrap file. Responsible for including all dependencies.
assets/       : The HTML, JavaScript, images and CSS for generating the user 
                interface for the calculator.
data/         : CSV files that are used for providing the backend data for the 
                calculations.
src/          : The source-code for the calculators.

```


## Adding a New Calculator
There are a number of steps that need to be completed in order to create a new calculator.


### Implement the backend calculator
Create a new folder (and PHP namespace) in `src/CostingResource/` and name it after your new calculator (eg: for ExampleCalculator, use the folder / namespace `Example`). You'll then need to create two files in here:

* `Calculator.php`: implements the calculation process. See `src/SpotWelding/Calculator.php` and `src/Cutting/Calculator.php` and follow the format used there.
* `CsvData.php`: implements the data retrieval process. See `src/SpotWelding/CsvData.php` and `src/Cutting/CsvData.php` and follow the format used there.


### Add the Calculator to the Settings
Open the file `src/CostingResource/Settings.php` and add the name and namespace for the new calculator to the list of static variables. Make sure you also add the new calculator to the function `getCalculatorInstanceFor(...)` so that an instance of the new calculator class is returned.


### Implement the HTML and JavaScript for the Calculator
Create the templates in `/assets/templates` as shown in the `cutting` and `spot_welding` examples. Typically you'll create `index.html.php` which is resposible for rendering the outer elements of the tabs, and then three sub-templates that correspond with each of the tabs.

Calculator specific JavaScript should go in `/assets/js/calculators/[calculator-name]` (this will be automatically included by the plugin), while any event handlers that need to be attached should be done via inline JavaScript in the respective template files. This is so the event handlers are reattached when the form is re-rendered.


### Other notes
Styles go in `/assets/css/styles.css` (no calculator specific stylesheet, just use calculator-specific ID and class attributes). Images can be placed in `/assets/images`.

