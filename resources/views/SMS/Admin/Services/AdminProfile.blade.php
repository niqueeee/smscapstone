@extends('SMS.Admin.AdminMain')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active"><i class="fa fa-user"></i> Profile</li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-danger">
      <div class="box-header with-border">
        <div class="box-header">
          <h3>User Information</h3>
        </div>
        <div class="box-body">
          <div class="col-md-3">
            <div class="well">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{ asset('images/'.Auth::user()->picture) }}" alt="User profile picture">
                {{ Form::open([
                  'id' => 'frmimage'])
                }}
                <div class="form-group" style="padding-top: 50px;">
                  <div class="btn btn-default btn-file btn-block">
                    <i class="fa fa-image"></i> Change Photo..
                    <input type="file" name="image" id='img' value="{{ old('image') }}">
                  </div>
                </div>
                {{ Form::close() }}
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="well">
              {{ Form::open([
                'id' => 'frmname', 'data-parsley-whitespace' => 'squish'])
              }}
              <div class="editname"><button class='btn btn-default btn-xs pull-right' value="frmname"><i class='fa fa-edit'></i></button></div>
              <div class="form-group">
                <label for="first_name" class="control-label">First Name*</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ Auth::user()->first_name }}" required="required" maxlength="25" readonly="readonly">
              </div>
              <div class="form-group">
                <label for="middle_name" class="control-label">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ Auth::user()->middle_name }}" maxlength="25" readonly="readonly">
              </div>
              <div class="form-group">
                <label for="last_name" class="control-label">Last Name*</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ Auth::user()->last_name }}" required="required" maxlength="25" readonly="readonly">
              </div>
              {{ Form::close() }}
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group well">
              {{ Form::open([
                'id' => 'frmcontact', 'data-parsley-whitespace' => 'squish'])
              }}
              <div class="editcontact"><button class='btn btn-default btn-xs pull-right' value="frmcontact"><i class='fa fa-edit'></i></button></div>
              <label class="control-label">Contact Number*</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </div>
                <input type="text" class="form-control" id="cell_no" name="cell_no" value="{{ Auth::user()->cell_no }}"  required="required" maxlength="15" readonly="readonly">
              </div>
              {{ Form::close() }}
            </div>
            <div class="form-group well">
              {{ Form::open([
                'id' => 'frmemail', 'data-parsley-whitespace' => 'squish'])
              }}
              <div class="editemail"><button class='btn btn-default btn-xs pull-right' value="frmemail"><i class='fa fa-edit'></i></button></div>
              <label for="lastName" class="control-label">Email*</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-at"></i>
                </div>
                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}"  required="required" maxlength="25" readonly="readonly">
              </div>
              {{ Form::close() }}
            </div>
            <div class="well">
              {{ Form::open([
                'id' => 'frmpassword', 'data-parsley-whitespace' => 'squish'])
              }}
              <div class="editpassword"><button class='btn btn-default btn-xs pull-right' value="frmpassword"><i class='fa fa-edit'></i></button></div>
              <div class="form-group">
                <label class="control-label">Current Password*</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-asterisk"></i>
                  </div>
                  <input type="password" class="form-control" id="current" name="current_password" placeholder="password" required="required" maxlength="61" readonly="readonly">
                </div> 
              </div>
              <div class="form-group">
                <label class="control-label">New Password*</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-asterisk"></i>
                  </div>
                  <input type="password" class="form-control" id="new" name="password" placeholder="password" required="required" maxlength="61" readonly="readonly">
                </div> 
              </div>
              <div class="form-group">
                <label class="control-label">Confirm Password*</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-asterisk"></i>
                  </div>
                  <input type="password" class="form-control" id="confirm" name="password_confirmation" id="password" placeholder="password" required="required" maxlength="61" readonly="readonly">
                </div> 
              </div>
              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@section('script')
{!! Html::script("custom/ProfileAjax.min.js") !!}
<script type="text/javascript">
  var urlimage = "{!! route('adminimage.store') !!}";
  var urlname = "{!! route('adminname.store') !!}";
  var urlemail = "{!! route('adminemail.store') !!}";
  var urlcontact = "{!! route('admincontact.store') !!}";
  var urlpassword = "{!! route('adminpassword.store') !!}";
</script>
@endsection