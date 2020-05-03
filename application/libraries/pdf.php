<?php

require('fpdf.php');

class PDF extends FPDF
{
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // HTML parser
        $html = str_replace("\n",' ',$html);
        $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                // Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,$e);
            }
            else
            {
                // Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    // Extract attributes
                    $a2 = explode(' ',$e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF = $attr['HREF'];
        if($tag=='BR')
            $this->Ln(5);
    }

    function CloseTag($tag)
    {
        // Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modify style and select corresponding font
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach(array('B', 'I', 'U') as $s)
        {
            if($this->$s>0)
                $style .= $s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
        // Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }

    function NbLines($w,$txt) 
    { 
        //Computes the number of lines a MultiCell of width w will take 
        $cw=&$this->CurrentFont['cw']; 

        if($w==0) {
            $w=$this->w-$this->rMargin-$this->x; 
        }
        
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize; 
        
        $s=str_replace("\r",'',$txt); 
        $nb=strlen($s); 

        if($nb>0 and $s[$nb-1]=="\n") {
            $nb--; 
        }
        
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

            if($c==' ') {
                $sep=$i; 
            }

            $l+=$cw[$c]; 

            if($l>$wmax) { 
                if($sep==-1) { 
                    if($i==$j) 
                        $i++; 
                } else { 
                    $i=$sep+1; 
                }

                $sep=-1; 
                $j=$i; 
                $l=0; 
                $nl++; 
            } else { 
                $i++; 
            }
        } 
        
        return $nl; 
    }
}

?>