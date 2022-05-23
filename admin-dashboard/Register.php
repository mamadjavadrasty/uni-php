<?php

namespace AdminDashboard;

use DataBase\DataBase;
require_once(realpath(dirname(__FILE__) . "/DataBase.php"));
class Register
{

    private $db;


    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function index()
    {
        require_once(BASE_PATH . "/template/auth/register.php");
    }

    public function store($request)
    {
        //validation request
        $this->validate($request);
        //customize and create data
        $request['request_dormitory'] = isset($request['request_dormitory']) ? 1 : 0;
        $create = $this->db->insert('student',array_keys($request),$request);
        //check if created
       if ($create){
           setResponse(['success'=>['message'=>'ثبت نام شما با موفقیت انجام شد']]);
       }
        setResponse(['error'=>['message'=>'خطایی رخ داده است دوباره تلاش کنید']]);
    }

    public function validate($data)
    {
        unset($data['request_dormitory']);

        //check if empty value
        foreach ($data as $filed){
            if (empty($filed)){
                setResponse(['error'=>['message'=>'لطفا تمام اطلاعات خواسته شده را پر کنید']]);
            }
        }
        //check size length
        if (strlen($data['national_code']) < 10 || strlen($data['national_code']) > 10){
            setResponse(['error'=>['message'=>'کد ملی باید ده رقم باشد']]);
        }
        if (filter_var($data['national_code'],FILTER_VALIDATE_INT)){
            setResponse(['error'=>['message'=>'کد ملی باید عدد باشد']]);
        }
        //check size length
        if (strlen($data['student_number']) < 14 || strlen($data['student_number']) > 14){
            setResponse(['error'=>['message'=>'شماره دانشجویی باید چهارده رقم باشد']]);
        }
        if (filter_var($data['student_number'],FILTER_VALIDATE_INT)){
            setResponse(['error'=>['message'=>'کد ملی باید عدد باشد']]);
        }
        //check choose
        if ($data['vaccine'] == 'c'){
            setResponse(['error'=>['message'=>'تعداد دوز واکسن تزریق شده را انتخاب کنید']]);
        }
    }

}