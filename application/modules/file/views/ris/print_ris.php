<!DOCTYPE html>
<html>
<head>
    <title>RS Report</title>
</head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<style type="text/css">
    .table , .tables{
        border-collapse: collapse;
        border-radius: 10px !important;
        overflow: hidden
    }

    .main_tbl{
        border-collapse: collapse;
        font-size: 11px
    }

    .table th, td {
        border-right: 1px solid black;
    }

    .tables th, td {
        border: 1px solid black ;
    }

    .main_tbl th, td {
        border: 1px solid black;
        
    }
    
    #header_table > th > td {
        border-right: 1px solid black !important;
    }

    #details > th > td {
        border-right: 1px solid black !important;
    }
    
</style>
<body>
    
    <table style="width:100%; height: 100px; border: 0px;">
        <tr>
            <td style="border: 0px;" width="25%">
            </td>
            <td style="width: 5%; border: 0px;">
                <img src="<?php echo $_SERVER['DOCUMENT_ROOT']?>/asset_management/assets/images/valencia.png" style="width: 70px; height: 65px; vertical-align: text-top">
                
            </td>
            <td style=" height: 50px; border: 0px;" align="center">
                <font style="font-size: 13px; margin-top: -10px; margin-left: 0px; white-space:nowrap; ">Republic of the Philippines</font><br/>
                <font style="font-size: 12px;  white-space:nowrap;">Province of Bukidnon</font><br/>
                <font style="font-size: 13px;  white-space:nowrap;">CITY OF VALENCIA</font>
                
            </td>
            <td width="40%" style="border: 0px;" align="right">
                <!-- <font style="font-size: 13px;  white-space:nowrap; vertical-align: bottom;"> PAR No.  </font> -->
            </td>

        </tr>
        
    </table>
    <div style="z-index: 10;  position: relative;  margin-left: 550px; margin-top: -20px; ">
        <p><font style="font-size: 10px;  ">PAR No. </font></p>    
    </div>
    

    <table style="width:100%; height: 100px; border: 1px;">
        <tr>
            <td style="border: 1px;" align="center">
                <font style="font-size: 13px; font-weight: bold; margin-top: -30px; margin-left: 0px; white-space:nowrap; vertical-align: top ">CITY GENERAL SERVICES OFFICE (CGSO)</font><br/>
                <font style="font-size: 16px; font-weight: bold; white-space:nowrap;">PROPERTY ACKNOWLEDGEMENT RECEIPT</font><br/>
            </td>
        </tr>
    </table>

    <table style="border: 1px solid black; width: 100%; margin-top: .25in" id="details" class="main_tbl">
        <thead>
            <tr>
                <th width="15%" height="3%"><font style="font-size: 14px;display: block; margin-top: 8px;">QUANTITY</font></th>
                <th width="10%"><font style="font-size: 14px;display: block; margin-top: 8px;">UNIT</font></th>
                <th colspan="2"><font style="font-size: 14px;display: block; margin-top: 8px;">DESCRIPTION</font></th>
                <th><font style="font-size: 14px;display: block; margin-top: 8px;">REMARKS</font></th>
                
            </tr>
            
        </thead>
        <tbody>
            <?php for($i = 0; $i <= 20; $i++){?>
            <tr style="height: 20px">
                <td style="border: 0px; border-right: 1px solid black">&nbsp</td>
                <td style="border: 0px; border-right: 1px solid black">&nbsp</td>
                <td colspan="2" style="border: 0px; border-right: 1px solid black">&nbsp</td>
                <td style="border: 0px;">&nbsp</td>
            </tr>
            <?php } ?>
            
            <tr>
                <td colspan="3" align="center" style="">
                <br/><br/>

                <font style="font-size: 13px;display: block; margin-top: 10px; font-weight: bold;">Position</font> <br/>
                
                <br/><br/><br/><br/>

                <font style="font-size: 13px;display: block; margin-top: -8px;">Date<br/></font>
                </td>

                <td colspan="2" align="center" height="20%">
                <font style="font-size: 13px;display: block; margin-top: 50px; font-weight: bold; text-decoration: underline;">VICKY LYN A. DURON</font><br/>
                <font style="font-size: 13px;display: block; margin-top: 8px; text-decoration: underline;">City General Services Officer</font><br/>
                <font style="font-size: 13px;display: block; margin-top: -8px;">Position</font>

                <br/><br/>

            
                
                <br/><br/>
                <font style="font-size: 13px;display: block; margin-top: 8px;"> _____________________</font><br/>
                <font style="font-size: 13px;display: block; margin-top: -8px; ">Date <br/>
                </font>
                </td>
            </tr>
        </tbody>
    </table>

   
    
</body>
</html>