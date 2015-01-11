<?php

include ('views/includes/header.php');
$members = $manager->getMembers();

?>

<div class="row">
	<form method="post" action="index.php" name="memberupdateform">
		<div class="small-12 columns">
			<table class="small-12">
				<thead>
					<tr>
						<th scope="column">Name</th>
						<?php foreach ($manager->getWorkshops() as $key => $name) : ?>
							<th scope="column"><?php echo $key ?></th>
						<?php endforeach; ?>
					</tr>
				</thread>
				<tbody>
					<?php if (sizeof($members)) {
						foreach ($members as $member) {
							include 'views/includes/member_row.php';
						}
					} ?>
				</tbody>

				<tfooter>
					<tr>
						<th scope="column">Name</th>
						<?php foreach ($manager->getWorkshops() as $key => $name) : ?>
							<th scope="column"><?php echo $key ?></th>
						<?php endforeach; ?>
					</tr>
				</tfooter>
			</table>
		</div>
		<div class="small-12 colums text-center">
			<input type="hidden" name="fingerprint" value="" />
			<input type="hidden" name="uagent" value="" />
			<button name="memberupdate" type="submit" class="radius">Speichern</button>
		</div>
	</form>
</div>

<?php include ('views/includes/footer.php'); ?>