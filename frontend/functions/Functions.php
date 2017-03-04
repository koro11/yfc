<?php
namespace frontend\functions;

class Functions
{
     public function aa()
     {
        echo 'asd';
     }
    /**
     * 批量插入
     */
    public function adds($table,$param)
    {
        if(empty($table) || empty($param) || !is_array($param)){
            exit('参数格式不符合标准');
        }
        $keys = array_keys($param[0]['food']);

        $keys = '(' . implode(',', $keys) . ')';

        $sql = "insert into $table $keys values";

        foreach($param as $k=>$v){
           $sql .= '(';
           foreach($v as $va){
               $sql .= "'".$va."',";
           }
           $sql = substr($sql, 0, -1);
           $sql .= ")";
           $sql .= ",";
        }
        $sql = substr($sql, 0, -1);
        return $sql;
    }
    public function add($table,$param)
    {
        if(empty($table) || empty($param) || !is_array($param)){
            exit('参数格式不符合标准');
        }
        $keys = array_keys($param);

        $keys = '(' . implode(',', $keys) . ')';

        $sql = "insert into $table $keys values";
            $sql .= '(';
            foreach($param as $va){
                $sql .= "'".$va."',";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";
            $sql .= ",";
        $sql = substr($sql, 0, -1);
        return $sql;
    }

}

