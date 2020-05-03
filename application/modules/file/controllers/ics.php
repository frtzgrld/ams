<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Main_Control.php');

Class ICS extends Main_Control
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('ics_model');
		$this->load->model('offices/office_model');
	}

	protected	 $title = 'Inventory Custodian Slip';

	public function index()
	{
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'ris',
			'title'		=> $this->title,
			'button'	=> null,
		);

		$this->get_view('ics/ics_index', $data);
	}

	public function datatable_ics_list()
	{
		if( $this->xhr() )
        $results = $this->ics_model->fetch_datable_ics_list();
        echo json_encode($results);
	}

	public function ics_new()
	{
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'ris',
			'title'		=> $this->title,
			'offices'	=> $this->office_model->office_list(),
			'button'	=> null,
		);

		$this->get_view('ics/ics_new', $data);
	}

	public function ics_header_save()
	{
		$this->db->insert('ics', array('ics_no' => $_POST['ics_no'], 'fund_cluster' => $_POST['fund_cluster'], 'received_from'	=> $_POST['received_from'], 'received_from_position' => $_POST['received_from_position'], 'received_from_date'	=> date_format(date_create($_POST['received_from_date']), 'Y-m-d'), 'issued_by' => $_POST['issued_by'], 'issued_by_position' => $_POST['issued_by_position'], 'issued_by_date' => date_format(date_create($_POST['issued_by_date']), 'Y-m-d')));

		$res_id = $this->db->insert_id();

		redirect('file/ics/ics_items/'.$res_id);
	}

	public function ics_items()
	{
		$icsid =  $this->uri->segment(4);
		$par_rec = $this->ics_model->get_ics_rec($icsid);
		// print_r($par_rec);
		// exit();
		
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'are',
			'title'		=> $this->title,
			'button'	=> null,
			'ics_id'	=> $icsid,
			'ics_no'	=> $par_rec[0]['ics_no'],
			'fund_cluster'	=> $par_rec[0]['fund_cluster'],
			'received_from'	=> $par_rec[0]['received_from'],
			'received_from_position'	=> $par_rec[0]['received_from_position'],
			'received_from_date'	=> date_format(date_create($par_rec[0]['received_from_date']), 'm/d/Y'),
			'issued_by'	=> $par_rec[0]['issued_by'],
			'issued_by_position'	=> $par_rec[0]['issued_by_position'],
			'issued_by_date'	=> date_format(date_create($par_rec[0]['issued_by_date']), 'm/d/Y'),
			'ics_items_list' => $this->ics_model->get_ics_item_list($icsid),
		);

		$this->get_view('ics/ics_items', $data);
	}

	public function datatable_ics_items()
	{
		if( $this->xhr() )

        $results = $this->ics_model->fetch_datable_ics_items_list();
        echo json_encode($results);	
	}

	public function save_items()
	{
		$prop_id = $this->input->post('prop_id');
		$ics_id = $this->input->post('ics_id'); 

		$data = array(
			'are'	=> $ics_id,
			'form_type' => 1,
			);
		
		$this->db->where('id', $prop_id);
		$results = $this->db->update('properties', $data);

		echo json_encode($results);
	}

	public function ics_header_update()
	{
		$this->xhr();
		$post_form_data = $this->input->post();
        $results = $this->ics_model->update_ics_header($post_form_data);
        // var_dump($results);
        echo json_encode($results);
	}

	public function delete_items()
	{
		$prop_id = $this->input->post('prop_id');
		$ics_id = $this->input->post('ics_id'); 

		$data = array(
			'are'	=> 0,
			'form_type' => 0,
			);
		
		$this->db->where('id', $prop_id);
		$results = $this->db->update('properties', $data);

		echo json_encode($results);
	}

	public function print_ics()
	{
		$ics_id = $this->uri->segment(4);
		$this->revert($ics_id, 'file/ics');

		$get_ics = $this->ics_model->get_ics('ics.id', $ics_id, true);
		$filename = 'xsj';

		$pdf = new PDF('P','mm', 'A4');
		$pdf->SetAutoPageBreak(false);

		$ctr = 0;
		$size1 = 25;
		$size2 = 50;
		$size3 = 30;
		$full = $size1*2 + $size2 + $size3 * 3;
		$allowance = 35;

        $pdf->AddPage();

        $total_amount = 0;

        foreach ($get_ics as $row) 
        {
        	$start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			$ch = 5;
	        $pdf->SetFont('Arial', '', 9);

	        //ARE Title
			$pdf->MultiCell($full, $ch*4, 'INVENTORY CUSTODIAN SLIP', 'TLR', 'C');
			$current_x += $size1;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			//office
			$pdf->MultiCell($full-140, $ch, '', 'L', 'C');
			$current_x += $full-140;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-100, $ch, 'CODEV', '', 'C');
			$current_x += $full-100;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-140, $ch, '', 'R', 'C');
			$current_x += $full-140;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			$pdf->MultiCell($full-140, $ch*2, '', 'L', 'C');
			$current_x += $full-140;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-100, $ch*2, 'Agency', 'T', 'C');
			$current_x += $full-100;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-140, $ch*2, '', 'R', 'C');
			$current_x += $full-140;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			//======== header supplier, po no=======================//

			//25
			$pdf->MultiCell($full-165, $ch*2, '', 'L', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//80
			$pdf->MultiCell($full-110, $ch*2, '', 'C');
			$current_x += $full-110;
			$pdf->SetXY($current_x, $current_y);

			//5
			$pdf->MultiCell($full-185, $ch*2, '', '', 'C');
			$current_x += $full-185;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch*2, 'No.:', '', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//50
			$pdf->MultiCell($full-140, $ch*2, $row['ICS_NO'], 'B', 'C');
			$current_x += $full-140;
			$pdf->SetXY($current_x, $current_y);

			//5
			$pdf->MultiCell($full-185, $ch*2, '', 'R', 'C');
			$current_x += $full-185;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			// ================ supplier address, Date ================//
			$pdf->MultiCell($full-165, $ch*2, '', 'L', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-110, $ch*2, '', 'C');
			$current_x += $full-110;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-185, $ch*2, '', '', 'C');
			$current_x += $full-185;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-165, $ch*2, 'Date:', '', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-140, $ch*2, date_format(date_create($row['CREATED_DATE']), 'Y-m-d') , 'B', 'C');
			$current_x += $full-140;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-185, $ch*2, '', 'R', 'C');
			$current_x += $full-185;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			// =============== lining ===================//
			$pdf->MultiCell($full-80, $ch-2, '', 'L', '');
			$current_x += $full-80;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-110, $ch-2, '', 'R', '');
			$current_x += $full-110;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			// ============= Office/college ===============//
			//25
			// $pdf->MultiCell($full-165, $ch+2, 'Office/College:', 'L', 'C');
			// $current_x += $full-165;
			// $pdf->SetXY($current_x, $current_y);

			// //
			// $pdf->MultiCell($full-30, $ch+2, '', 'B', '');
			// $current_x += $full-30;
			// $pdf->SetXY($current_x, $current_y);

			// $pdf->MultiCell($full-185, $ch+2, '', 'R', 'C');
			// $current_x += $full-185;
			// $pdf->SetXY($current_x, $current_y);

			// $pdf->Ln();
	  //       $start_x = $pdf->GetX();
			// $current_y = $pdf->GetY();
			// $current_x = $pdf->GetX();

			// ================= lining ==============//
			$pdf->MultiCell($full-75, $ch, '', 'LB', '');
			$current_x += $full-75;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-115, $ch, '', 'RB', '');
			$current_x += $full-115;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			// ================= items ===============//

			//17.5
			$pdf->MultiCell($full-172.5, $ch, '', 'TLR', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			//17.5
			$pdf->MultiCell($full-172.5, $ch, '', 'TR', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			//40
			$pdf->MultiCell($full-150, $ch, 'Amount', 'TRB', 'C');
			$current_x += $full-150;
			$pdf->SetXY($current_x, $current_y);

			//60
			$pdf->MultiCell($full-130, $ch, '', 'TR', 'C');
			$current_x += $full-130;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			// $pdf->MultiCell($full-167.5, $ch*2, 'Class Code', 'TLRB', 'C');
			// $current_x += $full-167.5;
			// $pdf->SetXY($current_x, $current_y);

			//30
			$pdf->MultiCell($full-160, $ch, '', 'TR', 'C');
			$current_x += $full-160;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch, 'Estimated ', 'TR', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			

			//17.5
			// $pdf->MultiCell($full-172.5, $ch*2, 'Total Cost', 'TRB', 'C');
			// $current_x += $full-172.5;
			// $pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			//17.5
			$pdf->MultiCell($full-172.5, $ch*2, 'QTY.', 'LR', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			//17.5
			$pdf->MultiCell($full-172.5, $ch*2, 'Unit', 'R', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			//20
			$pdf->MultiCell($full-170, $ch*2, 'Unit Cost', 'R', 'C');
			$current_x += $full-170;
			$pdf->SetXY($current_x, $current_y);

			//20
			$pdf->MultiCell($full-170, $ch*2, 'Total Cost', 'R', 'C');
			$current_x += $full-170;
			$pdf->SetXY($current_x, $current_y);


			//60
			$pdf->MultiCell($full-130, $ch*2, 'Article Description', 'RB', 'C');
			$current_x += $full-130;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			// $pdf->MultiCell($full-167.5, $ch*2, 'Class Code', 'TLRB', 'C');
			// $current_x += $full-167.5;
			// $pdf->SetXY($current_x, $current_y);

			//30
			$pdf->MultiCell($full-160, $ch*2, 'Inventory Item No', 'RB', 'C');
			$current_x += $full-160;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch*2, 'Useful Life', 'RB', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//17.5
			// $pdf->MultiCell($full-172.5, $ch*2, 'Total Cost', 'TRB', 'C');
			// $current_x += $full-172.5;
			// $pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			if($row['PROPERTIES'] != null)
			{
				foreach ($row['PROPERTIES'] as $items) 
				{
					$pdf->SetFont('Arial', '', 9);
		        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

		        	//============== item details ===========//
					//17.5
					$pdf->MultiCell($full-172.5, $ch+2, '1', 'TLR', 'C');
					$current_x += $full-172.5;
					$pdf->SetXY($current_x, $current_y);

					//17.5
					$pdf->MultiCell($full-172.5, $ch+2, 'unit', 'TR', 'C');
					$current_x += $full-172.5;
					$pdf->SetXY($current_x, $current_y);

					//20
					$pdf->MultiCell($full-170, $ch+2, $items['UNITCOST'], 'TR', 'R');
					$current_x += $full-170;
					$pdf->SetXY($current_x, $current_y);

					//20
					$pdf->MultiCell($full-170, $ch+2, $items['UNITCOST'], 'TR', 'R');
					$current_x += $full-170;
					$pdf->SetXY($current_x, $current_y);

					//60
					$pdf->MultiCell($full-130, $ch+2, $items['DESCRIPTION'], 'TR', 'C');
					$current_x += $full-130;
					$pdf->SetXY($current_x, $current_y);

					//22.5
					// $pdf->MultiCell($full-167.5, $ch+2, $items['CLASSCODE'], 'TLRB', 'C');
					// $current_x += $full-167.5;
					// $pdf->SetXY($current_x, $current_y);

					//30
					$pdf->MultiCell($full-160, $ch+2, $items['PROPERTYNO'] , 'TR', 'L');
					$current_x += $full-160;
					$pdf->SetXY($current_x, $current_y);

					//25
					$pdf->MultiCell($full-165, $ch+2, $items['EST_USEFUL_LIFE'], 'TR', 'R');
					$current_x += $full-165;
					$pdf->SetXY($current_x, $current_y);


					//17.5
					// $pdf->MultiCell($full-172.5, $ch+2, $items['UNITCOST'] , 'TRB', 'R');
					// $current_x += $full-172.5;
					// $pdf->SetXY($current_x, $current_y);

					$pdf->Ln();
			        $start_x = $pdf->GetX();
					$current_y = $pdf->GetY();
					$current_x = $pdf->GetX();

					//============== item details ===========//
					//17.5
					$pdf->MultiCell($full-172.5, $ch+2, '', 'LR', 'C');
					$current_x += $full-172.5;
					$pdf->SetXY($current_x, $current_y);

					//17.5
					$pdf->MultiCell($full-172.5, $ch+2, '', 'R', 'C');
					$current_x += $full-172.5;
					$pdf->SetXY($current_x, $current_y);

					//20
					$pdf->MultiCell($full-170, $ch+2, '', 'R', 'C');
					$current_x += $full-170;
					$pdf->SetXY($current_x, $current_y);

					//20
					$pdf->MultiCell($full-170, $ch+2, '', 'R', 'C');
					$current_x += $full-170;
					$pdf->SetXY($current_x, $current_y);

					//60
					$pdf->MultiCell($full-130, $ch+2, '', 'R', 'C');
					$current_x += $full-130;
					$pdf->SetXY($current_x, $current_y);

					//22.5
					// $pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
					// $current_x += $full-167.5;
					// $pdf->SetXY($current_x, $current_y);

					//30
					$pdf->MultiCell($full-160, $ch+2, '' , 'R', 'R');
					$current_x += $full-160;
					$pdf->SetXY($current_x, $current_y);

					//25
					$pdf->MultiCell($full-165, $ch+2, '', 'R', 'R');
					$current_x += $full-165;
					$pdf->SetXY($current_x, $current_y);


					//17.5
					// $pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
					// $current_x += $full-172.5;
					// $pdf->SetXY($current_x, $current_y);

					$pdf->Ln();
			        $start_x = $pdf->GetX();
					$current_y = $pdf->GetY();
					$current_x = $pdf->GetX();

					$pdf->SetFont('Arial', '', 9);
		        	$lines = $pdf->NbLines( $size2, '');
				}
			}
			

				

        }

        $pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, '');

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'LRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'RB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//20	
				$pdf->MultiCell($full-170, $ch+2, '', 'RB', 'C');
				$current_x += $full-170;
				$pdf->SetXY($current_x, $current_y);

				//20
				$pdf->MultiCell($full-170, $ch+2, '', 'RB', 'C');
				$current_x += $full-170;
				$pdf->SetXY($current_x, $current_y);

				//60
				$pdf->MultiCell($full-130, $ch+2, '***Nothing Follows*', 'RB', 'C');
				$current_x += $full-130;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				// $pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				// $current_x += $full-167.5;
				// $pdf->SetXY($current_x, $current_y);

				//30
				$pdf->MultiCell($full-160, $ch+2, '' , 'RB', 'R');
				$current_x += $full-160;
				$pdf->SetXY($current_x, $current_y);

				//25
				$pdf->MultiCell($full-165, $ch+2, '', 'RB', 'R');
				$current_x += $full-165;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				// $pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				// $current_x += $full-172.5;
				// $pdf->SetXY($current_x, $current_y);

				$pdf->Ln();
		        $start_x = $pdf->GetX();
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, '');

        // ============== accounting ============//
		//35
		// $pdf->MultiCell($full-155, $ch*2, 'Serial No:', 'BL', 'C');
		// $current_x += $full-155;
		// $pdf->SetXY($current_x, $current_y);

		// //67.5
		// $pdf->MultiCell($full-122.5, $ch*2, '', 'B', 'L');
		// $current_x += $full-122.5;
		// $pdf->SetXY($current_x, $current_y);

		// //22.5
		// $pdf->MultiCell($full-167.5, $ch*2, 'Location:', 'BL', 'L');
		// $current_x += $full-167.5;
		// $pdf->SetXY($current_x, $current_y);

		// //65
		// $pdf->MultiCell($full-125, $ch*2, '', 'BR', 'L');
		// $current_x += $full-125;
		// $pdf->SetXY($current_x, $current_y);

		// $pdf->Ln();
  //       $start_x = $pdf->GetX();
		// $current_y = $pdf->GetY();
		// $current_x = $pdf->GetX();

		// ============== remarks ============//
		//35
		// $pdf->MultiCell($full-155, $ch*4, 'Remarks:', 'BL', 'C');
		// $current_x += $full-155;
		// $pdf->SetXY($current_x, $current_y);

		// //155
		// $pdf->MultiCell($full-35, $ch*4, '', 'BR', 'L');
		// $current_x += $full-35;
		// $pdf->SetXY($current_x, $current_y);

		// $pdf->Ln();
  //       $start_x = $pdf->GetX();
		// $current_y = $pdf->GetY();
		// $current_x = $pdf->GetX();

		//============== received by =============//
		//10
		$pdf->MultiCell($full-180, $ch*2, '', 'L', 'L');
		$current_x += $full-180;
		$pdf->SetXY($current_x, $current_y);

		//35
		$pdf->MultiCell($full-155, $ch*2, 'Received From:', '', 'L');
		$current_x += $full-155;
		$pdf->SetXY($current_x, $current_y);

		//42.5
		$pdf->MultiCell($full-147.5, $ch*2, '', '', 'L');
		$current_x += $full-147.5;
		$pdf->SetXY($current_x, $current_y);

		//15
		$pdf->MultiCell($full-175, $ch*2, '', 'R', 'L');
		$current_x += $full-175;
		$pdf->SetXY($current_x, $current_y);

		//25
		$pdf->MultiCell($full-165, $ch*2, 'Issued By:', 'L', 'L');
		$current_x += $full-165;
		$pdf->SetXY($current_x, $current_y);

		//52.5
		$pdf->MultiCell($full-137.5, $ch*2, '', '', 'L');
		$current_x += $full-137.5;
		$pdf->SetXY($current_x, $current_y);

		//10
		$pdf->MultiCell($full-180, $ch*2, '', 'R', 'L');
		$current_x += $full-180;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		// ======================== breakline ===============//

		//120.5
		$pdf->MultiCell($full-87.5, $ch*2, '', 'LR', 'L');
		$current_x += $full-87.5;
		$pdf->SetXY($current_x, $current_y);

		//87.5
		$pdf->MultiCell($full-102.5, $ch*2, '', 'LR', 'L');
		$current_x += $full-102.5;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();


		// ======================== Chief Accountant ===============//
		//20
		$pdf->MultiCell($full-170, $ch*2, '', 'L', 'C');
		$current_x += $full-170;
		$pdf->SetXY($current_x, $current_y);

		//67.5
		$pdf->MultiCell($full-122.5, $ch*2, 'Signature over Printed Name', 'T', 'C');
		$current_x += $full-122.5;
		$pdf->SetXY($current_x, $current_y);

		//15
		$pdf->MultiCell($full-175, $ch*2, '', 'R', 'L');
		$current_x += $full-175;
		$pdf->SetXY($current_x, $current_y);

		//22.5
		$pdf->MultiCell($full-167.5, $ch*2, '', 'L', 'L');
		$current_x += $full-167.5;
		$pdf->SetXY($current_x, $current_y);

		//55
		$pdf->MultiCell($full-135, $ch*2, 'Signature over Printed Name', 'T', 'C');
		$current_x += $full-135;
		$pdf->SetXY($current_x, $current_y);

		//10
		$pdf->MultiCell($full-180, $ch*2, '', 'R', 'L');
		$current_x += $full-180;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		// ======================== breakline ===============//

		//120.5
		$pdf->MultiCell($full-87.5, $ch*2, '', 'LR', 'L');
		$current_x += $full-87.5;
		$pdf->SetXY($current_x, $current_y);

		//87.5
		$pdf->MultiCell($full-102.5, $ch*2, '', 'LR', 'L');
		$current_x += $full-102.5;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		// ======================== Position ===============//
		//20
		$pdf->MultiCell($full-170, $ch*2, '', 'L', 'C');
		$current_x += $full-170;
		$pdf->SetXY($current_x, $current_y);

		//67.5
		$pdf->MultiCell($full-122.5, $ch*2, 'Position / Office', 'T', 'C');
		$current_x += $full-122.5;
		$pdf->SetXY($current_x, $current_y);

		//15
		$pdf->MultiCell($full-175, $ch*2, '', 'R', 'L');
		$current_x += $full-175;
		$pdf->SetXY($current_x, $current_y);

		//22.5
		$pdf->MultiCell($full-167.5, $ch*2, '', 'L', 'L');
		$current_x += $full-167.5;
		$pdf->SetXY($current_x, $current_y);

		//55
		$pdf->MultiCell($full-135, $ch*2, 'Position / Office', 'T', 'C');
		$current_x += $full-135;
		$pdf->SetXY($current_x, $current_y);

		//10
		$pdf->MultiCell($full-180, $ch*2, '', 'R', 'L');
		$current_x += $full-180;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		// ======================== breakline ===============//

		//120.5
		$pdf->MultiCell($full-87.5, $ch*2, '', 'LR', 'L');
		$current_x += $full-87.5;
		$pdf->SetXY($current_x, $current_y);

		//87.5
		$pdf->MultiCell($full-102.5, $ch*2, '', 'LR', 'L');
		$current_x += $full-102.5;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		// ======================== Date ===============//
		//20
		$pdf->MultiCell($full-170, $ch*2, '', 'LB', 'C');
		$current_x += $full-170;
		$pdf->SetXY($current_x, $current_y);

		//67.5
		$pdf->MultiCell($full-122.5, $ch*2, 'Date', 'TB', 'C');
		$current_x += $full-122.5;
		$pdf->SetXY($current_x, $current_y);

		//15
		$pdf->MultiCell($full-175, $ch*2, '', 'RB', 'L');
		$current_x += $full-175;
		$pdf->SetXY($current_x, $current_y);

		//22.5
		$pdf->MultiCell($full-167.5, $ch*2, '', 'LB', 'L');
		$current_x += $full-167.5;
		$pdf->SetXY($current_x, $current_y);

		//55
		$pdf->MultiCell($full-135, $ch*2, 'Date', 'TB', 'C');
		$current_x += $full-135;
		$pdf->SetXY($current_x, $current_y);

		//10
		$pdf->MultiCell($full-180, $ch*2, '', 'RB', 'L');
		$current_x += $full-180;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

        $pdf->Output($filename.'.pdf', 'I');
	}
}
