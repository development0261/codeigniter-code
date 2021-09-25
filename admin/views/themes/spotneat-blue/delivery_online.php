<?php echo get_header(); ?>
    <?php if($isAdmin != 11) { ?>
<style>
.page-action{
    display: none;
}
</style>
    <?php } ?>
<div class="row content">
	<div class="col-md-12">
        <div class="panel panel-default panel-table panel-tabs">
            

            <form role="form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
                <div class="table-responsive">
                    <table border="0" class="table table-striped table-border">
                        <thead>
                        <tr>
                            <!--<th class="action action-one"></th>-->
                            <th><?php echo 'Delivery id'; ?></th>
                            <th><?php echo lang('column_delivery'); ?></th>
                            <th><?php echo lang('email'); ?></th>
                            <th><?php echo lang('phone'); ?></th>
                           
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($delivery_online) { ?>
                            <?php foreach ($delivery_online as $online) { ?>
                                <tr>
                                    <!--<td class="action action-one"><a class="btn btn-danger" title="Blacklist IP" href="<?php //echo $online['blacklist']; ?>"><i class="fa fa-ban"></i></a></td>-->
                                    <td><?php echo $online['delivery_id']; ?></td>
                                    <td><?php echo $online['delivery_name']; ?></td>
                                    <td><?php echo $online['email']; ?></td>
                                    <td><?php echo $online['telephone']; ?></td>
                                    
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8"><?php echo $text_empty; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>

          <div class="pagination-bar clearfix">
                <div class="links"><?php echo $pagination['links']; ?></div>
                <div class="info"><?php //echo $pagination['info']; ?></div>
            </div>
        </div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<?php echo get_footer(); ?>