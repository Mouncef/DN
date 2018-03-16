<?php
/**
 * Created by PhpStorm.
 * User: PC_MA27
 * Date: 08/02/2018
 * Time: 14:51
 */
namespace App\Service;


use TCPDF;
use WhiteOctober\TCPDFBundle\Controller\TCPDFController;


class PDFGenerator extends TCPDF
{
    private $pdf;
    private $templating;

    public function __construct(TCPDFController $pdf, \Twig_Environment $templating)
    {
        $this->pdf = $pdf;
        $this->templating = $templating;
    }

    public function generatePDF($html, $filename)
    {
        $pdf = $this->pdf->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator('Mouncef ZAGHRAT');
        $pdf->SetAuthor('Mouncef ZAGHRAT');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $string = 'www.darnawal.com';
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Dar Nawal', $string, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        // Set some content to print
        $html = /*'
            <h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
            <i>This is the first example of TCPDF library.</i>
            <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
            <p>Please check the source code documentation and other examples for further information.</p>
            <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
            ';*/

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($filename.".pdf", 'I');
    }

    public function savePDF()
    {
        /*------------------------------------Sauvegarde de la facture PDF  ------------------------------------*/
        /* $facturesDir = $this->getParameter('factures_directory');
         $userDir = $this->getParameter('factures_directory')."/".$output['user']->getId();
         $anneeDir = $this->getParameter('factures_directory')."/".$output['user']->getId()."/".$output['annee'];
         $moisDir = $this->getParameter('factures_directory')."/".$output['user']->getId()."/".$output['annee']."/".$output['mois'];*/
        $now = new \DateTime("now");
        $strNow = $now->format("d_m_Y_H_i");
        $pdfName = rand(1,99)."_".$strNow;
        $fileName = 'Synthèse_XXXX';
        $pdf = $this->pdf->create();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Orca Formation');
        $pdf->SetTitle('Synthese');
        $pdf->SetSubject('Synthese 1111');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();
        $content = $this->templating->render('backend/subscribers/list.html.twig');
        $pdf->writeHTML($content);
        /*if (!is_dir($facturesDir)){
            mkdir($facturesDir, 0700);
        }
        if (!is_dir($userDir)){
            mkdir($userDir, 0700);
        }
        if (!is_dir($anneeDir)){
            mkdir($anneeDir, 0700);
        }
        if (!is_dir($moisDir)){
            mkdir($moisDir, 0700);
        }*/
        $pdf->Output('PDF/'.$pdfName.'.pdf', 'F');
        /*------------------------------------  End of PDF Saving  -------------------------------------*/
    }

    public function generateInvoicePDF($html, $filename){

        // create new PDF document
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator('Dar Nawal');
        $pdf->SetAuthor('Dar Nawal');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');
        $pdf->SetKeywords('DarNawal, Luxe, Caftans');


        // set default header data
        $pdf->SetHeaderData('tcpdf_logo.jpg', 50, null, null);

        // set header and footer fonts
        $pdf->setHeaderFont(Array('helvetica', '', 10));
        $pdf->setFooterFont(Array('helvetica', '', 8));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont('courier');

        // set margins
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 25);

        // set image scale factor
        $pdf->setImageScale(1);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', 'B', 20);

        // add a page
        $pdf->AddPage();

//        $pdf->Write(25, '', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 9, 0,0,0);

        $pdf->writeHTML($html, true, true, false, false, '');

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($filename.".pdf", 'I');


    }


}