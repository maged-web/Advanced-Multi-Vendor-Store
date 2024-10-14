@if($errors->any())
<div class="alert alert-danger">
    <h2>Error occuared</h2>
    @foreach ($errors->all() as $error )
    <li>{{$error}}</li>    
    @endforeach
</div>
@endif
<div class="form-group">
<x-from.input name='name' label="Category name" class=form-control :value="$category->name" />
</div>
<div class="form-group">
    <label for="">Category parent</label>
    <select name="parent_id" @class(["form-control" ,"form-select",'is-invalid'=>$errors->has('parent_id')])>
        <option value="">Primary Category</option>
        @foreach ($parents as $parent )
            <option value="{{$parent->id}}" @selected(old('parent_id',$category->parent_id)==$parent->id)>{{$parent->name}}</option>
        @endforeach
    </select>
    @error('parent_id')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>
<div class="form-group">
    <label for="">Description</label>   
    <x-from.textarea name="description" :value="$category->description"/>
    @error('name')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>


<div class="form-group">
    <x-from.label id='image'>Image</x-from.label>
    <x-from.input type="file" name="image"  accept="image/*" />
    @if($category->image)
    <img src="{{asset('storage/'.$category->image)}}" height="50px">
    @endif
    @error('image')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>

<div class="form-group">
    <label for="status">Status</label>
    <div>
        <x-from.radio name="status" :checked="$category->status" :options="['active'=>'Active','archived'=>'Archived']" />
    </div>
       
</div>


<div class="form-group">
    <button type="submit" class="btn btn-primary">{{$button_label??'Save'}}</button>
</div>