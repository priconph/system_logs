var handler = "./handler/handler.php";

var tbl_disabled 			= "tbl_disabled_accnt";
var dt_disabled 			= "";
var tbl_rap_logs			= "tbl_rap_logs";
var dt_sys_logs 			= "";
var tbl_logs_by_username	= "tbl_logs_by_username";
var dt_logs_by_username 	= "";
var username 				= $('#hidden_username').val();

$(document).ready(function(){
	dt_disabled = $('#'+tbl_disabled).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/dt_disabled.php",
		"drawCallback": function( settings ) {
			$('#'+tbl_disabled).attr('style','width:100%;');
		}
	});
	
	$('#'+tbl_disabled+' tbody').on( 'click', 'tr .fa-toggle-on', function () {
		var pkid = $(this).data('id');
		var un = $(this).closest('tr').find('td:eq(0)').text();
		if(confirm('Are you sure you want to enable this account?')) {
			var data = {
				"action"	: "enable_account",
				"id"		: pkid,
				"username"	: un,
				"iss"		: username,
			}
			data = $.param(data);
			$.ajax({
				type	: "post",
				dataType: "json",
				data	: data,
				url		: handler,
				success	: function(data){
					alert(data['msg']);
					reload_datatables();
				}
			});
		}
	});

	dt_logs_by_username = $('#'+tbl_logs_by_username).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/dt_logs_by_username.php?un=n/a",
		"drawCallback": function( settings ) {
			$('#'+tbl_disabled).attr('style','width:100%;');
		}
	});
	
	$('#'+tbl_disabled+' tbody').on( 'click', 'tr .fa-list', function () {
		dt_logs_by_username.ajax.url('server_side_scripts/dt_logs_by_username.php?un='+username).load();
		$('#mdl_logs_per_username').modal();
	});
	
	dt_sys_logs = $('#'+tbl_rap_logs).DataTable({
		"aaSorting"	 : [],	
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "server_side_scripts/dt_sys_logs.php",
		"drawCallback": function( settings ) {
			$('#'+tbl_rap_logs).attr('style','width:100%;');
		}
	});
	
	function reload_datatables() {
		dt_disabled.ajax.reload();
		dt_sys_logs.ajax.reload();
	}
	
	$('#btn_advance_search').click(function() {
		$('#mdl_advance_search').modal();
	});
	
	// $('#'+tbl_records+' tbody').on( 'click', 'tr .glyphicon-edit', function () {
		// var data = {
			// "action"	: "update_fetch_record",
			// "pkid"		: $(this).val(),
			// "username"	: username,
		// }
		// data = $.param(data);
		// $.ajax({
			// type	: "post",
			// dataType: "json",
			// data	: data,
			// url		: handler,
			// success	: function(data){
				// for(ctr=0;ctr<data['ctr'];ctr++){
					// $('#txt_pkid').val(data['pkid2'][ctr]);
					// $('#txt_name_update').val(data['name'][ctr]);
					// $('#txt_lastname_update').val(data['lastname'][ctr]);
					// $('#txt_address_update').val(data['address'][ctr]);
					// $('#txt_remarks_update').val(data['remarks'][ctr]);
					// $('#modal_update_record').modal('show');
				// }
			// }
		// });
	// });
	
	// $('#'+tbl_records+' tbody').on( 'click', 'tr .glyphicon-remove', function () {
		// var selected_pkid = $(this).val();
		// if(confirm("You are about to delete a record! Proceed?")){
			// var data = {
				// "action"	: "delete_record",
				// "pkid"		: selected_pkid
			// }
			// data = $.param(data);
			// delete_record(data);
		// }else{
			// return false;
		// }		
	// });
	
	/* open modal for adding new record */
	$('#btn_new_record').click(function(){ 
		$('#modal_add_new_record').modal('show');
	});
	
	/* add new record form submit */
	$('#frm_add_new_record').submit(function(e){
		/* prevent page to submit */
		e.preventDefault();
		var data = {
			"action"	: "add_new_record",
			"username"	: username,
		}
		data = $.param(data) + "&" + $(this).serialize();
		add_new_record(data);
	});
	
	/* form submit button event */
	$('#frm_update_record').submit(function(e){
		/* prevent page to submit */
		e.preventDefault();
		var data = {
			"action"	: "update_record"
		}
		data = $.param(data) + "&" + $(this).serialize();
		update_record(data);
	});
	
	/* delete button record click event */
	$('#btn_delete_record').click(function(){
		
	});

});

/* function for adding new record */
function add_new_record(data){
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(data){
			alert(data['result']);
			$('#modal_add_new_record').modal('hide');
			// dt_sys_logs.ajax.reload();
		}
	});
}
	
/* function for updating record */
function update_record(data){
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(data){
			alert(data['result']);
			$('#modal_update_record').modal('hide');
			// dt_sys_logs.ajax.reload();
		}
	});
}

function delete_record(data){
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(data){
			alert(data['result']);
			// dt_sys_logs.ajax.reload();
		}
	});
}