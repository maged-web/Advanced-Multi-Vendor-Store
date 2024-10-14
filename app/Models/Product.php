<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','description','category_id','image','store_id','price','compare_price','slug'
    ];

    protected $hidden=['image','created_at','updated_at','deleted_at'];

    protected $appends=['image_url'];

        public function Category()
    {
        return $this->belongsTo(Category::class);
    }
    public function Store()
    {
        return $this->belongsTo(Store::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status','active');
    }

    public function getImageUrlAttribute()
    {
        if(!$this->image)
            return "https://www.mon-site-bug.fr/uploads/products/default-product.png";
        if(Str::startsWith($this->image,['http://','https://']))
            {
                return $this->image; 
            }
        return asset('storage/' . $this->image);
        
    }
    public function getSalesPercentAttribute()
    {
        if(!$this->compare_price)
            return 0;
        return number_format(100 - (100 * $this->price/$this->compare_price),1);
    }
    public static function booted()
    {
        static::addGlobalScope('store',new StoreScope());
        static::creating(function(Product $product)
        {
            $product->slug=Str::slug($product->name);
        });
    }

    public function scopeFilter(Builder $builder,$filters)
    {
       $options = array_merge([
        'store_id'=>null,
        'category_id'=>null,
        'tag_id'=>null,
        'status'=>'active'
       ],$filters);

       $builder->when($options['status'],function($query,$status)
       {
        return $query->where('status','=',$status);
       });
       $builder->when($options['store_id'],function($builder,$value)
       {
        $builder->where('store_id','=',$value);
       });
       $builder->when($options['category_id'],function($builder,$value)
       {
        $builder->where('category_id','=',$value);
       });
       $builder->when($options['tag_id'],function($builder,$value)
       {

        $builder->whereExists(function($query) use ($value)
        {
         $query->select(1)
         ->from('product_tag')
         ->whereRaw('product_id = products.id')
         ->where('tag_id',$value);
        });

       // $builder->whereRaw('id IN (SELECT product_id FROM product_tags Where tag_id = ?)',[$value]);
       // $builder->whereRaw('EXISTS (SELECT 1 FROM product_tags Where tag_id = ? and product_id = products.id)',[$value]);



      /*   $builder->whereHas('tags',function($builder) use ($value)
        {
            $builder->where('id','=',$value);

        }); */
       });

     
    }

}
