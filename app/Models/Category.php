<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'name','description','parent_id','image','status','slug'
    ];
    public function products()
    {
        return $this->hasMany(Product::class); 
    }
    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id','id')->
        withDefault([
            'name'=>'-'
        ]); 
    }
    public function childrens()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status','=','active');
    }

    public function scopeFilter(Builder $builder,$filters)
    {
        $builder->when($filters['name']??false,function($builder,$value)
        {
            $builder->where('categories.name','LIKE',"%{$value}%");
        });
        $builder->when($filters['categories.status']??false,function($builder,$value)
        {
            $builder->where('status','=',"$value");
        });

       /*  if($filters['name']??false)
        {
         $builder->where('name','LIKE',"%{$filters['name']}%");
        }
        if($filters['status']??false)
        {
         $builder->where('status','=',$filters['status']);
        } */
    }
    public static function rules($id=0)
    {
        return [
            'name'=>['required','string','min:3','max:255',"unique:categories,name,$id",'filter:laravel,php'],
            'parent_id'=>[
                'nullable','int','exists:categories,id',
            ],
            'image'=>[
                'image','max:1048576','dimensions:min_width=100,min_height=100',
            ],
            'status'=>'in:active,archived'
        ];
    }
   
}
