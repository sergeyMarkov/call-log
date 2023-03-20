<?php ob_start() ?>
<a href="/add-call-header">Create new log</a>
<table class="table mt-4">
	<thead class="thead-light">
		<tr>
			<th scope="col">Call #ID</th>
			<th scope="col">IT Person</th>
			<th scope="col">Username</th>
			<th scope="col">Subject</th>
			<th scope="col">Details</th>
			<th scope="col">Date</th>
			<th scope="col">Total Time</th>
			<th scope="col">Status</th>
			<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_data as $row) { ?>
			<tr>
				<th scope="row"><a href="/filter/call_id/<?= $row->id ?>"><?= $row->id ?></a></th>
				<td><?= $row->it_person ?></td>
				<td><a href="/filter/user_name/<?= $row->user_name ?>"><?= $row->user_name ?></a></td>
				<td><?= $row->subject ?></td>
				<td><?= $row->header_details ?></td>
				<td><a href="/filter/date/<?= $row->date_formated ?>"><?= $row->date_formated ?></a></td>
				<td><?= ($row->total_hours ?: '00') . ':' . ($row->total_minutes ?: '00') ?></td>
				<td><?= $row->status ?></td>
				<td><?php if ($row->status == 'Completed') { ?>
						<a class="delete" data-id="<?= $row->id ?>" class="delete">delete</a>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>