@extends('layouts.sitemaster')
@section('pageTitle', 'Coin Address')
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
            <h4 class="page-title">{{ $crypto->name }} Address <button class="btn btn-exel pull-right" data-toggle="modal" data-target="#editbtc">New Address<i class="fa fa-btc-plus fa-fw"></i></button>
            </h4>
          </div>

          <div class="card-body table-responsive">
            <table id="example1" class="table display table-striped table-bordered text-center">
              <thead>
                <tr>
                  <th>Address</th>
                  <th>Barcode</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                @forelse($btcs as $btc)
                  <tr>
                    <td>{{ $btc->address }}</td>
                    <td><img src="{{ asset('storage') }}/{{ $btc->image }}" style="height: 50px; width: 70px">
                      </td>
                    <td>
                      <a href="#" data-toggle="modal" data-target="#editbtc{{ $btc->id }}" class="text-green p-2">
                        <i class="fa fa-edit"></i>
                      </a>
                      

                      <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $btc->id }}').submit();" class="text-red p-2">
                        <i class="fa fa-trash"></i>
                      </a>

                        <form id="delete{{ $btc->id }}" action="{{ url('admin/services/btc') }}/{{ $btc->id }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                          {{ Method_field('DELETE') }}
                        </form>  
                    </td>
                  </tr>   

                  <div class="modal fade mt-5" id="editbtc{{ $btc->id }}" tabindex="-1" role="dialog" aria-labelledby="editbtc{{ $btc->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                       <div class="modal-content">
                          <div class="modal-header">
                            Edit {{ $btc->name }}
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form method="POST" action="{{ url('admin/services/btc') }}/{{ $btc->id }}" enctype="multipart/form-data">
                            @csrf
                            {{ Method_field('PUT') }}
                             <div class="modal-body">
                                <div class="form-group">
                                  <label>Address</label>
                                  <input type="text" value="{{ $btc->address }}" name="address" required="" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label>Barcode</label>
                                  <input type="file" name="image" class="form-control">
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

    <div class="modal fade mt-5" id="editbtc" tabindex="-1" role="dialog" aria-labelledby="editbtcLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
              Add Cypto
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form method="POST" action="{{ url('admin/services/btc') }}" enctype="multipart/form-data">
              @csrf
               <div class="modal-body">
                  <div class="form-group">
                    <label>Address</label>
                    <input type="hidden" name="crypto_id" value="{{ $crypto->id }}">
                    <input type="text" name="address" required="" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Barcode</label>
                    <input type="file" name="image" class="form-control">
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
