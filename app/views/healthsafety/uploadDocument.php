<h3>Upload Health &amp; Safety Document for <?php echo $data['item']->item_name ?></h3>

<form method="POST" action="" enctype="multipart/form-data">
	<div class="row edit-panel">
		<div class="col-md-6">
			<div>
				<label for="doc_name">Document Name</label><br />
				<input type="text" name="doc_name" id="doc_name" />
			</div>
			<div>
				<label for="document">Document</label><br />
				<input type="file" name="document" id="document" />
			</div>
			<!--
			<div>
				<label for="item_notes">Notes</label><br />
				<textarea name="item_notes" id="item_notes"></textarea>
			</div>
			-->
			<div>
				<button  class="btn btn-success" type="submit">Upload</button>
			</div>
		</div>
	</div>
</form>