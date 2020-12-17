@extends('admin/master')
@section('content')
<div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/admindb">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Reports</li>
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
                  @foreach($new_reports as $report)
                <a style="cursor: pointer" data-toggle="collapse" data-target="#rep{{$report->id}}" class="list-group-item"><b>New Report from : {{$report->fromUser->name}} - to : {{$report->toUser->name}}</b></a>
                <div id="rep{{$report->id}}" class="collapse">
                {{$report->report}}
                    <br>
                    <button class="btn btn-warning" onclick="block('{{$report->toUser->slug}}')">Block Reported User ({{$report->toUser->email}})</button>
                    <button class="btn btn-danger" onclick="block('{{$report->fromUser->slug}}')">Block Reporter ({{$report->fromUser->email}})</button>
                </div>
                @endforeach
                @foreach($old_reports as $report)
                <a style="cursor: pointer" data-toggle="collapse" data-target="#rep{{$report->id}}" class="list-group-item">Report from : {{$report->fromUser->name}} - to : {{$report->toUser->name}}</a>
                <div id="rep{{$report->id}}" class="collapse">
                {{$report->report}}
                    <br>
                    <button class="btn btn-warning" onclick="block('{{$report->toUser->slug}}')">Block Reported User ({{$report->toUser->email}})</button>
                    <button class="btn btn-danger" onclick="block('{{$report->fromUser->slug}}')">Block Reporter ({{$report->fromUser->email}})</button>
                </div>
                @endforeach
                </div>
            </div>
          </div>
          </div>
        </div>
        <form action="/admindb/block-user" method="post" id="block-form" hidden>
            @csrf
            <input type="text" name="slug" id="block-slug">
        </form>
  </div>
  <!-- /.content-wrapper -->

</div>
    <script>
        function block(slug){
            $("#block-slug").val(slug);
            $("#block-form").submit();
        }
    </script>
@stop
