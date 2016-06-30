<?php
/*
PHPDoctor: The PHP Documentation Creator
Copyright (C) 2004 Paul James <paul@peej.co.uk>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/** This generates the package-frame.html file that lists the interfaces and
 * classes in a given package for displaying in the lower-left frame of the
 * frame-formatted default output.
 *
 * @package PHPDoctor\Doclets\HtmlBs
 */
class packageFrameWriter extends HTMLWriter
{

    /** Build the package frame index.
     *
     * @param Doclet doclet
     */
    public function packageFrameWriter(&$doclet)
    {

        parent::HTMLWriter($doclet);

        $rootDoc =& $this->_doclet->rootDoc();

        $this->_output =& $this->_allItems($rootDoc);
        $this->_write('allitems-frame.html', 'All Items', FALSE);

        $packages =& $rootDoc->packages();
        ksort($packages);

        foreach ($packages as $packageName => $package) {

            $this->_depth = $package->depth() + 1;

            $this->_output =& $this->_buildFrame($package);
            $this->_write($package->asPath().'/package-frame.html', $package->name(), FALSE);

        }

    }

    /** Build package frame
     *
     * @return str
     */
    function &_buildFrame(&$package)
    {
        ob_start();

        echo '<body id="frame">', "\n\n";

        echo '<h2><a href="package-summary.html" target="main">', $package->name(), "</a></h2>\n\n";

        $classes =& $package->ordinaryClasses();
        if ($classes && is_array($classes)) {
            ksort($classes);
            echo "<h3>Classes</h3>\n";
            echo "<ul>\n";
            foreach ($classes as $name => $class) {
                echo '<li><a href="', str_repeat('../', $package->depth() + 1), $classes[$name]->asPath(), '" target="main">', $classes[$name]->name(), "</a></li>\n";
            }
            echo "</ul>\n\n";
        }

        $interfaces =& $package->interfaces();
        if ($interfaces && is_array($interfaces)) {
            ksort($interfaces);
            echo "<h3>Interfaces</h3>\n";
            echo "<ul>\n";
            foreach ($interfaces as $name => $interface) {
                echo '<li><a href="', str_repeat('../', $package->depth() + 1), $interfaces[$name]->asPath(), '" target="main">', $interfaces[$name]->name(), "</a></li>\n";
            }
            echo "</ul>\n\n";
        }

        $traits =& $package->traits();
        if ($traits && is_array($traits)) {
            ksort($traits);
            echo "<h3>Traits</h3>\n";
            echo "<ul>\n";
            foreach ($traits as $name => $trait) {
                echo '<li><a href="', str_repeat('../', $package->depth() + 1), $traits[$name]->asPath(), '" target="main">', $traits[$name]->name(), "</a></li>\n";
            }
            echo "</ul>\n\n";
        }

        $exceptions =& $package->exceptions();
        if ($exceptions && is_array($exceptions)) {
            ksort($exceptions);
            echo "<h3>Exceptions</h3>\n";
            echo "<ul>\n";
            foreach ($exceptions as $name => $exception) {
                echo '<li><a href="', str_repeat('../', $package->depth() + 1), $exceptions[$name]->asPath(), '" target="main">', $exceptions[$name]->name(), "</a></li>\n";
            }
            echo "</ul>\n\n";
        }

        $functions =& $package->functions();
        if ($functions && is_array($functions)) {
            ksort($functions);
            echo "<h3>Functions</h3>\n";
            echo "<ul>\n";
            foreach ($functions as $name => $function) {
                echo '<li><a href="', str_repeat('../', $package->depth() + 1), $functions[$name]->asPath(), '" target="main">', $functions[$name]->name(), "</a></li>\n";
            }
            echo "</ul>\n\n";
        }

        $globals =& $package->globals();
        if ($globals && is_array($globals)) {
            ksort($globals);
            echo "<h3>Globals</h3>\n";
            echo "<ul>\n";
            foreach ($globals as $name => $global) {
                echo '<li><a href="', str_repeat('../', $package->depth() + 1), $globals[$name]->asPath(), '" target="main">', $globals[$name]->name(), "</a></li>\n";
            }
            echo "</ul>\n\n";
        }

        echo '</body>', "\n\n";

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /** Build all items frame
     *
     * @return str
     */
    function &_allItems(&$rootDoc)
    {
        ob_start();

        echo '<body id="frame">', "\n\n";

        echo "<h2>All Items</h2>\n\n";

        $classes =& $rootDoc->classes();
        if ($classes) {
            ksort($classes);
            echo '<div class="panel panel-default"><div class="panel-heading"><h3>Classes</h3></div>', "\n";
            echo '<div class="list-group">',"\n";
            foreach ($classes as $name => $class) {
                $package =& $classes[$name]->containingPackage();
                if ($class->isInterface()) {
                    echo '<a class="list-group-item list-group-item-info" href="', $classes[$name]->asPath(), '" title="', $classes[$name]->packageName(),'" target="main"><em>', $classes[$name]->name(), "</em></a>\n";
                } elseif ($class->isTrait()) {
                    echo '<a class="list-group-item list-group-item-warning" href="', $classes[$name]->asPath(), '" title="', $classes[$name]->packageName(),'" target="main"><em>', $classes[$name]->name(), "</em></a>\n";
                } else {
                    echo '<a class="list-group-item" href="', $classes[$name]->asPath(), '" title="', $classes[$name]->packageName(),'" target="main">', $classes[$name]->name(), "</a>\n";
                }
            }
            echo "</div></div>\n\n";
        }

        $functions =& $rootDoc->functions();
        if ($functions) {
            ksort($functions);
            echo '<div class="panel panel-info"><div class="panel-heading"><h3>Functions</h3></div>', "\n";
            echo '<ul class="list-group">',"\n";
            foreach ($functions as $name => $function) {
                $package =& $functions[$name]->containingPackage();
                echo '<li class="list-group-item"><a href="', $package->asPath(), '/package-functions.html#', $functions[$name]->name(), '()" title="', $functions[$name]->packageName(),'" target="main">', $functions[$name]->name(), "</a></li>\n";
            }
            echo "</ul></div>\n\n";
        }

        $globals =& $rootDoc->globals();
        if ($globals) {
            ksort($globals);
            echo '<div class="panel panel-warning"><div class="panel-heading"><h3>Globals</h3></div>', "\n";
            echo '<ul class="list-group">',"\n";
            foreach ($globals as $name => $global) {
                $package =& $globals[$name]->containingPackage();
                echo '<li class="list-group-item"><a href="', $package->asPath(), '/package-globals.html#', $globals[$name]->name(), '" title="', $globals[$name]->packageName(),'" target="main">', $globals[$name]->name(), "</a></li>\n";
            }
            echo "</ul></div>\n\n";
        }

        echo '</body>', "\n\n";

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

}
