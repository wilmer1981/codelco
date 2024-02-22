<?phpphp

$ver = split('\.', phpversion());
$ver = $ver[0] * 10000 + $ver[1] * 100 + $ver[2];
if ($ver < 40004)
	die("ChartDirector PHP API only supports PHP Ver 4.0.4 or above. Your PHP version is ".phpversion().".");

if (!extension_loaded("ChartDirector PHP API"))
{
	if ($ver >= 40201)
		$ext = "phpchartdir421.dll";
	else if ($ver >= 40100)
		$ext = "phpchartdir410.dll";
	else if ($ver >= 40005)
		$ext = "phpchartdir405.dll";
	else
		$ext = "phpchartdir404.dll";

	if (!dl($ext))
	{ ?>
<br><br>Please make sure you have copied all ChartDirector PHP extension files to your PHP extension 
subdirectory.<br><br>

Your PHP extension directory is currently configured as "<?phpphp echo get_cfg_var("extension_dir")?>". If it is
a relative path name, please make sure you know where it is relative to. It could be relative to the PHP 
executable, Apache executable, or some other directory, depending on your system configuration. To avoid 
confusion, you may want to modify your PHP configuration to use an absolute path name instead.<br><br>

Please also make sure the web server anonymous user has sufficient privileges to read and execute the 
ChartDirector PHP extension files.<br><br>

If the problem persists, please email this entire web page to <a href="mailto:support@advsofteng.com">
support@advsofteng.com</a> for support.

<?phpphp
		die();
	}
}

$dllVersion = callmethod("getVersion");
if (($dllVersion & 0x7fff0000) != 0x02050000)
{
	$majorDllVer = ($dllVersion >> 24) & 0xff;
	$minorDllVer = ($dllVersion >> 16) & 0xff;
	die("Version mismatch - \"phpchartdir.php\" is of Ver 2.5, but \"chartdir.dll/libchartdir.so\" is of Ver $majorDllVer.$minorDllVer");
}

#///////////////////////////////////////////////////////////////////////////////////
#//	implement destructor handling
#///////////////////////////////////////////////////////////////////////////////////
$garbage = array();
function autoDestroy($me) {
	global $garbage;
	$garbage[] = $me;
}
function garbageCollector() {
	global $garbage;
	reset($garbage);
    while (list(, $obj) = each($garbage))
        $obj->__del__();
    $garbage = array();
}
register_shutdown_function("garbageCollector");


#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to libgraphics.h
#///////////////////////////////////////////////////////////////////////////////////
define("BottomLeft", 1);
define("BottomCenter", 2);
define("BottomRight", 3);
define("Left", 4);
define("Center", 5);
define("Right", 6);
define("TopLeft", 7);
define("TopCenter", 8);
define("TopRight", 9);
define("Top", TopCenter);
define("Bottom", BottomCenter);

define("NoAntiAlias", 0);
define("AntiAlias", 1);
define("AutoAntiAlias", 2);

define("DashLine", 0x0505);
define("DotLine", 0x0202);
define("DotDashLine", 0x05050205);
define("AltDashLine", 0x0A050505);

$goldGradient = array(0, 0xFFE743, 0x60, 0xFFFFE0, 0xB0, 0xFFF0B0, 0x100, 0xFFE743);
$silverGradient = array(0, 0xC8C8C8, 0x60, 0xF8F8F8, 0xB0, 0xE0E0E0, 0x100, 0xC8C8C8);
$redMetalGradient = array(0, 0xE09898, 0x60, 0xFFF0F0, 0xB0, 0xF0D8D8, 0x100, 0xE09898);
$blueMetalGradient = array(0, 0x9898E0, 0x60, 0xF0F0FF, 0xB0, 0xD8D8F0, 0x100, 0x9898E0);
$greenMetalGradient = array(0, 0x98E098, 0x60, 0xF0FFF0, 0xB0, 0xD8F0D8, 0x100, 0x98E098);
function goldGradient() { global $goldGradient; return $goldGradient; }
function silverGradient() { global $silverGradient; return $silverGradient; }
function redMetalGradient() { global $redMetalGradient; return $redMetalGradient; }
function blueMetalGradient() { global $blueMetalGradient; return $blueMetalGradient; }
function greenMetalGradient() { global $greenMetalGradient; return $greenMetalGradient; }

class TTFText
{
	function TTFText($ptr) {
		$this->ptr = $ptr;
		autoDestroy($this);
	}
	function __del__() {
		callmethod("TTFText.destroy", $this->ptr);
	}
	function getWidth() {
		return callmethod("TTFText.getWidth", $this->ptr);
	}
	function getHeight() {
		return callmethod("TTFText.getHeight", $this->ptr);
	}
	function getLineHeight() {
		return callmethod("TTFText.getLineHeight", $this->ptr);
	}
	function getLineDistance() {
		return callmethod("TTFText.getLineDistance", $this->ptr);
	}
	function draw($x, $y, $color, $alignment) {
		callmethod("TTFText.draw", $this->ptr, $x, $y, $color, $alignment);
	}
}

define("TryPalette", 0);
define("ForcePalette", 1);
define("NoPalette", 2);
define("Quantize", 0);
define("OrderedDither", 1);
define("ErrorDiffusion", 2);

class DrawArea {
	function DrawArea($ptr = Null) {
		if ($ptr == Null) {
			$this->ptr = callmethod("DrawArea.create");
			autoDestroy($this);
		}
		else {
			$this->ptr = $ptr;
		}
	}
	function __del__() {
		callmethod("DrawArea.destroy", $this->ptr);
	}
	function setSize($width, $height, $bgColor = 0xffffff) {
		callmethod("DrawArea.setSize", $this->ptr, $width, $height, $bgColor);
	}
	function getWidth() {
		return callmethod("DrawArea.getWidth", $this->ptr);
	}
	function getHeight() {
		return callmethod("DrawArea.getHeight", $this->ptr);
	}
	function setBgColor($c) {
		callmethod("DrawArea.setBgColor", $this->ptr, $c);
	}
	function pixel($x, $y, $c) {
		callmethod("DrawArea.pixel", $this->ptr, $x, $y, $c);
	}
	function getPixel($x, $y) {
		return callmethod("DrawArea.getPixel", $this->ptr, $x, $y);
	}
	function hline($x1, $x2, $y, $c) {
		callmethod("DrawArea.hline", $this->ptr, $x1, $x2, $y, $c);
	}
	function vline($y1, $y2, $x, $c) {
		callmethod("DrawArea.vline", $this->ptr, $y1, $y2, $x, $c);
	}
	function line($x1, $y1, $x2, $y2, $c, $lineWidth = 1) {
		callmethod("DrawArea.line", $this->ptr, $x1, $y1, $x2, $y2, $c, $lineWidth);
	}
	function arc($cx, $cy, $rx, $ry, $a1, $a2, $c) {
		callmethod("DrawArea.arc", $this->ptr, $cx, $cy, $rx, $ry, $a1, $a2, $c);
	}
	function rect($x1, $y1, $x2, $y2, $edgeColor, $fillColor, $raisedEffect = 0) {
		callmethod("DrawArea.rect", $this->ptr, $x1, $y1, $x2, $y2, $edgeColor, $fillColor, $raisedEffect);
	}
	function polygon($points, $edgeColor, $fillColor) {
		$x = array();
		$y = array();
		reset($points);
		while (list(, $coor) = each($points)) {
			$x[] = $coor[0];
			$y[] = $coor[1];
		}
		callmethod("DrawArea.polygon", $this->ptr, $x, $y, $edgeColor, $fillColor);
	}
	function surface($x1, $y1, $x2, $y2, $depthX, $depthY, $edgeColor, $fillColor) {
		callmethod("DrawArea.surface", $this->ptr, $x1, $y1, $x2, $y2, $depthX, $depthY, $edgeColor, $fillColor);
	}
	function sector($cx, $cy, $rx, $ry, $a1, $a2, $edgeColor, $fillColor) {
		callmethod("DrawArea.sector", $this->ptr, $cx, $cy, $rx, $ry, $a1, $a2, $edgeColor, $fillColor);
	}
	function cylinder($cx, $cy, $rx, $ry, $a1, $a2, $depthX, $depthY, $edgeColor, $fillColor) {
		callmethod("DrawArea.cylinder", $this->ptr, $cx, $cy, $rx, $ry, $a1, $a2, $depthX, $depthY, $edgeColor, $fillColor);
	}
	function circle($cx, $cy, $rx, $ry, $edgeColor, $fillColor) {
		callmethod("DrawArea.circle", $this->ptr, $cx, $cy, $rx, $ry, $edgeColor, $fillColor);
	}
	function circleShape($cx, $cy, $rx, $ry, $edgeColor, $fillColor) {
		callmethod("DrawArea.circle", $this->ptr, $cx, $cy, $rx, $ry, $edgeColor, $fillColor);
	}
	function fill($x, $y, $color, $borderColor = Null) {
		if ($borderColor == Null)
			callmethod("DrawArea.fill", $this->ptr, $x, $y, $color);
		else
			$this->fill2($x, $y, $color, $borderColor);
	}
	function fill2($x, $y, $color, $borderColor) {
		callmethod("DrawArea.fill2", $this->ptr, $x, $y, $color, $borderColor);
	}
	function text($str, $font, $fontSize, $x, $y, $color) {
		callmethod("DrawArea.text", $this->ptr, $str, $font, $fontSize, $x, $y, $color);
	}
	function text2($str, $font, $fontIndex, $fontHeight, $fontWidth, $angle, $vertical, $x, $y, $color, $alignment = TopLeft) {
		callmethod("DrawArea.text2", $this->ptr, $str, $font, $fontIndex, $fontHeight, $fontWidth, $angle, $vertical, $x, $y, $color, $alignment);
	}
	function text3($str, $font, $fontSize) {
		return new TTFText(callmethod("DrawArea.text3", $this->ptr, $str, $font, $fontSize));
	}
	function text4($text, $font, $fontIndex, $fontHeight, $fontWidth, $angle, $vertical) {
		return new TTFText(callmethod("DrawArea.text4", $this->ptr, $text, $font, $fontIndex, $fontHeight, $fontWidth, $angle, $vertical));
	}
	function merge($d, $x, $y, $align, $transparency) {
		callmethod("DrawArea.merge", $this->ptr, $d->ptr, $x, $y, $align, $transparency);
	}
	function tile($d, $transparency) {
		callmethod("DrawArea.tile", $this->ptr, $d->ptr, $transparency);
	}
	function loadGIF($filename) {
		return callmethod("DrawArea.loadGIF", $this->ptr, $filename);
	}
	function loadPNG($filename) {
		return callmethod("DrawArea.loadPNG", $this->ptr, $filename);
	}
	function loadJPG($filename) {
		return callmethod("DrawArea.loadJPG", $this->ptr, $filename);
	}
	function loadWMP($filename) {
		return callmethod("DrawArea.loadWMP", $this->ptr, $filename);
	}
	function load($filename) {
		return callmethod("DrawArea.load", $this->ptr, $filename);
	}
	function out($filename) {
		return callmethod("DrawArea.out", $this->ptr, $filename);
	}
	function outGIF($filename) {
		return callmethod("DrawArea.outGIF", $this->ptr, $filename);
	}
	function outPNG($filename) {
		return callmethod("DrawArea.outPNG", $this->ptr, $filename);
	}
	function outJPG($filename, $quality = 80) {
		return callmethod("DrawArea.outJPG", $this->ptr, $filename, $quality);
	}
	function outWMP($filename) {
		return callmethod("DrawArea.outWMP", $this->ptr, $filename);
	}
	function outGIF2() {
		return callmethod("DrawArea.outGIF2", $this->ptr);
	}
	function outPNG2() {
		return callmethod("DrawArea.outPNG2", $this->ptr);
	}
	function outJPG2($quality = 80) {
		return callmethod("DrawArea.outJPG2", $this->ptr, $quality);
	}
	function outWMP2() {
		return callmethod("DrawArea.outWMP2", $this->ptr);
	}
	function setPaletteMode($p) {
		callmethod("DrawArea.setPaletteMode", $this->ptr, $p);
	}
	function setDitherMethod($m) {
		callmethod("DrawArea.setDitherMethod", $this->ptr, $m);
	}
	function setTransparentColor($c) {
		callmethod("DrawArea.setTransparentColor", $this->ptr, $c);
	}
	function setAntiAliasText($a) {
		callmethod("DrawArea.setAntiAliasText", $this->ptr, $a);
	}
	function setInterlace($i) {
		callmethod("DrawArea.setInterlace", $this->ptr, $i);
	}
	function setColorTable($colors, $offset) {
		callmethod("DrawArea.setColorTable", $this->ptr, $colors, $offset);
	}
	function getARGBColor($c) {
		return callmethod("DrawArea.getARGBColor", $this->ptr, $c);
	}
	function dashLineColor($color, $dashPattern) {
		return callmethod("DrawArea.dashLineColor", $this->ptr, $colors, $dashPattern);
	}
	function patternColor($c, $h = 0, $startX = 0, $startY = 0) {
 		if (!is_array($c))
	        return $this->patternColor2($c, $h, $startX);
 		return callmethod("DrawArea.patternColor", $this->ptr, $c, $h, $startX, $startY);
    }
	function patternColor2($filename, $startX = 0, $startY = 0) {
		return callmethod("DrawArea.patternColor2", $this->ptr, $filename, $startX, $startY);
	}
	function gradientColor($startX, $startY = 90, $endX = 1, $endY = 0, $startColor = 0, $endColor = Null) {
		if (is_array($startX))
			return $this->gradientColor2($startX, $startY, $endX, $endY, $startColor);
		return callmethod("DrawArea.gradientColor", $this->ptr, $startX, $startY, $endX, $endY, $startColor, $endColor);
	}
	function gradientColor2($c, $angle = 90, $scale = 1, $startX = 0, $startY = 0) {
		return callmethod("DrawArea.gradientColor2", $this->ptr, $c, $angle, $scale, $startX, $startY);
    }
    function halfColor($c) {
		return callmethod("DrawArea.halfColor", $this->ptr, $c);
    }
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to drawobj.h
#///////////////////////////////////////////////////////////////////////////////////
define("Transparent", 0xff000000);
define("Palette", 0xffff0000);
define("BackgroundColor", 0xffff0000);
define("LineColor", 0xffff0001);
define("TextColor", 0xffff0002);
define("DataColor", 0xffff0008);
define("SameAsMainColor", 0xffff0007);

class Box {
	function Box($ptr) {
		$this->ptr = $ptr;
	}
	function setPos($x, $y) {
		callmethod("Box.setPos", $this->ptr, $x, $y);
	}
	function setSize($w, $h) {
		callmethod("Box.setSize", $this->ptr, $w, $h);
	}
	function setBackground($color, $edgeColor = -1, $raisedEffect = 0) {
		callmethod("Box.setBackground", $this->ptr, $color, $edgeColor, $raisedEffect);
	}
	function getImageCoor() {
		return callmethod("Box.getImageCoor", $this->ptr);
	}
}

class TextBox extends Box {
	function TextBox($ptr) {
		$this->ptr = $ptr;
	}
	function setText($text) {
		callmethod("TextBox.setText", $this->ptr, $text);
	}
	function setAlignment($a) {
		callmethod("TextBox.setAlignment", $this->ptr, $a);
	}
	function setFontStyle($font, $fontIndex = 0) {
		callmethod("TextBox.setFontStyle", $this->ptr, $font, $fontIndex);
	}
	function setFontSize($fontHeight, $fontWidth = 0) {
		callmethod("TextBox.setFontSize", $this->ptr, $fontHeight, $fontWidth);
	}
	function setFontAngle($angle, $vertical = 0) {
		callmethod("TextBox.setFontAngle", $this->ptr, $angle, $vertical);
	}
	function setFontColor($color) {
		callmethod("TextBox.setFontColor", $this->ptr, $color);
	}
	function setMargin2($leftMargin, $rightMargin, $topMargin, $bottomMargin) {
		callmethod("TextBox.setMargin2", $this->ptr,
			$leftMargin, $rightMargin, $topMargin, $bottomMargin);
	}
	function setMargin($m) {
		callmethod("TextBox.setMargin", $this->ptr, $m);
	}
}

class Line {
	function Line($ptr) {
		$this->ptr = $ptr;
	}
	function setPos($x1, $y1, $x2, $y2) {
		callmethod("Line.setPos", $this->ptr, $x1, $y1, $x2, $y2);
	}
	function setColor($c) {
		callmethod("Line.setColor", $this->ptr, $c);
	}
	function setWidth($w) {
		callmethod("Line.setWidth", $this->ptr, $w);
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to basechart.h
#///////////////////////////////////////////////////////////////////////////////////
class LegendBox extends TextBox {
	function LegendBox($ptr) {
		$this->ptr = $ptr;
	}
	function addKey($text, $color) {
		callmethod("LegendBox.addKey", $this->ptr, $text, $color);
	}
	function setKeySize($width, $height = -1, $gap = -1) {
		callmethod("LegendBox.setKeySize", $this->ptr, $width, $height, $gap);
	}
	function getImageCoor2($dataItem) {
		return callmethod("LegendBox.getImageCoor", $this->ptr, $dataItem);
	}
	function getHTMLImageMap($url, $queryFormat = "", $extraAttr = "") {
		return callmethod("LegendBox.getHTMLImageMap", $this->ptr, $url, $queryFormat, $extraAttr);
	}
}

define("PNG", 0);
define("GIF", 1);
define("JPG", 2);
define("WMP", 3);

class BaseChart {
	function __del__() {
		callmethod("BaseChart.destroy", $this->ptr);
	}
	#//////////////////////////////////////////////////////////////////////////////////////
	#//	set overall chart
	#//////////////////////////////////////////////////////////////////////////////////////
	function setSize($width, $height) {
		callmethod("BaseChart.setSize", $this->ptr, $width, $height);
	}
	function setBorder($color) {
		callmethod("BaseChart.setBorder", $this->ptr, $color);
	}
	function setBackground($bgColor, $edgeColor = -1, $raisedEffect = 0) {
		callmethod("BaseChart.setBackground", $this->ptr, $bgColor, $edgeColor, $raisedEffect);
	}
	function setWallpaper($img) {
		callmethod("BaseChart.setWallpaper", $this->ptr, $img);
	}
	function setBgImage($img, $align = Center) {
		callmethod("BaseChart.setBgImage", $this->ptr, $img, $align);
	}
	function setTransparentColor($c) {
		callmethod("BaseChart.setTransparentColor", $this->ptr, $c);
	}
	function addTitle2($alignment, $text, $font = "", $fontSize = 12, $fontColor = TextColor,
		$bgColor = Transparent, $edgeColor = Transparent) {
		return new TextBox(callmethod("BaseChart.addTitle2", $this->ptr,
			$alignment, $text, $font, $fontSize, $fontColor, $bgColor, $edgeColor));
	}
	function addTitle($text, $font = "", $fontSize = 12, $fontColor = TextColor,
		$bgColor = Transparent, $edgeColor = Transparent) {
		return new TextBox(callmethod("BaseChart.addTitle", $this->ptr,
			$text, $font, $fontSize, $fontColor, $bgColor, $edgeColor));
	}
	function addLegend($x, $y, $vertical = 1, $font = "", $fontSize = 10) {
		return new LegendBox(callmethod("BaseChart.addLegend", $this->ptr,
			$x, $y, $vertical, $font, $fontSize));
	}
	function getLegend() {
		return new LegendBox(callmethod("BaseChart.getLegend", $this->ptr));
	}
	#//////////////////////////////////////////////////////////////////////////////////////
	#//	drawing primitives
	#//////////////////////////////////////////////////////////////////////////////////////
	function getDrawArea() {
		return new DrawArea(callmethod("BaseChart.getDrawArea", $this->ptr));
	}
	function addDrawObj($obj) {
		callmethod("BaseChart.addDrawObj", $obj->ptr);
		return $obj;
	}
	function addText($x, $y, $text, $font = "", $fontSize = 8, $fontColor = TextColor,
		$alignment = TopLeft, $angle = 0, $vertical = 0) {
		return new TextBox(callmethod("BaseChart.addText", $this->ptr,
			$x, $y, $text, $font, $fontSize, $fontColor, $alignment, $angle, $vertical));
	}
	function addLine($x1, $y1, $x2, $y2, $color = LineColor, $lineWidth = 1) {
		return new Line(callmethod("BaseChart.addLine", $this->ptr,
			$x1, $y1, $x2, $y2, $color, $lineWidth));
	}
	#//////////////////////////////////////////////////////////////////////////////////////
	#//	$color management methods
	#//////////////////////////////////////////////////////////////////////////////////////
	function setColor($paletteEntry, $color) {
		callmethod("BaseChart.setColor", $this->ptr, $paletteEntry, $color);
	}
	function setColors($colors) {
		if (count($colors) <= 0 or $colors[count($colors) - 1] != -1)
			$colors[] = -1;
		callmethod("BaseChart.setColors", $this->ptr, $colors);
	}
	function setColors2($paletteEntry, $colors) {
		if (count($colors) <= 0 or $colors[count($colors) - 1] != -1 )
			$colors[] = -1;
		callmethod("BaseChart.setColors2", $this->ptr, $paletteEntry, $colors);
	}
	function getColor($paletteEntry) {
		return callmethod("BaseChart.getColor", $this->ptr, $paletteEntry);
	}
	function dashLineColor($color, $dashPattern) {
		return callmethod("BaseChart.dashLineColor", $this->ptr, $colors, $dashPattern);
	}
	function patternColor($c, $h = 0, $startX = 0, $startY = 0) {
	    if (!is_array($c))
	        return $this->patternColor2($c, $h, $startX);
		return callmethod("BaseChart.patternColor", $this->ptr, $c, $h, $startX, $startY);
    }
	function patternColor2($filename, $startX = 0, $startY = 0) {
		return callmethod("BaseChart.patternColor2", $this->ptr, $filename, $startX, $startY);
	}
    function gradientColor($startX, $startY = 90, $endX = 1, $endY = 0, $startColor = 0, $endColor = Null) {
		if (is_array($startX))
			return $this->gradientColor2($startX, $startY, $endX, $endY, $startColor);
		return callmethod("BaseChart.gradientColor", $this->ptr, $startX, $startY, $endX, $endY, $startColor, $endColor);
	}
	function gradientColor2($c, $angle = 90, $scale = 1, $startX = 0, $startY = 0) {
		return callmethod("BaseChart.gradientColor2", $this->ptr, $c, $angle, $scale, $startX, $startY);
    }

	#//////////////////////////////////////////////////////////////////////////////////////
	#//	chart creation methods
	#//////////////////////////////////////////////////////////////////////////////////////
	function layout() {
		callmethod("BaseChart.layout", $this->ptr);
	}
	function makeChart($filename) {
		return callmethod("BaseChart.makeChart", $this->ptr, $filename);
	}
	function makeChart2($format) {
		return callmethod("BaseChart.makeChart2", $this->ptr, $format);
	}
	function makeChart3() {
		return new DrawArea(callmethod("BaseChart.makeChart3", $this->ptr));
	}
	function getHTMLImageMap($url, $queryFormat = "", $extraAttr = "") {
		return callmethod("BaseChart.getHTMLImageMap", $this->ptr, $url, $queryFormat, $extraAttr);
	}
	function halfColor($c) {
		return callmethod("BaseChart.halfColor", $this->ptr, $c);
	}
	function autoColor() {
		return callmethod("BaseChart.autoColor", $this->ptr);
	}
}

$defaultPalette = array(
	0xffffff, 0x000000, 0x000000, 0x808080,
	0x808080, 0x808080, 0x808080, 0x808080,
	0xff3333, 0x33ff33, 0x6666ff, 0xffff00,
	0xff66ff, 0x99ffff,	0xffcc33, 0xcccccc,
	0xcc9999, 0x339966, 0x999900, 0xcc3300,
	0x669999, 0x993333, 0x006600, 0x990099,
	0xff9966, 0x99ff99, 0x9999ff, 0xcc6600,
	0x33cc33, 0xcc99ff, 0xff6666, 0x99cc66,
	0x009999, 0xcc3333, 0x9933ff, 0xff0000,
	0x0000ff, 0x00ff00, 0xffcc99, 0x999999,
	-1
);
function defaultPalette() { global $defaultPalette; return $defaultPalette; }

$whiteOnBlackPalette = array(
	0x000000, 0xffffff, 0xffffff, 0x808080,
	0x808080, 0x808080, 0x808080, 0x808080,
	0xff0000, 0x00ff00, 0x0000ff, 0xffff00,
	0xff00ff, 0x66ffff,	0xffcc33, 0xcccccc,
	0x9966ff, 0x339966, 0x999900, 0xcc3300,
	0x99cccc, 0x006600, 0x660066, 0xcc9999,
	0xff9966, 0x99ff99, 0x9999ff, 0xcc6600,
	0x33cc33, 0xcc99ff, 0xff6666, 0x99cc66,
	0x009999, 0xcc3333, 0x9933ff, 0xff0000,
	0x0000ff, 0x00ff00, 0xffcc99, 0x999999,
	-1
);
function whiteOnBlackPalette() { global $whiteOnBlackPalette; return $whiteOnBlackPalette; }

$transparentPalette = array(
	0xffffff, 0x000000, 0x000000, 0x808080,
	0x808080, 0x808080, 0x808080, 0x808080,
	0x80ff0000, 0x8000ff00, 0x800000ff, 0x80ffff00,
	0x80ff00ff, 0x8066ffff,	0x80ffcc33, 0x80cccccc,
	0x809966ff, 0x80339966, 0x80999900, 0x80cc3300,
	0x8099cccc, 0x80006600, 0x80660066, 0x80cc9999,
	0x80ff9966, 0x8099ff99, 0x809999ff, 0x80cc6600,
	0x8033cc33, 0x80cc99ff, 0x80ff6666, 0x8099cc66,
	0x80009999, 0x80cc3333, 0x809933ff, 0x80ff0000,
	0x800000ff, 0x8000ff00, 0x80ffcc99, 0x80999999,
	-1
);
function transparentPalette() { global $transparentPalette; return $transparentPalette; }

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to piechart.h
#///////////////////////////////////////////////////////////////////////////////////

define("SideLayout", 0);
define("CircleLayout", 1);

class Sector {
	function Sector($ptr) {
		$this->ptr = $ptr;
	}
	function setExplode($distance = -1) {
		callmethod("Sector.setExplode", $this->ptr, $distance);
	}
	function setLabelFormat($formatString) {
		callmethod("Sector.setLabelFormat", $this->ptr, $formatString);
	}
	function setLabelStyle($font = "", $fontSize = 8, $fontColor = TextColor) {
		return new TextBox(callmethod("Sector.setLabelStyle", $this->ptr, $font, $fontSize, $fontColor));
	}
	function setLabelPos($pos, $joinLineColor = -1) {
		callmethod("Sector.setLabelPos", $this->ptr, $pos, $joinLineColor);
	}
	function setColor($color, $edgeColor = -1, $joinLineColor = -1) {
		callmethod("Sector.setColor", $this->ptr, $color, $edgeColor, $joinLineColor);
	}
	function getImageCoor() {
		return callmethod("Sector.getImageCoor", $this->ptr);
	}
	function getLabelCoor() {
		return callmethod("Sector.getLabelCoor", $this->ptr);
	}
	function setLabelLayout($layoutMethod, $pos = -1) {
		callmethod("Sector.setLabelLayout", $this->ptr, $layoutMethod, $pos);
	}
}

class PieChart extends BaseChart {
	function PieChart($width, $height, $bgColor = BackgroundColor, $edgeColor = Transparent) {
		$this->ptr = callmethod("PieChart.create", $width, $height, $bgColor, $edgeColor);
		autoDestroy($this);
	}
	function setPieSize($x, $y, $r) {
		callmethod("PieChart.setPieSize", $this->ptr, $x, $y, $r);
	}
	function set3D($depth = -1, $angle = -1, $shadowMode = 0) {
		callmethod("PieChart.set3D", $this->ptr, $depth, $angle, $shadowMode);
	}
	function setStartAngle($startAngle, $clockWise = 1) {
		callmethod("PieChart.setStartAngle", $this->ptr, $startAngle, $clockWise);
	}
	function setLabelFormat($formatString) {
		callmethod("PieChart.setLabelFormat", $this->ptr, $formatString);
	}
	function setLabelStyle($font = "", $fontSize = 8, $fontColor = TextColor) {
		return new TextBox(callmethod("PieChart.setLabelStyle", $this->ptr, $font,
			$fontSize, $fontColor));
	}
	function setLabelPos($pos, $joinLineColor = -1) {
		callmethod("PieChart.setLabelPos", $this->ptr, $pos, $joinLineColor);
	}
	function setData($data, $labels = Null) {
		callmethod("PieChart.setData", $this->ptr, $data, $labels);
	}
	function sector($sectorNo) {
		return new Sector(callmethod("PieChart.sector", $this->ptr, $sectorNo));
	}
	function setLabelLayout($layoutMethod, $pos = -1, $topBound = -1, $bottomBound = -1) {
		callmethod("PieChart.setLabelLayout", $this->ptr, $layoutMethod, $pos, $topBound, $bottomBound);
	}
	function setLineColor($edgeColor, $joinLineColor = -1) {
		callmethod("PieChart.setLineColor", $this->ptr, $edgeColor, $joinLineColor);
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to axis.h
#///////////////////////////////////////////////////////////////////////////////////
class BaseAxis {
	function BaseAxis($ptr) {
		$this->ptr = $ptr;
	}
	function setLabelStyle($font, $fontSize = 8, $fontColor = TextColor, $fontAngle = 0) {
		return new TextBox(callmethod("BaseAxis.setLabelStyle", $this->ptr, $font, $fontSize, $fontColor, $fontAngle));
	}
	function setLabelGap($d) {
		callmethod("BaseAxis.setLabelGap", $this->ptr, $d);
	}
	function setTitle($text, $font = "arialbd.ttf", $fontSize = 8, $fontColor = TextColor) {
		return new TextBox(callmethod("BaseAxis.setTitle", $this->ptr, $text, $font, $fontSize, $fontColor));
	}
	function setTitlePos($alignment, $titleGap = 6) {
		callmethod("BaseAxis.setTitlePos", $this->ptr, $alignment, $titleGap);
	}
	function setColors($axisColor, $labelColor = TextColor, $titleColor = -1, $tickColor = -1) {
		callmethod("BaseAxis.setColors", $this->ptr, $axisColor, $labelColor, $titleColor, $tickColor);
	}
	function setTickLength($majorTickLen, $minorTickLen = Null) {
		if ($minorTickLen == Null)
			callmethod("BaseAxis.setTickLength", $this->ptr, $majorTickLen);
		else
			$this->setTickLength2($majorTickLen, $minorTickLen);
	}
	function setTickLength2($majorTickLen, $minorTickLen) {
		callmethod("BaseAxis.setTickLength2", $this->ptr, $majorTickLen, $minorTickLen);
	}
	function getCoor($v) {
		return callmethod("BaseAxis.getCoor", $this->ptr, $v);
	}
	function getLength() {
		return callmethod("BaseAxis.getLength", $this->ptr);
	}
	function addMark($lineColor, $value, $text = "", $font = "", $fontSize = 8) {
		return new Mark(callmethod("BaseAxis.addMark", $this->ptr, $lineColor, $value, $text, $font, $fontSize));
	}
	function addZone($startValue, $endValue, $color) {
		callmethod("BaseAxis.addZone", $this->ptr, $startValue, $endValue, $color);
	}
	function setWidth($width) {
		callmethod("BaseAxis.setWidth", $this->ptr, $width);
	}
	function setLength($length) {
		callmethod("BaseAxis.setLength", $this->ptr, $length);
	}
	function setPos($x, $y, $align = Center) {
		callmethod("BaseAxis.setPos", $this->ptr, $x, $y, $align);
	}
}

class XAxis extends BaseAxis {
	function XAxis($ptr) {
		$this->ptr = $ptr;
	}
	function setLabels($labels) {
		return new TextBox(callmethod("XAxis.setLabels", $this->ptr, $labels));
	}
	function setIndent($indent) {
		callmethod("XAxis.setIndent", $this->ptr, $indent);
	}
	function addLabel($pos, $label) {
		callmethod("XAxis.addLabel", $this->ptr, $pos, $label);
	}
	function getLabel($i) {
		return callmethod("XAxis.getLabel", $this->ptr, $i);
	}	
	function setLinearScale($lowerLimit, $upperLimit, $tickInc = 0) {
		if (is_array($tickInc))
			setLinearScale2($lowerLimit, $upperLimit, $tickInc);
		else
			callmethod("XAxis.setLinearScale", $this->ptr, $lowerLimit, $upperLimit, $tickInc);
	}
	function setLinearScale2($lowerLimit, $upperLimit, $labels) {
		callmethod("XAxis.setLinearScale2", $this->ptr, $lowerLimit, $upperLimit, $labels);
	}
}

class Mark extends TextBox {
	function Mark($ptr) {
		$this->ptr = $ptr;
	}
	function setValue($value) {
		callmethod("Mark.setValue", $this->ptr, $value);
	}
	function setMarkColor($lineColor, $textColor = -1, $tickColor = -1) {
		callmethod("Mark.setMarkColor", $this->ptr, $lineColor, $textColor, $tickColor);
	}
	function setLineWidth($w) {
		callmethod("Mark.setLineWidth", $this->ptr, $w);
	}
	function setDrawOnTop($b) {
		callmethod("Mark.setDrawOnTop", $this->ptr, $b);
	}
}

class YAxis extends BaseAxis {
	function YAxis($ptr) {
		$this->ptr = $ptr;
	}
	function setLinearScale($lowerLimit, $upperLimit, $tickInc = 0) {
		callmethod("YAxis.setLinearScale", $this->ptr, $lowerLimit, $upperLimit, $tickInc);
	}
	function setLogScale($logScale = 1) {
		callmethod("YAxis.setLogScale", $this->ptr, $logScale);
	}
	function setLogScale2($lowerLimit, $upperLimit, $tickInc = 0) {
		callmethod("YAxis.setLogScale2", $this->ptr, $lowerLimit, $upperLimit, $tickInc);
	}
	function setAutoScale($topExtension = 0, $bottomExtension = 0, $zeroAffinity = 0.8) {
		callmethod("YAxis.setAutoScale", $this->ptr, $topExtension, $bottomExtension, $zeroAffinity);
	}
	function setTickDensity($tickDensity) {
		callmethod("YAxis.setTickDensity", $this->ptr, $tickDensity);
	}
	function setTopMargin($topMargin) {
		callmethod("YAxis.setTopMargin", $this->ptr, $topMargin);
	}
	function setLabelFormat($formatString) {
		callmethod("YAxis.setLabelFormat", $this->ptr, $formatString);
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to layer.h
#///////////////////////////////////////////////////////////////////////////////////
define("NoValue", +1.7e308);

define("NoSymbol", 0);
define("SquareSymbol", 1);
define("DiamondSymbol", 2);
define("TriangleSymbol", 3);
define("RightTriangleSymbol", 4);
define("LeftTriangleSymbol", 5);
define("InvertedTriangleSymbol", 6);
define("CircleSymbol", 7);
define("CrossSymbol", 8);
define("Cross2Symbol", 9);

define("NormalLegend", 0);
define("ReverseLegend", 1);
define("NoLegend", 2);

class DataSet {
	function DataSet($ptr) {
		$this->ptr = $ptr;
	}
	function setData($data) {
		callmethod("DataSet.setData", $this->ptr, $data);
	}
	function setDataName($name) {
		callmethod("DataSet.setDataName", $this->ptr, $name);
	}
	function setDataColor($dataColor, $edgeColor = -1, $shadowColor = -1, $shadowEdgeColor = -1) {
		callmethod("DataSet.setDataColor", $this->ptr, $dataColor, $edgeColor, $shadowColor, $shadowEdgeColor);
	}
	function setDataSymbol($symbol, $size = 5, $fillColor = -1, $edgeColor = -1) {
	    if (!is_numeric($symbol))
        	return setDataSymbol2($symbol);
		callmethod("DataSet.setDataSymbol", $this->ptr, $symbol, $size, $fillColor, $edgeColor);
	}
	function setDataSymbol2($image) {
	    if (!is_string($image))
        	return setDataSymbol3($image);
		callmethod("DataSet.setDataSymbol2", $this->ptr, $image);
	}
	function setDataSymbol3($image) {
		callmethod("DataSet.setDataSymbol3", $this->ptr, $image->ptr);
	}
	function setUseYAxis2($b = 1) {
		callmethod("DataSet.setUseYAxis2", $this->ptr, $b);
	}
	function setLineWidth($w) {
		callmethod("DataSet.setLineWidth", $this->ptr, $w);
	}
	function setDataLabelFormat($formatString) {
		callmethod("DataSet.setDataLabelFormat", $this->ptr, $formatString);
	}
	function setDataLabelStyle($font = "", $fontSize = 8, $fontColor = TextColor, $fontAngle = 0) {
		return new TextBox(callmethod("DataSet.setDataLabelStyle", $this->ptr, $font, $fontSize, $fontColor, $fontAngle));
	}
}

define("Overlay", 0);
define("Stack", 1);
define("Depth", 2);
define("Side", 3);

class Layer {
	function Layer($ptr) {
		$this->ptr = $ptr;
	}
	function setSize($x, $y, $w, $h, $swapXY = 0) {
		callmethod("Layer.setSize", $this->ptr, $x, $y, $w, $h, $swapXY);
	}
	function setBorderColor($color, $raisedEffect = 0) {
		callmethod("Layer.setBorderColor", $this->ptr, $color, $raisedEffect);
	}
	function set3D($d = -1, $zGap = 0) {
		callmethod("Layer.set3D", $this->ptr, $d, $zGap);
	}
	function set3D2($xDepth, $yDepth, $xGap, $yGap) {
		callmethod("Layer.set3D2", $this->ptr, $xDepth, $yDepth, $xGap, $yGap);
	}
	function setLineWidth($w) {
		callmethod("Layer.setLineWidth", $this->ptr, $w);
	}
	function setDataCombineMethod($m) {
		callmethod("Layer.setDataCombineMethod", $this->ptr, $m);
	}
	function addDataSet($data, $color = -1, $name = "") {
		return new DataSet(callmethod("Layer.addDataSet", $this->ptr, $data, $color, $name));
	}
	function getMinX() {
		return callmethod("Layer.getMinX", $this->ptr);
	}
	function getMaxX() {
		return callmethod("Layer.getMaxX", $this->ptr);
	}
	function getMaxY($yAxis = 1) {
		return callmethod("Layer.getMaxY", $this->ptr, $yAxis);
	}
	function getMinY($yAxis = 1) {
		return callmethod("Layer.getMinY", $this->ptr, $yAxis);
	}
	function getDepthX() {
		return callmethod("Layer.getDepthX", $this->ptr);
	}
	function getDepthY() {
		return callmethod("Layer.getDepthY", $this->ptr);
	}
	function getXCoor($v) {
		return callmethod("Layer.getXCoor", $this->ptr, $v);
	}
	function getYCoor($v, $yAxis = 1) {
		return callmethod("Layer.getYCoor", $this->ptr, $v, $yAxis);
	}
	function setDataLabelFormat($formatString) {
		callmethod("Layer.setDataLabelFormat", $this->ptr, $formatString);
	}
	function setDataLabelStyle($font = "", $fontSize = 8, $fontColor = TextColor, $fontAngle = 0) {
		return new TextBox(callmethod("Layer.setDataLabelStyle", $this->ptr, $font, $fontSize, $fontColor, $fontAngle));
	}
	function setAggregateLabelFormat($formatString) {
		callmethod("Layer.setAggregateLabelFormat", $this->ptr, $formatString);
	}
	function setAggregateLabelStyle($font = "", $fontSize = 8, $fontColor = TextColor, $fontAngle = 0) {
		return new TextBox(callmethod("Layer.setAggregateLabelStyle", $this->ptr, $font, $fontSize, $fontColor, $fontAngle));
	}
	function getImageCoor($dataSet, $dataItem = Null) {
		if ($dataItem == Null)
			return $this->getImageCoor2($dataSet);
		return callmethod("Layer.getImageCoor", $this->ptr, $dataSet, $dataItem);
	}
	function getImageCoor2($dataItem) {
		return callmethod("Layer.getImageCoor2", $this->ptr, $dataItem);
	}
	function getHTMLImageMap($url, $queryFormat = "", $extraAttr = "") {
		return callmethod("Layer.getHTMLImageMap", $this->ptr, $url, $queryFormat, $extraAttr);
	}
	function setLegend($m) {
		callmethod("Layer.setLegend", $this->ptr, $m);
	}
	function getDataSet($dataSet) {
		return new DataSet(callmethod("Layer.getDataSet", $this->ptr, $dataSet));
	}
	function setXData($xData, $maxValue = Null) {
		if ($maxValue == Null)
			callmethod("Layer.setXData", $this->ptr, $xData);
		else
			$this->setXData2($xData, $maxValue);
	}
	function setXData2($minValue, $maxValue) {
		callmethod("Layer.setXData2", $this->ptr, $minValue, $maxValue);
	}
	function addCustomDataLabel($dataSet, $dataItem, $label, $font = "", $fontSize = 8, $fontColor = TextColor, $fontAngle = 0) {
		return new TextBox(callmethod("Layer.addCustomDataLabel", $this->ptr, $dataSet, $dataItem, $label, $font, $fontSize, $fontColor, $fontAngle));
	}
	function addCustomAggregateLabel($dataItem, $label, $font = "", $fontSize = 8, $fontColor = TextColor, $fontAngle = 0) {
		return new TextBox(callmethod("Layer.addCustomAggregateLabel", $this->ptr, $dataItem, $label, $font, $fontSize, $fontColor, $fontAngle));
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to barlayer.h
#///////////////////////////////////////////////////////////////////////////////////
class BarLayer extends Layer {
	function BarLayer($ptr) {
		$this->ptr = $ptr;
	}
	function setBarGap($barGap, $subBarGap = 0.2) {
		callmethod("BarLayer.setBarGap", $this->ptr, $barGap, $subBarGap);
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to linelayer.h
#///////////////////////////////////////////////////////////////////////////////////
class LineLayer extends Layer {
	function LineLayer($ptr) {
		$this->ptr = $ptr;
	}
	function setGapColor($lineColor, $lineWidth = -1) {
		callmethod("LineLayer.setGapColor", $this->ptr, $lineColor, $lineWidth);
	}
	function setImageMapWidth($width) {
		callmethod("LineLayer.setImageMapWidth", $this->ptr, $width);
	}
}

class ScatterLayer extends LineLayer {
	function ScatterLayer($ptr) {
		$this->ptr = $ptr;
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to trendlayer.h
#///////////////////////////////////////////////////////////////////////////////////
class TrendLayer extends Layer {
	function TrendLayer($ptr) {
		$this->ptr = $ptr;
	}
	function setImageMapWidth($width) {
		callmethod("TrendLayer.setImageMapWidth", $this->ptr, $width);
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to arealayer.h
#///////////////////////////////////////////////////////////////////////////////////
class AreaLayer extends Layer {
	function AreaLayer($ptr) {
		$this->ptr = $ptr;
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to hloclayer.h
#///////////////////////////////////////////////////////////////////////////////////
class HLOCLayer extends Layer {
	function HLOCLayer($ptr) {
		$this->ptr = $ptr;
	}
	function setDataGap($gap) {
		callmethod("HLOCLayer.setDataGap", $this->ptr, $gap);
	}
	function setCandleStick($b) {
		callmethod("HLOCLayer.setCandleStick", $this->ptr, $b);
	}
}

class CandleStickLayer extends HLOCLayer {
	function CandleStickLayer($ptr) {
		$this->ptr = $ptr;
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to xychart.h
#///////////////////////////////////////////////////////////////////////////////////
class PlotArea {
	function PlotArea($ptr) {
		$this->ptr = $ptr;
	}
	function setBackground($color, $altBgColor = -1, $edgeColor = LineColor) {
		callmethod("PlotArea.setBackground", $this->ptr, $color, $altBgColor, $edgeColor);
	}
	function setBackground2($img, $align = Center) {
		callmethod("PlotArea.setBackground2", $this->ptr, $img, $align);
	}
	function setGridColor($hGridColor, $vGridColor = Transparent) {
		callmethod("PlotArea.setGridColor", $this->ptr, $hGridColor, $vGridColor);
	}
	function setGridWidth($hGridWidth, $vGridWidth = -1) {
		callmethod("PlotArea.setGridWidth", $this->ptr, $hGridWidth, $vGridWidth);
	}
}

class XYChart extends BaseChart {
	function XYChart($width, $height, $bgColor = BackgroundColor, $edgeColor = Transparent) {
		$this->ptr = callmethod("XYChart.create", $width, $height, $bgColor, $edgeColor);
		$this->xAxis = new XAxis(callmethod("XYChart.xAxis", $this->ptr));
		$this->xAxis2 = new XAxis(callmethod("XYChart.xAxis2", $this->ptr));
		$this->yAxis = new YAxis(callmethod("XYChart.yAxis", $this->ptr));
		$this->yAxis2 = new YAxis(callmethod("XYChart.yAxis2", $this->ptr));
		autoDestroy($this);
	}
	function yAxis() {
		return new YAxis(callmethod("XYChart.yAxis", $this->ptr));
	}
	function yAxis2() {
		return new YAxis(callmethod("XYChart.yAxis2", $this->ptr));
	}
	function syncYAxis($slope = 1, $intercept = 0) {
		callmethod("XYChart.syncYAxis", $this->ptr, $slope, $intercept);
	}
	function setYAxisOnRight($b = 1) {
		callmethod("XYChart.setYAxisOnRight", $this->ptr, $b);
	}
	function xAxis() {
		return new XAxis(callmethod("XYChart.xAxis", $this->ptr));
	}
	function xAxis2() {
		return new XAxis(callmethod("XYChart.xAxis2", $this->ptr));
	}
	function setPlotArea($x, $y, $width, $height, $bgColor = Transparent, $altBgColor = -1,
		$edgeColor = LineColor, $hGridColor = 0xc0c0c0, $vGridColor = Transparent) {
		return new PlotArea(callmethod("XYChart.setPlotArea", $this->ptr,
			$x, $y, $width, $height, $bgColor, $altBgColor, $edgeColor, $hGridColor, $vGridColor));
	}
	function addBarLayer($data = Null, $color = -1, $name = "", $depth = 0) {
		if ($data != Null)
			return new BarLayer(callmethod("XYChart.addBarLayer", $this->ptr, $data, $color, $name, $depth));
		else
			return $this->addBarLayer2();
	}
	function addBarLayer2($dataCombineMethod = Side, $depth = 0) {
		return new BarLayer(callmethod("XYChart.addBarLayer2", $this->ptr, $dataCombineMethod, $depth));
	}
	function addBarLayer3($data, $colors = Null, $names = Null, $depth = 0) {
		return new BarLayer(callmethod("XYChart.addBarLayer3", $this->ptr, $data, $colors, $names, $depth));
	}
	function addLineLayer($data = Null, $color = -1, $name = "", $depth = 0) {
		if ($data != Null)
			return new LineLayer(callmethod("XYChart.addLineLayer", $this->ptr, $data, $color, $name, $depth));
		else
			return $this->addLineLayer2();
	}
	function addLineLayer2($dataCombineMethod = Overlay, $depth = 0) {
		return new LineLayer(callmethod("XYChart.addLineLayer2", $this->ptr, $dataCombineMethod, $depth));
	}
	function addAreaLayer($data = Null, $color = -1, $name = "", $depth = 0) {
		if ($data != Null)
			return new AreaLayer(callmethod("XYChart.addAreaLayer", $this->ptr, $data, $color, $name, $depth));
		else
			return $this->addAreaLayer2();
	}
	function addAreaLayer2($dataCombineMethod = Stack, $depth = 0) {
		return new AreaLayer(callmethod("XYChart.addAreaLayer2", $this->ptr, $dataCombineMethod, $depth));
	}
	function addHLOCLayer($highData = Null, $lowData = Null, $openData = Null, $closeData = Null, $color = -1) {
		if ($highData != Null)
			return new HLOCLayer(callmethod("XYChart.addHLOCLayer", $this->ptr,
				$highData, $lowData, $openData, $closeData, $color));
		else
			return $this->addHLOCLayer2();
	}
	function addHLOCLayer2() {
		return new HLOCLayer(callmethod("XYChart.addHLOCLayer2", $this->ptr));
	}
	function swapXY($b = 1) {
		callmethod("XYChart.swapXY", $this->ptr, $b);
	}
	function addScatterLayer($xData, $yData, $name = "", $symbol = SquareSymbol, $symbolSize = 5, $fillColor = -1, $edgeColor = -1) {
		return new ScatterLayer(callmethod("XYChart.addScatterLayer", $this->ptr, $xData, $yData, $name, $symbol, $symbolSize, $fillColor, $edgeColor));
	}
	function addCandleStickLayer($highData, $lowData, $openData, $closeData, $riseColor = 0xffffff, $fallColor = 0x0, $edgeColor = LineColor) {
		return new CandleStickLayer(callmethod("XYChart.addCandleStickLayer", $this->ptr, $highData, $lowData, $openData, $closeData, $riseColor, $fallColor, $edgeColor));
	}
	function addTrendLayer($data, $color = -1, $name = "", $depth = 0) {
		return new TrendLayer(callmethod("XYChart.addTrendLayer", $this->ptr, $data, $color, $name, $depth));
	}
	function addTrendLayer2($xData, $yData, $color = -1, $name = "", $depth = 0) {
		return new TrendLayer(callmethod("XYChart.addTrendLayer2", $this->ptr, $xData, $yData, $color, $name, $depth));
	}
}

#///////////////////////////////////////////////////////////////////////////////////
#//	bindings to chartdir.h
#///////////////////////////////////////////////////////////////////////////////////
function getCopyright() {
	return callmethod("getCopyright");
}

function getVersion() {
	return callmethod("getVersion");
}

function getDescription() {
	return callmethod("getDescription");
}

function getBootLog() {
	return callmethod("getBootLog");
}

function libgTTFTest($font = "", $fontIndex = 0, $fontHeight = 8, $fontWidth = 8, $angle = 0) {
    return callmethod("libgTTFTest", $font, $fontIndex, $fontHeight, $fontWidth, $angle);
}

?>
