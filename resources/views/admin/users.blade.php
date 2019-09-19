@extends('admin/master')
@section('content')
<style>
    .form-control{
      width:100%;
      min-width: 100px;
    }
    @media(max-width: 786px){
      .card-body{
        padding: 10px 0;
      }
    }
  </style>
<div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/admindb">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Control Users</li>
      </ol>

    <!-- Page Content -->
    @if(count($errors)>0)
    <br>
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(Session::has('m'))
      <?php $a=[]; $a=session()->pull('m'); ?>
      <div class="alert alert-{{$a[0]}}" style="width: 40%">
        {{$a[1]}}
      </div>
    @endif
    <!-- Page Content -->
      <form action="/admindb/editusers" method="post">
        @csrf
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <select class="form-control" style="width: 150px;display: inline;position: relative; top: 2px;left:20px;" id="filter">
          <option value="">Select Filter</option>
          <option value="admin" {{isset($filter)&&$filter=='admin'?'selected':''}}>Admin</option>
          <option value="user" {{isset($filter)&&$filter=='user'?'selected':''}}>User</option>
          <option value="developer" {{isset($filter)&&$filter=='developer'?'selected':''}}>Developer</option>
          <option value="broker" {{isset($filter)&&$filter=='broker'?'selected':''}}>Broker</option>
          <option value="owner" {{isset($filter)&&$filter=='owner'?'selected':''}}>Owner</option>
          <option value="renter" {{isset($filter)&&$filter=='renter'?'selected':''}}>Renter</option>
        </select>
        <script type="text/javascript">
          $('#filter').change(function(){
            if($('#filter').val()==""){
              location.href='/admindb/users';
            }else{
              location.href='/admindb/users/'+$('#filter').val();
            }
          });
        </script>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
                    <th scope="col">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $k=>$a)
                  <tr>
                    <th scope="row">{{$k+1}}</th>
                    <td><input type="text" class="form-control" name="name[{{$a->id}}]" value="{{$a->name}}"></td>
                    <td><input type="text" class="form-control" name="email[{{$a->id}}]" value="{{$a->email}}"></td>
                    <td><input type="text" class="form-control" name="phone[{{$a->id}}]" value="{{$a->phone}}"></td>
                    <td><input type="text" class="form-control" name="password[{{$a->id}}]"></td>
                    @if($a->id!=1)
                    <td>
                      <select name="role[{{$a->id}}]" class="form-control">
                        <option value="user" {{$a->role=='user'?'selected':''}}>User</option>
                        <option value="admin" {{$a->role=='admin'?'selected':''}}>Admin</option>
                        <option value="developer" {{$a->role=='developer'?'selected':''}}>Developer</option>
                        <option value="broker" {{$a->role=='broker'?'selected':''}}>Broker</option>
                        <option value="owner" {{$a->role=='owner'?'selected':''}}>Owner</option>
                        <option value="renter" {{$a->role=='renter'?'selected':''}}>Renter</option>
                      </select>
                    </td>
                    <td><a href="/admindb/removeuser/{{$a->id}}" class="btn btn-danger">X</a></td>
                    @else
                    <td>Admin</td>
                    <td></td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            </div>
            {{ $users->links() }}
          </div>
        </form>
        </div>

  </div>
  <!-- /.content-wrapper -->

</div>
@stop