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
			'offices'	=> $this->office_model->office_list(),
		);

		$this->get_view(array('ris/ris_modal','ris/ris_index'), $data);
	}

	public function ris_new()
	{
		$ris = $this->ris_model->getrisno();
		
		// $ris_no = sprintf("%'.011d", $ris[0]['RIS_NO']);
		$ris_no = substr($ris[0]['RIS_NO'], 4);
		$risno = sprintf("%05d", intval($ris_no)+1);
		$risno_final = $risno;
		// var_dump($risno_final);
		// exit();
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'ris',
			'title'		=> $this->title,
			'offices'	=> $this->office_model->office_list(),
			'button'	=> null,
			'risno'		=> $risno_final,
		);
		
		$this->get_view('ris/ris_new', $data);
	}

	public function ris_items()
	{
		$risid =  $this->uri->segment(4);
		$ris_rec = $this->ris_model->get_ris_rec($risid);
		// var_dump($ris_rec);
		// exit();
		
		$data = array(
			'menu' 		=> 'file',
			'submenu' 	=> 'ris',
			'title'		=> $this->title,
			'offices'	=> $this->office_model->office_list(),
			'button'	=> null,
			'ris_id'	=> $ris_rec[0]['ID'],
			'ris_items_list' => $this->ris_model->get_ris_item_list($risid),
			'office_rec'	=> $ris_rec[0]['OFFICES'],
			'ris_no'		=> $risid,
			// 'requested_by'	=> $ris_rec[0]['REQUESTED_BY'],
			// 'noted_by'		=> $ris_rec[0]['NOTED_BY'],
			// 'approved_by'	=> $ris_rec[0]['APPROVED_BY'],
			// 'issued_by'		=> $ris_rec[0]['ISSUED_BY'],
			// 'received_by'	=> $ris_rec[0]['RECEIVED_BY'],
			// 'posted_by'		=> $ris_rec[0]['POSTED_BY'],
			'requested_date'			=> date_format(date_create($ris_rec[0]['REQUESTED_DATE']), 'm/d/Y'),
		);
		

		$this->get_view('ris/ris_items', $data);
	}

	public function ris_header_save()
	{
		$reqdate = date('Y-m-d',(strtotime($_POST['requested_date'])));
	
		$this->db->insert('ris', array('offices' => $_POST['office'], 'ris_no' => $_POST['ris_no'], 'requested_by' => $this->session->userdata('EMPLOYEENO'), 'requested_date' => $reqdate, 'createdby' => $this->session->userdata('EMPLOYEENO'), 'createddate' => date('Y-m-d h:i:s')));
		$res_id = $this->db->insert_id();

		redirect('file/ris/ris_items/'.$_POST['ris_no']);
	}

	public function datatable_ris_items()
	{
		$this->xhr();
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
		// var_dump($ris_id);
		// exit();
		$itemlist = $this->ris_model->get_item($itemid);
		
		$results = $this->db->insert('ris_items', array('ris_no' => $ris_id, 'req_stock_no' => $itemlist[0]['code'], 'req_unit' => $itemlist[0]['unit'], 'req_description' => $itemlist[0]['id']));
		$data = "";
		if($results)
		{
			$data=  array(
				'result'    => 'success',
				'header'    => 'SUCCESS',
				'message'   => 'Requested Item has been successfully saved.',
				'redirect'  => base_url().'file/ris/ris_items/'.$ris_id,
			);
		}
		echo json_encode($data);
	}

	public function save_quantity()
	{
		$req_qty = $this->input->post('req_qty');
		$rel_qty = $this->input->post('rel_qty');
		$ris_id = $this->input->post('save_ris_id');
		$risitemid = $this->input->post('ris_item_id');
		$assigned_office = $this->input->post('save_office');

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

		//2
		$qty = $rel_qty;
		//2
		$remainingQty = $qty;
		$currentQty = 0;
		// $onqueue = $supplies[0]['ONQUEUE'];
		foreach ($supplies as $k => $key) {
			// var_dump($supplies[$k+1]['ID']);
			// exit();
			if($remainingQty <= 0)
			{
				break;
			}

				if($remainingQty > $key['QTYONHAND'])
				{
					$currentQty += $key['QTYONHAND']; //40
					$remainingQty -= $key['QTYONHAND']; //2

					$tempqty = $remainingQty - $key['QTYONHAND'];
					$data3 = array(
						'QTYONHAND' => 0,
						'ONQUEUE'	=> 0
						);
					$this->db->where('id', $key['ID']);
					$this->db->update('supplies', $data3);

					$this->db->insert('distribution', array(
						'suppliesid' => $key['ID'], 
						'assigned_qty' => $tempqty, 
						'assigned_to_office' => $assigned_office, 
						'assigned_by' => $this->session->userdata('EMPLOYEENO'), 
						'assigned_date' => date('Y-m-d h:i:s'),
						'datecreated' => date('Y-m-d h:i:s'),
						'ris_items' => $risitemid
					));
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

					$qty_onhand = intval($key['QTYONHAND']) - $remainingQty;

					$tmpqtyonhandsave = $qty_onhand - $tempRemainingQty;
					// var_dump($qty_onhand - $tempRemainingQty);
					// exit();
					if($tmpqtyonhandsave == 0)
					{
					
						$data2 = array(
							'QTYONHAND' => 0,
							'ONQUEUE'	=> 0,
							);
						$this->db->where('id', $key['ID']);
						$this->db->update('supplies', $data2);

						$dataarry = array(
							'ONQUEUE'	=> 1,
						);
						$this->db->where('id', $supplies[$k+1]['ID']);
						$this->db->update('supplies', $dataarry);

						$this->db->insert('distribution', array(
							'suppliesid' => $key['ID'], 
							'assigned_qty' => $$qty_onhand, 
							'assigned_to_office' => $assigned_office, 
							'assigned_by' => $this->session->userdata('EMPLOYEENO'), 
							'assigned_date' => date('Y-m-d h:i:s'),
							'datecreated' => date('Y-m-d h:i:s'),
							'ris_items' => $risitemid
						));
					}
					else{
						$data2 = array(
							'QTYONHAND' => $qty_onhand - $tempRemainingQty,
							'ONQUEUE'	=> 1,
							);
						$this->db->where('id', $key['ID']);
						$this->db->update('supplies', $data2);

						$this->db->insert('distribution', array(
							'suppliesid' => $key['ID'], 
							'assigned_qty' => $qty_onhand, 
							'assigned_to_office' => $assigned_office, 
							'assigned_by' => $this->session->userdata('EMPLOYEENO'), 
							'assigned_date' => date('Y-m-d h:i:s'),
							'datecreated' => date('Y-m-d h:i:s'),
							'ris_items' => $risitemid
						));


					}
				}
		}
		$risitemsdata = array(
			'REQ_QTY' => $req_qty,
			'ISSUED_QTY' => $rel_qty
		);
		$this->db->where('ID', $risitemid);
		$this->db->update('ris_items', $data);
		// exit();
		redirect('file/ris/ris_items/'.$ris_id);
	}

	public function getQty()
	{
		$ris_id = $this->input->post('ris_id');
		$results = $this->ris_model->get_ris_item($ris_id);
		// var_dump($results);
		echo json_encode($results);
	}

	public function validate_ris()
	{
		$this->xhr();
		$post_formdata = $this->input->post();
        $results = $this->ris_model->manage_ris( $post_formdata );
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
