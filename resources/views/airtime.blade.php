@extends('layouts.sitemaster')
@section('pageTitle', 'Networks')
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

          <div class="card-header">
            <h4 class="page-title">Networks<button class="btn btn-exel pull-right" data-toggle="modal" data-target="#editairtime">Add New <i class="fa fa-airtime-plus fa-fw"></i></button>
            </h4>
          </div>

          <div class="card-body table-responsive">
            <table id="example1" class="table display table-striped table-bordered text-center">

              <thead>
                <tr>
                  <th>Name</th>
                  <th>Image</th>
                  <th>Rate (%)</th>
                  <th>Transfer Code</th>
                  <th>PIN Change</th>
                  <th>Modify</th>
                </tr>
              </thead>

              <tbody>
                @forelse($airtimes as $airtime)
                  <tr>
                    <td>{{ $airtime->name }}</td>
                    <td><img src="{{ asset('storage') }}/{{ $airtime->image }}" style="height: 50px; width: 70px">
                      </td>
                    <td>{{ $airtime->rate}}</td>
                    <td>{{ $airtime->transfer_code }}</td>
                    <td>{{ $airtime->pin_change }}</td>
                    <td>
                      <a href="#" data-toggle="modal" data-target="#editairtime{{ $airtime->id }}" class="text-green p-2">
                        <i class="fa fa-edit"></i>
                      </a>
                      
                      <a href="{{ url('/admin/services/airtime') }}/{{ $airtime->id }}" class="p-2">
                        <i class="fa fa-eye"></i>
                      </a>

                      <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $airtime->id }}').submit();" class="text-red p-2">
                        <i class="fa fa-trash"></i>
                      </a>

                        <form id="delete{{ $airtime->id }}" action="{{ url('admin/services/airtime') }}/{{ $airtime->id }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                          {{ Method_field('DELETE') }}
                        </form>  
                    </td>
                  </tr>   

                  <div class="modal fade mt-5" id="editairtime{{ $airtime->id }}" tabindex="-1" role="dialog" aria-labelledby="editairtime{{ $airtime->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                       <div class="modal-content">
                          <div class="modal-header">
                            Edit {{ $airtime->name }}
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form method="POST" action="{{ url('admin/services/airtime') }}/{{ $airtime->id }}" enctype="multipart/form-data">
                            @csrf
                            {{ Method_field('PUT') }}
                             <div class="modal-body">
                                <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" value="{{ $airtime->name }}" name="name" required="" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Image</label>
                                  <input type="file" name="image" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Rate</label>
                                  <input type="number" name="rate" value="{{ $airtime->rate}}" required="" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Transfer Code</label>
                                  <input type="text" name="transfer_code" value="{{ $airtime->transfer_code}}" required="" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>PIN change</label>
                                  <input type="text" name="pin_change" value="{{ $airtime->pin_change }}" required="" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Submit</button>
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
      </div>
    </div>

    <div class="modal fade mt-5" id="editairtime" tabindex="-1" role="dialog" aria-labelledby="editairtimeLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
              Add Network
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form method="POST" action="{{ url('admin/services/airtime') }}" enctype="multipart/form-data">
              @csrf
                <div class="modal-body">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required="" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" required="" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Rate</label>
                    <input type="number" name="rate" required="" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Transfer Code</label>
                    <input type="text" name="transfer_code" required="" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>PIN change</label>
                    <input type="text" name="pin_change" required="" class="form-control">
                  </div>
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
         </div>
      </div>
    </div>

  </div>
</div>
@endsection
