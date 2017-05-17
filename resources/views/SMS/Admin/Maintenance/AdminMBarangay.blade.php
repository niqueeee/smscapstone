@extends('SMS.Admin.AdminMain')
@section('content')
<!-- CENTER -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Maintenance
			<small>Barangay</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Maintenance</li>
			<li class="active">Barangay</li>
		</ol>
	</section>
	<section class="content">
		<!-- Your Page Content Here -->
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-danger">
					<div class="modal fade" id="add_barangay">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									{{ Form::button('&times;', [
										'class' => 'close',
										'type' => '',
										'data-dismiss' => 'modal'
										]) 
									}}
									<h4>Add Barangay</h4>
								</div>
								<div class="modal-body">
									{{ Form::open([
										'id' => 'frmBarangay', 'data-parsley-whitespace' => 'squish'
										])
									}}
									<div class="form-group">
										{{ Form::label('name', 'Select District') }}
										{{ Form::select('intDistID', $district, null, [
											'id' => 'intDistID',
											'class' => 'form-control'])
										}}
									</div>
									<div class="form-group">
										{{ Form::label('name', 'Barangay Name') }}
										{{ Form::text('strBaraDesc', null, [
											'id' => 'strBaraDesc',
											'class' => 'form-control',
											'maxlength' => '25',
											'required' => 'required',
											'data-parsley-pattern' => '^[a-zA-Z0-9. ]+$',
											'autocomplete' => 'off'
											]) 
										}}
									</div>
									<div class="form-group">
										{{ Form::button('Submit', [
											'id' => 'btn-save',
											'class' => 'btn btn-success btn-block',
											'value' => 'add',
											'type' => ''
											]) 
										}}
									</div>
									{{ Form::close() }}
								</div>
							</div>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive">
						{{ Form::button("<i class='fa fa-plus'></i> Add Barangay", [
							'id' => 'btn-add',
							'class' => 'btn btn-primary btn-sm',
							'value' => 'add',
							'type' => '',
							'style' => 'margin-bottom: 10px;'
							]) 
						}}
						<table id="barangay-table" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
							<thead>
								<th>District Name</th>
								<th>Barangay Name</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody id="barangay-list">
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<!-- /.box -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	@endsection
	@section('meta')
	<meta name="_token" content="{!! csrf_token() !!}" />
	@endsection
	@section('script')
	{!! Html::script("custom/BarangayAjax.js") !!}
	<script type="text/javascript">
		var dataurl = "{!! route('barangay.data') !!}";
	</script>
	@endsection