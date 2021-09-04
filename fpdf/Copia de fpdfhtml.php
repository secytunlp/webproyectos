<?php 
require('fpdf.php');

//if (!defined('PARAGRAPH_STRING')) define('PARAGRAPH_STRING', '~~~');

function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['G']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter in 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}

class fpdfhtmlHelper extends FPDF {
	var $B;
	var $I;
	var $U;
	var $HREF;
	var $fontList;
	var $issetfont;
	var $issetcolor;
	
	function PDF($orientation='P', $unit='mm', $format='A4')
	{
	    //Call parent constructor
	    $this->FPDF($orientation, $unit, $format);
	    //Initialization
	    $this->B=0;
	    $this->I=0;
	    $this->U=0;
	    $this->HREF='';
	
	    $this->tableborder=0;
	    $this->tdbegin=false;
	    $this->tdwidth=0;
	    $this->tdheight=0;
	    $this->tdalign="L";
	    $this->tdbgcolor=false;
	
	    $this->oldx=0;
	    $this->oldy=0;
	
	    $this->fontlist=array("arial", "times", "courier", "helvetica", "symbol");
	    $this->issetfont=false;
	    $this->issetcolor=false;
	}
	/**
    * Allows you to control how the pdf is returned to the user, most of the time in CakePHP you probably want the string
    *
    * @param string $name name of the file.
    * @param string $destination where to send the document values: I, D, F, S
    * @return string if the $destination is S
    */
	function fpdfOutput ($name = 'page.pdf', $destination = 's') {
		// I: send the file inline to the browser. The plug-in is used if available.
		//    The name given by name is used when one selects the "Save as" option on the link generating the PDF.
		// D: send to the browser and force a file download with the name given by name.
		// F: save to a local file with the name given by name.
		// S: return the document as a string. name is ignored.
		return $this->Output($name, $destination);
	}

	function findAlign($html){
		if(ereg("justify", $html)){
			$this->ALIGN='J';
		}elseif(ereg("center", $html)){
			$this->ALIGN='C';
		}elseif(ereg("right", $html)){
			$this->ALIGN='R';
		}elseif(ereg("left", $html)){
			$this->ALIGN='L';
		}
	}

	function findUnderline($style){
		if(ereg("underline", $style)){
			$this->U=1;
		}
	}


	function trimespecialchar($html){

		//Reemplazo de caracteres especiales
		$html=str_replace("&aacute;",'á',$html);
		$html=str_replace("&eacute;",'é',$html);
		$html=str_replace("&iacute;",'í',$html);
		$html=str_replace("&oacute;",'ó',$html);
		$html=str_replace("&uacute;",'ú',$html);
		$html=str_replace("&Aacute;",'Á',$html);
		$html=str_replace("&Eacute;",'É',$html);
		$html=str_replace("&Iacute;",'Í',$html);
		$html=str_replace("&Oacute;",'Ó',$html);
		$html=str_replace("&Uacute;",'Ú',$html);
		$html=str_replace("&ordm;",'º',$html);
		$html=str_replace("&ntilde;",'ñ',$html);
		$html=str_replace("&Ntilde;",'Ñ',$html);
		$html=str_replace("&nbsp;",' ',$html);
		$html=str_replace("&lt;",'<',$html);
		$html=str_replace("&gt;",'>',$html);
		$html=str_replace("&amp;",'&',$html);
		$html=str_replace("&quot;",'"',$html);
		$html=str_replace("&ldquo;",'"',$html);
		$html=str_replace("&rdquo;",'"',$html);
		$html=str_replace("&Agrave;",'À',$html);
		$html=str_replace("&Egrave;",'È',$html);
		$html=str_replace("&Igrave;",'Ì',$html);
		$html=str_replace("&Ograve;",'Ò',$html);
		$html=str_replace("&Ugrave;",'Ù',$html);
		$html=str_replace("&agrave;",'à',$html);
		$html=str_replace("&egrave;",'è',$html);
		$html=str_replace("&igrave;",'ì',$html);
		$html=str_replace("&ograve;",'ò',$html);
		$html=str_replace("&ugrave; ",'ù',$html);
		$html=str_replace("&Auml;",'Ä',$html);
		$html=str_replace("&Euml;",'Ë',$html);
		$html=str_replace("&Iuml;",'Ï',$html);
		$html=str_replace("&Ouml;",'Ö',$html);
		$html=str_replace("&Uuml;",'Ü',$html);
		$html=str_replace("&Acirc;",'Â',$html);
		$html=str_replace("&Ecirc;",'Ê',$html);
		$html=str_replace("&Icirc;",'Î',$html);
		$html=str_replace("&Ocirc;",'Ô',$html);
		$html=str_replace("&Ucirc;",'Û',$html);
		$html=str_replace("&acirc;",'â',$html);
		$html=str_replace("&ecirc;",'ê',$html);
		$html=str_replace("&icirc;",'î',$html);
		$html=str_replace("&ocirc;",'ô',$html);
		$html=str_replace("&ucirc;",'û',$html);
		$html=str_replace("&auml;",'ä',$html);
		$html=str_replace("&euml;",'ë',$html);
		$html=str_replace("&iuml;",'ï',$html);
		$html=str_replace("&ouml;",'ö',$html);
		$html=str_replace("&uuml;",'ü',$html);
		$html=str_replace("&Atilde;",'Ã',$html);
		$html=str_replace("&Otilde;",'Õ',$html);
		$html=str_replace("&atilde;",'ã',$html);
		$html=str_replace("&otilde;",'õ',$html);
		$html=str_replace("&aring;",'å',$html);
		$html=str_replace("&Aring;",'Å',$html);
		$html=str_replace("&Ccedil;",'Ç',$html);
		$html=str_replace("&ccedil;",'ç',$html);
		$html=str_replace("&Yacute;",'Ý',$html);
		$html=str_replace("&yacute;",'ý',$html);
		$html=str_replace("&yuml;",'ÿ',$html);
		$html=str_replace("&iquest;",'¿',$html);
		$html=str_replace("&ndash;",'–',$html);
		$html=str_replace("&iexcl;",'¡',$html);
		$html=str_replace("&middot;",'·',$html);
		$html=str_replace("&hellip;",'...',$html);
		$html=str_replace("&rsquo;","'",$html);
		$html=str_replace("&acute;","'",$html);
		$html=str_replace("&lsquo;","'",$html);
		$html=str_replace("&#39;","'",$html);
		
		return $html;
	}

	function WriteHTML($html)
{
    $html=strip_tags($html, "<b><u><i><a><img><p>
<strong><em><font><tr><blockquote><hr><td><tr><table><sup>"); //remove all unsupported tags
    $html=str_replace("\n", '', $html); //replace carriage returns by spaces
    $html=str_replace("\t", '', $html); //replace carriage returns by spaces
    $html = $this->trimespecialchar($html);
    $a=preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE); //explodes the string
    $table=array();
    $item=0;
    
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if ($tableOK){
            	$tdText .= ($tdOK)?$e:'';
	            		
            }
            
            else {
	            if($this->HREF)
	                $this->PutLink($this->HREF, $e);
	            elseif($this->tdbegin) {
	                //if(trim($e)!='' and $e!=" ") {
	                    $this->Cell($this->tdwidth, $this->tdheight, $e, $this->tableborder, '', $this->tdalign, $this->tdbgcolor);
	              /*  }
	                elseif($e==" ") {
	                    $this->Cell($this->tdwidth, $this->tdheight, '', $this->tableborder, '', $this->tdalign, $this->tdbgcolor);
	                }*/
	            }
	            else
	                $this->Write(5, stripslashes(txtentities($e)));
            }
        }
        else
        {
        	if ($tableOK){
            	if(substr($e,0,1)=='/'){
	            	if (strtoupper(substr($e, 1))=='TD') {
	            		
	            			$table[$item][]=$tdText;
	            			$tdText='';
	            	}
	            	if (strtoupper(substr($e, 1))=='TR') {
	            		
	            			$item++;
	            	}
	            	if (strtoupper(substr($e, 1))=='TABLE') {
	            		$tableOK=0; 
	            		$countA = (count($table[0])==0)?1:count($table[0]);
	            		$wcol = intval(185/$countA);
	            		$wArray = array();
	            		for($j=0;$j<$countA;$j++){
	            			$wArray[$j]=$wcol;
	            		}
	            		$this->SetWidths($wArray);
						foreach ($table as $r=>$m)
							$this->row($table[$r]);
	            		$table=array();
	            		$item=0;
	            	}
            	}
            	else {
            		 $a2=explode(' ', $e);
	                $tag=strtoupper(array_shift($a2));
            		 if ($tag=='TD') $tdOK=1;
            	}
            }
            
            else {
        	
        	
	             if ($tdOK){
	            	switch ( strtoupper($e)) {
						case 'P' :
							$e = str_replace('p','span',$e);
						break;
						case '/P' :
							$e = str_replace('/p','/span',$e);
						break;
						case 'BR' :
							$e = str_replace('br','',$e);
						break;
						case 'BR/' :
							$e = str_replace('br/','',$e);
						break;
						case 'HR' :
							$e = str_replace('hr','',$e);
						break;
							
					}
	            }
	        	//Tag
	            if(substr($e,0,1)=='/'){
	            	if (strtoupper(substr($e, 1))=='TD') $tdOK=0;
	            	
	                $this->CloseTag(strtoupper(substr($e, 1)));
	            }
	            else
	            {
	                //Extract attributes
	                $e =str_replace('style="','', $e);
	                $e =str_replace(': ','=', $e);
	                $e =str_replace(';"','', $e);
	                $rgbpos = strpos($e,'rgb(');
	                if($rgbpos){
	                	$rgbfin = strpos($e,')');
	                	$rgb = substr($e,$rgbpos,$rgbfin);
	                	$e =str_replace($rgb,trim($rgb), $e);
	                }
	                
	                 $e =str_replace('background-color','bgcolor', $e);
	                 
	                $a2=explode(' ', $e);
	                $tag=strtoupper(array_shift($a2));
	                $attr=array();
	                foreach($a2 as $v)
	                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$', $v, $a3))
	                        $attr[strtoupper($a3[1])]=$a3[2];
	               
	                $this->OpenTag($tag, $attr);
	                if ($tag=='TD') $tdOK=1;
	                if ($tag=='TABLE') $tableOK=1;
	            }
            }
        }
        
    }
}

function OpenTag($tag, $attr)
{
    //Opening tag
    switch($tag){

        case 'SUP':
            if($attr['SUP'] != '') {    
                //Set current font to: Bold, 6pt     
                $this->SetFont('', '', 6);
                //Start 125cm plus width of cell to the right of left margin         
                //Superscript "1"
                $this->Cell(2, 2, $attr['SUP'], 0, 0, 'L');
            }
            break;

        case 'TABLE': // TABLE-BEGIN
            $this->Ln(10);
        	if( $attr['BORDER'] != '' ) $this->tableborder=$attr['BORDER'];
            else $this->tableborder=0;
            break;
        case 'TR': //TR-BEGIN
            break;
        case 'TD': // TD-BEGIN
            if( $attr['WIDTH'] != '' ) $this->tdwidth=($attr['WIDTH']/4);
            else $this->tdwidth=20; // SET to your own width if you need bigger fixed cells
            if( $attr['HEIGHT'] != '') $this->tdheight=($attr['HEIGHT']/6);
            else $this->tdheight=6; // SET to your own height if you need bigger fixed cells
            if( $attr['ALIGN'] != '' ) {
                $align=$attr['ALIGN'];        
                if($align=="LEFT") $this->tdalign="L";
                if($align=="CENTER") $this->tdalign="C";
                if($align=="RIGHT") $this->tdalign="R";
            }
            else $this->tdalign="L"; // SET to your own
            if( $attr['BGCOLOR'] != '' ) {
                if (strchr($attr['BGCOLOR'],'rgb')){
                	$attr['BGCOLOR'] = str_replace('rgb(','',$attr['BGCOLOR']);
                	$attr['BGCOLOR'] = str_replace(')','',$attr['BGCOLOR']);
                	$coul = explode(',',$attr['BGCOLOR']);
                	$this->SetFillColor($coul[0], $coul[1], $coul[2]);
                }
                else{
            		$coul=hex2dec($attr['BGCOLOR']);
            		$this->SetFillColor($coul['R'], $coul['G'], $coul['B']);
                }
                    
                    $this->tdbgcolor=true;
                }
            $this->tdbegin=true;
            break;

        case 'HR':
            if( $attr['WIDTH'] != '' )
                $Width = $attr['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.2);
            $this->Line($x, $y, $x+$Width, $y);
            $this->SetLineWidth(0.2);
            $this->Ln(1);
            break;
        case 'STRONG':
            $this->SetStyle('B', true);
            break;
        case 'EM':
            $this->SetStyle('I', true);
            break;
        case 'B':
        case 'I':
        case 'U':
            $this->SetStyle($tag, true);
            break;
        case 'A':
            $this->HREF=$attr['HREF'];
            break;
        case 'IMG':
            if(isset($attr['SRC']) and (isset($attr['WIDTH']) or isset($attr['HEIGHT']))) {
                if(!isset($attr['WIDTH']))
                    $attr['WIDTH'] = 0;
                if(!isset($attr['HEIGHT']))
                    $attr['HEIGHT'] = 0;
                $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
            }
            break;
        //case 'TR':
        case 'BLOCKQUOTE':
        case 'BR':
            $this->Ln(5);
            break;
        case 'P':
            $this->Ln(5);
            break;
        case 'FONT':
            if (isset($attr['COLOR']) and $attr['COLOR']!='') {
                $coul=hex2dec($attr['COLOR']);
                $this->SetTextColor($coul['R'], $coul['G'], $coul['B']);
                $this->issetcolor=true;
            }
            if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist)) {
                $this->SetFont(strtolower($attr['FACE']));
                $this->issetfont=true;
            }
            if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist) and isset($attr['SIZE']) and $attr['SIZE']!='') {
                $this->SetFont(strtolower($attr['FACE']), '', $attr['SIZE']);
                $this->issetfont=true;
            }
            break;
    }
}

function CloseTag($tag)
{
    //Closing tag
    if($tag=='SUP') {
    }

    if($tag=='TD') { // TD-END
        $this->tdbegin=false;
        $this->tdwidth=0;
        $this->tdheight=0;
        $this->tdalign="L";
        $this->tdbgcolor=false;
    }
    if($tag=='TR') { // TR-END
        $this->Ln();
    }
    if($tag=='TABLE') { // TABLE-END
        //$this->Ln();
        $this->tableborder=0;
    }

    if($tag=='STRONG')
        $tag='B';
    if($tag=='EM')
        $tag='I';
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag, false);
    if($tag=='A')
        $this->HREF='';
    if($tag=='FONT'){
        if ($this->issetcolor==true) {
            $this->SetTextColor(0);
        }
        if ($this->issetfont) {
            $this->SetFont('arial');
            $this->issetfont=false;
        }
    }
}

function SetStyle($tag, $enable)
{
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B', 'I', 'U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('', $style);
}

function PutLink($URL, $txt)
{
    //Put a hyperlink
    $this->SetTextColor(0, 0, 255);
    $this->SetStyle('U', true);
    $this->Write(5, $txt, $URL);
    $this->SetStyle('U', false);
    $this->SetTextColor(0);
}
	
	var $widths;
	var $aligns;
	
	function SetWidths($w)
	{
	    //Set the array of column widths
	    $this->widths=$w;
	}
	
	function SetAligns($a)
	{
	    //Set the array of column alignments
	    $this->aligns=$a;
	}
	
	function Row($data)
	{
	    //Calculate the height of the row
	    $nb=0;
	    for($i=0;$i<count($data);$i++)
	        $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
	    $h=5*$nb;
	    //Issue a page break first if needed
	    $this->CheckPageBreak($h);
	    //Draw the cells of the row
	    for($i=0;$i<count($data);$i++)
	    {
	        $w=$this->widths[$i];
	        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
	        //Save the current position
	        $x=$this->GetX();
	        $y=$this->GetY();
	        //Draw the border
	        $this->Rect($x, $y, $w, $h);
	        //Print the text
	        $this->MultiCell($w, 5, $data[$i], 0, $a);
	        //Put the position to the right of the cell
	        $this->SetXY($x+$w, $y);
	    }
	    //Go to the next line
	    $this->Ln($h);
	}
	
	function CheckPageBreak($h)
	{
	    //If the height h would cause an overflow, add a new page immediately
	    if($this->GetY()+$h>$this->PageBreakTrigger)
	        $this->AddPage($this->CurOrientation);
	}
	
	function NbLines($w, $txt)
	{
	    //Computes the number of lines a MultiCell of width w will take
	    $cw=&$this->CurrentFont['cw'];
	    if($w==0)
	        $w=$this->w-$this->rMargin-$this->x;
	    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	    $s=str_replace("\r", '', $txt);
	    $nb=strlen($s);
	    if($nb>0 and $s[$nb-1]=="\n")
	        $nb--;
	    $sep=-1;
	    $i=0;
	    $j=0;
	    $l=0;
	    $nl=1;
	    while($i<$nb)
	    {
	        $c=$s[$i];
	        if($c=="\n")
	        {
	            $i++;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	            continue;
	        }
	        if($c==' ')
	            $sep=$i;
	        $l+=$cw[$c];
	        if($l>$wmax)
	        {
	            if($sep==-1)
	            {
	                if($i==$j)
	                    $i++;
	            }
	            else
	                $i=$sep+1;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	        }
	        else
	            $i++;
	    }
	    return $nl;
	}
}
?>