<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#content" data-toggle="tab"><?php echo lang('text_tab_content'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-title" class="col-sm-3 control-label"><?php echo lang('label_title'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-user" class="col-sm-3 control-label"><?php echo lang('label_account_sid'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="account_sid" id="input-api-user" class="form-control" value="<?php echo set_value('account_sid', $account_sid); ?>" />
							<?php echo form_error('account_sid', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-version" class="col-sm-3 control-label"><?php echo lang('label_api_version'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="api_version" id="input-api-version" class="form-control" value="<?php echo set_value('api_version', $api_version); ?>" />
							<?php echo form_error('api_version', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-token" class="col-sm-3 control-label"><?php echo lang('label_auth_token'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="auth_token" id="input-api-token" class="form-control" value="<?php echo set_value('auth_token', $auth_token); ?>" />
							<?php echo form_error('auth_token', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-mode" class="col-sm-3 control-label"><?php echo lang('label_api_mode'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($api_mode === 'live') { ?>
									<label class="btn btn-warning"><input type="radio" name="api_mode" value="sandbox" <?php echo set_radio('api_mode', 'sandbox'); ?>><?php echo lang('text_sandbox'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="api_mode" value="live" <?php echo set_radio('api_mode', 'live', TRUE); ?>><?php echo lang('text_go_live'); ?></label>
								<?php } else { ?>
									<label class="btn btn-warning active"><input type="radio" name="api_mode" value="sandbox" <?php echo set_radio('api_mode', 'sandbox', TRUE); ?>><?php echo lang('text_sandbox'); ?></label>
									<label class="btn btn-success"><input type="radio" name="api_mode" value="live" <?php echo set_radio('api_mode', 'live'); ?>><?php echo lang('text_go_live'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('api_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-total" class="col-sm-3 control-label"><?php echo lang('label_account_number'); ?>
							<span class="help-block"><?php echo lang('help_account_number'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="account_number" id="input-order-total" class="form-control" value="<?php echo set_value('account_number', $account_number); ?>" />
							<?php echo form_error('account_number', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
				<div id="content" class="tab-pane row wrap-all">
					<div id="templates" class="row wrap-top">
						<div class="panel panel-default panel-table">
							<div class="panel-heading">
								<h3 class="panel-title"><?php echo lang('text_tab_templates'); ?></h3>
							</div>
							<?php 
							if ($template_data) { ?>
								<div class="table-responsive">
									<table border="0" class="table table-striped table-border table-no-spacing table-templates">
										<thead>
											<tr>
												<th class="action action-one"></th>
												<th class="left"><?php echo lang('column_title'); ?></th>
												<th class="text-right"><?php echo lang('column_date_updated'); ?></th>
												<th class="text-right"><?php echo lang('column_date_added'); ?></th>
											</tr>
										</thead>
										<tbody id="accordion">
											<?php $template_row = 1; ?>
											<?php foreach ($template_data as $tpl_data) { ?>
											<tr>
					                            <td colspan="4">
					                                <div class="template-heading">
														<div class="table-responsive">
					                                        <table border="0" class="table-template">
					                                        <input type="hidden" name="templates[<?php echo $tpl_data['template_data_id']; ?>][code]" id="input-subject" class="form-control" value="<?php echo set_value('templates['.$tpl_data['template_data_id'].'][code]', $tpl_data['code']); ?>" />
																<tr data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="template-row-<?php echo $tpl_data['template_data_id']; ?>" data-target="#template-row-<?php echo $tpl_data['template_data_id']; ?>">
																	<td class="action action-one">
																		<i class="fa fa-chevron-up up"></i>
																		<i class="fa fa-chevron-down down"></i>
																	</td>
																	<td class="left"><?php echo $tpl_data['title']; ?></td>
																	<td class="text-right"><?php echo $tpl_data['date_updated']; ?></td>
																	<td class="text-right"><?php echo $tpl_data['date_added']; ?></td>
																</tr>
															</table>
														</div>
					                                </div>
													<div id="template-row-<?php echo $tpl_data['template_data_id']; ?>" class="collapse">
														<div class="template-content">
															<div class="form-group">
																<div id="input-wysiwyg" class="col-md-12">
																	<textarea name="templates[<?php echo $tpl_data['template_data_id']; ?>][body]" style="height:300px;width:100%;" class="form-control"><?php echo set_value('templates['.$tpl_data['template_data_id'].'][body]', $tpl_data['body']); ?></textarea>
																	<?php echo form_error('templates['.$tpl_data['template_data_id'].'][body]', '<span class="text-danger">', '</span>'); ?>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
											<?php $template_row++; ?>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<?php } else { ?>
								<div class="panel-body">
									<div class="alert alert-info">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<?php echo lang('alert_template_missing'); ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</form>

				
			
	</div>
</div>
<script type="text/javascript">
	/*$('textarea').summernote({
		height: 300,
	});*/

	
</script>