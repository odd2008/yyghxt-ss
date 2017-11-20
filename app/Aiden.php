<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Aiden extends Model
{
    /*
     * return 所有用户id和名字组成的一维数组
     */
    public static function getAllUserArray()
    {
        $obj=User::select('id','realname')->get();
        $users=[];
        foreach ($obj as $user){
            $users[$user->id]=$user->realname;
        }
        return $users;
    }

    /*
     * return 对应表的id和名称组成的一维数组
     */
    public static function getAllModelArray($table)
    {
        $obj=DB::table($table)->select('id','display_name')->get();
        $data=[];
        foreach ($obj as $v){
            $data[$v->id]=$v->display_name;
        }
        return $data;
    }

    /*
     * return 当前用户权限对应的科室id和科室名称的一维数组
     */
    public static function getAuthdOffices()
    {
        $offices=[];
        foreach (Auth::user()->offices as $office){
            $offices[$office->id]=$office->display_name;
        }
        return $offices;
    }
    /*
     * return 当前用户权限对应的病种id和名称的二维数组(以科室分组)
     */
    public static function getAuthdDiseases()
    {
        $diseases=[];
        foreach (Auth::user()->offices as $office){
            $diseases[$office->id]['name']=$office->display_name;
            foreach ($office->diseases as $disease){
                $diseases[$office->id]['diseases'][$disease->id]=$disease->display_name;
            }
        }
        return $diseases;
    }
    /*
     * return 当前用户权限对应的科室下的医生id和姓名的一维数组
     */
    public static function getAuthdDoctors()
    {;
        return Doctor::whereIn('office_id',array_keys(static::getAuthdOffices()));

    }
}