@extends('layout.dashboard')

@section('title','Edit Category')

@section ('breadcrumb')
@parent
<li class="breadcrumb-item active">Product Page</li>
<li class="breadcrumb-item active">Edit Product Page</li>

@endsection
@section('content')
@if(session()->has('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif
<form action="{{route('dashboard.products.update',$product->id)}}" method="POST" enctype="multipart/form-data">
    @csrf 
    @method('PUT')
   @include('dashboard.products._form',['button_label'=>'Update'])
</form>
@endsection


