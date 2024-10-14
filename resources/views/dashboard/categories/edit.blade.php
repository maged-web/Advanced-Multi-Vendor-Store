@extends('layout.dashboard')

@section('title','Edit Category')

@section ('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories Page</li>
<li class="breadcrumb-item active">Edit Category Page</li>

@endsection
@section('content')
@if(session()->has('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif
<form action="{{route('dashboard.categories.update',$category->id)}}" method="POST" enctype="multipart/form-data">
    @csrf 
    @method('PUT')
   @include('dashboard.categories._form',['button_label'=>'Update'])
</form>
@endsection


