	<?php foreach ($locations as $location) { ?>
		<?php if ($location['table_id'] === $filter_location) { ?>
			<option value="<?php echo $location['tablen_id']; ?>" <?php echo set_select('filter_location', $location['table_id'], TRUE); ?> ><?php echo $location['table_name']; ?></option>
		<?php } else { ?>
			<option value="<?php echo $location['table_id']; ?>" <?php echo set_select('filter_location', $location['table_id']); ?> ><?php echo $location['table_name']; ?></option>
		<?php } ?>
	<?php } ?>
