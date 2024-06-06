<?php
namespace System\Database\ORM;
use App\Casts\ProfileCast;
use System\Database\Traits\HasAttributes;
use System\Database\Traits\HasCRUD;
use System\Database\Traits\HasMethodCaller;
use System\Database\Traits\HasQueryBuilder;
use System\Database\Traits\HasRelation;
use System\Database\Traits\HasSoftDelete;
use System\Database\Traits\ModelSetting;

abstract class Model
{
    use ModelSetting,HasAttributes,HasCRUD,HasRelation,HasQueryBuilder,HasSoftDelete,HasMethodCaller;
   protected $table;
    protected $filable=[];
    protected $casts=[
        'profile'=>ProfileCast::class
    ];
    protected $hidden=[];
    protected $createdAt='created_at';
    protected $updatedAt='updated_at';
    protected $deletedAt=null;
    protected $collection=[];
    protected $primaryKey='id';

}