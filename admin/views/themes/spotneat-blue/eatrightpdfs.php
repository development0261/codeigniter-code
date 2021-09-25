<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Eat Right Pdfs</h3>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table class="table table-striped table-border">
						<thead>
							<tr>								
								<th>Title</th>
								<th>View PDF</th>
								<th>Status</th>								
								<th>Action</th>	
							</tr>
						</thead>
						<tbody>
							<?php 
							// echo "<pre>";print_r($eatrightpdfsql->result());
						
							if (!empty($eatrightpdfsSql)) {
								 foreach ($eatrightpdfsSql as $eatrightpdf) { ?>
							<tr>								
								<td><?php echo $eatrightpdf['pdf_title']; ?></td>
								<td><a href="<?php echo base_url().'views/uploads/trainers/eat_right_pdf/'.$eatrightpdf['pdf_image_name']; ?>" target="_blank">View PDF<a></td>	
								<td><?php echo $eatrightpdf['is_active'] == '1'?'Active':'Inactive'; ?></td>
								<td>
								<?php
								if($eatrightpdf['is_active'] == '1'){
								?>
								<a href="<?php echo base_url().'eatrightpdfs/makeinactive/'.$eatrightpdf['eat_right_pdf_id']; ?>" style="color: #056608;"><strong>Make Inactive</strong></a>
								<?php
								} else if($eatrightpdf['is_active'] == '0'){
								?>
								<a href="<?php echo base_url().'eatrightpdfs/makeactive/'.$eatrightpdf['eat_right_pdf_id']; ?>" style="color: #ff0000;"><strong>Make Active</strong></a>
								<?php
								}
								?>
								</td>
							</tr>
							<?php } 
						     } else {?>
							<tr>
								<td colspan="3"><?php echo lang('text_empty'); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>