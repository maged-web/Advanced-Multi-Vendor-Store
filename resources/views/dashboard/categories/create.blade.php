@extends('layout.dashboard')

@section('title','Categoties')

@section ('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories Page</li>
@endsection
@section('content')
<form action="{{route('dashboard.categories.store')}}" method="POST" enctype="multipart/form-data">
    @csrf 
    @include('dashboard.categories._form')

</form>
@endsection


