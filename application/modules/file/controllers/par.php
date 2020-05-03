<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Main_Control.php');

Class PAR extends Main_Control
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('par_model');
		$this->load->model('offices/office_model');
	}

	protected $title = 'Property Acknowledgement Receipt';
	
	public function index()
	{
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'ris',
			'title'		=> $this->title,
			'button'	=> null,
		);

		$this->get_view('par/par_index', $data);
	}

	public function datatable_par_list()
	{
		if( $this->xhr() )
		$status = $this->uri->segment(4);
		// echo $status;
		// exit();
        $results = $this->par_model->fetch_datable_par_list($status);
        echo json_encode($results);
	}

	public function par_new()
	{
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'ris',
			'title'		=> $this->title,
			'offices'	=> $this->office_model->office_list(),
			'button'	=> null,
		);

		$this->get_view('par/par_new', $data);
	}

	public function par_header_save()
	{
		$this->db->insert('par', array('par_no' => $_POST['par_no'], 'fund_cluster' => $_POST['fund_cluster'], 'received_by'	=> $_POST['received_by'], 'received_by_position' => $_POST['received_by_position'], 'received_by_date'	=> date_format(date_create($_POST['received_by_date']), 'Y-m-d'), 'issued_by' => $_POST['issued_by'], 'issued_by_position' => $_POST['issued_by_position'], 'issued_by_date' => date_format(date_create($_POST['issued_by_date']), 'Y-m-d'), 'created_by' => $this->session->userdata('USERID'), 'status' => 0));

		// $this->db->insert('par', array('fund_cluster' => $_POST['fund_cluster'], 'entity_name' => 'City of CODEV', 'created_by' => $this->session->userdata('USERID')));

		$res_id = $this->db->insert_id();

		// $this->db->insert('par_details', array('par' => $res_id));

		redirect('file/par/par_items/'.$res_id);
	}

	public function par_items()
	{
		$parid =  $this->uri->segment(4);
		$par_rec = $this->par_model->get_par_rec($parid);
		// print_r($par_rec);
		// exit();
		
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'are',
			'title'		=> $this->title,
			'button'	=> null,
			'par_id'	=> $parid,
			'par_no'	=> $par_rec[0]['par_no'],
			'fund_cluster'	=> $par_rec[0]['fund_cluster'],
			'received_by'	=> $par_rec[0]['received_by'],
			'received_by_position'	=> $par_rec[0]['received_by_position'],
			'received_by_date'	=> date_format(date_create($par_rec[0]['received_by_date']), 'm/d/Y'),
			'issued_by'	=> $par_rec[0]['issued_by'],
			'issued_by_position'	=> $par_rec[0]['issued_by_position'],
			'issued_by_date'	=> date_format(date_create($par_rec[0]['issued_by_date']), 'm/d/Y'),
			'par_items_list' => $this->par_model->get_par_item_list($parid),
			'status'	=> $par_rec[0]['status'],
		);

		$this->get_view('par/par_items', $data);
	}

	public function datatable_par_items()
	{
		if( $this->xhr() )
		$stat = 0;
        $results = $this->par_model->fetch_datable_par_items_list($stat);
        echo json_encode($results);	
	}

	public function datatable_par_items_trans()
	{
		if( $this->xhr() )
		$stat = 1;
        $results = $this->par_model->fetch_datable_par_items_list($stat);
        echo json_encode($results);	
	}

	public function save_items()
	{
		$prop_id = $this->input->post('prop_id');
		
		$par_id = $this->input->post('par_id'); 

		$par_details = $this->par_model->get_par_det($prop_id);
		// print_r($par_details);
		// exit();
		if(count($par_details) < 1 || $par_details == NULL)
		{
			$this->db->insert('par_details', array('par' => $par_id, 'property' => $prop_id, 'CREATEDBY' => $this->session->userdata('USERID')));	

			$data_update2 = array(
				'status' => 1);
			$this->db->where('id', $par_id);
			$this->db->update('par', $data_update2);
		}
		else
		{
			$data_update = array(
				'active' => 0);
			$this->db->where('id', $par_details[0]['ID']);
			$this->db->update('par_details', $data_update);

			$data_update2 = array(
				'active' => 0,
				'status' => 2);
			$this->db->where('id', $par_details[0]['PAR']);
			$this->db->update('par', $data_update2);

			$this->db->insert('par_details', array('par' => $par_id, 'property' => $prop_id, 'CREATEDBY' => $this->session->userdata('USERID')));

			$data_update3 = array(
				'status' => 1);
			$this->db->where('id', $par_id);
			$this->db->update('par', $data_update3);	
		}

		$property_list = $this->par_model->get_property_list($prop_id);

		if($property_list[0]['STATUS'] == 0)
		{
			$data2 = array(
			'status' => 1);	

			$this->db->where('id', $prop_id);
			$this->db->where('active', 1);
			$results = $this->db->update('properties', $data2);
		}
		else
		{

			$data2 = array(
			'status' => 2);	

			$this->db->where('id', $prop_id);
			$this->db->where('active', 1);
			$results = $this->db->update('properties', $data2);
		}
		

		

		echo json_encode($results);
	}

	public function par_header_update()
	{
		$this->xhr();
		$post_form_data = $this->input->post();
        $results = $this->par_model->update_par_header($post_form_data);
        // var_dump($results);
        echo json_encode($results);
	}

	public function delete_items()
	{
		$prop_id = $this->input->post('prop_id');
		$par_id = $this->input->post('par_id'); 

		$data = array(
			'are'	=> 0,
			'form_type' => 0,
			);
		
		$this->db->where('id', $prop_id);
		$results = $this->db->update('properties', $data);

		echo json_encode($results);
	}

	public function view_par()
	{
		$par_id = $this->uri->segment(4);
		$data['details'] = $this->par_model->get_par('par.id', $par_id, true);
	// var_dump($get_par);
	// exit();
		// $data = array(
		// 	'SUPPLIER' => $record[0]['SUPPLIER'],
		// 	'PO_NO'		=> $record[0]['PO_NO'],
		// 	'PO_DATE'	=> date_format(date_create($record[0]['PO_DATE']), 'm/d/Y'),
		// 	'IAR_CONTROL_NO'	=> $record[0]['IAR_CONTROL_NO'],
		// 	'PR_NO'	=> $record[0]['PR_NO'],
		// 	'PR_DATE'	=> date_format(date_create($record[0]['PR_DATE']), 'm/d/Y'),

		// 	);
		$this->load->library('pdf_helper');
        $this->pdf_helper->load_view('par/print_par', $data);
        $this->pdf_helper->render();
        $this->pdf_helper->output();
        $this->pdf_helper->stream("par.pdf", array('Attachment' => 0));
	}

	public function print_par()
	{
		$par_id = $this->uri->segment(4);
		$this->revert($par_id, 'file/par');

		$get_par = $this->par_model->get_par('par.id', $par_id, true);
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

        foreach ($get_par as $row) 
        {
        	$start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			$ch = 5;
	        $pdf->SetFont('Arial', '', 9);

	        //ARE Title
			$pdf->MultiCell($full, $ch*4, 'PROPERTY ACKNOWLEDGEMENT RECEIPT', 'TLR', 'C');
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
			$pdf->MultiCell($full-140, $ch*2, $row['PAR_NO'], 'B', 'C');
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
			$pdf->MultiCell($full-172.5, $ch*2, 'QTY.', 'TLRB', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			//17.5
			$pdf->MultiCell($full-172.5, $ch*2, 'Unit', 'TRB', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			//67.5
			$pdf->MultiCell($full-122.5, $ch*2, 'Article Description', 'TRB', 'C');
			$current_x += $full-122.5;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			// $pdf->MultiCell($full-167.5, $ch*2, 'Class Code', 'TLRB', 'C');
			// $current_x += $full-167.5;
			// $pdf->SetXY($current_x, $current_y);

			//40
			$pdf->MultiCell($full-150, $ch*2, 'Property No', 'TRB', 'C');
			$current_x += $full-150;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			$pdf->MultiCell($full-167.5, $ch*2, 'Date Acquired', 'TRB', 'C');
			$current_x += $full-167.5;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch*2, 'Unit Cost', 'TRB', 'C');
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
				$pdf->MultiCell($full-172.5, $ch+2, '1', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, 'unit', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//67.5
				$pdf->MultiCell($full-122.5, $ch+2, $items['DESCRIPTION'], 'TRB', 'C');
				$current_x += $full-122.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				// $pdf->MultiCell($full-167.5, $ch+2, $items['CLASSCODE'], 'TLRB', 'C');
				// $current_x += $full-167.5;
				// $pdf->SetXY($current_x, $current_y);

				//40
				$pdf->MultiCell($full-150, $ch+2, $items['PROPERTYNO'] , 'TRB', 'L');
				$current_x += $full-150;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, $items['DATEACQUIRED'], 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//25
				$pdf->MultiCell($full-165, $ch+2, $items['UNITCOST'] , 'TRB', 'R');
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
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//67.5
				$pdf->MultiCell($full-122.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-122.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				// $pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				// $current_x += $full-167.5;
				// $pdf->SetXY($current_x, $current_y);

				//40
				$pdf->MultiCell($full-150, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-150;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//25
				$pdf->MultiCell($full-165, $ch+2, '' , 'TRB', 'R');
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
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//67.5
				$pdf->MultiCell($full-122.5, $ch+2, '***Nothing Follows*', 'TRB', 'C');
				$current_x += $full-122.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				// $pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				// $current_x += $full-167.5;
				// $pdf->SetXY($current_x, $current_y);

				//40
				$pdf->MultiCell($full-150, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-150;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//25
				$pdf->MultiCell($full-165, $ch+2, '' , 'TRB', 'R');
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
		$pdf->MultiCell($full-155, $ch*2, 'Received By', '', 'L');
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
