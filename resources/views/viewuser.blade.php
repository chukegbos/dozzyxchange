@extends('layouts.sitemaster')
@section('pageTitle', ucwords($user->name))
@section('content')
<div class="content pt-2">
  <div class="container">
    <div class="card card-primary card-shadow" data-collapsed="0">
      <div class="card-heading">
        <div class="page-title text-center">
          <strong><h2>{{ ucwords($user->last_name) }} {{ ucwords($user->first_name) }}<h2></strong>
        </div>
      </div>

      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
        </div>
      @endif

      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <strong>Error!</strong>
         
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="card-body table-responsive p-0">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <table class="table table-hover">
                  <tr>
                      <th width="200px">Wallet Balance</th>
                      <td>(<span>&#8358;</span>) {{ number_format($user->balance,2) }}</td>
                  </tr> 
                  <tr>
                      <th width="200px">Phone Number</th>
                      <td>{{ $user->phone }}</td>
                  </tr> 

                  <tr>
                      <th width="200px">Email</th>
                      <td>{{ $user->email }}</td>
                  </tr>               

                  <tr>
                      <th width="200px">Address</th>
                      <td>{{ $user->address }} {{ $user->city }} {{ $user->state }}, {{ $user->country }}</td>
                  </tr> 

                  <tr>
                      <th width="200px">Account Number</th>
                      <td>{{ $user->acc_number }}</td>
                  </tr> 

                  <tr>
                      <th width="200px">Account Name</th>
                      <td>{{ $user->acc_name }}</td>
                  </tr> 

                  <tr>
                      <th width="200px">Name of Bank</th>
                      <td>
                        @forelse($banks as $bank)
                          @if($bank->code==$user->bank_name)
                            {{ $bank->name }}
                          @endif
                        @empty
                        @endforelse 
                      </td>
                  </tr> 

                  <tr>
                      <th width="200px">Password</th>
                      <td>******** <span class="pull-right"><a href="" data-toggle="modal" data-target="#changepassword" style="color: blue">Reset Password</a></span></td>
                  </tr> 

                 

                  <tr>
                      <th width="200px">Date Joined</th>
                      <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at))->toFormattedDateString() }}</td>
                  </tr> 
              </table> 
            </div>
        </div>
      </div>

      <div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="background:white">
            <div class="modal-content">
              <div class="modal-header">
                  <h4>Reset Password</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
              </div>
              <div class="modal-body">
                <form method="post" class="profile-wrapper" action="{{ url('admin/changepassword') }}" >
                   {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label for="fname">New Password</label>                     
                        <input class="form-control" type="password" name="password" required autofocus>
                        <input type="hidden" name="id" value="{{ $user->id }}">
                    </div> 
                    <button type="submit" class="btn btn-success pull-right">Save <i class="fa fa-save"></i></button>                              
                </form>
              </div>
              
              <div class="modal-footer">
               
              </div>
            </div><!-- /.modal-content -->                     
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
