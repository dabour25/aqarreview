@extends('admin/master')
@section('content')
<div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/admindb">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Control Advertises</li>
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
        <div class="container">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Review</th>
                    <th scope="col">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($ads as $k=>$a)
                  <tr>
                    <th scope="row">{{$k+1}}</th>
                    <td>{{$a->title}}</td>
                    <td>{{$a->name}}</td>
                    <td>{{$a->email}}</td>
                    <td><a href="/admindb/ads/{{$a->slug}}" class="btn btn-success" target="blank">Review</a></td>
                    <td><a id="removal{{$a->id}}" href="#" class="btn btn-danger">X</a></td>
                  </tr>
                      <form action="/admindb/ads/{{$a->id}}" method="post" id="remove{{$a->id}}">
                          @csrf
                          {{method_field('DELETE')}}
                      </form>
                      <script>
                        $('#removal{{$a->id}}').click(function () {
                            $('#remove{{$a->id}}').submit();
                        });
                      </script>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          {{ $ads->links() }}
        </div>
        </div>
      </div>

  </div>
  <!-- /.content-wrapper -->

</div>
@stop
