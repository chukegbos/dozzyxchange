@extends('layouts.sitemaster')
@section('pageTitle', 'All Users')
@section('content')
  <div class="content pt-5">
    <div class="container">
      <div class="card card-primary card-shadow" data-collapsed="0">
        <div class="card-heading">
          <div class="page-title text-center">
            <strong><h2>All Users<h2></strong>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="example1" class="table display table-striped table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Wallet (<span>&#8358;</span>)</th>

                  <th>Date Joined</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($users as $user)
                  <tr>
                    <td>{{ $user->last_name }} {{ $user->first_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ number_format($user->balance,2) }}</td>
                   
                    <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at))->toFormattedDateString() }}</td>

                    <td style="padding: 10px">
                      <a href="{{ url('admin/searchaccount') }}/{{ $user->id }}" style="color: blue"> Profile</a>
                      |
                      <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $user->id }}').submit();" style="color: red">
                        Delete
                      </a>

                      <form id="delete{{ $user->id }}" action="{{ url('admin/deleteuser') }}/{{ $user->id }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        {{ Method_field('DELETE') }}
                      </form>  
                    </td>
                  </tr> 
                @empty
                @endforelse 
              </tbody>                
            </table>
          </div>
        </div>
      </h2>
    </div>
  </div>
@endsection
