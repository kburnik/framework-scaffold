<?

// print_r($_GET);

header("location: http://kolekcionar.eu/photos/" . $_GET['path']);
die();

$p = parse_url($_GET['path']);
$path = reset( explode('?',$_GET['path']));
$parts = explode('/',$path);

// print_r($parts);

switch ($parts[0]) {
	case 'thumbs':
		$basenamePrefix = "tmb.";
		$method = 'enboxImagePreserve';
		$params = array(70,70);
		array_shift($parts);
		$applyWatermark = false;
	break;
	case 'subs':
		$basenamePrefix = "sub.";
		$method = 'restrictImage';
		$params = array(400,400);
		array_shift($parts);
		$applyWatermark = true;
	break;
	default:
		if (preg_match('/([0-9]+)(x|y|r)([0-9]+)/',$parts[0],$results)) {
			$mode = $results[0];
			$basenamePrefix = $mode.".";
			array_shift($results);
			list($w,$m,$h) = $results;
			switch($m){
				case 'x':
					$method = 'enboxImagePreserve';
				break;
				case 'y':
					$method = 'restrictImage';
				break;
				case 'r':
					$method = 'enboxImage';
				break;
			}
			$params = array($w,$h);
			array_shift($parts);
		} else {
			$basenamePrefix = "";
		}
	break;
}

$originalImagePath =  implode('/',$parts);


// if no image
if (!file_exists($originalImagePath) || !is_file($originalImagePath) ) {
	header('HTTP/1.0 404 Not Found');
	$originalImagePath = dirname(__FILE__).'/default.png';
	$parts = array( 'default.png' );
}

$c = count($parts);
$parts[$c-1] = $basenamePrefix.$parts[$c-1];
$cachedImagePath = 'cache/' . implode('/',$parts);

$cachedImageDirectory = dirname($cachedImagePath);


if (!file_exists($cachedImagePath)) {
	include_once(dirname(__FILE__) . '/../../project.php');
	if (!file_exists($cachedImageDirectory)) {
		mkdir($cachedImageDirectory,0755,true);
	}

	$imageProc = new ImageProcessor( $originalImagePath );
	if (isset($method)) {
		call_user_func_array(array($imageProc,$method),$params);
	}
	if ($applyWatermark) {
		$watermarkImagePath = dirname(__FILE__).'/watermark2.png';
		$imageProc->applyWatermark( $watermarkImagePath );
	}
	$imageProc->save( $cachedImagePath );
	$imageProc->destroy();

	$isCached = 'NO';
} else {
	$isCached = 'YES';
}

header('X-Image-Cached:'. $isCached);
header('Content-Type:image/jpeg');
if ($isCached == "YES") {
	header("Cache-Control: private, max-age=10800, pre-check=10800");
	header("Pragma: private");
	header("Expires: " . date(DATE_RFC822, strtotime(" 30 day")));
}
@readfile($cachedImagePath);
