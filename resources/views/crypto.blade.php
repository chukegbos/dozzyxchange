@extends('layouts.sitemaster')
@section('pageTitle', 'Crypto Currency')
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
            <h4 class="page-title">Crypto Currency <button class="btn btn-exel pull-right" data-toggle="modal" data-target="#editcrypto">Add New <i class="fa fa-crypto-plus fa-fw"></i></button>
            </h4>
          </div>

          <div class="card-body table-responsive">
            <table id="example1" class="table display table-striped table-bordered text-center">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Image</th>
                  <th>Selling Rate (<span>&#8358;</span>)</th>
                  <th>Buying Rate (<span>&#8358;</span>)</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                @forelse($cryptos as $crypto)
                  <tr>
                    <td>{{ $crypto->name }}</td>
                    <td><img src="{{ asset('storage') }}/{{ $crypto->image }}" style="height: 50px; width: 70px">
                      </td>
                    <td>{{ $crypto->selling_rate}}</td>
                    <td>{{ $crypto->buying_rate}}</td>
                    <td>
                      <a href="#" data-toggle="modal" data-target="#editcrypto{{ $crypto->id }}" class="text-green p-2">
                        <i class="fa fa-edit"></i>
                      </a>
                      
                      <!--<a href="{{ url('/admin/services/crypto') }}/{{ $crypto->id }}" class="p-2">
                        <i class="fa fa-eye"></i>
                      </a>-->

                      <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $crypto->id }}').submit();" class="text-red p-2">
                        <i class="fa fa-trash"></i>
                      </a>

                        <form id="delete{{ $crypto->id }}" action="{{ url('admin/services/crypto') }}/{{ $crypto->id }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                          {{ Method_field('DELETE') }}
                        </form>  
                    </td>
                  </tr>   

                  <div class="modal fade mt-5" id="editcrypto{{ $crypto->id }}" tabindex="-1" role="dialog" aria-labelledby="editcrypto{{ $crypto->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                       <div class="modal-content">
                          <div class="modal-header">
                            Edit {{ $crypto->name }}
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form method="POST" action="{{ url('admin/services/crypto') }}/{{ $crypto->id }}" enctype="multipart/form-data">
                            @csrf
                            {{ Method_field('PUT') }}
                             <div class="modal-body">
                                <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" value="{{ $crypto->name }}" name="name" required="" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label>Image</label>
                                  <input type="file" name="image" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label>Selling Price</label>
                                  <input type="number" name="selling_rate" value="{{ $crypto->selling_rate}}" required="" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Buying Price</label>
                                  <input type="number" name="buying_rate" value="{{ $crypto->buying_rate}}" required="" class="form-control">
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

    <div class="modal fade mt-5" id="editcrypto" tabindex="-1" role="dialog" aria-labelledby="editcryptoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
              Add Cypto
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form method="POST" action="{{ url('admin/services/crypto') }}" enctype="multipart/form-data">
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
                    <label>Selling Price</label>
                    <input type="number" name="selling_rate" required="" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Buying Price</label>
                    <input type="number" name="buying_rate" required="" class="form-control">
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
