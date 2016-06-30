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

/** This generates the index.html file used for presenting the frame-formated
 * "cover page" of the API documentation.
 *
 * @package PHPDoctor\Doclets\HtmlBs
 */
class htmlWriter
{

    /** The doclet that created this object.
     *
     * @var doclet
     */
    public $_doclet;

    /** The section titles to place in the header and footer.
     *
     * @var str[][]
     */
    public $_sections = NULL;

    /** The directory structure depth. Used to calculate relative paths.
     *
     * @var int
     */
    public $_depth = 0;

    /** The <body> id attribute value, used for selecting style.
     *
     * @var str
     */
    public $_id = 'overview';

    /** The output body.
     *
     * @var str
     */
    public $_output = '';

    /** Writer constructor.
     */
    public function htmlWriter(&$doclet)
    {
        $this->_doclet =& $doclet;
    }

    /** Build the HTML header. Includes doctype definition, <html> and <head>
     * sections, meta data and window title.
     *
     * @return str
     */
    public function _htmlHeader($title)
    {

        $output = $this->_doctype();
        $output .= '<html lang="en">'."\n";
        $output .= "<head>\n\n";

        $output .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'."\n\n";
        $output .= '<meta name="generator" content="PHPDoctor '.$this->_doclet->version().' (http://peej.github.com/phpdoctor/)">'."\n";
        $output .= '<meta name="when" content="'.gmdate('r').'">'."\n\n";

        $output .= <<<HTML
<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="http://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<!-- Compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
HTML;
        $output .= '<link rel="stylesheet" type="text/css" href="'.str_repeat('../', $this->_depth).'stylesheet.css">'."\n";
        $output .= '<link rel="start" href="'.str_repeat('../', $this->_depth).'overview-summary.html">'."\n\n";

        $output .= '<title>';
        if ($title) {
            $output .= $title.' ('.$this->_doclet->windowTitle().')';
        } else {
            $output .= $this->_doclet->windowTitle();
        }
        $output .= "</title>\n\n";
        $output .= "</head>\n";

        return $output;

    }

    /** Get the HTML DOCTYPE for this output
     *
     * @return str
     */
    public function _doctype()
    {
        return '<!DOCTYPE html>'."\n\n";
    }

    /** Build the HTML footer.
   *
   * @return str
   */
    public function _htmlFooter()
    {
        return '</html>';
    }

    /** Build the HTML shell header. Includes beginning of the <body> section,
     * and the page header.
     *
     * @return str
     */
    public function _shellHeader($path)
    {
        $output = '<body id="'.$this->_id.'" onload="parent.document.title=document.title;">'."\n\n";
        $output .= $this->_nav($path);

        return $output;
    }

    /** Build the HTML shell footer. Includes the end of the <body> section, and
     * page footer.
     *
     * @return str
     */
    public function _shellFooter($path)
    {
        $output = $this->_nav($path);
        $output .= "<hr>\n\n";
        $output .= '<p id="footer">'.$this->_doclet->bottom().'</p>'."\n\n";
        $output .= "</body>\n\n";

        return $output;
    }

    /** Build the navigation bar
     *
     * @return str
     */
    public function _nav($path)
    {
$output = <<<HTML
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navmenu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">{$this->_doclet->getHeader()}</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navmenu">
HTML;
    /*    $output .= '<div class="header">'."\n";
        $output .= '<h2>'.$this->_doclet->getHeader()."</h2>\n";*/
        if ($this->_sections) {
            $output .= "<ul class=\"nav navbar-nav\">\n";
            foreach ($this->_sections as $section) {
                if (isset($section['selected']) && $section['selected']) {
                    $output .= '<li class="active"><a href="#">'.$section['title']."</a></li>\n";
                } else {
                    if (isset($section['url'])) {
                        $output .= '<li><a href="'.str_repeat('../', $this->_depth).$section['url'].'">'.$section['title']."</a></li>\n";
                    } else {
                        $output .= '<li class="disabled"><a href="#">'.$section['title'].'</a></li>';
                    }
                }
            }
            $output .= "</ul>\n";
        }

        /*<ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        </ul>*/


        $output .= '<span class="navbar-right"><a class="btn btn-default navbar-btn" href="'.str_repeat('../', $this->_depth).'index.html" target="_top">Frames</a>'."\n";
        $output .= '<a class="btn btn-default navbar-btn" href="'.str_repeat('../', $this->_depth).str_replace('\\', '/', $path).'" target="_top">No frames</a>'."\n";
        $output .= "</span></div>\n</div><!-- /.navbar-collapse -->\n  </div></nav><span class=\"gap\"></span>";

        $thisClass = strtolower(get_class($this));
        if ($thisClass == 'classwriter') {
            $output .= '<div class="small_links">'."\n";
            $output .= 'Summary: <a href="#summary_field">Field</a> | <a href="#summary_method">Method</a> | <a href="#summary_constr">Constr</a>'."\n";
            $output .= 'Detail: <a href="#detail_field">Field</a> | <a href="#detail_method">Method</a> | <a href="#summary_constr">Constr</a>'."\n";
            $output .= "</div>\n";
        } elseif ($thisClass == 'functionwriter') {
            $output .= '<div class="small_links">'."\n";
            $output .= 'Summary: <a href="#summary_function">Function</a>'."\n";
            $output .= 'Detail: <a href="#detail_function">Function</a>'."\n";
            $output .= "</div>\n";
        } elseif ($thisClass == 'globalwriter') {
            $output .= '<div class="small_links">'."\n";
            $output .= 'Summary: <a href="#summary_global">Global</a>'."\n";
            $output .= 'Detail: <a href="#detail_global">Global</a>'."\n";
            $output .= "</div>\n";
        }

        return $output;
    }

    public function _sourceLocation($doc)
    {
        if ($this->_doclet->includeSource()) {
            $url = strtolower(str_replace(DIRECTORY_SEPARATOR, '/', $doc->sourceFilename()));
            echo '<a class="pull-right location" href="', str_repeat('../', $this->_depth), 'source/', $url, '.html#line', $doc->sourceLine(), '">', $doc->location(), "</a>\n\n";
        } else {
            echo '<span class="pull-right location">', $doc->location(), "</span>\n";
        }
    }

    /** Write the HTML page to disk using the given path.
     *
     * @param str path The path to write the file to
     * @param str title The title for this page
     * @param bool shell Include the page shell in the output
     */
    public function _write($path, $title, $shell)
    {
        $phpdoctor =& $this->_doclet->phpdoctor();

        // make directory separators suitable to this platform
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);

        // make directories if they don't exist
        $dirs = explode(DIRECTORY_SEPARATOR, $path);
        array_pop($dirs);
        $testPath = $this->_doclet->destinationPath();
        foreach ($dirs as $dir) {
            $testPath .= $dir.DIRECTORY_SEPARATOR;
            if (!is_dir($testPath)) {
                if (!@mkdir($testPath)) {
                    $phpdoctor->error(sprintf('Could not create directory "%s"', $testPath));
                    exit;
                }
            }
        }

        // write file
        $fp = fopen($this->_doclet->destinationPath().$path, 'w');
        if ($fp) {
            $phpdoctor->message('Writing "'.$path.'"');
            fwrite($fp, $this->_htmlHeader($title));
            if ($shell) fwrite($fp, $this->_shellHeader($path));
            fwrite($fp, $this->_output);
            if ($shell) fwrite($fp, $this->_shellFooter($path));
            fwrite($fp, $this->_htmlFooter());
            fclose($fp);
        } else {
            $phpdoctor->error('Could not write "'.$this->_doclet->destinationPath().$path.'"');
            exit;
        }
    }

    /** Format tags for output.
     *
     * @param Tag[] tags
     * @return str The string representation of the elements doc tags
     */
    public function _processTags(&$tags)
    {
        $tagString = '';
        foreach ($tags as $key => $tag) {
            if ($key != '@text') {
                if (is_array($tag)) {
                    $hasText = FALSE;
                    foreach ($tag as $key => $tagFromGroup) {
                        if ($tagFromGroup->text($this->_doclet) != '') {
                            $hasText = TRUE;
                        }
                    }
                    if ($hasText) {
                        $tagString .= '<dt>'.$tag[0]->displayName().":</dt>\n";
                        foreach ($tag as $tagFromGroup) {
                            $tagString .= '<dd class="group">'.$tagFromGroup->text($this->_doclet)."</dd>\n";
                        }
                    }
                } else {
                    $text = $tag->text($this->_doclet);
                    if ($text != '') {
                        $tagString .= '<dt>'.$tag->displayName().":</dt>\n";
                        $tagString .= '<dd class="text">'.$text."</dd>\n";
                    } elseif ($tag->displayEmpty()) {
                        $tagString .= '<dt>'.$tag->displayName().".</dt>\n";
                    }
                }
            }
        }
        if ($tagString) {
            echo "<dl class=\"dl-horizontal tags\">\n", $tagString, "</dl>\n";
        }
    }

    /** Convert inline tags into a string for outputting.
     *
     * @param Tag tag The text tag to process
     * @param bool first Process first line of tag only
     * @return str The string representation of the elements doc tags
     */
    public function _processInlineTags(&$tag, $first = FALSE)
    {
        $description = '';
        if (is_array($tag)) $tag = $tag[0];
        if (is_object($tag)) {
            if ($first) {
                $tags =& $tag->firstSentenceTags($this->_doclet);
            } else {
                $tags =& $tag->inlineTags($this->_doclet);
            }
            if ($tags) {
                foreach ($tags as $aTag) {
                    if ($aTag) {
                        $description .= $aTag->text($this->_doclet);
                    }
                }
            }

            return $this->_doclet->formatter->toFormattedText($description);
        }

        return NULL;
    }

}
