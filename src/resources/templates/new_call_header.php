<?php ob_start() ?>

<a href="/">Go back</a>

<h3>New Call Header details</h3>
<form method="POST" action="/">
	<table class="table mt-4">
		<tr class="thead-light">
			<th scope="col">IT Person</th>
			<th scope="col">Username</th>
			<th scope="col">Subject</th>
			<th scope="col">Details</th>
			<th scope="col"></th>
		</tr>
		<tr>
			<td><input type="text" name="it_person" id="it_person" required /></td>
			<td><input type="text" name="user_name" id="user_name" /></td>
			<td><input type="text" name="subject" id="subject" /></td>
			<td><input type="text" name="details" id="details" /></td>
			<td><button type="submit">Add&nbsp;new</button></td>
		</tr>
	</table>
	<input type="hidden" name="new_call_header" value="1" />
</form>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>