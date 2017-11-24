<?php 

declare(strict_types=1);

namespace Turbine\utils;

use Turbine\Main;

class Skin {

  public function getBytesFromFile($filename){
    $im = imagecreatefrompng($filename);
    list($width, $height) = getimagesize($filename);
    $bytes = '';
  for($y = 0; $y < $height; $y++){
  for($x = 0; $x < $width; $x++){
    $argb = imagecolorat($im, $x, $y);
    $a = ((~((int) ($argb >> 24))) << 1) & 0xff;
    $r = ($argb >> 16) & 0xff;
    $g = ($argb >> 8) & 0xff;
    $b = $argb & 0xff;
    $bytes .= chr($r) . chr($g) . chr($b) . chr($a);
   }
  }
     //echo "BYTES=".strlen($bytes)."\n";
     return $bytes;
  }

  public function getRandSkin(){
    $rand = rand(1, 25);
    $main = Main::getInstance();
  if(in_array($rand, $main->skins)){
    return $this->getRandSkin();
  } else {
    $main->skins[] = $rand;
    return $this->getBytesFromFile($main->getDataFolder() . 'skins/' . $rand . '.png');
   }
  }
}
