@extends('SMS.Student.StudentMain')
@section('override')
{!! Html::style("plugins/select2/select2.min.css") !!}
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Messages
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('student/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Here</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-2">
        <a href="{{ url('student/messages') }}" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>
        <div class="box box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Folders</h3>
            <div class="box-tools">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
              <li><a href="{{ url('student/messages') }}"><i class="fa fa-inbox"></i> Inbox
                <span class="label label-primary pull-right">12</span></a></li>
                <li><a href="{{ url('student/messages/sent') }}"><i class="fa fa-envelope-o"></i> Sent</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-10">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Compose New Message</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {{ Form::open([
                'method' => 'Post',
                'enctype' => 'multipart/form-data',
                'route' => 'studentmessage.store'])
              }}
              <div class="form-group">
                <label>Send To:</label>
                <select class="form-control select2" name="receiver[]" multiple="multiple" data-placeholder="Send To:" style="width: 100%;">
                  @foreach ($users as $user)
                  <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Subject:</label>
                <input class="form-control" type="text" name="title" placeholder="Subject:">
              </div>
              <div class="form-group">
                <label>Message:</label>
                <textarea id="compose-textarea" name="description" class="form-control" style="height: 300px; resize: none;"></textarea>
              </div>
              <div class="form-group">
                <div class="btn btn-default btn-file">
                  <i class="fa fa-paperclip"></i> Attachment
                  <input type="file" name="pdf">
                </div>
                <p class="help-block">Max. 2MB</p>
              </div>
              <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-envelope-o"></i> Send</button>
              {{Form::close()}}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  @endsection
  @section('script')
  {!! Html::script("plugins/select2/select2.min.js") !!}
  <script type="text/javascript">
    $(".select2").select2();
  </script>
  @endsection