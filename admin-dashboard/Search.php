<?php

namespace AdminDashboard;

use DataBase\DataBase;
require_once(realpath(dirname(__FILE__) . "/DataBase.php"));

class Search
{
    private $db;


    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function index()
    {
        require_once(BASE_PATH . "/template/app/search.php");
    }

    public function search($request)
    {
        //sql for search
        $sql = 'SELECT * FROM `students` WHERE `id` > 0 ';

        if (!empty($request['first_name'])){
            $sql .= "and `first_name` LIKE '" . '%' . $request['first_name'] . '%' . "' ";
        }
        if (!empty($request['last_name'])){
            $sql .= "and `last_name` LIKE '" . '%' . $request['last_name'] . '%' . "' ";
        }
        if (!empty($request['national_code'])){
            $sql .= 'and `national_code` = '.$request['national_code'].' ';
        }

        if (!empty($request['vaccine'])){
            if ($request['vaccine'] != '*'){
                $request['vaccine'] = $request['vaccine'] == 'nothing' ? 0 : $request['vaccine'];
                $sql .= 'and `vaccine` = '.$request['vaccine'].' ';
            }
        }
        if (!empty($request['request_dormitory'])){
            $sql .= 'and `request_dormitory` = 1';
        }

        $sql .= " LIMIT 0," . $request['limit'] . " ";
        //get data
        $students = $this->db->select($sql)->fetchAll();
        //array to json and send data
        setResponse(['students'=>$students]);

    }
}