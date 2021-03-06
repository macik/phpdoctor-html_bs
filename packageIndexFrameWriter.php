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

/** This generates the overview-frame.html file used for displaying the list
 * of package links in the upper-left frame in the frame-formatted default
 * output.
 *
 * @package PHPDoctor\Doclets\HtmlBs
 */
class packageIndexFrameWriter extends HTMLWriter
{

    /** Build the package frame index.
     *
     * @param Doclet doclet
     */
    public function packageIndexFrameWriter(&$doclet)
    {

        parent::HTMLWriter($doclet);

        ob_start();

        echo '<body id="frame">', "\n\n";

        echo '<h2>'.$this->_doclet->getHeader()."</h2>\n\n";

        echo "<div class=\"list-group\">\n";
        echo '<a class="list-group-item" href="allitems-frame.html" target="index">All Items</a>'."\n";
        echo "</div>\n\n";

        echo "<div class=\"panel panel-default\"><div class=\"panel-heading\"><h2 class=\"panel-title\">Namespaces</h2></div>\n\n";

        $rootDoc =& $this->_doclet->rootDoc();

        echo "<div class=\"list-group\">\n";
        $packages =& $rootDoc->packages();
        ksort($packages);
        foreach ($packages as $name => $package) {
            echo '<a class="list-group-item" href="'.$package->asPath().'/package-frame.html" target="index">'.$package->name().'</a></li>'."\n";
        }
        echo "</div></div>\n\n";

        echo '</body>', "\n\n";

        $this->_output = ob_get_contents();
        ob_end_clean();

        $this->_write('overview-frame.html', 'Overview', FALSE);

    }

}
