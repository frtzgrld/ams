<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Main_Control.php');

Class ARE extends Main_Control
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('are_model');
		$this->load->model('offices/office_model');
	}

	protected $title = 'Acknowledgment Receipt for Equipment';

	public function index()
	{
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'are',
			'title'		=> $this->title,
			'button'	=> null,
		);

		$this->get_view('are/are_index', $data);
	}

	public function datatable_are_list()
	{
		if( $this->xhr() )
        $results = $this->are_model->fetch_datable_are_list();
        echo json_encode($results);
	}

	public function datatable_are_items()
	{
		if( $this->xhr() )
        $results = $this->are_model->fetch_datable_are_items_list();
        echo json_encode($results);	
	}

	public function are_new()
	{
		$areid =  $this->uri->segment(4);
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'are',
			'title'		=> $this->title,
			'offices'	=> $this->office_model->office_list(),
			'are_items_list' => $this->are_model->get_are_item_list($areid),
			'button'	=> null,
		);

		$this->get_view('file/are/are_new', $data);
	}

	public function are_header_save()
	{
		$this->db->insert('are', array('offices' => $_POST['office'], 'are_no' => $_POST['are_no'], 'date' => date_format(date_create($_POST['date']), 'Y-m-d'), 'serialno' => $_POST['serialno'], 'location' => $_POST['location'], 'remarks' => $_POST['remarks'], 'received_by'	=> $_POST['received_by'], 'received_by_position' => $_POST['received_by_position'], 'received_by_date'	=> date_format(date_create($_POST['received_by_date']), 'Y-m-d'), 'received_from' => $_POST['received_from'], 'received_from_position' => $_POST['received_from_position'], 'received_from_date' => date_format(date_create($_POST['received_from_date']), 'Y-m-d')));

		$res_id = $this->db->insert_id();

		redirect('file/are/are_items/'.$res_id);
	}

	public function are_header_update()
	{
		$this->xhr();
		$post_form_data = $this->input->post();
        $results = $this->are_model->update_are_header($post_form_data);
        // var_dump($results);
        echo json_encode($results);
	}

	public function are_items()
	{
		$areid =  $this->uri->segment(4);
		$are_rec = $this->are_model->get_are_rec($areid);
		
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'are',
			'title'		=> $this->title,
			'offices'	=> $this->office_model->office_list(),
			'button'	=> null,
			'are_id'	=> $areid,
			'are_no'	=> $are_rec[0]['are_no'],
			'date'		=> date_format(date_create($are_rec[0]['date']), 'm/d/Y') ,
			'offices_rec'	=> $are_rec[0]['offices'],
			'serial_no'	=> $are_rec[0]['serialno'],
			'location'	=> $are_rec[0]['location'],
			'remarks'	=> $are_rec[0]['remarks'],
			'received_by'	=> $are_rec[0]['received_by'],
			'received_by_position'	=> $are_rec[0]['received_by_position'],
			'received_by_date'	=> date_format(date_create($are_rec[0]['received_by_date']), 'm/d/Y'),
			'received_from'	=> $are_rec[0]['received_from'],
			'received_from_position'	=> $are_rec[0]['received_from_position'],
			'received_from_date'	=> date_format(date_create($are_rec[0]['received_from_date']), 'm/d/Y'),
			'are_items_list' => $this->are_model->get_are_item_list($areid),
		);

		$this->get_view('are/are_items', $data);
	}

	public function save_items()
	{
		$prop_id = $this->input->post('prop_id');
		$are_id = $this->input->post('are_id'); 

		$data = array(
			'are'	=> $are_id,
			);
		
		$this->db->where('id', $prop_id);
		$results = $this->db->update('properties', $data);

		echo json_encode($results);
	}

	public function delete_items()
	{
		$prop_id = $this->input->post('prop_id');
		$are_id = $this->input->post('are_id'); 

		$data = array(
			'are'	=> 0,
			);
		
		$this->db->where('id', $prop_id);
		$results = $this->db->update('properties', $data);

		echo json_encode($results);
	}

	public function print_are()
	{
		$are_id = $this->uri->segment(4);
		$this->revert($are_id, 'file/are');

		$get_are = $this->are_model->get_are('are.id', $are_id, true);
		//var_dump($get_are);
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

        foreach ($get_are as $row) 
        {
        	$start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			$ch = 5;
	        $pdf->SetFont('Arial', '', 9);

	        //ARE Title
			$pdf->MultiCell($full, $ch*4, 'ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT', 'TLR', 'C');
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

			$pdf->MultiCell($full-100, $ch, $row['DESCRIPTION'], '', 'C');
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
			$pdf->MultiCell($full-140, $ch*2, $row['ARE_NO'], 'B', 'C');
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

			$pdf->MultiCell($full-140, $ch*2, date_format(date_create($row['DATE']), 'Y-m-d') , 'B', 'C');
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
			$pdf->MultiCell($full-165, $ch+2, 'Office/College:', 'L', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//
			$pdf->MultiCell($full-30, $ch+2, '', 'B', '');
			$current_x += $full-30;
			$pdf->SetXY($current_x, $current_y);

			$pdf->MultiCell($full-185, $ch+2, '', 'R', 'C');
			$current_x += $full-185;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

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

			//45
			$pdf->MultiCell($full-145, $ch*2, 'Article Description', 'TRB', 'C');
			$current_x += $full-145;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			$pdf->MultiCell($full-167.5, $ch*2, 'Class Code', 'TLRB', 'C');
			$current_x += $full-167.5;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			$pdf->MultiCell($full-167.5, $ch*2, 'Date Acquired', 'TRB', 'C');
			$current_x += $full-167.5;
			$pdf->SetXY($current_x, $current_y);

			//30
			$pdf->MultiCell($full-160, $ch*2, 'Property No', 'TRB', 'C');
			$current_x += $full-160;
			$pdf->SetXY($current_x, $current_y);

			//17.5
			$pdf->MultiCell($full-172.5, $ch*2, 'Unit Cost', 'TRB', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			//17.5
			$pdf->MultiCell($full-172.5, $ch*2, 'Total Cost', 'TRB', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			foreach ($row['PROPERTIES'] as $items) 
			{
				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//45
				$pdf->MultiCell($full-145, $ch+2, $items['DESCRIPTION'], 'TRB', 'C');
				$current_x += $full-145;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, $items['CLASSCODE'], 'TLRB', 'C');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, $items['DATEACQUIRED'], 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//30
				$pdf->MultiCell($full-160, $ch+2, $items['PROPERTYNO'] , 'TRB', 'R');
				$current_x += $full-160;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, $items['UNITCOST'] , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, $items['UNITCOST'] , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				$pdf->Ln();
		        $start_x = $pdf->GetX();
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();
			}

				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//45
				$pdf->MultiCell($full-145, $ch+2, '', 'TRB', 'C');
				$current_x += $full-145;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//30
				$pdf->MultiCell($full-160, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-160;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				$pdf->Ln();
		        $start_x = $pdf->GetX();
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//45
				$pdf->MultiCell($full-145, $ch+2, '', 'TRB', 'C');
				$current_x += $full-145;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//30
				$pdf->MultiCell($full-160, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-160;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				$pdf->Ln();
		        $start_x = $pdf->GetX();
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//45
				$pdf->MultiCell($full-145, $ch+2, '', 'TRB', 'C');
				$current_x += $full-145;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//30
				$pdf->MultiCell($full-160, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-160;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				$pdf->Ln();
		        $start_x = $pdf->GetX();
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//45
				$pdf->MultiCell($full-145, $ch+2, '', 'TRB', 'C');
				$current_x += $full-145;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//30
				$pdf->MultiCell($full-160, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-160;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				$pdf->Ln();
		        $start_x = $pdf->GetX();
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//45
				$pdf->MultiCell($full-145, $ch+2, '', 'TRB', 'C');
				$current_x += $full-145;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//30
				$pdf->MultiCell($full-160, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-160;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				$pdf->Ln();
		        $start_x = $pdf->GetX();
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//45
				$pdf->MultiCell($full-145, $ch+2, '', 'TRB', 'C');
				$current_x += $full-145;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//30
				$pdf->MultiCell($full-160, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-160;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				$pdf->Ln();
		        $start_x = $pdf->GetX();
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '', 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//45
				$pdf->MultiCell($full-145, $ch+2, '', 'TRB', 'C');
				$current_x += $full-145;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, '', 'TRB', 'R');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//30
				$pdf->MultiCell($full-160, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-160;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, '' , 'TRB', 'R');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				$pdf->Ln();
		        $start_x = $pdf->GetX();
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

        }

        // ============== accounting ============//
		//35
		$pdf->MultiCell($full-155, $ch*2, 'Serial No:', 'BL', 'C');
		$current_x += $full-155;
		$pdf->SetXY($current_x, $current_y);

		//67.5
		$pdf->MultiCell($full-122.5, $ch*2, '', 'B', 'L');
		$current_x += $full-122.5;
		$pdf->SetXY($current_x, $current_y);

		//22.5
		$pdf->MultiCell($full-167.5, $ch*2, 'Location:', 'BL', 'L');
		$current_x += $full-167.5;
		$pdf->SetXY($current_x, $current_y);

		//65
		$pdf->MultiCell($full-125, $ch*2, '', 'BR', 'L');
		$current_x += $full-125;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		// ============== remarks ============//
		//35
		$pdf->MultiCell($full-155, $ch*4, 'Remarks:', 'BL', 'C');
		$current_x += $full-155;
		$pdf->SetXY($current_x, $current_y);

		//155
		$pdf->MultiCell($full-35, $ch*4, '', 'BR', 'L');
		$current_x += $full-35;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

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
		$pdf->MultiCell($full-165, $ch*2, 'Received From:', 'L', 'L');
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