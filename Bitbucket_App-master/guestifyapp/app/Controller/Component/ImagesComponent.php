<?php
class ImagesComponent extends Object {

    var $components = array('Session');

    # needed placeholder functions
    public function initialize(Controller $controller, $settings = array()) {
        $this->controller = $controller;
    }

    public function startup(Controller $controller) {
    }

    public function shutdown(Controller $controller) {
    }

    public function beforeRender(Controller $controller) {
    }

    public function beforeRedirect(Controller $controller) {
    }



    public function createResizings($filename, $folder) {
        
        $error = 0;
        $tempuploaddir = APP . "webroot/img/temp";

        $file = $tempuploaddir.'/'.$filename;

        $uploaddir_300 = APP . "webroot/img/".$folder."/300";
        if(!is_dir($uploaddir_300)){
            mkdir($uploaddir_300, 0777);
        }

        $uploaddir_600 = APP . "webroot/img/".$folder."/600";
        if(!is_dir($uploaddir_600)){
            mkdir($uploaddir_600, 0777);
        }

        $uploaddir_original = APP . "webroot/img/".$folder."/original";
        if(!is_dir($uploaddir_original)){
            mkdir($uploaddir_original, 0777);
        }


        // verify the extension
        $filetype = $this->getFileExtension($file);
        $filetype = strtolower($filetype);
        if(($filetype != "jpeg")  && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png")){
            return;
        }

        $imgsize = GetImageSize($file);

        # prepare filenames and paths
        $tempfile  = $tempuploaddir . "/" . $filename;
        $_300_file = $uploaddir_300 . "/" . $filename;
        $_600_file = $uploaddir_600 . "/" . $filename;
        $_original = $uploaddir_original . "/" . $filename;

        # generate the images
        $this->resize_img($tempfile, 300, $_300_file);
        $this->resize_img($tempfile, 600, $_600_file);
        copy($tempfile, $_original);

        # unlink the temp file
        unlink($tempfile);

        return $filename;
    }


    /*
    * Deletes the image and its associated thumbnail
    * Example in controller action:  $this->Image->delete_image("1210632285.jpg","sets");
    *
    * Parameters:
    * $filename: The file name of the image
    * $folderName: the name of the parent folder of the images. The images will be stored to /webroot/img/$folderName/big/ and  /webroot/img/$folderName/small/
    */
    public function delete_image($filename, $folderName) {
            unlink("img/".$folderName."/80/".$filename);
            unlink("img/".$folderName."/300/".$filename);
            unlink("img/".$folderName."/800/".$filename);
            unlink("img/".$folderName."/cropped/".$filename);
            unlink("img/".$folderName."/original/".$filename);
    }


    public function crop_img($imgname, $scale, $filename) {
        $filetype = $this->getFileExtension($imgname);
        $filetype = strtolower($filetype);

        switch($filetype) {
            case "jpeg":
            case "jpg":
                $img_src = ImageCreateFromjpeg($imgname);
                break;
            case "gif":
                $img_src = imagecreatefromgif($imgname);
                break;
            case "png":
                $img_src = imagecreatefrompng($imgname);
                break;
        }

        $width = imagesx($img_src);
        $height = imagesy($img_src);
        $ratiox = $width / $height * $scale;
        $ratioy = $height / $width * $scale;

        //-- Calculate resampling
        $newheight = ($width <= $height) ? $ratioy : $scale;
        $newwidth  = ($width <= $height) ? $scale : $ratiox;

        //-- Calculate cropping (division by zero)
        $cropx = ($newwidth - $scale != 0) ? ($newwidth - $scale) / 2 : 0;
        $cropy = ($newheight - $scale != 0) ? ($newheight - $scale) / 2 : 0;

        //-- Setup Resample & Crop buffers
        $resampled = imagecreatetruecolor($newwidth, $newheight);
        $cropped   = imagecreatetruecolor($scale, $scale);

        //-- Resample
        imagecopyresampled($resampled, $img_src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        //-- Crop
        imagecopy($cropped, $resampled, 0, 0, $cropx, $cropy, $newwidth, $newheight);

        // Save the cropped image
        switch($filetype) {
            case "jpeg":
            case "jpg":
                imagejpeg($cropped,$filename,100);
                break;
            case "gif":
                imagegif($cropped,$filename,100);
                break;
            case "png":
                imagepng($cropped,$filename);
                break;
        }
    }


    public function resize_img($imgname, $size, $filename) {
        $filetype = $this->getFileExtension($imgname);
        $filetype = strtolower($filetype);

        switch($filetype) {
            case "jpeg":
            case "jpg":
                $img_src = ImageCreateFromjpeg($imgname);
                break;
            case "gif":
                $img_src = imagecreatefromgif($imgname);
                break;
            case "png":
                $img_src = imagecreatefrompng($imgname);
                break;
        }

        $true_width  = imagesx($img_src);
        $true_height = imagesy($img_src);

        $width  = $size;
        $height = ($width/$true_width)*$true_height;

        $img_des = ImageCreateTrueColor($width,$height);
        if($filetype == "png") {
            imagealphablending($img_des, false);
        }
        imagecopyresampled ($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);
        // Save the resized image
        switch($filetype) {
            case "jpeg":
            case "jpg":
                imagejpeg($img_des,$filename,100);
                break;
            case "gif":
                imagegif($img_des,$filename,100);
                break;
            case "png":
                imagesavealpha($img_des, true);
                // only available up to GD-lib 1.6
                imagepng($img_des,$filename);
                break;
        }
        imagedestroy($img_des);
    }


    public function getFileExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
}
