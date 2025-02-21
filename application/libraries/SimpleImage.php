<?php
// Класс для работы с изображениями
class SimpleImage {

   var $image;
   var $image_type;

   function load($filename) {
      if(@$image_info = getimagesize($filename)){
         $this->image_type = $image_info[2];
         if( $this->image_type == IMAGETYPE_JPEG ) {
            if($this->image = imagecreatefromjpeg($filename)) {
               return true;
            }else {
               return false;
            }
         }elseif( $this->image_type == IMAGETYPE_GIF ) {
            if($this->image = imagecreatefromgif($filename)) {
               return true;
            }else {
               return false;
            }
         }elseif( $this->image_type == IMAGETYPE_PNG ) {
            if($this->image = imagecreatefrompng($filename)) {
               return true;
            }else {
               return false;
            }
         }
      }else {
         return false;
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null, $tmp_file = '') {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         // imagegif($this->image,$filename);
         move_uploaded_file($tmp_file, $filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }
}

// пример использования
   // include('classSimpleImage.php');
   // $image = new SimpleImage();
   // $image->load('image.jpg');
   // $image->resizeToWidth(250);
   // $image->save('image1.jpg');
?>