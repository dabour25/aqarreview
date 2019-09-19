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
                <a style="cursor: pointer" data-toggle="collapse" data-target="#ad{{$ad->id}}" class="list-group-item"><b>New Advertise : {{$ad->title}}</a>
                <div id="ad{{$ad->id}}" class="collapse">
                  <a href="/admindb/review/{{$ad->id}}" class="btn btn-success" target="blank">Review</a>
                  <a href="/admindb/approvea/{{$ad->id}}" class="btn btn-primary">Approve</a>
                </div>
                @endforeach
                @foreach($oldads as $oad)
                <a style="cursor: pointer" data-toggle="collapse" data-target="#ad{{$oad->id}}" class="list-group-item">
                Advertise : {{$oad->title}} Still not Approved</a>
                <div id="ad{{$oad->id}}" class="collapse">
                  <a href="/admindb/review/{{$oad->id}}" class="btn btn-success" target="blank">Review</a>
                  <a href="/admindb/approvea/{{$oad->id}}" class="btn btn-primary">Approve</a>
                </div>
                @endforeach
                </div>
            </div>
          </div>
          </div>
        </div>

  </div>
  <!-- /.content-wrapper -->

</div>
@stop