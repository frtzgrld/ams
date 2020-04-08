<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'modules/tools/controllers/tools.php');

Class Calendar extends Tools
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('activity_model');

		$this->load->library('calendar');
	}	

	protected $title = 'Calendar';

	public function index()
	{
		$year = $this->uri->segment(3);
		$month = $this->uri->segment(4);

		if( is_null($year) || !is_numeric($year) )
			redirect( base_url().'tools/calendar/activities/'.date('Y/m'));
	} 

	public function _activities()
	{
		$data = array(
				'menu' 		=> 'dashboard',
				'submenu' 	=> '',
				'title'		=> $this->title,
				'button'	=> null,
				'year'		=> $this->uri->segment(4),
				'month'		=> $this->uri->segment(5),
				'date'		=> $this->uri->segment(6),
				'activity'	=> $this->activity_model->calendar_of_activities($this->uri->segment(4),$this->uri->segment(5),$this->uri->segment(6)),
			);

		$prefs = array(
				'template'		=> '{table_open}<table class="table table-bordered table-eis" cellpadding="1" cellspacing="2">{/table_open}
					{heading_row_start}<tr>{/heading_row_start}
					{heading_previous_cell}<th class="prev_sign"><a href="{previous_url}">Previous</button></a></th>{/heading_previous_cell}
					{heading_title_cell}<th class="month_sign" colspan="{colspan}">{heading}</th>{/heading_title_cell}
					{heading_next_cell}<th class="next_sign"><a href="{next_url}">Next</a></th>{/heading_next_cell}
					{heading_row_end}</tr>{/heading_row_end}
					//Deciding where to week row start
					{week_row_start}<tr class="week_name" >{/week_row_start}
					//Deciding  week day cell and  week days
					{week_day_cell}<td >{week_day}</td>{/week_day_cell}
					//week row end
					{week_row_end}</tr>{/week_row_end}
					{cal_row_start}<tr>{/cal_row_start}
					{cal_cell_start}<td>{/cal_cell_start}
					{cal_cell_content}<a class="activity" href="{content}">{day}</a>{/cal_cell_content}
					{cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
					{cal_cell_no_content}{day}{/cal_cell_no_content}
					{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}
					{cal_cell_blank}&nbsp;{/cal_cell_blank}
					{cal_cell_end}</td>{/cal_cell_end}
					{cal_row_end}</tr>{/cal_row_end}
					{table_close}</table>{/table_close}',
				'day_type'			=> 'short',
				'show_next_prev' 	=> true,
				'next_prev_url' 	=> base_url().'tools/calendar/activities/',
			);

		$this->load->library('calendar', $prefs);
		$this->get_view('calendar_index', $data);
	}

	public function activities()
	{
		$data = array(
				'menu' 		=> 'dashboard',
				'submenu' 	=> '',
				'title'		=> $this->title,
				'button'	=> null,
				'year'		=> $this->uri->segment(4),
				'month'		=> $this->uri->segment(5),
				'date'		=> $this->uri->segment(6),
				'activity'	=> $this->activity_model->calendar_of_activities($this->uri->segment(4),$this->uri->segment(5),$this->uri->segment(6)),
			);

		$this->get_view('calendar_of_activities', $data);
	}


	public function today()
	{
		
	}
}