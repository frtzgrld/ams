
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		    <div class="panel panel-default bx-shadow-none">
		        <div class="panel-heading" role="tab" id="headingOne">
		            <h4 class="panel-title">
		                <a role="button" class="collapsed" data-toggle="collapse"
		                   data-parent="#accordion" href="#collapseOne"
		                   aria-expanded="false" aria-controls="collapseOne" id="calendar_collapse">
		                    Calendar of Procurement Activity
		                </a>
		            </h4>
		        </div>
		        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
		            <div class="panel-body">
		                <?php echo $this->calendar->generate($year, $month, $activity); ?>
		            </div>
		        </div>
		    </div>
		</div>

		<script type="text/javascript">
			
			function getActivity(date) 
			{
				alert(date);
			}

		</script>