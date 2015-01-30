<?php
// Set the content-Type
function makeCaptcha()
{
	header('Content-Type: image/png');
	$fontpath = realpath('.'); //replace . with a different directory if needed
	putenv('GDFONTPATH='.$fontpath);
	// Create the image
	$im = @imagecreatefrompng("captcha_bg.png"); 
	// Create some color
	if( !$im ) {
	    exit('failed ');
	}
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);
	$black = imagecolorallocate($im, 0, 0, 0);

	// The text to draw
	$randomString = generateRandomString(5);

	$fonts = array('arial.ttf', 'larabiefont.ttf', 'Cheddar_Jack.ttf', 'DJB_Perfect.ttf', 'black_jack.ttf','CaviarDreams_Italic.ttf' );

	//Add the characters into the string in a loop
	$codelen = strlen($randomString);
	$num_fonts = count($fonts);
	for($i = 0; $i<$codelen; $i++){
	    $image_angle = rand(-10,10);
	    $font = $fonts[rand(0,$num_fonts-1)];
	    imagettftext($im, 30, $image_angle , 30 * $i, 38,  $black, $font, substr($randomString,$i,1));
	}


	imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR );
	// Using imagepng() results in clearer text compared with imagejpeg()
	imagepng($im,$fontpath.'/'.$randomString.'.png');
	imagedestroy($im);
        return $im;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function main()
{
    for($i=0;$i<10;$i++) {
        makeCaptcha();
    }
}

main()

?>

