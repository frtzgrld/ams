<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'modules/file/controllers/file.php');

class Quotations extends File {

	function __construct()
	{
		parent::__construct();

		$this->load->model('quotation_model');
	}


	protected $title = 'Quotations';
	protected $submenu = 'quotations';


	public function index()
	{
		$data = array(
				'menu' 		=> $this->menu,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title,
				'quotation'	=> $this->quotation_model->get_quotation(),
			);

		$this->get_view('quotation/quotation_index', $data);
	}


	public function new_request()
	{
		$data = array(
				'menu' 		=> $this->menu,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title.' <small>NEW REQUEST</small>',
				'purch_req'	=> $this->file_model->options_purchase_request(),
				'app'		=> $this->file_model->options_app(),
				'quotation'	=> null,
			);

		$this->get_view('quotation/quotation_form', $data);
	}


	public function edit_quotation()
	{
		$url_quotation_id = $this->uri->segment(4);
		$quotation_detail = $this->quotation_model->get_quotation( array('ID' => $url_quotation_id), TRUE );
		$this->respond( $quotation_detail );

		$data = array(
				'menu' 		=> $this->menu,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title.' <small>NEW REQUEST</small>',
				'purch_req'	=> $this->file_model->options_purchase_request(),
				'app'		=> $this->file_model->options_app(),
				'quotation'	=> $quotation_detail,
			);

		$this->get_view('quotation/quotation_form', $data);
	}


	public function datatable_quotation()
	{
		$this->xhr();
        $results = $this->quotation_model->fetch_datable_quotation();
        echo json_encode($results);
	}

 
	public function quotation_detail()
	{
		$url_quotation_id = $this->uri->segment(4);
		$quotation_detail = $this->quotation_model->get_quotation( array('ID' => $url_quotation_id), TRUE );
		$this->respond( $quotation_detail );

		$data = array(
				'menu' 		=> $this->menu,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title,
				'quotation'	=> $quotation_detail,
			);

		$this->get_view('quotation/quotation_detail', $data);
	}


	public function validate_quotation()
	{
		$this->xhr();
		$post_formdata = $this->input->post();
		$results = $this->quotation_model->save_quotation( $post_formdata );
        echo json_encode($results);
	}


	public function extend_deadline()
	{
		$this->xhr();
		$post_formdata = $this->input->post();
		$results = $this->quotation_model->save_date_extension( $post_formdata );
        echo json_encode($results);
	}


	public function print_quotation()
	{
		$url_quotation_id = $this->uri->segment(4);
		$quotation_detail = $this->quotation_model->get_quotation( array('ID' => $url_quotation_id), TRUE );
		$this->respond( $quotation_detail );

		// print_r($quotation); die();

		$filename = 'rfq_'.$url_quotation_id;

		$pdf = new PDF('P','mm', 'A4');
		$pdf->SetAutoPageBreak(false);

		$ctr = 0;
		$size1 = 10;
		$size2 = 20;
		$size3 = 30;
		$size4 = 65;
		$size5 = 25;
		$full = 190;
		$allowance = 35;

        $pdf->AddPage();

        foreach ($quotation_detail as $row) 
        {
        	$ch = 5;
	        $pdf->SetFont('Arial', 'B', 12);
			$pdf->MultiCell($full, $ch, 'City Government of Valencia', '', 'C');

	        $pdf->SetFont('Arial', '', 14);
			$pdf->MultiCell($full, $ch*3, 'Request for Quotation', '', 'C');

	  //       $pdf->SetFont('Arial', 'BU', 12);
			// $pdf->MultiCell($full, $ch, 'Agency', '', 'C');
			// $pdf->MultiCell($full, $ch, '', '', 'C');

			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
			$pdf->SetXY($current_x, $current_y);

	        $pdf->SetFont('Arial', '', 9);
			$pdf->MultiCell($full, $ch, '', '', 'C');

			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
			$pdf->SetXY($current_x, $current_y);

	        // $line_of_office = $pdf->NbLines($full*0.4, $row['CANVAS_NO']);

			$pdf->MultiCell($full*0.2, $ch, 'Quotation no.', '', 'L');
			$pdf->SetXY($current_x+=$full*0.2, $current_y);
	        $pdf->SetFont('Arial', 'B', 9);
			$pdf->MultiCell($full*0.25, $ch, $row['QUOTATION_NO'], 'B', 'L');
			
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
	        $pdf->SetFont('Arial', '', 9);
			$pdf->SetXY($current_x, $current_y);
			$pdf->MultiCell($full*0.2, $ch, 'Purchase Request(s) no.', '', 'L');
			$pdf->SetXY($current_x+=$full*0.2, $current_y);
	        $pdf->SetFont('Arial', 'B', 9);
			$pdf->MultiCell($full*0.25, $ch, $row['PURCHASE_REQUESTS'][0]['PR_NO'], 'B', 'L');

			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
	        $pdf->SetFont('Arial', '', 9);
			$pdf->SetXY($current_x, $current_y);
			$pdf->MultiCell($full*0.2, $ch, 'APP / SPPMP', '', 'L');
			$pdf->SetXY($current_x+=$full*0.2, $current_y);
	        $pdf->SetFont('Arial', 'B', 9);
			$pdf->MultiCell($full*0.25, $ch, NULL, 'B', 'L');

			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
	        $pdf->SetFont('Arial', '', 9);
			$pdf->SetXY($current_x, $current_y);
			$pdf->MultiCell($full*0.2, $ch, 'Canvas no.', '', 'L');
			$pdf->SetXY($current_x+=$full*0.2, $current_y);
	        $pdf->SetFont('Arial', 'B', 9);
			$pdf->MultiCell($full*0.25, $ch, $row['CANVAS_NO'], 'B', 'L');

			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
	        $pdf->SetFont('Arial', '', 9);
			$pdf->SetXY($current_x, $current_y);
			$pdf->MultiCell($full*0.2, $ch, 'Date', '', 'L');
			$pdf->SetXY($current_x+=$full*0.2, $current_y);
	        $pdf->SetFont('Arial', 'B', 9);
			$pdf->MultiCell($full*0.25, $ch, date_format(date_create($row['DATEPOSTED']), 'd-M-y'), 'B', 'L');

			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
	        $pdf->SetFont('Arial', '', 9);
			$pdf->SetXY($current_x, $current_y);
			$pdf->MultiCell($full*0.2, $ch, 'Authority', '', 'L');
			$pdf->SetXY($current_x+=$full*0.2, $current_y);
	        $pdf->SetFont('Arial', 'B', 9);
			$pdf->MultiCell($full*0.25, $ch, $row['AUTHORITY'][0]['DESCRIPTION'], 'B', 'L');

			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
	        $pdf->SetFont('Arial', '', 9);
			$pdf->SetXY($current_x, $current_y);
			$pdf->MultiCell($full*0.2, $ch, 'Authority No. / Date:', '', 'L');
			$pdf->SetXY($current_x+=$full*0.2, $current_y);
	        $pdf->SetFont('Arial', 'B', 9);
			$pdf->MultiCell($full*0.25, $ch, $row['AUTHORITY_NO'].'   '.date_format(date_create($row['AUTHORITY_DATE']), 'd-M-y'), 'B', 'L');

			$pdf->Ln();
	        $pdf->SetFont('Arial', '', 9);
			$pdf->MultiCell($full, $ch, 'Please quote your lowest government price for the following items specified below:', '', 'L');
			$pdf->MultiCell($full, $ch, '', '', 'L');
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			//	table header

	        $pdf->SetFont('Arial', '', 9);
			$pdf->MultiCell($full*0.1, $ch, 'Item No.', 'TBL', 'C');
			
			$pdf->SetXY($current_x+=$full*0.1, $current_y);
			$pdf->MultiCell($full*0.15, $ch, 'Total ABC (in Php)', 'TBL', 'C');
			
			$pdf->SetXY($current_x+=$full*0.15, $current_y);
			$pdf->MultiCell($full*0.05, $ch, 'Qty.', 'TBL', 'C');
			
			$pdf->SetXY($current_x+=$full*0.05, $current_y);
			$pdf->MultiCell($full*0.05, $ch, 'Unit', 'TBL', 'C');
			
			$pdf->SetXY($current_x+=$full*0.05, $current_y);
			$pdf->MultiCell($full*0.41, $ch, 'Specifications', 'TBL', 'C');
			
			$pdf->SetXY($current_x+=$full*0.41, $current_y);
			$pdf->MultiCell($full*0.12, $ch, 'Unit Price', 'TBLR', 'C');
			
			$pdf->SetXY($current_x+=$full*0.12, $current_y);
			$pdf->MultiCell($full*0.12, $ch, 'Total Price', 'TBLR', 'C');

			//	table body
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
			$spaces = 30;

			foreach ($row['PURCHASE_REQUESTS'] as $prs) 
			{
				$item_ctr = $total_amount = 0;

				foreach ($prs['ITEMS'] as $item ) 
				{
					$item_ctr++;
					$lines = $pdf->NbLines( $full*0.4, $item['PRI_DESC']);
					$spaces -= $lines+1;

		        	$pdf->SetFont('Arial', '', 9);
					$pdf->MultiCell($full*0.1, $ch*$lines, $item_ctr, 'L', 'L');

					$pdf->SetXY($current_x+=$full*0.1, $current_y);
					$pdf->MultiCell($full*0.15, $ch*$lines, null, 'L', 'L');

					$pdf->SetXY($current_x+=$full*0.15, $current_y);
					$pdf->MultiCell($full*0.05, $ch, number_format($item['QTY']), 'L', 'R');
					
					$pdf->SetXY($current_x+=$full*0.05, $current_y);
					$pdf->MultiCell($full*0.05, $ch*$lines, $item['UNIT'], 'L', 'C');
					
		        	$pdf->SetFont('Arial', 'B', 9);
					$pdf->SetXY($current_x+=$full*0.05, $current_y);
					$pdf->MultiCell($full*0.41, $ch*$lines, $item['PRI_DESC'], 'L', 'L');
					
		        	$pdf->SetFont('Arial', '', 9);
					$pdf->SetXY($current_x+=$full*0.41, $current_y);
					$pdf->MultiCell($full*0.12, $ch*$lines, null, 'LR', 'R');
					//	($item['UNIT_COST'])?number_format($item['UNIT_COST'],2):
					
					$pdf->SetXY($current_x+=$full*0.12, $current_y);
					$pdf->MultiCell($full*0.12, $ch*$lines, null, 'LR', 'R');
					//	($item['AMOUNT'])?number_format($item['AMOUNT'],2):

		        	// $pdf->SetFont('Arial', '', 9);
		        	$lines = $pdf->NbLines( $full*0.41, $item['SPECS']);
		        	$spaces -= $lines+1;

					$current_y = $pdf->GetY();
					$current_x = $pdf->GetX();

		        	$pdf->SetFont('Arial', '', 9);
					$pdf->MultiCell($full*0.1, $ch*$lines, NULL, 'L', 'L');

					$pdf->SetXY($current_x+=$full*0.1, $current_y);
					$pdf->MultiCell($full*0.15, $ch*$lines, NULL, 'L', 'L');

		        	$pdf->SetFont('Arial', 'B', 10);
					$pdf->SetXY($current_x+=$full*0.15, $current_y);
					$pdf->MultiCell($full*0.05, $ch*$lines, NULL, 'L', 'L');
					
		        	$pdf->SetFont('Arial', '', 9);
					$pdf->SetXY($current_x+=$full*0.05, $current_y);
					$pdf->MultiCell($full*0.05, $ch*$lines, NULL, 'L', 'R');
					
					$pdf->SetXY($current_x+=$full*0.05, $current_y);
					$pdf->MultiCell($full*0.01, $ch*$lines, NULL, 'L', 'L');
					
		        	$pdf->SetFont('Arial', 'I', 9);
					$pdf->SetXY($current_x+=$full*0.01, $current_y);
					$pdf->MultiCell($full*0.4, $ch, $item['SPECS'], '', 'L');
					
		        	$pdf->SetFont('Arial', '', 9);
					$pdf->SetXY($current_x+=$full*0.4, $current_y);
					$pdf->MultiCell($full*0.12, $ch*$lines, NULL, 'LR', 'R');
					
					$pdf->SetXY($current_x+=$full*0.12, $current_y);
					$pdf->MultiCell($full*0.12, $ch*$lines, NULL, 'LR', 'R');
					
					$current_y = $pdf->GetY();
					$current_x = $pdf->GetX();

		        	$pdf->SetFont('Arial', '', 9);
					$pdf->MultiCell($full*0.1, $ch*$lines, NULL, 'L', 'L');

					$pdf->SetXY($current_x+=$full*0.1, $current_y);
					$pdf->MultiCell($full*0.15, $ch*$lines, NULL, 'L', 'L');

		        	$pdf->SetFont('Arial', 'B', 10);
					$pdf->SetXY($current_x+=$full*0.15, $current_y);
					$pdf->MultiCell($full*0.05, $ch*$lines, NULL, 'L', 'L');
					
		        	$pdf->SetFont('Arial', '', 9);
					$pdf->SetXY($current_x+=$full*0.05, $current_y);
					$pdf->MultiCell($full*0.05, $ch*$lines, NULL, 'L', 'R');
					
					$pdf->SetXY($current_x+=$full*0.05, $current_y);
					$pdf->MultiCell($full*0.41, $ch*$lines, NULL, 'L', 'R');
					
					$pdf->SetXY($current_x+=$full*0.41, $current_y);
					$pdf->MultiCell($full*0.12, $ch*$lines, NULL, 'LR', 'R');
					
					$pdf->SetXY($current_x+=$full*0.12, $current_y);
					$pdf->MultiCell($full*0.12, $ch*$lines, NULL, 'LR', 'R');
					
					$current_y = $pdf->GetY();
					$current_x = $pdf->GetX();

					//	specs proper
					// foreach ($item['SPECIFICATIONS'] as $spec) 
					// {
			  //       	$pdf->SetFont('Arial', '', 9);
			  //       	$lines = $pdf->NbLines( $size2, trim($spec['SPECIFICATION']));

					// 	$pdf->MultiCell($size1, $ch*$lines, NULL, 'L', 'L');
					// 	$current_x += $size1;
					// 	$pdf->SetXY($current_x, $current_y);

					// 	$pdf->MultiCell($size2, $ch*$lines, NULL, 'L', 'R');
					// 	$current_x += $size2;
					// 	$pdf->SetXY($current_x, $current_y);

					// 	$pdf->MultiCell($size2, $ch*$lines, NULL, 'L', 'R');
					// 	$current_x += $size2;
					// 	$pdf->SetXY($current_x, $current_y);

					// 	$pdf->MultiCell($size2, $ch*$lines, NULL, 'L', 'R');
					// 	$current_x += $size2;
					// 	$pdf->SetXY($current_x, $current_y);

					// 	$pdf->MultiCell($size4, $ch, trim($spec['SPECIFICATION']), 'L', 'L');
					// 	$current_x += $size4;
					// 	$pdf->SetXY($current_x, $current_y);

					// 	$pdf->MultiCell($size5, $ch*$lines, NULL, 'L', 'R');
					// 	$current_x += $size5;
					// 	$pdf->SetXY($current_x, $current_y);

					// 	$pdf->MultiCell($size3, $ch*$lines, NULL, 'LR', 'R');
					// 	$current_x += $size3;
					// 	$pdf->SetXY($current_x, $current_y);
						
					// 	$pdf->Ln();
				 //        $start_x = $pdf->GetX();
					// 	$current_y = $pdf->GetY();
					// 	$current_x = $pdf->GetX();
					// }
					$total_amount += $item['AMOUNT'];
				}
			}

			//	occupy remaining height
        	$pdf->SetFont('Arial', '', 9);
			$pdf->MultiCell($full*0.1, $ch*$spaces, NULL, 'L', 'L');

			$pdf->SetXY($current_x+=$full*0.1, $current_y);
			$pdf->MultiCell($full*0.15, $ch*$spaces, NULL, 'L', 'L');

        	$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetXY($current_x+=$full*0.15, $current_y);
			$pdf->MultiCell($full*0.05, $ch*$spaces, NULL, 'L', 'L');
			
        	$pdf->SetFont('Arial', '', 9);
			$pdf->SetXY($current_x+=$full*0.05, $current_y);
			$pdf->MultiCell($full*0.05, $ch*$spaces, NULL, 'L', 'R');
			
			$pdf->SetXY($current_x+=$full*0.05, $current_y);
			$pdf->MultiCell($full*0.41, $ch*$spaces, NULL, 'L', 'R');
			
			$pdf->SetXY($current_x+=$full*0.41, $current_y);
			$pdf->MultiCell($full*0.12, $ch*$spaces, NULL, 'LR', 'R');
			
			$pdf->SetXY($current_x+=$full*0.12, $current_y);
			$pdf->MultiCell($full*0.12, $ch*$spaces, NULL, 'LR', 'R');

			//	footer begin
	        $pdf->SetFont('Arial', 'B', 10);

			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
			$pdf->MultiCell($full*0.25, $ch*3, 'Deadline of Submission: ', 'T', 'L');

			$pdf->SetXY($current_x+=$full*0.25, $current_y);
			$pdf->MultiCell($full*0.45, $ch*3, date_format( date_create($row['DEADLINE_OF_SUBMISSION']), 'F d, Y h:i A'), 'T', 'L');

			$pdf->SetXY($current_x+=$full*0.45, $current_y);
			$pdf->MultiCell($full*0.15, $ch*3, 'Grand Total:', 'T', 'L');

			$pdf->SetXY($current_x+=$full*0.15, $current_y);
			$pdf->MultiCell($full*0.15, $ch*3, NULL, 'T', 'L'); //'Php '.number_format($total_amount,2)

			// $current_y = $pdf->GetY();
			// $current_x = $pdf->GetX();
			// $pdf->MultiCell($full*0.2, $ch*2, NULL, '', 'C');

			// $pdf->SetXY($current_x+=$full*0.2, $current_y);
			// $pdf->MultiCell($full*0.4, $ch*2, 'Requested by:', '', 'C');
			
			// $pdf->SetXY($current_x+=$full*0.4, $current_y);
			// $pdf->MultiCell($full*0.4, $ch*2, 'Approved by:', '', 'C');
			
			// $current_y = $pdf->GetY();
			// $current_x = $pdf->GetX();
			// $pdf->MultiCell($full*0.2, $ch*2, 'Signature:', '', 'L');
			
			// $pdf->SetXY($current_x+=$full*0.2, $current_y);
			// $pdf->MultiCell($full*0.8, $ch*2, NULL, '', 'L');

			// $current_y = $pdf->GetY();
			// $current_x = $pdf->GetX();
			// $pdf->MultiCell($full*0.2, $ch, 'Printed name:', '', 'L');
			
			// $pdf->SetXY($current_x+=$full*0.2, $current_y);
			// $pdf->MultiCell($full*0.4, $ch, profile('EMPLOYEENO',$row['CANVASSED_BY'],'FULLNAME'), '', 'C');

			// $pdf->SetXY($current_x+=$full*0.4, $current_y);
			// $pdf->MultiCell($full*0.4, $ch, (is_null($row['CANVASSED_DATE'])?NULL:profile('EMPLOYEENO',$row['DECISION_BY'],'FULLNAME')), 'R', 'C');

			// $current_y = $pdf->GetY();
			// $current_x = $pdf->GetX();
			// $pdf->MultiCell($full*0.2, $ch, 'Designation:', 'LR', 'L');

			// $pdf->SetXY($current_x+=$full*0.2, $current_y);
			// $pdf->MultiCell($full*0.4, $ch, '', '', 'C');

			// $pdf->SetXY($current_x+=$full*0.4, $current_y);
			// $pdf->MultiCell($full*0.4, $ch, (is_null($row['CANVASSED_DATE'])?NULL:''), 'R', 'C');

			// $current_y = $pdf->GetY();
			// $current_x = $pdf->GetX();
			// $pdf->MultiCell($full*0.2, $ch, NULL, 'BLR', 'L');

			// $pdf->SetXY($current_x+=$full*0.2, $current_y);
			// $pdf->MultiCell($full*0.8, $ch, NULL, 'BR', 'C');
		}

		$pdf->Output($filename.'.pdf', 'I');
	}
}