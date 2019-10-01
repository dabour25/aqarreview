@extends('admin/master')
@section('content')
<div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/admindb">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Links & Data</li>
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
            <form action="/admindb/links" method="post">
              @csrf
              <label>Phone:</label>
              <input type="text" name="phone" class="form-control" value="{{$data[0]->value}}">
              <label>Email:</label>
              <input type="text" name="email" class="form-control" value="{{$data[1]->value}}">
              <label>FaceBook:</label>
              <input type="text" name="face" class="form-control" value="{{$data[2]->value}}">
              <label>Twiter:</label>
              <input type="text" name="twit" class="form-control" value="{{$data[3]->value}}">
              <label>Instagram:</label>
              <input type="text" name="inst" class="form-control" value="{{$data[4]->value}}">
              <br>
              <button type="submit" class="btn btn-primary">Save</button>
            </form>
            <hr>
            <form action="/admindb/adsdefault" method="post" enctype="multipart/form-data">
              @csrf
              <label>Default Ads Image</label>
              <br>
              <img src="{{asset('/img/ads')}}/{{$data[5]->value}}" width="150px">
              <br><br>
              <input type="file" name="default">
              <br><br>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
          </div>
        </div>
  </div>
  <!-- /.content-wrapper -->

</div>
@stop