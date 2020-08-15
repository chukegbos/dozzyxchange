@extends('layouts.sitemaster')
@section('pageTitle', 'Numbers')
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
            <h4 class="page-title">{{ $airtime->name }} Numbers <button class="btn btn-exel pull-right" data-toggle="modal" data-target="#editline">New Number<i class="fa fa-line-plus fa-fw"></i></button>
            </h4>
          </div>

          <div class="card-body table-responsive">
            <table id="example1" class="table display table-striped table-bordered text-center">
              <thead>
                <tr>
                  <th>Numbers</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                @forelse($lines as $line)
                  <tr>
                    <td>{{ $line->number }}</td>
                  
                    <td>
                      <a href="#" data-toggle="modal" data-target="#editline{{ $line->id }}" class="text-green p-2">
                        <i class="fa fa-edit"></i>
                      </a>
                      

                      <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $line->id }}').submit();" class="text-red p-2">
                        <i class="fa fa-trash"></i>
                      </a>

                        <form id="delete{{ $line->id }}" action="{{ url('admin/services/line') }}/{{ $line->id }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                          {{ Method_field('DELETE') }}
                        </form>  
                    </td>
                  </tr>   

                  <div class="modal fade mt-5" id="editline{{ $line->id }}" tabindex="-1" role="dialog" aria-labelledby="editline{{ $line->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                       <div class="modal-content">
                          <div class="modal-header">
                            Edit {{ $line->name }}
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form method="POST" action="{{ url('admin/services/line') }}/{{ $line->id }}" enctype="multipart/form-data">
                            @csrf
                            {{ Method_field('PUT') }}
                             <div class="modal-body">
                                <div class="form-group">
                                  <label>Number</label>
                                  <input type="text" value="{{ $line->number }}" name="number" required="" class="form-control">
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

    <div class="modal fade mt-5" id="editline" tabindex="-1" role="dialog" aria-labelledby="editlineLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
              Add Cypto
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form method="POST" action="{{ url('admin/services/line') }}" enctype="multipart/form-data">
              @csrf
               <div class="modal-body">
                  <div class="form-group">
                    <label>number</label>
                    <input type="hidden" name="airtime_id" value="{{ $airtime->id }}">
                    <input type="text" name="number" required="" class="form-control">
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
