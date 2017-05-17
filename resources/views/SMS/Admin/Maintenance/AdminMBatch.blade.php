@extends('SMS.Admin.AdminMain')
@section('content')
<!-- CENTER -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Maintenance
			<small>Batch</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Maintenance</li>
			<li class="active">Batch</li>
		</ol>
	</section>
	<section class="content">
		<!-- Your Page Content Here -->
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-danger">
					<div class="modal fade" id="add_batch">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									{{ Form::button('&times;', [
										'class' => 'close',
										'type' => '',
										'data-dismiss' => 'modal'
										]) 
									}}
									<h4>Add Batch</h4>
								</div>
								<div class="modal-body">
									{{ Form::open([
										'id' => 'frmBatch', 'data-parsley-whitespace' => 'squish'
										])
									}}
									<div class="form-group">
										{{ Form::label('name', 'Batch Name') }}
										{{ Form::text('strBatcDesc', null, [
											'id' => 'strBatcDesc',
											'class' => 'form-control',
											'maxlength' => '20',
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
						{{ Form::button("<i class='fa fa-plus'></i> Add Batch", [
							'id' => 'btn-add',
							'class' => 'btn btn-primary btn-sm',
							'value' => 'add',
							'type' => '',
							'style' => 'margin-bottom: 10px;'
							]) 
						}}
						<table id="batch-table" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
							<thead>
								<th>Batch Name</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody id="batch-list">
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
	{!! Html::script("custom/BatchAjax.js") !!}
	<script type="text/javascript">
		var dataurl = "{!! route('batch.data') !!}";
	</script>
	@endsection