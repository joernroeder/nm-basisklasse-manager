<tr>
	<td scope="row"><?php echo $member->fullname; ?></td>

	<?php
	//foreach ($manager->getWorkshops() as $key => $name) : 
	$memberWorkshops = $manager->getMemberWorkshops($member->member_id);

	foreach ($memberWorkshops as $key => $value) :
		$input_id = $key .'_'. $member->member_id;
		$checked = $value ? ' checked="checked"' : '';
	?>
		<td>
			<div class="switch small radius">
				<input id="<?php echo $input_id ?>" name="<?php echo $input_id ?>" type="checkbox"<?php echo $checked; ?>>
				<label for="<?php echo $input_id ?>"></label>
			</div>
		</td>
	<?php endforeach; ?>
</tr>