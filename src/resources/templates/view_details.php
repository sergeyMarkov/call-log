<?php ob_start() ?>

<a href="/">go back</a>
<?php foreach ($_data['calls'] as $c) { ?>
	<h3>Call #<?= $c->id ?> Header</h3>
	<table class="table mt-4">
		<tr class="thead-light">
			<th scope="col">Call #ID</th>
			<th scope="col">IT Person</th>
			<th scope="col">Username</th>
			<th scope="col">Subject</th>
			<th scope="col">Details</th>
			<th scope="col">Date</th>
			<th scope="col">Total Time</th>
			<th scope="col">Status</th>
		</tr>
		<tr>
			<td><?= $c->id ?></td>
			<td><?= $c->it_person ?></td>
			<td><?= $c->user_name ?></td>
			<td><?= $c->subject ?></td>
			<td><?= $c->header_details ?></td>
			<td><?= $c->date_formated ?></td>
			<td><?= $c->total_hours . ':' . $c->total_minutes ?></td>
			<td><?= $c->status ?></td>
		</tr>
	</table>
	<h5>Call #<?= $c->id ?> Details</h5>
	<?php if ($c->details) { ?>
		<table class="table mt-4">
			<thead class="thead-light">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Details</th>
					<th scope="col">Hours</th>
					<th scope="col">Minutes</th>
					<th scope="col">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($c->details as $row) { ?>
					<tr>
						<td><?= $row->id ?></td>
						<td><?= $row->details ?></td>
						<td><?= $row->hours ?></td>
						<td><?= $row->minutes ?></td>
						<td><?= $row->date_formated ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } else {
		echo 'No details';
	} ?>
	<p>&nbsp;</p>
<?php } ?>

<?php if ($c->status != 'Completed' && count($_data['calls']) == 1) { ?>
	<h3>New Call Details</h3>
	<form method="POST" action="/">
		<table class="table mt-4">
			<tr class="thead-light">
				<th scope="col">Details</th>
				<th scope="col">Hours</th>
				<th scope="col">Minutes</th>
				<th scope="col">New Status</th>
				<th></th>
			</tr>
			<tr>
				<td><input type="text" name="details" id="details" required /></td>
				<td><input type="number" name="hours" id="hours" value="0" required /></td>
				<td><input type="number" name="minutes" id="minutes" value="0" required /></td>
				<td>
					<select name="status">
						<option value="In Progress">In Progress</option>
						<option value="Completed">Completed</option>
					</select>
				</td>
				<td><button type="submit">Add new</button></td>
			</tr>
		</table>
		<input type="hidden" name="call_id" value="<?= $c->id ?>" />
		<input type="hidden" name="new_call_details" value="1" />
	</form>
<?php } ?>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>