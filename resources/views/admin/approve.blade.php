@extends('admin/master')
@section('content')
<div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/admindb">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Approve Advertises</li>
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
                <div class="list-group">
                @foreach($ads as $ad)
                <a style="cursor: pointer" data-toggle="collapse" data-target="#ad{{$ad->id}}" class="list-group-item"><b>New Advertise : {{$ad->title}}</b></a>
                <div id="ad{{$ad->id}}" class="collapse">
                  <a href="/admindb/ads/{{$ad->slug}}" class="btn btn-success" target="blank">Review</a>
                  <a href="#" id="approveal{{$ad->id}}" class="btn btn-primary">Approve</a>
                  <a href="#" id="removal{{$ad->id}}" class="btn btn-danger">Remove</a>
                </div>
                <form action="/admindb/ads/{{$ad->id}}" method="post" id="approve{{$ad->id}}">
                    @csrf
                    {{method_field('PUT')}}
                </form>
                <form action="/admindb/ads/{{$ad->id}}" method="post" id="remove{{$ad->id}}">
                    @csrf
                    {{method_field('DELETE')}}
                </form>
                <script>
                    $('#approveal{{$ad->id}}').click(function () {
                        $('#approve{{$ad->id}}').submit();
                    });
                    $('#removal{{$ad->id}}').click(function () {
                        $('#remove{{$ad->id}}').submit();
                    });
                </script>
                @endforeach
                @foreach($oldads as $oad)
                <a style="cursor: pointer" data-toggle="collapse" data-target="#ad{{$oad->id}}" class="list-group-item">
                Advertise : {{$oad->title}} Still not Approved</a>
                <div id="ad{{$oad->id}}" class="collapse">
                  <a href="/admindb/ads/{{$oad->slug}}" class="btn btn-success" target="blank">Review</a>
                  <a href="#" id="approveal{{$oad->id}}" class="btn btn-primary">Approve</a>
                  <a href="#" id="removal{{$oad->id}}" class="btn btn-danger">Remove</a>
                </div>
                <form action="/admindb/ads/{{$oad->id}}" method="post" id="approve{{$oad->id}}">
                    @csrf
                    {{method_field('PUT')}}
                </form>
                <form action="/admindb/ads/{{$oad->id}}" method="post" id="remove{{$oad->id}}">
                    @csrf
                    {{method_field('DELETE')}}
                </form>
                    <script>
                        $('#approveal{{$oad->id}}').click(function () {
                            $('#approve{{$oad->id}}').submit();
                        });
                        $('#removal{{$oad->id}}').click(function () {
                            $('#remove{{$oad->id}}').submit();
                        });
                    </script>
                @endforeach
                </div>
            </div>
          </div>
          {{ $oldads->links() }}
          </div>
        </div>
  </div>
  <!-- /.content-wrapper -->
</div>
@stop
