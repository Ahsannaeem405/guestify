<?php
App::import('Vendor','tcpdf/tcpdf');

class XTCPDF extends TCPDF {
    var $xheadertext  = 'PDF created for guestify';
    var $xfootertext  = 'Copyright @ guestify. All rights reserved.';
    var $xfooterfont  = PDF_FONT_NAME_MAIN ;
    var $xheaderfont  = PDF_FONT_NAME_MAIN ;
    var $xfooterfontsize = 7;
    var $xheaderfontsize = 7;

    var $type = '';


    /**
    * Overwrites the default header
    * set the text in the view using
    *    $fpdf->xheadertext = 'YOUR ORGANIZATION';
    * set the fill color in the view using
    *    $fpdf->xheadercolor = array(0,0,100); (r, g, b)
    * set the font in the view using
    *    $fpdf->setHeaderFont(array('YourFont','',fontsize));
    */
    function Header() {

        // Logo
        $image_file = K_PATH_IMAGES.'guestify_logo_10cm_CMYK__wordbrand_inverse.jpg';
        $this->Image(
            $image_file, 
            0,      // (float) Abscissa of the upper-left corner (LTR) or upper-right corner (RTL).
            10,     // (float) Ordinate of the upper-left corner (LTR) or upper-right corner (RTL).
            38,     // (float) Width of the image in the page. If not specified or equal to zero, it is automatically calculated.
            22,     // (float) Height of the image in the page. If not specified or equal to zero, it is automatically calculated.
            'JPEG', //  (string) Image format. Possible values are (case insensitive): JPEG and PNG (whitout GD library) and all images supported by GD: GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM;. If not specified, the type is inferred from the file extension.
            'http://guestify.net', 
            'T',    // (string) Indicates the alignment of the pointer next to image insertion relative to image height. The value can be:
                    // T: top-right for LTR or top-left for RTL
                    // M: middle-right for LTR or middle-left for RTL
                    // B: bottom-right for LTR or bottom-left for RTL
                    // N: next line

            false,  //  (mixed) If true resize (reduce) the image to fit $w and $h (requires GD or ImageMagick library); if false do not resize; if 2 force resize in all cases (upscaling and downscaling).
            300,    // (int) dot-per-inch resolution used on resize
            'R',    // (string) Allows to center or align the image on the current line. Possible values are:
                    // L : left align
                    // C : center
                    // R : right align
                    // “ : empty string : left for LTR or right for RTL

            false,  // (boolean) true if this image is a mask, false otherwise
            false,  //  (mixed) image object returned by this function or false
            0,      // (mixed) Indicates if borders must be drawn around the cell. The value can be a number:
                    //     0: no border (default)
                    //     1: frame

                    // or a string containing some or all of the following characters (in any order):

                    //     L: left
                    //     T: top
                    //     R: right
                    //     B: bottom

                    // or an array of line styles for each border group - for example: array(‘LTRB’ => array(‘width’ => 2, ‘cap’ => ‘butt’, ‘join’ => ‘miter’, ‘dash’ => 0, ‘color’ => array(0, 0, 0)))
            false,  //  (mixed) If not false scale image dimensions proportionally to fit within the ($w, $h) box. $fitbox can be true or a 2 characters string indicating the image alignment inside the box. The first character indicate the horizontal alignment (L = left, C = center, R = right) the second character indicate the vertical algnment (T = top, M = middle, B = bottom).
            false,  //  (boolean) If true do not display the image.
            false   //  (boolean) If true the image is resized to not exceed page dimensions.
        );

        $this->setY(10); // shouldn't be needed due to page margin, but helps, otherwise it's at the page top
        $this->SetTextColor(0, 0, 0);

        $this->Cell(0, 20, '', 0, 1, 'C', false);
        $this->SetFont($this->xheaderfont,'',$this->xheaderfontsize);
        $this->Text(15, 26, $this->xheadertext);
    }


    /**
    * Overwrites the default footer
    * set the text in the view using
    * $fpdf->xfootertext = 'Copyright @ YOUR ORGANIZATION. All rights reserved.';
    */
    function Footer() {
        $this->setY(280); // shouldn't be needed due to page margin, but helps, otherwise it's at the page top

        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);
        $this->MultiCell(0, 20, $this->xfootertext, 0, 'C');
    }

}
