@extends('layout.dashboard')

@section('title',$category->name)

@section ('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories Page</li>
<li class="breadcrumb-item active">{{$category->name}}</li>

@endsection
@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        @php
        $products=$category->products()->with('store')->latest()->paginate(5)    
        @endphp
        @forelse ($products as $product)
            
        <tr>
            <td><img src="{{asset('storage/'.$product->image)}}" height="50px"></td>
            <td>{{$product->name}}</td>
            <td>{{$product->store->name}}</td>
            <td>{{$product->status}}</td>
            <td>{{$product->created_at}}</td>
           
        </tr>
        @empty
<tr>
    <td colspan="5">No categories defined.</td>
</tr>
        @endforelse
    </tbody>
</table>
{{$products->links()}}
@endsection


