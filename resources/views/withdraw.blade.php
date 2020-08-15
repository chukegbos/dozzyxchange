@extends('layouts.sitemaster')
@section('pageTitle', 'Withdraw')
@section('content')
  <div class="content pt-5">
    <div class="container">
      <div class="card card-primary card-shadow" data-collapsed="0">
        <div class="card-heading">
          <div class="page-title text-center">
            <strong><h2>Withdrawal Request<h2></strong>
          </div>
        </div>

        <div class="card-body">
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
           <div class="table-responsive advance-table">
              <table id="example1" class="table display table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Name
                    <th>Amount (<span>&#8358;</span>)</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($withdraws as $withdraw)
                    <tr>
                      <td>{{ $withdraw->last_name }} {{ $withdraw->first_name }}</td>
                      <td>{{ number_format($withdraw->amount,2) }}</td>
                      <td>
                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($withdraw->created_at))->toFormattedDateString() }} 
                      </td>
                      <td>
                        @if($withdraw->status==NULL)
                          Pending
                          <a href="{{ url('/admin/withdraw') }}/{{ $withdraw->id }}" class="btn btn-excel btn-xs float-right">Approve</a>
                          
                        @else
                          Paid
                        @endif
                      </td>
                    </tr> 
                  @empty
                  @endforelse 
                </tbody> 
              </table>
           </div>
        </div>
      </div>
    </div>
  </div>
@endsection
