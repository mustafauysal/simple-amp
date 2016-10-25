Simple AMP [![Build Status](https://travis-ci.org/mustafauysal/simple-amp.svg?branch=master)](https://travis-ci.org/mustafauysal/simple-amp)
===============

 A simple plugin that generates AMP pages based on current template.

## Description ##

A ridiculously simple yet powerful plugin that automatically generates AMP pages based on current template.

### Features ###

* It is extremely simple, no configuration needed.
* Works for all pages which uses WordPress template.

### Advanced Usage & Filters ###

* If you need conditional check, use `Simple_AMP_Helper::is_amp_endpoint()`
* Default endpoint is `amp` but you can change it via `simple_amp_query_var` filter
* You can modify HTML output by using `simple_amp_html_output` filter
* You can modify AMP output by using `simple_amp_output` filter
* You can use custom template file by using `simple_amp_template` filter
* Use `simple_amp_debug` filter for validation issues and fixes



**PHP requirement**:  This plugin only works with PHP 5.5 and above


### Credits ###

* [AMP](https://wordpress.org/plugins/amp/) plugin for inspiration
* [amp-library](https://github.com/Lullabot/amp-library) for converting HTML to AMP


### Contributing ###
Pull requests are welcome on [Github](https://github.com/mustafauysal/simple-amp)


## Installation ##

Extract the zip file and just drop the contents in the `wp-content/plugins/` directory of your WordPress installation and then activate the Plugin from admin's Plugins page.


## Frequently Asked Questions ##

= Why AMP pages looks ugly? =

You should consider adding some inline css.

= Why it requires PHP 5.5? =

Because, Simple AMP uses [amp-library](https://github.com/Lullabot/amp-library)
