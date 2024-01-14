<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * The table associated with the model.
     * 指定哪一張表
     * @var string
     */
    protected $table = 'news';

    /**
     * The primary key associated with the table.
     *主鍵是哪個欄位
     * @var string
     */
    //Heidi->news主鍵=id
    protected $primaryKey = 'id';


    //白名單，填入可輸入之欄位
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['img_path', 'title', 'content'];
}
