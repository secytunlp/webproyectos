<?php
//require( '../Library/php/i_functions.php'); 

Class Exportexcel{
    
   	###############
	//ClassABM
	//Constructor que bindea las propiedades para
	//la conexion.
	#############
	function Exportexcel( $p_strFileName = '', $p_bPrint = false )
	{
	
	#m_intPageNum = CInt("0" & Request.QueryString("PageNum"))
	#m_intGroupNum = CInt("0" & Request.QueryString("GroupNum"))
	
	#ajusto el ContentType de la página
	if( !$p_bPrint)
	{
		Header("ContentType:  application/vnd.ms-excel");
		#//Set File Name
		#// - el FileName incluye un Time Stamp del proceso
		$strFileName = Date("YmdHms"). '_' . $p_strFileName . '.xls'; 
	
		Header("Content-Disposition: attachment; filename= $strFileName");	
	}else{
		Header("ContentType:  text/html");
	}
	
	Header("Charset:  ");
	
	

	}

// 	function GetExcelPreview()
// 	{
	//         If (Session("dsGrid") Is Nothing) Then
	//             echo "No hay datos para esta consulta...")
	//         Else
	//             If (Session("g_arrRptDefinition") Is Nothing) Then
	//                 echo "No se ecuentra definido el modelo del reporte para esta consulta...")
	//             Else
	//                 GetHTMLPreview(Session("dsGrid"), Session("g_arrRptDefinition"))
	//             End If
	//         End If
// 	}

	function GetHTMLPreview($arrTitles, $arrContent, $arrSubTotals = null, $p_strTitle = '', $p_bPrint = false )
	{
// 		var $strContent ;
// 		$intCol
// 		$intRow ;
		
		##Estilo para las celdas del tipo texto
		echo "<html>\n";
		echo "<head>\n";
		echo "    <style> \n";

		echo " body \n";
		echo " {font-size: 10pt; ";
		echo " font-family: Verdana;}\n ";


		echo "       .style0 \n";
		echo "{mso-number-format:General; text-align:general; vertical-align:bottom;white-space:nowrap;\n" ;
		echo "mso-rotate:0; mso-background-source:auto; mso-pattern:auto; color:windowtext; font-size:10.0pt;\n";
		echo "font-weight:400; font-style:normal; text-decoration:none; font-family:Arial; mso-generic-font-family:auto;\n";
		echo "mso-font-charset:0; border:none; mso-protection:locked visible; mso-style-name:Normal;	mso-style-id:0;}\n";
		echo "   .xl27\n";
		echo "   {mso-style-parent:style0;\n";
		echo "   mso-number-format:'\@';\n";
		echo "   border:.5pt solid black;\n";
		echo "   white-space:normal;}\n";
		echo "</style>\n";
		echo "</head>\n";
		echo "<body>\n";
		
		
		if(strlen($p_strTitle )>0)
		{
			echo "<br>\n";
			echo "<Div width='595px' style='font-size: 14px; font-weight: bold; font-family:  Verdana; color: #002b5e; margin-top: 20px; text-align: left; ' >" . $p_strTitle . "</Div>\n" ;
			echo "<br>\n";
			echo "<br>\n";
		}
		
		
	
		if( isset($_GET['Filters']) )
		{
			$arrFilters  = explode(",", $_GET['Filters'] );
			$i = 1;
			echo "<br><TABLE border='0' width='595px' >\n";
			foreach($arrFilters as $key => $value) 
			{
				
				
				echo "<tr>\n";
				echo "		<td style='color: #002b5e; font-size: 11pt; font-weight: bold; font-family:  Verdana;  text-align: center;'>\n";
				$arrValue = explode(";", $value );
				
				echo $arrValue[0] . ': ' . $arrValue[1];
				
				echo "		</td>\n";
				echo "</tr>\n";
				
				
				
				
			}
			echo "</TABLE><br><br><br>\n";
		}

		echo "<TABLE border='1pt' width='595px'>\n";
	
		#build <THEAD>
		$strContent = "<THEAD style='font-size: 10pt;'><TR>\n";
				
		foreach ( $arrTitles as $Data) 
		{ 
			$Data = str_replace( "ó", "&#243", $Data);
			$Data = str_replace( "á", "&#225", $Data);
			$Data = str_replace( "é", "&#233", $Data);
			$Data = str_replace( "í", "&#237", $Data);
			$Data = str_replace( "ú", "&#250", $Data);
			$Data = str_replace( "Á", "&#193", $Data);
			$Data = str_replace( "É", "&#201", $Data);
			$Data = str_replace( "Í", "&#205", $Data);
			$Data = str_replace( "Ó", "&#211", $Data);
			$Data = str_replace( "Ú", "&#218", $Data);
			$Data = str_replace( "Ñ", "&#209", $Data);
			$Data = str_replace( "ñ", "&#241", $Data);
			$strContent .= "<TH>" . $Data . "</TH>\n";
		}
		
		$strContent .= "</TR></THEAD>\n";
	
		echo $strContent;
	
		If ($arrContent != null)
		{ 
		
			#se descargan los datos de todo el Reporte
			# - debo ver que grupo de registros se seleccionaron
			
			#build <TBODY>
			echo "<TBODY style='font-size: 8pt;'>\n";
			
			foreach($arrContent as $arrRow)
			{
			
				$strContent = "<TR>";
				
				foreach($arrRow as $Col)
				{
				
						$Col = str_replace( "ó", "&#243", $Col);
						$Col = str_replace( "á", "&#225", $Col);
						$Col = str_replace( "é", "&#233", $Col);
						$Col = str_replace( "í", "&#237", $Col);
						$Col = str_replace( "ú", "&#250", $Col);
						$Col = str_replace( "Á", "&#193", $Col);
						$Col = str_replace( "É", "&#201", $Col);
						$Col = str_replace( "Í", "&#205", $Col);
						$Col = str_replace( "Ó", "&#211", $Col);
						$Col = str_replace( "Ú", "&#218", $Col);
						$Col = str_replace( "Ñ", "&#209", $Col);
						$Col = str_replace( "ñ", "&#241", $Col);
						
						$strContent .= '<TD>';
						if( trim($Col) != "")
						{
							$strContent .=$Col;
						}else{
							$strContent .='&nbsp;';
						}
						 
						$strContent .=  '</TD>';
						
				}
			
				
				
				$strContent .= "</TR>\n";
	
				echo $strContent;
			
			}
			
			
			if($arrSubTotals != null)
			{
				$strContent = "<TR>\n";
				foreach($arrSubTotals as $Col)
				{
			
					$Col = str_replace( "ó", "&#243", $Col);
					$Col = str_replace( "á", "&#225", $Col);
					$Col = str_replace( "é", "&#233", $Col);
					$Col = str_replace( "í", "&#237", $Col);
					$Col = str_replace( "ú", "&#250", $Col);
					$Col = str_replace( "Á", "&#193", $Col);
					$Col = str_replace( "É", "&#201", $Col);
					$Col = str_replace( "Í", "&#205", $Col);
					$Col = str_replace( "Ó", "&#211", $Col);
					$Col = str_replace( "Ú", "&#218", $Col);
					$Col = str_replace( "Ñ", "&#209", $Col);
					$Col = str_replace( "ñ", "&#241", $Col);
					
					
					$strContent .= "<TD style='font-weight: bold;'>";
					if( trim($Col) != "")
					{
						$strContent .= $Col;
					}else{
						$strContent .='&nbsp;';
					}
						
					$strContent .=  '</TD>';
					
				}
				$strContent .= "</TR>\n";
				
				echo $strContent;
			}
			echo "</TBODY>\n";
		
		}
	
		#close <TABLE>
		echo "</TABLE>\n";

		if ($p_bPrint)
		{
			echo "<br /><br /><a href='#' onclick='window.print();'><img src='../img/imprimir.gif' border='0'></a>";
		}

		echo "</body>\n";
		echo "</html>\n";
	}
	
}
?>