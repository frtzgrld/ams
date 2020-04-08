<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Main_Control.php');

Class RIS extends Main_Control
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('ris_model');
		$this->load->model('offices/office_model');
	}

	protected $title = 'Requisition Issuance Slip';

	public function index()
	{
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'ris',
			'title'		=> $this->title,
			'button'	=> null,
		);

		$this->get_view('ris/ris_index', $data);
	}

	public function ris_new()
	{
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'ris',
			'title'		=> $this->title,
			'offices'	=> $this->office_model->office_list(),
			'button'	=> null,
		);

		$this->get_view('ris/ris_new', $data);
	}

	public function ris_items()
	{
		$risid =  $this->uri->segment(4);
		$ris_rec = $this->ris_model->get_ris_rec($risid);
		// var_dump($ris_rec);
		
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'ris',
			'title'		=> $this->title,
			'offices'	=> $this->office_model->office_list(),
			'button'	=> null,
			'ris_id'	=> $risid,
			'ris_items_list' => $this->ris_model->get_ris_item_list($risid),
			'office_rec'	=> $ris_rec[0]['OFFICES'],
			'ris_no'		=> $ris_rec[0]['RIS_NO'],
			'requested_by'	=> $ris_rec[0]['REQUESTED_BY'],
			'noted_by'		=> $ris_rec[0]['NOTED_BY'],
			'approved_by'	=> $ris_rec[0]['APPROVED_BY'],
			'issued_by'		=> $ris_rec[0]['ISSUED_BY'],
			'received_by'	=> $ris_rec[0]['RECEIVED_BY'],
			'posted_by'		=> $ris_rec[0]['POSTED_BY'],
			'requested_date'			=> date_format(date_create($ris_rec[0]['REQUESTED_DATE']), 'm/d/Y'),
			
		);

		$this->get_view('ris/ris_items', $data);
	}

	public function ris_header_save()
	{
		$this->db->insert('ris', array('offices' => $_POST['office'], 'ris_no' => $_POST['ris_no'], 'requested_by' => $_POST['requested_by'], 'requested_date' => $_POST['requested_date'], 'noted_by' => $_POST['noted_by'], 'approved_by'	=> $_POST['approved_by'], 'issued_by' => $_POST['issued_by'], 'received_by' => $_POST['received_by'], 'posted_by' => $_POST['posted_by'], 'createdby' => $this->session->userdata('USERID')));
		$res_id = $this->db->insert_id();

		redirect('file/ris/ris_items/'.$res_id);
	}

	public function datatable_ris_items()
	{
		if( $this->xhr() )
        $results = $this->ris_model->fetch_datable_item_list();
        echo json_encode($results);
	}

	public function datatable_ris_list()
	{
		if( $this->xhr() )
        $results = $this->ris_model->fetch_datable_ris_list();
        echo json_encode($results);
	}

	public function save_items()
	{
		$itemid = $this->input->post('item_id');
		$ris_id = $this->input->post('ris_id'); 
		$itemlist = $this->ris_model->get_item($itemid);
		
		$results = $this->db->insert('ris_items', array('ris' => $ris_id, 'req_stock_no' => $itemlist[0]['code'], 'req_unit' => $itemlist[0]['unit'], 'req_description' => $itemlist[0]['id']));
		echo json_encode($results);
	}

	public function save_quantity()
	{
		$req_qty = $this->input->post('req_qty');
		$rel_qty = $this->input->post('rel_qty');
		$ris_id = $this->input->post('save_ris_id');
		$risitemid = $this->input->post('ris_item_id');

		$data = array(
			'req_qty'	=> $req_qty,
			'issued_qty' => $rel_qty,
			);
		
		// $this->db->where('id', $risitemid);
		// $this->db->update('ris_items', $data);

		$risitem_details = $this->ris_model->get_ris_item($risitemid);
		$supplies = $this->ris_model->get_supplies($risitem_details[0]['REQ_DESCRIPTION']);
		// var_dump($supplies);
		// exit();
		$qty = $rel_qty;
		$remainingQty = $qty;
		$currentQty = 0;

		foreach ($supplies as $key) {
			if($remainingQty <= 0)
			{
				break;
			}


			if($remainingQty > $key['QTYONHAND'])
			{
				$currentQty += $key['QTYONHAND']; //40
				$remainingQty -= $key['QTYONHAND']; //2

				$tempqty = $released_qty - $key['QTYONHAND'];
				$data3 = array(
					'QTYONHAND' => 0,
					'ONQUEUE'	=> 0
					);
				$this->db->where('id', $key['ID']);
				$this->db->update('supplies', $data3);
				// $released_qty = $tempqty;
				// echo $released_qty;
				// exit();
			}
			else
			{
				$tempCurrentQty = $currentQty; // 40
				$tempRemainingQty = $remainingQty; //2

				$currentQty += $remainingQty; //42
				$remainingQty = $currentQty - ($tempCurrentQty + $remainingQty);

				$qty_onhand = $key['QTYONHAND'] - $released_qty;

				$data2 = array(
					'QTYONHAND' => $qty_onhand - $tempRemainingQty,
					'ONQUEUE'	=> 1,
					);
				$this->db->where('id', $key['ID']);
				$this->db->update('supplies', $data2);
				// $released_qty = 0;
			}
		}

		redirect('file/ris/ris_items/'.$ris_id);
	}

	public function getQty()
	{
		$ris_id = $this->input->post('ris_id');
		$results = $this->ris_model->get_ris_item($ris_id);
		// var_dump($results);
		echo json_encode($results);
	}

	public function print_ris()
	{
		$ris_id = $this->uri->segment(4);
		$this->revert($ris_id, 'file/ris');

		$get_ris = $this->ris_model->get_ris('ris.id', $ris_id, true);
		//var_dump($get_ris);
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

        foreach ($get_ris as $row) 
        {
        	$start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			$ch = 5;
	        $pdf->SetFont('Arial', '', 9);

	        //ARE Title
			$pdf->MultiCell($full, $ch*4, 'REQUISITION ISSUANCE SLIP', 'TLR', 'C');
			$current_x += $size1;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			//======== Entity Name Func Cluster=======================//

			//25
			$pdf->MultiCell($full-165, $ch*2, 'Supplier:', 'L', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//60
			$pdf->MultiCell($full-130, $ch*2, '', 'B', 'C');
			$current_x += $full-130;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch*2, '', '', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch*2, 'PO No.:', '', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//50
			$pdf->MultiCell($full-140, $ch*2, '', 'B', 'C');
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

			//======== Division Office=======================//

			//25
			$pdf->MultiCell($full-165, $ch*2, 'Division:', 'TL', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//65
			$pdf->MultiCell($full-125, $ch*2, '', 'TB', 'C');
			$current_x += $full-125;
			$pdf->SetXY($current_x, $current_y);

			//5
			$pdf->MultiCell($full-185, $ch*2, '', 'TR', 'C');
			$current_x += $full-185;
			$pdf->SetXY($current_x, $current_y);

			//50
			$pdf->MultiCell($full-140, $ch*2, 'Responsibility Center Code:', 'TL', 'C');
			$current_x += $full-140;
			$pdf->SetXY($current_x, $current_y);

			//40
			$pdf->MultiCell($full-150, $ch*2, '', 'TB', 'C');
			$current_x += $full-150;
			$pdf->SetXY($current_x, $current_y);

			//5
			$pdf->MultiCell($full-185, $ch*2, '', 'TR', 'C');
			$current_x += $full-185;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();
			
			// ================ Office RIS No ================//
			//25
			$pdf->MultiCell($full-165, $ch*2, 'Office:', 'L', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//65
			$pdf->MultiCell($full-125, $ch*2, '', 'B', 'C');
			$current_x += $full-125;
			$pdf->SetXY($current_x, $current_y);

			//5
			$pdf->MultiCell($full-185, $ch*2, '', 'R', 'C');
			$current_x += $full-185;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch*2, 'RIS No.:', 'L', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//65
			$pdf->MultiCell($full-125, $ch*2, '', 'B', 'C');
			$current_x += $full-125;
			$pdf->SetXY($current_x, $current_y);

			//5
			$pdf->MultiCell($full-185, $ch*2, '', 'R', 'C');
			$current_x += $full-185;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			// ================= header items ===============//

			//95
			$pdf->MultiCell($full-95, $ch*2, 'Requisition', 'TLRB', 'C');
			$current_x += $full-95;
			$pdf->SetXY($current_x, $current_y);

			//30
			$pdf->MultiCell($full-160, $ch*2, 'Stock Available?', 'TRB', 'C');
			$current_x += $full-160;
			$pdf->SetXY($current_x, $current_y);

			//65
			$pdf->MultiCell($full-125, $ch*2, 'Issue', 'TRB', 'C');
			$current_x += $full-125;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			// ================= items ===============//

			//17.5
			$pdf->MultiCell($full-172.5, $ch*2, 'Stock No.', 'TLRB', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			//17.5
			$pdf->MultiCell($full-172.5, $ch*2, 'Unit', 'TRB', 'C');
			$current_x += $full-172.5;
			$pdf->SetXY($current_x, $current_y);

			//37.5
			$pdf->MultiCell($full-152.5, $ch*2, 'Description', 'TRB', 'C');
			$current_x += $full-152.5;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			$pdf->MultiCell($full-167.5, $ch*2, 'Quantity', 'TLRB', 'C');
			$current_x += $full-167.5;
			$pdf->SetXY($current_x, $current_y);

			//15
			$pdf->MultiCell($full-175, $ch*2, 'Yes', 'TRB', 'C');
			$current_x += $full-175;
			$pdf->SetXY($current_x, $current_y);

			//15
			$pdf->MultiCell($full-175, $ch*2, 'No', 'TRB', 'C');
			$current_x += $full-175;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch*2, 'Quantity', 'TRB', 'C');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//40
			$pdf->MultiCell($full-150, $ch*2, 'Remarks', 'TRB', 'C');
			$current_x += $full-150;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

			foreach ($row['ITEMS'] as $items) 
			{
				$pdf->SetFont('Arial', '', 9);
	        	$lines = $pdf->NbLines( $size2, $items['DESCRIPTION']);

	        	//============== item details ===========//
				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, $items['REQ_STOCK_NO'], 'TLRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//17.5
				$pdf->MultiCell($full-172.5, $ch+2, $items['REQ_UNIT'], 'TRB', 'C');
				$current_x += $full-172.5;
				$pdf->SetXY($current_x, $current_y);

				//45
				$pdf->MultiCell($full-152.5, $ch+2, $items['DESCRIPTION'], 'TRB', 'C');
				$current_x += $full-152.5;
				$pdf->SetXY($current_x, $current_y);

				//22.5
				$pdf->MultiCell($full-167.5, $ch+2, $items['REQ_QTY'], 'TLRB', 'C');
				$current_x += $full-167.5;
				$pdf->SetXY($current_x, $current_y);

				//15
				$pdf->MultiCell($full-175, $ch+2, $items['AVAILABILITY'], 'TRB', 'R');
				$current_x += $full-175;
				$pdf->SetXY($current_x, $current_y);

				//15
				$pdf->MultiCell($full-175, $ch+2, $items['AVAILABILITY'] , 'TRB', 'R');
				$current_x += $full-175;
				$pdf->SetXY($current_x, $current_y);

				//25
				$pdf->MultiCell($full-165, $ch+2, $items['ISSUED_QTY'] , 'TRB', 'R');
				$current_x += $full-165;
				$pdf->SetXY($current_x, $current_y);

				//40
				$pdf->MultiCell($full-150, $ch+2, $items['ISSUED_REMARKS'] , 'TRB', 'R');
				$current_x += $full-150;
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
			$pdf->MultiCell($full-152.5, $ch+2, '', 'TRB', 'C');
			$current_x += $full-152.5;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
			$current_x += $full-167.5;
			$pdf->SetXY($current_x, $current_y);

			//15
			$pdf->MultiCell($full-175, $ch+2, '', 'TRB', 'R');
			$current_x += $full-175;
			$pdf->SetXY($current_x, $current_y);

			//15
			$pdf->MultiCell($full-175, $ch+2, '', 'TRB', 'R');
			$current_x += $full-175;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch+2, '', 'TRB', 'R');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//40
			$pdf->MultiCell($full-150, $ch+2, '', 'TRB', 'R');
			$current_x += $full-150;
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
			$pdf->MultiCell($full-152.5, $ch+2, '', 'TRB', 'C');
			$current_x += $full-152.5;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
			$current_x += $full-167.5;
			$pdf->SetXY($current_x, $current_y);

			//15
			$pdf->MultiCell($full-175, $ch+2, '', 'TRB', 'R');
			$current_x += $full-175;
			$pdf->SetXY($current_x, $current_y);

			//15
			$pdf->MultiCell($full-175, $ch+2, '', 'TRB', 'R');
			$current_x += $full-175;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch+2, '', 'TRB', 'R');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//40
			$pdf->MultiCell($full-150, $ch+2, '', 'TRB', 'R');
			$current_x += $full-150;
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
			$pdf->MultiCell($full-152.5, $ch+2, '', 'TRB', 'C');
			$current_x += $full-152.5;
			$pdf->SetXY($current_x, $current_y);

			//22.5
			$pdf->MultiCell($full-167.5, $ch+2, '', 'TLRB', 'C');
			$current_x += $full-167.5;
			$pdf->SetXY($current_x, $current_y);

			//15
			$pdf->MultiCell($full-175, $ch+2, '', 'TRB', 'R');
			$current_x += $full-175;
			$pdf->SetXY($current_x, $current_y);

			//15
			$pdf->MultiCell($full-175, $ch+2, '', 'TRB', 'R');
			$current_x += $full-175;
			$pdf->SetXY($current_x, $current_y);

			//25
			$pdf->MultiCell($full-165, $ch+2, '', 'TRB', 'R');
			$current_x += $full-165;
			$pdf->SetXY($current_x, $current_y);

			//40
			$pdf->MultiCell($full-150, $ch+2, '', 'TRB', 'R');
			$current_x += $full-150;
			$pdf->SetXY($current_x, $current_y);

			$pdf->Ln();
	        $start_x = $pdf->GetX();
			$current_y = $pdf->GetY();
			$current_x = $pdf->GetX();

		// ============== Purpose ============//
		//35
		$pdf->MultiCell($full-155, $ch*2, 'Purpose', 'L', 'C');
		$current_x += $full-155;
		$pdf->SetXY($current_x, $current_y);

		//145
		$pdf->MultiCell($full-45, $ch*2, '', 'B', 'L');
		$current_x += $full-45;
		$pdf->SetXY($current_x, $current_y);

		//10
		$pdf->MultiCell($full-180, $ch*2, '', 'R', 'L');
		$current_x += $full-180;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		//============== Purpose line =============//
		//35
		$pdf->MultiCell($full-155, $ch*2, '', 'L', 'C');
		$current_x += $full-155;
		$pdf->SetXY($current_x, $current_y);

		//145
		$pdf->MultiCell($full-45, $ch*2, '', 'B', 'L');
		$current_x += $full-45;
		$pdf->SetXY($current_x, $current_y);

		//10
		$pdf->MultiCell($full-180, $ch*2, '', 'R', 'L');
		$current_x += $full-180;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		//============== item details ===========//
		//190
		$pdf->MultiCell($full, $ch+2, '', 'LRB', 'C');
		$current_x += $full;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		//============== item details ===========//
		//38
		$pdf->MultiCell($full-152, $ch+2, '', 'TLRB', 'C');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch+2, 'Requested By:', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch+2, 'Approved By:', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch+2, 'Issued By:', 'TLRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch+2, 'Received By:', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		//============== item details ===========//
		//38
		$pdf->MultiCell($full-152, $ch*2, 'Signature:', 'TLRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TLRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		//============== item details ===========//
		//38
		$pdf->MultiCell($full-152, $ch*2, 'Printed Name:', 'TLRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TLRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		//============== item details ===========//
		//38
		$pdf->MultiCell($full-152, $ch*2, 'Designation:', 'TLRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TLRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();

		//============== item details ===========//
		//38
		$pdf->MultiCell($full-152, $ch*2, 'Date:', 'TLRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TLRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		//38
		$pdf->MultiCell($full-152, $ch*2, '', 'TRB', 'L');
		$current_x += $full-152;
		$pdf->SetXY($current_x, $current_y);

		$pdf->Ln();
        $start_x = $pdf->GetX();
		$current_y = $pdf->GetY();
		$current_x = $pdf->GetX();
        }



        $pdf->Output($filename.'.pdf', 'I');
    }
}
