# PHPDoctor-HTML_BS

«**HTML_BS**» is a [PHPDoctor](https://github.com/peej/phpdoctor) Doclet to generate documentation in [Bootstrap](http://getbootstrap.com/) styled HTML format.

This Doclet developed on [this forked version](https://github.com/macik/phpdoctor) of original *PHPDoctor* generator and not tested with original package.

«**HTML_BS**» is based on [«standard» doclet](https://github.com/macik/phpdoctor/tree/master/doclets/standard) of PHPDoctor.

*PHPDoctor* itself is a little bit outdated (not support traits for example) but a pretty much useful in doc generation for code with a lot of [Procedural programming](https://en.wikipedia.org/wiki/Procedural_programming) and a number of [@packages](https://manual.phpdoc.org/HTMLSmartyConverter/HandS/phpDocumentor/tutorial_tags.package.pkg.html).

## Install and setup

 * Download [PHPDoctor bundle](https://github.com/macik/phpdoctor/archive/master.zip) (if not done yet) than download [«html_bs» package](https://github.com/macik/phpdoctor-html_bs/releases/) and unpack files in `doclets/html_bs` subfolder of *PHPDoctor*.
 * Make or change [default INI file](https://github.com/macik/phpdoctor/blob/master/examples/phpdoctor.ini) to set «HTML_BS» doclet and text formatter as follows:

	```
	# To use «HTML_BS» as default
	doclet = html_bs

	# Recommended to set up formatter as text for better results
	formatter = textFormatter

	```

 * Configure other options as [PHPDoctor documentation](https://github.com/peej/phpdoctor#configuration) says.

## Sample pages

This doclet developed for [Cotonti CMS](https://www.cotonti.com/) project as replacement for ugly standard HTML doclet.

For a demonstration of generation result for «HTML_BS» doclet you can view [Cotonti API reference](https://www.cotonti.com/reference/) pages.

![image](https://cloud.githubusercontent.com/assets/1009926/16507810/7a3c28b0-3f35-11e6-8b9e-4b8102170edf.png)

## Changelog and versions

Last actual version is [0.5.0](https://github.com/macik/phpdoctor-html_bs/releases/tag/v0.5.0) and working in progress. So you can try last development version. 

## Author and license

Written by Andrew Matsovkin aka [Macik](https://github.com/macik) and distributed under GNU license.

## References

* [PHPDoctor](http://www.peej.co.uk/phpdoctor/) -- Home of PHPDoctor pages
* [macik/phpdoctor](https://github.com/macik/phpdoctor) -- Fork of PHPDoctor tested with «**HTM_BS**»
* [Cotonti API](https://www.cotonti.com/reference/) -- Demo pages with «**HTM_BS**» generated documentation
* [www.cotonti.com](https://www.cotonti.com/) -- Home of Cotonti project inspired creation of «**HTM_BS**»
