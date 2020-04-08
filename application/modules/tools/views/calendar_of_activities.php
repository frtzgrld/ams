<!-- <pre><?php print_r($activity); ?></pre> -->
	
	<div class="card-box">
		<h3 class="text-info m-t-10 m-b-20"><?php $format = ($month?'F':'').' '.($date?'d':'').' '.($year?'Y':''); echo date_format(date_create($year.($month?'-'.$month:'').($date?'-'.$date:'')), $format); ?></h3>
		<table class="table">
			<thead>
				<tr>
					<th width="10%">Date</th>
					<th width="05%">Day</th>
					<th width="70%">Activity</th>
					<th width="15%">Link</th>
				</tr>
			</thead>
			<tbody><?php

		if( $activity )
		{
			foreach ($activity as $act)
				if($act['task'])
					foreach ($act['task'] as $task): ?>
						
						<tr <?php echo $act['date']==date('Y-m-d') ? 'class="info"' : null; ?>>
							<td><?php echo date_format(date_create($act['date']),'M d, Y'); ?></td>
							<td><?php echo date_format(date_create($act['date']),'D'); ?></td>
							<td><?php echo $task['TASK_DESCRIPTION']; ?></td>
							<td>
								<a class="btn btn-block btn-info btn-xs" href="<?php echo base_url().'procurement/activity/'.$task['SLUG'].'/'.$task['CODE'];?>">View</a>
							</td>
						</tr><?php

					endforeach; 
                // else
                //     echo '<tr><td colspan="5" class="text-center">No activity today</td></tr>';
		}
		else
		{	?>
			<tr>
				<td colspan="5" class="text-center">No activity for the selected date</td>
			</tr><?php
		}	?>

			</tbody>
		</table>
	</div>