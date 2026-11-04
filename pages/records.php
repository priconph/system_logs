<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<div class="row" id="main_container">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<h3 class="page-header">Rapid Logs</h3>
		<div class="pull-right page-header">
			<!-- <button class="btn btn-primary btn-sm glyphicon glyphicon-plus" id="btn_new_record" value="New Record"> New</button> -->
		</div><br>
		<div>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#disabled_accnt" aria-controls="disabled_accnt" role="tab" data-toggle="tab">Disabled Accounts</a></li>
			<li role="presentation"><a href="#rap_logs" aria-controls="login" role="login" data-toggle="tab">System Logs</a></li>
		  </ul>
		  <br>
		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="disabled_accnt">
				<table class="table table-striped table-bordered table-condensed" id="tbl_disabled_accnt">
					<thead>
						<tr>
							<th>Username</th>
							<th>Last log-in</th>
							<th>Date/Time Disabled</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>	
			</div>
			<div role="tabpanel" class="tab-pane" id="rap_logs">
				<button type="button" class="btn btn-default fa fa-search" style="margin:10px;" id="btn_advance_search"> Advance Search</button>
				<table class="table table-striped table-bordered table-condensed" id="tbl_rap_logs">
					<thead>
						<tr>
							<th>Activity</th>
							<th>Username</th>
							<th>IP address</th>
							<th>Page</th>
							<th>Query</th>
							<th>Date/Time Access</th>
							<th>System Name/Remarks</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>	
			</div>
			<div role="tabpanel" class="tab-pane" id="messages">...3</div>
			<div role="tabpanel" class="tab-pane" id="settings">...4</div>
		  </div>
		</div>
</div>


<!--Modal-->
<div class="modal fade" id="mdl_logs_per_username">
  <div class="modal-dialog-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Logs</h4>
      </div>
      <div class="modal-body">
		   <div>
			<table class="table table-striped table-bordered table-condensed" id="tbl_logs_by_username">
				<thead>
					<tr>
						<th>Date/Time</th>
						<th>Activity</th>
						<th>IP address</th>
						<th>Page</th>
						<th>Transaction</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>	
		   </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Modal-->
<div class="modal fade" id="mdl_advance_search">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Advance Search</h4>
      </div>
      <div class="modal-body">
		   <div>
			<div class="form-group">
				<label for="txt_name">Activity</label>
				<input type="text" class="form-control" name="activity" placeholder="Activity" list="dt_activity" required>
			</div>
			<div class="form-group">
				<label for="txt_lastname">Username</label>
				<input type="text" class="form-control" name="username" placeholder="Username" required>
			</div>
			<div class="form-group">
				<label for="txt_address">IP address</label>
				<input type="text" class="form-control" name="ip_address" placeholder="IP address" required>
			</div>
			<div class="form-group">
				<label for="txt_remarks">Query</label>
				<input type="text" class="form-control" name="query" placeholder="Query">
			</div>
			<div class="form-group">
				<label for="txt_remarks">Date</label>
				<input type="text" class="form-control" name="date" placeholder="Date">
			</div>
		   </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_search">Search</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--Modal-->
<div class="modal fade" id="modal_add_new_record">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add New Record</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="index.php?page=records.php" id="frm_add_new_record">
		  <div class="form-group">
			<label for="txt_name">Name</label>
			<input type="text" class="form-control" name="txt_name" placeholder="Name" required>
		  </div>
		  <div class="form-group">
			<label for="txt_lastname">Lastname</label>
			<input type="text" class="form-control" name="txt_lastname" placeholder="Lastname" required>
		  </div>
		   <div class="form-group">
			<label for="txt_address">Address</label>
			<input type="text" class="form-control" name="txt_address" placeholder="Address" required>
		  </div>
		   <div class="form-group">
			<label for="txt_remarks">Remarks</label>
			<input type="text" class="form-control" name="txt_remarks" placeholder="Remarks">
		  </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Modal-->
<div class="modal fade" id="modal_update_record">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Record</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="index.php?page=records.php" id="frm_update_record">
		  <div class="form-group">
			<input type="hidden" class="form-control" id="txt_pkid" name="txt_pkid" placeholder="pkid">
			<label for="txt_name">Name</label>
			<input type="text" class="form-control" id="txt_name_update" name="txt_name_update" placeholder="Name" required>
		  </div>
		  <div class="form-group">
			<label for="txt_lastname">Lastname</label>
			<input type="text" class="form-control" id="txt_lastname_update" name="txt_lastname_update" placeholder="Lastname" required>
		  </div>
		   <div class="form-group">
			<label for="txt_address">Address</label>
			<input type="text" class="form-control" id="txt_address_update" name="txt_address_update" placeholder="Address" required>
		  </div>
		   <div class="form-group">
			<label for="txt_remarks">Remarks</label>
			<input type="text" class="form-control" id="txt_remarks_update" name="txt_remarks_update" placeholder="Remarks">
		  </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="js/records.js" language="javascript"></script>
