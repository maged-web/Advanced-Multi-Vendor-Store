@extends('layout.dashboard')

@section('title','Trashed categoties')

@section ('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories Page</li>
<li class="breadcrumb-item active">Trahs Page</li>
@endsection
@section('content')

<div class="mb-5"><a href="{{route('dashboard.categories.index')}}" class="btn btn-sm btn-outline-primary">Back</a></div>

<x-alert type="success"/>

<form  action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4" >
    <x-from.input name='name' placeholder='Name' class="mx-2" :value="request('name')"/>
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option @selected(request('status')=='active') value="active">Active</option>
        <option @selected(request('status')=='archived') value="archived">Archived</option>
    </select>
    <button class="mx-2 btn btn-dark">Filter</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>deleted at</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
            
        <tr>
            <td><img src="{{asset('storage/'.$category->image)}}" height="50px"></td>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->status}}</td>
            <td>{{$category->deleted_at}}</td>
            <td>
                <form action="{{route('dashboard.categories.restore',$category->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-outline-success">Restore</button>
                </form>                        </td>
            <td>
                <form action="{{route('dashboard.categories.force-delete',$category->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
<tr>
    <td colspan="7">No categories defined.</td>
</tr>
        @endforelse
    </tbody>
</table>
{{$categories->withQueryString()->links()}}
@endsection


