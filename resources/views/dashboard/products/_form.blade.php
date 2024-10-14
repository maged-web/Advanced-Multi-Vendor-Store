@if($errors->any())
<div class="alert alert-danger">
    <h2>Error occuared</h2>
    @foreach ($errors->all() as $error )
    <li>{{$error}}</li>    
    @endforeach
</div>
@endif
<div class="form-group">
<x-from.input name='name' label="Product name" class=form-control-lg :value="$product->name" />
</div>
<div class="form-group">
    <label for="">Category</label>
    <select name="parent_id" @class(["form-control" ,"form-select",'is-invalid'=>$errors->has('parent_id')])>
        <option value="">Primary Category</option>
        @foreach (App\Models\Category::all() as $category )
            <option value="{{$category->id}}" @selected(old('category_id',$product->category_id)==$category->id)>{{$category->name}}</option>
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
</div>


<div class="form-group">
    <x-from.label id='image'>Image</x-from.label>
    <x-from.input type="file" name="image"  accept="image/*" />
    @if($product->image)
    <img src="{{asset('storage/'.$product->image)}}" height="50px">
    @endif
    @error('image')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>

<div class="form-group">
    <x-from.input name="price" label='Price' :value="$product->price"/>
</div>

<div class="form-group">
    <x-from.input name="compare_price" label='Compare Price' :value="$product->compare_price"/>
</div>

<div class="form-group">
    <x-from.input name="tags" label='Tags' :value="$tags"/>
</div>

<div class="form-group">
    <label for="status">Status</label>
    <div>
        <x-from.radio name="status" :checked="$product->status" :options="['active'=>'Active','archived'=>'Archived','draft'=>'Draft']" />
    </div>   
</div>


<div class="form-group">
    <button type="submit" class="btn btn-primary">{{$button_label??'Save'}}</button>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></scri>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script>
    var inputElm = document.querySelector('[name=tags]'),
    tagify = new Tagify (inputElm);  
</script>
@endpush