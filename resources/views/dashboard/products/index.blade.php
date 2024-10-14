@extends('layout.dashboard')

@section('title','Products')

@section ('breadcrumb')
@parent
<li class="breadcrumb-item active">Products Page</li>
@endsection
@section('content')

{{-- <div class="mb-5">
    <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
    <a href="{{route('dashboard.categories.trash')}}" class="btn btn-sm btn-outline-dark">Trash</a>
</div> --}}

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
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created at</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            
        <tr>
            <td><img src="{{asset('storage/'.$product->image)}}" height="50px"></td>
            <td>{{$product->id}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->category->name }}</td>
            <td>{{$product->store->name}}</td>
            <td>{{$product->status}}</td>
            <td>{{$product->created_at}}</td>
            <td>
                <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                        </td>
            <td>
                <form action="{{route('dashboard.products.destroy',$product->id)}}" method="POST">
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
{{$products->withQueryString()->links()}}
@endsection


