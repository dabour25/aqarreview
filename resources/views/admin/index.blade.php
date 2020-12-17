@extends('admin/master')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/admindb">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Overview</li>
      </ol>

      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-comments"></i>
              </div>
              @if($messagescount!=0)
              <div class="mr-5">{{$messagescount}} New Messages!</div>
              @else
              <div class="mr-5">No New Messages</div>
              @endif
            </div>
            <a class="card-footer text-white clearfix small z-1" href="/admindb/messages">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-list"></i>
              </div>
              @if($newads!=0)
              <div class="mr-5">{{$newads}} New Ads!</div>
              @else
              <div class="mr-5">No New Ads</div>
              @endif
            </div>
            <a class="card-footer text-white clearfix small z-1" href="/admindb/approve">
              <span class="float-left">Check Ads</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-user"></i>
              </div>
              <div class="mr-5">Users Register: {{$usercount}}</div>
            </div>
          </div>
        </div>

          <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-warning o-hidden h-100">
                  <div class="card-body">
                      <div class="card-body-icon">
                          <i class="fas fa-fw fa-bullhorn"></i>
                      </div>
                      @if($reports!=0)
                          <div class="mr-5">{{$reports}} New Reports!</div>
                      @else
                          <div class="mr-5">No New Reports</div>
                      @endif
                  </div>
                  <a class="card-footer text-white clearfix small z-1" href="/admindb/reports">
                      <span class="float-left">View Reports</span>
                      <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
                  </a>
              </div>
          </div>

      </div>
@stop
