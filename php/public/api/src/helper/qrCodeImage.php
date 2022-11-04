<?php 

namespace Helper;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QrCodeImage {

    public static function generate(string $name, string $url): string {
        $im = imagecreatetruecolor(300, 500);
        $black = imagecolorallocate($im, 0, 0, 0);
        $white = imagecolorallocate($im, 255, 255, 255);
        imagefilledrectangle($im, 0, 0, 300, 500, $white);

        $font = __DIR__ . "/../assets/font/inter.ttf";

        $bbox = imageftbbox(18, 0, $font, $name);
        $x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2) - 5;
        $y = 80;
        imagefttext($im, 18, 0, $x, $y, $black, $font, $name);


        $bbox = imageftbbox(15, 0, $font, "Scan Me");
        $x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2) - 5;
        $y = 240;
        imagefttext($im, 15, 0, $x, $y, $black, $font, "Scan Me");

        $options = new QROptions([
            'scale' => 4,
            'eccLevel' => QRCode::ECC_H
        ]);

        $qrcode64 = str_replace("data:image/png;base64,", "", (new QRCode($options))->render($url));
        $imQrcode = \Helper\QrCodeImage::resize(
            imageCreateFromString(base64_decode($qrcode64))
        );


        imagecopymerge($im, $imQrcode, 50, 250, 0, 0, 200, 200, 100);

        ob_start();

        imagepng($im);
        $imageContent = ob_get_contents();

        ob_end_clean();

        return 'data:image/png;base64,' . base64_encode($imageContent);
    }

    public static function resize($qrCode){
        $width = imagesx($qrCode);
        $height = imagesy($qrCode);
    
        $newwidth = 200;
        $newheight = 200;
    
        $thumb = imagecreatetruecolor($newwidth, $newheight);
    
        imagecopyresampled($thumb, $qrCode, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        ob_start();
        imagepng($thumb);
        $imagedata = ob_get_contents();
        ob_end_clean();
    
        imagedestroy($qrCode);
        imagedestroy($thumb);
    
        return imagecreatefromstring($imagedata);
    }
}