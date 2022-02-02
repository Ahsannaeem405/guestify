<?php
App::import('Vendor','tcpdf/tcpdf');

class XTCPDF extends TCPDF {
    
    var $xheadertext  = '';
    var $xfootertext  = '';
    var $xfooterfont  = PDF_FONT_NAME_MAIN ;
    var $xheaderfont  = PDF_FONT_NAME_MAIN ;
    var $xfooterfontsize = 7;
    var $xheaderfontsize = 7;

    var $type = '';
    var $image_file = '';


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

        // Logo (guestify?)
        #$image_file = K_PATH_IMAGES.'guestify_logo.jpg';
        #$this->Image($this->image_file, 0, 15, 57, 20, 'JPEG', 'http://www.guestify.net', 'T', false, 150, 'R', false, false, 0, false, false, false);

        # define specific controls for each format here if needed
        if($this->type == 'A6') {

        }

        if($this->type == 'A7') {

        }

        if($this->type == 'HORZ') {

        }

        #$this->setY(5); // shouldn't be needed due to page margin, but helps, otherwise it's at the page top
        #$this->setY(1);
        $this->SetTextColor(10, 10, 10);
        $this->SetFont('helvetica','', 12);
        $this->MultiCell(0, 20, $this->xheadertext, 0, 'C');
    }


    /**
    * Overwrites the default footer
    * set the text in the view using
    * $fpdf->xfootertext = 'Copyright @ YOUR ORGANIZATION. All rights reserved.';
    */
    function Footer() {

        #$this->setY(280); // shouldn't be needed due to page margin, but helps, otherwise it's at the page top
        $this->SetFont('helvetica','', 10);
        $this->MultiCell(0, 20, $this->xfootertext, 0, 'C');
    }

}