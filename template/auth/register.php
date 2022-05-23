<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ثبت نام</title>
    <link rel="stylesheet" href="<?= asset('public/css/app.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/css/font.css') ?>">
</head>
<body>
<section class="w-full bg-gray-100">
    <section class="container h-screen flex justify-center items-center">
        <div class="w-full sm:max-w-lg rounded shadow text-center bg-white border">
            <h1 class="font-bold mt-2 mb-2 font-medium text-xl text-gray-700">ثبت نام دانشجو</h1>
            <section class="p-4">
                <div id="error" class="bg-red-500 text-gray-100 p-2 text-center hidden rounded shadow">

                </div>
                <div id="message" class="bg-green-500 text-white p-2 text-center hidden rounded shadow">

                </div>
                <form id="form" method="post">
                    <div class="mb-4 text-right">
                        <label class="block mb-1 text-gray-500" for="first_name">نام خود را وارد کنید</label>
                        <input id="first_name" type="text" name="first_name" value="" class="py-2 px-3 border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block w-full">
                    </div>
                    <div class="mb-4 text-right">
                        <label class="block mb-1 text-gray-500" for="last_name">نام خوانوادگی خود را وارد کنید</label>
                        <input id="last_name" type="text" name="last_name" value="" class="py-2 px-3 border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block w-full">
                    </div>
                    <div class="mb-4 text-right">
                        <label class="block mb-1 text-gray-500" for="student_number">شماره دانشجویی خود را وارد کنید</label>
                        <input id="student_number" type="number" name="student_number" value="" class="py-2 px-3 border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block w-full">
                    </div>
                    <div class="mb-4 text-right">
                        <label class="block mb-1 text-gray-500" for="national_code">کد ملی خود را وارد کنید</label>
                        <input id="national_code" type="number" name="national_code" value="" class="py-2 px-3 border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block w-full">
                    </div>

                    <div class="mb-4 text-right">
                        <label class="block mb-1 text-gray-500" for="vaccine">چند نوبت واکسن کرونا تزریق کرده اید</label>
                        <select id="vaccine" name="vaccine" class="py-2 px-3 border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block w-full">
                            <option value="c" selected>انتخاب کنید</option>
                            <option value="nothing">واکسن تزریق نکرده ام</option>
                            <option value="1">یک</option>
                            <option value="2">دو</option>
                            <option value="3">سه</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input id="request_dormitory" name="request_dormitory" type="checkbox" class="border w-4 h-4 border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                        <label for="request_dormitory" class="ml-2 block text-md leading-5 text-gray-900 mr-1"> درخواست خوابگاه </label>
                    </div>

                    <div class="mt-6">
                        <button id="btnSub" type="button" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold capitalize text-white hover:bg-blue-600 focus:outline-none disabled:opacity-25 transition">ثبت</button>
                    </div>
                </form>
            </section>
        </div>
    </section>
</section>
</body>
<script src="<?= asset('public/js/jquery-3.5.1.min.js') ?>"></script>
<script>
    $("#btnSub").click(function () {
        const btnSub = $("#btnSub");
        const form = $("#form");
        const error = $("#error");
        const message = $("#message");
        btnSub.html('لطفا منتظر بمانید...');
        $.ajax({
            url:'http://localhost:8000/register/store',
            type:'post',
            data:form.serialize(),
            success:function (response) {
                if (response.success){
                    error.addClass('hidden');
                    message.removeClass('hidden').html(response.success.message);
                }else{
                    message.addClass('hidden');
                    error.removeClass('hidden').html(response.error.message);
                }
                btnSub.html('ثبت');
            }
        })
    })
</script>
</html>