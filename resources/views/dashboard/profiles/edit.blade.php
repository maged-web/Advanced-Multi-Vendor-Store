@extends('layout.dashboard')

@section('title','Edit Profile')

@section ('breadcrumb')
@parent
<li class="breadcrumb-item active">Profile </li>
<li class="breadcrumb-item active">Edit Profile</li>

@endsection

@section('content')

@if(session()->has('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif

<form action="{{route('dashboard.profile.update')}}" method="POST" >
    @csrf 
    @method('PATCH')
    
    <div class="form-row">
        <div class="col-md-6">
            <x-from.input name='first_name' label='First name' :value="$user->profile->first_name" />
        </div>
        <div class="col-md-6">
            <x-from.input name='last_name' label='Last name' :value="$user->profile->last_name"/>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6">
            <x-from.input name='birthday' type='date' label='Birthday' :value="$user->profile->birthday"/>
        </div>
        <div class="col-md-6">
            <x-from.radio name='gender' label='Gender' :options="['male'=>'Male','female'=>'Female']" :checked="$user->profile->gender" />
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4">
            <x-from.input name='street_address' label='Street Address' :value="$user->profile->street_address" />
        </div>
        <div class="col-md-4">
            <x-from.input name='city' label='City' :value="$user->profile->city" />
        </div>
        <div class="col-md-4">
            <x-from.input name='state' label='State' :value="$user->profile->state" />
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4">
            <x-from.input name='postal_code' label='Postal Code' :value="$user->profile->postal_code" />
        </div>
        <div class="col-md-4">
            <x-from.select :options="$countries" name='country' label='Country' :selected="$user->profile->country" />
        </div>
        <div class="col-md-4">
            <x-from.select name='locale' :options="$locales" label='Locale' :selected="$user->profile->locale" />
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>

@endsection


