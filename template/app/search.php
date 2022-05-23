<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>سرچ</title>
    <link rel="stylesheet" href="<?= asset('public/css/app.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/css/font.css') ?>">
</head>
<body>
<section class="w-full bg-gray-100">
    <section class="container h-screen flex justify-center items-center">
        <div class=" rounded shadow text-center bg-white border">
            <h1 class="font-bold mt-2 mb-2 font-medium text-xl text-gray-700">سرچ دانشجو</h1>
            <section class="p-4">
                <form id="form" method="post">
                    <div class="mb-4 text-right inline-block">
                        <label class="block mb-1 text-gray-500" for="first_name">نام</label>
                        <input id="first_name" type="text" name="first_name" value="" class="py-2  border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block">
                    </div>
                    <div class="mb-4 text-right inline-block">
                        <label class="block mb-1 text-gray-500" for="last_name">نام خانوادگی</label>
                        <input id="last_name" type="text" name="last_name" value="" class="py-2 px-3 border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block">
                    </div>
                    <div class="mb-4 text-right inline-block">
                        <label class="block mb-1 text-gray-500" for="national_code">کد ملی</label>
                        <input id="national_code" type="number" name="national_code" value="" class="py-2 px-3 border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block">
                    </div>
                    <div class="mb-4 text-right inline-block">
                        <label class="block mb-1 text-gray-500" for="vaccine">بر اساس دوز واکسن</label>
                        <select id="vaccine" name="vaccine" class="py-2 px-3 border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block">
                            <option value="*">همه</option>
                            <option value="nothing">واکسن نزده ها</option>
                            <option value="1">یک</option>
                            <option value="2">دو</option>
                            <option value="3">سه</option>
                        </select>
                    </div>
                    <div class="mb-4 text-right inline-block">
                        <label class="block mb-1 text-gray-500" for="limit">تعداد</label>
                        <select id="limit" name="limit" class="py-2 px-3 border focus:border-blue-300 border-gray-300 focus:outline-none rounded-md shadow-sm disabled:bg-gray-100 mt-1 block">
                            <option value="3">3</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>

                        </select>
                    </div>
                    <div class="mr-5 flex items-center">
                        <input id="request_dormitory" name="request_dormitory" type="checkbox" class="border w-4 h-4 border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                        <label for="request_dormitory" class="ml-2 block text-md leading-5 text-gray-900 mr-1"> درخواستی های خوابگاه </label>
                    </div>
                    <div class="mt-6">
                        <button id="btnSub" type="button" class="inline-flex items-center justify-center px-2 py-1 bg-blue-500 border border-transparent rounded-md font-semibold capitalize text-white hover:bg-blue-600 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition">جستجو</button>
                    </div>

                </form>
                <div id="place_table" class="flex justify-center mt-2 border-t">
                    <table class="min-w-full">
                        <thead class="border-b">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">#</th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                نام
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                نام خانوادگی
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                کد ملی
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                شماره دانشجویی
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                وضعیت واکسن
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                درخواست خوابگاه
                            </th>
                        </tr>
                        </thead>
                        <tbody id="body_table">

                        </tbody>
                    </table>
                </div>
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
        const body_table = $("#body_table");

        btnSub.html('لطفا منتظر بمانید...');

        $.ajax({
            url: 'http://localhost:8000/search/student',
            type: 'POST',
            data:form.serialize(),
            success: function (response) {
                btnSub.html('جستجو');

                var results = response.students;
                //html string table
                var htmlString = '';


                for(var i = 0;i < results.length;i++){
                    var result = results[i];
                    var statusDormitory = result.request_dormitory == 1 ? 'دارد':'ندارد';
                    htmlString += '<tr>';
                    htmlString += '<td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">'+ (i+1) +'</td>';
                    htmlString += '<td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">'+ result.first_name +'</td>';
                    htmlString += '<td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">'+ result.last_name  +'</td>';
                    htmlString += '<td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">'+ result.national_code +'</td>';
                    htmlString += '<td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">'+ result.student_number +'</td>';
                    htmlString += '<td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">'+ result.vaccine+'</td>';
                    htmlString += '<td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">'+ statusDormitory +'</td>';
                    htmlString += '</tr>';
                }

                body_table.html(htmlString);
            }

        });
    });

</script>
</html>