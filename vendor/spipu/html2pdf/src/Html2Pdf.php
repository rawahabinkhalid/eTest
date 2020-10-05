<?php
/**
 * Html2Pdf Library - main class
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2017 Laurent MINGUET
 */

namespace Spipu\Html2Pdf;

use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ImageException;
use Spipu\Html2Pdf\Exception\LongSentenceException;
use Spipu\Html2Pdf\Exception\TableException;
use Spipu\Html2Pdf\Exception\HtmlParsingException;
use Spipu\Html2Pdf\Extension\Core;
use Spipu\Html2Pdf\Extension\ExtensionInterface;
use Spipu\Html2Pdf\Parsing\HtmlLexer;
use Spipu\Html2Pdf\Parsing\Node;
use Spipu\Html2Pdf\Parsing\TagParser;
use Spipu\Html2Pdf\Parsing\TextParser;
use Spipu\Html2Pdf\Tag\TagInterface;
use Spipu\Html2Pdf\Debug\DebugInterface;
use Spipu\Html2Pdf\Debug\Debug;

require_once dirname(__FILE__) . '/config/tcpdf.config.php';

class Html2Pdf
{
    /**
     * myPdf object, extends from TCPDF
     * @var MyPdf
     */
    public $pdf = null;

    /**
     * CSS parsing
     * @var Parsing\Css
     */
    public $parsingCss = null;

    /**
     * HTML parsing
     * @var Parsing\Html
     */
    public $parsingHtml = null;

    /**
     * @var Debug
     */
    private $debug;

    /**
     * @var HtmlLexer
     */
    private $lexer;

    /**
     * @var CssConverter
     */
    private $cssConverter;

    /**
     * @var SvgDrawer
     */
    private $svgDrawer;

    protected $_langue           = 'fr';        // locale of the messages
    protected $_orientation      = 'P';         // page orientation : Portrait ou Landscape
    protected $_format           = 'A4';        // page format : A4, A3, ...
    protected $_encoding         = '';          // charset encoding
    protected $_unicode          = true;        // means that the input text is unicode (default = true)

    protected $_testTdInOnepage  = true;        // test of TD that can not take more than one page
    protected $_testIsImage      = true;        // test if the images exist or not
    protected $_fallbackImage    = null;        // fallback image to use in img tags

    protected $_parsePos         = 0;           // position in the parsing
    protected $_tempPos          = 0;           // temporary position for complex table
    protected $_page             = 0;           // current page number

    protected $_subHtml          = null;        // sub html
    protected $_subPart          = false;       // sub Html2Pdf
    protected $_subHEADER        = array();     // sub action to make the header
    protected $_subFOOTER        = array();     // sub action to make the footer
    protected $_subSTATES        = array();     // array to save some parameters

    protected $_isSubPart        = false;       // flag : in a sub html2pdf
    protected $_isInThead        = false;       // flag : in a thead
    protected $_isInTfoot        = false;       // flag : in a tfoot
    protected $_isInOverflow     = false;       // flag : in a overflow
    protected $_isInFooter       = false;       // flag : in a footer
    protected $_isInDraw         = null;        // flag : in a draw (svg)
    protected $_isAfterFloat     = false;       // flag : is just after a float
    protected $_isInForm         = false;       // flag : is in a float. false / action of the form
    protected $_isInLink         = '';          // flag : is in a link. empty / href of the link
    protected $_isInParagraph    = false;       // flag : is in a paragraph
    protected $_isForOneLine     = false;       // flag : in a specific sub html2pdf to have the height of the next line

    protected $_maxX             = 0;           // maximum X of the current zone
    protected $_maxY             = 0;           // maximum Y of the current zone
    protected $_maxE             = 0;           // number of elements in the current zone
    protected $_maxH             = 0;           // maximum height of the line in the current zone
    protected $_maxSave          = array();     // save the maximums of the current zone
    protected $_currentH         = 0;           // height of the current line

    protected $_defaultLeft      = 0;           // default marges of the page
    protected $_defaultTop       = 0;
    protected $_defaultRight     = 0;
    protected $_defaultBottom    = 0;
    protected $_defaultFont      = null;        // default font to use, is the asked font does not exist

    protected $_margeLeft        = 0;           // current marges of the page
    protected $_margeTop         = 0;
    protected $_margeRight       = 0;
    protected $_margeBottom      = 0;
    protected $_marges           = array();     // save the different marges of the current page
    protected $_pageMarges       = array();     // float marges of the current page
    protected $_background       = array();     // background informations

    protected $_hideHeader       = array();     // array : list of pages which the header gonna be hidden
    protected $_hideFooter       = array();     // array : list of pages which the footer gonna be hidden
    protected $_firstPage        = true;        // flag : first page
    protected $_defList          = array();     // table to save the stats of the tags UL and OL

    protected $_lstAnchor        = array();     // list of the anchors
    protected $_lstField         = array();     // list of the fields
    protected $_lstSelect        = array();     // list of the options of the current select
    protected $_previousCall     = null;        // last action called

    protected $_sentenceMaxLines = 1000;        // max number of lines for a sentence

    /**
     * @var Html2Pdf
     */
    static protected $_subobj    = null;        // object html2pdf prepared in order to accelerate the creation of sub html2pdf
    static protected $_tables    = array();     // static table to prepare the nested html tables

    /**
     * list of tag definitions
     * @var ExtensionInterface[]
     */
    protected $extensions = array();

    /**
     * List of tag objects
     * @var TagInterface[]
     */
    protected $tagObjects = array();

    /**
     * @var bool
     */
    protected $extensionsLoaded = false;

    /**
     * class constructor
     *
     * @param string  $orientation page orientation, same as TCPDF
     * @param mixed   $format      The format used for pages, same as TCPDF
     * @param string  $lang        Lang : fr, en, it...
     * @param boolean $unicode     TRUE means that the input text is unicode (default = true)
     * @param String  $encoding    charset encoding; default is UTF-8
     * @param array   $margins     Default margins (left, top, right, bottom)
     * @param boolean $pdfa        If TRUE set the document to PDF/A mode.
     *
     * @return Html2Pdf
     */
    public function __construct(
        $orientation = 'P',
        $format = 'A4',
        $lang = 'fr',
        $unicode = true,
        $encoding = 'UTF-8',
        $margins = array(5, 5, 5, 8),
        $pdfa = false
    ) {
        // init the page number
        $this->_page         = 0;
        $this->_firstPage    = true;

        // save the parameters
        $this->_orientation  = $orientation;
        $this->_format       = $format;
        $this->_langue       = strtolower($lang);
        $this->_unicode      = $unicode;
        $this->_encoding     = $encoding;
        $this->_pdfa         = $pdfa;

        // load the Locale
        Locale::load($this->_langue);

        // create the  myPdf object
        $this->pdf = new MyPdf($orientation, 'mm', $format, $unicode, $encoding, false, $pdfa);

        // init the CSS parsing object
        $this->cssConverter = new CssConverter();
        $textParser = new TextParser($encoding);
        $this->parsingCss = new Parsing\Css($this->pdf, new TagParser($textParser), $this->cssConverter);
        $this->parsingCss->fontSet();
        $this->_defList = array();

        // init some tests
        $this->setTestTdInOnePage(true);
        $this->setTestIsImage(true);

        // init the default font
        $this->setDefaultFont(null);

        $this->lexer = new HtmlLexer();
        // init the HTML parsing object
        $this->parsingHtml = new Parsing\Html($textParser);
        $this->_subHtml = null;
        $this->_subPart = false;

        $this->setDefaultMargins($margins);
        $this->setMargins();
        $this->_marges = array();

        // init the form's fields
        $this->_lstField = array();

        $this->svgDrawer = new SvgDrawer($this->pdf, $this->cssConverter);

        $this->addExtension(new Core\HtmlExtension());
        $this->addExtension(new Core\SvgExtension($this->svgDrawer));

        return $this;
    }

    /**
     * Gets the detailed version as array
     *
     * @return array
     */
    public function getVersionAsArray()
    {
        return array(
            'major'     => 5,
            'minor'     => 2,
            'revision'  => 1
        );
    }

    /**
     * Gets the current version as string
     *
     * @return string
     */
    public function getVersion()
    {
        $v = $this->getVersionAsArray();
        return $v['major'].'.'.$v['minor'].'.'.$v['revision'];
    }

    /**
     * Clone to create a sub Html2Pdf from self::$_subobj
     *
     * @access public
     */
    public function __clone()
    {
        $this->pdf = clone $this->pdf;
        $this->parsingHtml = clone $this->parsingHtml;
        $this->parsingCss = clone $this->parsingCss;
        $this->parsingCss->setPdfParent($this->pdf);
    }

    /**
     * Set the max number of lines for a sentence
     *
     * @param int $nbLines
     *
     * @return $this
     */
    public function setSentenceMaxLines($nbLines)
    {
        $this->_sentenceMaxLines = (int) $nbLines;

        return $this;
    }

    /**
     * Get the max number of lines for a sentence
     *
     * @return int
     */
    public function getSentenceMaxLines()
    {
        return $this->_sentenceMaxLines;
    }

    /**
     * @param ExtensionInterface $extension
     */
    public function addExtension(ExtensionInterface $extension)
    {
        $name = strtolower($extension->getName());
        $this->extensions[$name] = $extension;
    }

    /**
     * Get the number of pages
     * @return int
     */
    public function getNbPages()
    {
        return $this->_page;
    }

    /**
     * Initialize the registered extensions
     *
     * @throws Html2PdfException
     */
    protected function loadExtensions()
    {
        if ($this->extensionsLoaded) {
            return;
        }
        foreach ($this->extensions as $extension) {
            foreach ($extension->getTags() as $tag) {
                if (!$tag instanceof TagInterface) {
                    throw new Html2PdfException('The ExtensionInterface::getTags() method must return an array of TagInterface.');
                }
                $this->addTagObject($tag);
            }
        }

        $this->extensionsLoaded = true;
    }

    /**
     * register a tag object
     *
     * @param TagInterface $tagObject the object
     */
    protected function addTagObject(TagInterface $tagObject)
    {
        $tagName = strtolower($tagObject->getName());
        $this->tagObjects[$tagName] = $tagObject;
    }

    /**
     * get the tag object from a tag name
     *
     * @param string $tagName tag name to load
     *
     * @return TagInterface|null
     */
    protected function getTagObject($tagName)
    {
        if (!$this->extensionsLoaded) {
            $this->loadExtensions();
        }

        if (!array_key_exists($tagName, $this->tagObjects)) {
            return null;
        }

        $tagObject = $this->tagObjects[$tagName];
        $tagObject->setParsingCssObject($this->parsingCss);
        $tagObject->setCssConverterObject($this->cssConverter);
        $tagObject->setPdfObject($this->pdf);
        if (!is_null($this->debug)) {
            $tagObject->setDebugObject($this->debug);
        }

        return $tagObject;
    }

    /**
     * set the debug mode to On
     *
     * @param DebugInterface $debugObject
     *
     * @return Html2Pdf $this
     */
    public function setModeDebug(DebugInterface $debugObject = null)
    {
        if (is_null($debugObject)) {
            $this->debug = new Debug();
        } else {
            $this->debug = $debugObject;
        }
        $this->debug->start();

        return $this;
    }

    /**
     * Set the test of TD that can not take more than one page
     *
     * @access public
     * @param  boolean  $mode
     * @return Html2Pdf $this
     */
    public function setTestTdInOnePage($mode = true)
    {
        $this->_testTdInOnepage = $mode ? true : false;

        return $this;
    }

    /**
     * Set the test if the images exist or not
     *
     * @access public
     * @param  boolean  $mode
     * @return Html2Pdf $this
     */
    public function setTestIsImage($mode = true)
    {
        $this->_testIsImage = $mode ? true : false;

        return $this;
    }

    /**
     * Set the default font to use, if no font is specified, or if the asked font does not exist
     *
     * @access public
     * @param  string   $default name of the default font to use. If null : Arial if no font is specified, and error if the asked font does not exist
     * @return Html2Pdf $this
     */
    public function setDefaultFont($default = null)
    {
        $this->_defaultFont = $default;
        $this->parsingCss->setDefaultFont($default);

        return $this;
    }

    /**
     * Set a fallback image
     *
     * @param string $fallback Path or URL to the fallback image
     *
     * @return $this
     */
    public function setFallbackImage($fallback)
    {
        $this->_fallbackImage = $fallback;

        return $this;
    }

    /**
     * add a font, see TCPDF function addFont
     *
     * @access public
     * @param string $family Font family. The name can be chosen arbitrarily. If it is a standard family name, it will override the corresponding font.
     * @param string $style Font style. Possible values are (case insensitive):<ul><li>empty string: regular (default)</li><li>B: bold</li><li>I: italic</li><li>BI or IB: bold italic</li></ul>
     * @param string $file The font definition file. By default, the name is built from the family and style, in lower case with no spaces.
     * @return Html2Pdf $this
     * @see TCPDF::addFont
     */
    public function addFont($family, $style = '', $file = '')
    {
        $this->pdf->AddFont($family, $style, $file);

        return $this;
    }

    /**
     * display a automatic index, from the bookmarks
     *
     * @access public
     * @param  string  $titre         index title
     * @param  int     $sizeTitle     font size of the index title, in mm
     * @param  int     $sizeBookmark  font size of the index, in mm
     * @param  boolean $bookmarkTitle add a bookmark for the index, at his beginning
     * @param  boolean $displayPage   display the page numbers
     * @param  int     $onPage        if null : at the end of the document on a new page, else on the $onPage page
     * @param  string  $fontName      font name to use
     * @param  string  $marginTop     margin top to use on the index page
     * @return null
     */
    public function createIndex(
        $titre = 'Index',
        $sizeTitle = 20,
        $sizeBookmark = 15,
        $bookmarkTitle = true,
        $displayPage = true,
        $onPage = null,
        $fontName = null,
        $marginTop = null
    ) {
        if ($fontName === null) {
            $fontName = 'helvetica';
        }

        $oldPage = $this->_INDEX_NewPage($onPage);

        if ($marginTop !== null) {
            $marginTop = $this->cssConverter->convertToMM($marginTop);
            $this->pdf->SetY($this->pdf->GetY() + $marginTop);
        }

        $this->pdf->createIndex($this, $titre, $sizeTitle, $sizeBookmark, $bookmarkTitle, $displayPage, $onPage, $fontName);
        if ($oldPage) {
            $this->pdf->setPage($oldPage);
        }
    }

    /**
     * clean up the objects, if the method output can not be called because of an exception
     *
     * @return Html2Pdf
     */
    public function clean()
    {
        self::$_subobj = null;
        self::$_tables = array();

        Locale::clean();

        return $this;
    }

    /**
     * Send the document to a given destination: string, local file or browser.
     * Dest can be :
     *  I : send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
     *  D : send to the browser and force a file download with the name given by name.
     *  F : save to a local server file with the name given by name.
     *  S : return the document as a string (name is ignored).
     *  FI: equivalent to F + I option
     *  FD: equivalent to F + D option
     *  E : return the document as base64 mime multi-part email attachment (RFC 2045)
     *
     * @param string $name The name of the file when saved.
     * @param string $dest Destination where to send the document.
     *
     * @throws Html2PdfException
     * @return string content of the PDF, if $dest=S
     * @see    TCPDF::close
     */
    public function output($name = 'document.pdf', $dest = 'I')
    {
        // if on debug mode
        if (!is_null($this->debug)) {
            $this->debug->stop();
            $this->pdf->Close();
            return '';
        }

    