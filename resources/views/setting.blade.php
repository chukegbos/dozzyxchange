@extends('layouts.sitemaster')
@section('pageTitle', 'Site Settings')
@section('content')

<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card mt-3">
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

          <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Site Settings</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true">About Company</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" id="session-tab" data-toggle="tab" href="#session" role="tab" aria-controls="session" aria-selected="false">Admins</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" id="logo-tab" data-toggle="tab" href="#logo" role="tab" aria-controls="logo" aria-selected="false">Logo</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="p-3">
                  <h4>setting Settings</h4>
                </div>
                <form method="POST" action="{{ url('admin/setting') }}/{{ $setting->id }}" enctype="multipart/form-data">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="form-body">
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Site Name</label>
                        <input type="text" name="sitename" class="form-control" required="" value="{{ $setting->sitename }}">
                      </div>

                      <div class="form-group">
                        <label>Site Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $setting->email }}" required="">
                      </div>

                      <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" class="form-control" value="{{ $setting->phone }}" required="">
                      </div>

                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="{{ $setting->address }}" required="">
                      </div>
                      <div class="form-group">
                        <label>Facebook Page</label>
                        <input type="text" name="facebook" class="form-control" value="{{ $setting->facebook }}">
                      </div>

                      <div class="form-group">
                        <label>Twitter Page</label>
                        <input type="text" name="twitter" class="form-control" value="{{ $setting->twitter }}">
                      </div>

                      <div class="form-group">
                        <label>LinkedIn Page</label>
                        <input type="text" name="linkedin" class="form-control" value="{{ $setting->linkedin }}">
                      </div>

                      <div class="form-group">
                        <label>Instagram Page</label>
                        <input type="text" name="instagram" class="form-control" value="{{ $setting->instagram }}">
                      </div>

                      
                    </div>
                  </div>
                  <div class="form-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>

              <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                <div class="p-3">
                  <h4>About</h4>
                </div>
                <form method="POST" action="{{ url('admin/setting') }}/{{ $setting->id }}" enctype="multipart/form-data">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="form-body">
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Vision</label>
                        <textarea name="vision" class="form-control">{{ $setting->vision }}</textarea>
                      </div>

                      <div class="form-group">
                        <label>Mission</label>
                        <textarea name="mission" class="form-control">{{ $setting->mission }}</textarea>
                      </div>

                      <div class="form-group">
                          <label>About Us</label>
                          <textarea  class="form-control" id="editorabout" rows="50" cols="110" name="about">{{ $setting->about }}
                          </textarea>
                          <script>
                              // Replace the <textarea id="editor1"> with a CKEditor
                              // instance, using default configuration.
                              CKEDITOR.replace( 'editorabout' );
                          </script>
                        </div>  

                    </div>
                  </div>
                  <div class="form-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>


              <div class="tab-pane fade" id="session" role="tabpanel" aria-labelledby="session-tab">
                <div class="p-3">
                  <h4>Site Admins
                  <button class="btn btn-success btn-xs float-right" data-toggle="modal" data-target="#addSession">Add New <i class="fa fa-plus fa-fw"></i></button></h4>
                </div>
                <div class="modal fade mt-5" id="addSession" tabindex="-1" role="dialog" aria-labelledby="addSessionLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addCourseLabel">Add Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <form method="POST" action="{{ url('admin/setting/admin') }}">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <label>Last Name </label>
                            <input type="text" name="last_name" class="form-control">
                          </div>

                          <div class="form-group">
                            <label>First Name </label>
                            <input type="text" name="first_name" class="form-control">
                          </div>

                          <div class="form-group">
                            <label> Email </label>
                            <input type="email" name="email" class="form-control" required="">
                          </div>

                          <div class="form-group">
                            <label> Password </label>
                            <input type="password" name="password" class="form-control" required="">
                          </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="table-responsive p-2">
                  <table class="table table-hover" id="example1">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Modify</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($userss as $users)
                        <tr>
                          <td>{{ $users->last_name }} {{ $users->first_name }}</td>
                          <td>{{ $users->email }}</td>
                          <td>
                            <a href="#" data-toggle="modal" data-target="#editSession{{ $users->id }}">
                              <i class="fa fa-edit text-blue"></i>
                            </a>
                            |
                            <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $users->id }}').submit();">
                              <i class="fa fa-trash text-red"></i>
                            </a>

                            <form id="delete{{ $users->id }}" action="{{ url('admin/setting/admin') }}/{{ $users->id }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                              {{ Method_field('DELETE') }}
                            </form>  
                          </td>
                        </tr>  
                        <div class="modal fade mt-5" id="editSession{{ $users->id }}" tabindex="-1" role="dialog" aria-labelledby="editSession{{ $users->id }}Label" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="addCourseLabel">Edit Admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form method="POST" action="{{ url('admin/setting/admin') }}/{{ $users->id }}">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label> Name </label>
                                    <input type="text" name="name" class="form-control" required="" value="{{ $users->name }}">
                                  </div>

                                  <div class="form-group">
                                    <label> Password </label>
                                    <input type="password" name="password" class="form-control">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      @empty
                      @endforelse 
                    </tbody>                
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="logo" role="tabpanel" aria-labelledby="standard-tab">
                <div class="p-3">
                  <h4>Upload Logo</h4>
                </div>
                <form method="POST" action="{{ url('admin/setting/logo') }}/{{ $setting->id }}" enctype="multipart/form-data" class="form-inline">
                  @csrf
                  {{ method_field('PUT') }}
                  
                      <div class="form-group">
                        <input type="file" name="logo" class="form-control" required>
                      </div>
                 
                      <button type="submit" class="btn btn-primary">Upload</button>
                  
                </form>
                <div class="m-4">
                  @if($setting->logo==NULL)
                    <div  class="p-4" style="background: red">
                      <img class="img-fluid img-responsive center" src="{{ asset('img/hsm.png') }}" style="height: 200px">
                    </div>
                  @else
                    <img class="img-fluid img-responsive center" src="{{ asset('storage') }}/{{ $setting->logo }}" style="height: 200px">
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
