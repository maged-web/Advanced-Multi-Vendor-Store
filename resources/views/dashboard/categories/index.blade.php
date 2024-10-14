@extends('layout.dashboard')

@section('title','Categoties')

@section ('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories Page</li>
@endsection
@section('content')

<div class="mb-5">
    <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
    <a href="{{route('dashboard.categories.trash')}}" class="btn btn-sm btn-outline-dark">Trash</a>
</div>

<x-alert type="success"/>
<x-alert type="info"/>

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
            <th>Parent</th>
            <th>#</th>
            <th>Status</th>
            <th>Created at</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
        <tr>
            <td><img src="{{asset('storage/'.$category->image)}}" height="50px"></td>
            <td>{{$category->id}}</td>
            <td><a href="{{route('dashboard.categories.show',$category->id)}}">{{$category->name}}</a></td>
            <td>{{$category->parent->name}}</td>
            <td>{{$category->products_number}}</td>
            <td>{{$category->status}}</td>
            <td>{{$category->created_at}}</td>
            <td>
                <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                        </td>
            <td>
                <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
<tr>
    <td colspan="9">No categories defined.</td>
</tr>
        @endforelse
    </tbody>
</table>
{{$categories->withQueryString()->links()}}
@endsection


