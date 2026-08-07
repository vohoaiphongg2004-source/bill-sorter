<!doctype html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kết quả - Bill Sorter</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #f5f7ff 0%,
                    #eef2ff 100%
                );

            color: #1f2937;
        }

        .container {
            width: 92%;
            max-width: 1100px;

            margin: 40px auto;
        }


        /* =========================
           HEADER
        ========================= */

        .header {
            text-align: center;

            margin-bottom: 30px;
        }

        .header-icon {
            width: 58px;
            height: 58px;

            margin: 0 auto 14px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 15px;

            background: #eef2ff;

            font-size: 28px;
        }

        .header h1 {
            margin: 0;

            font-size: 32px;

            color: #111827;
        }

        .header p {
            margin: 8px 0 0;

            color: #6b7280;

            font-size: 15px;
        }


        /* =========================
           SUCCESS
        ========================= */

        .success-card {
            background: white;

            border-radius: 15px;

            padding: 16px 20px;

            margin-bottom: 22px;

            display: flex;
            align-items: center;

            gap: 13px;

            border-left: 5px solid #22c55e;

            box-shadow:
                0 8px 25px rgba(0,0,0,.06);
        }

        .success-icon {
            width: 40px;
            height: 40px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #dcfce7;

            color: #16a34a;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;
            font-weight: bold;
        }

        .success-text strong {
            display: block;

            color: #15803d;

            font-size: 15px;

            margin-bottom: 3px;
        }

        .success-text span {
            color: #6b7280;

            font-size: 13px;
        }


        /* =========================
           PAGE CARD
        ========================= */

        .page-card {
            background: white;

            border-radius: 16px;

            padding: 25px;

            margin-bottom: 25px;

            box-shadow:
                0 8px 30px rgba(0,0,0,.07);
        }

        .page-title {
            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 18px;
        }

        .page-icon {
            width: 45px;
            height: 45px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: #eef2ff;

            font-size: 21px;
        }

        .page-title h2 {
            margin: 0;

            font-size: 21px;

            color: #111827;
        }

        .page-title p {
            margin: 4px 0 0;

            color: #6b7280;

            font-size: 13px;
        }


        /* =========================
           PAGE INPUT
        ========================= */

        .page-input-wrapper {
            display: flex;

            gap: 10px;
        }

        #pageList {
            flex: 1;

            min-width: 0;

            padding: 13px 15px;

            border: 1px solid #d1d5db;

            border-radius: 9px;

            background: #f9fafb;

            font-family:
                Consolas,
                monospace;

            font-size: 15px;

            color: #111827;

            outline: none;
        }

        #pageList:focus {
            border-color: #6366f1;

            background: white;

            box-shadow:
                0 0 0 3px
                rgba(99,102,241,.1);
        }


        /* =========================
           BUTTON
        ========================= */

        button {
            border: none;

            border-radius: 9px;

            padding: 10px 16px;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            transition: .2s ease;
        }

        button:hover {
            transform: translateY(-1px);
        }

        .copy-main {
            background: #4f46e5;

            color: white;

            min-width: 125px;
        }

        .copy-main:hover {
            background: #4338ca;
        }

        .copy-small {
            background: #eef2ff;

            color: #4f46e5;
        }

        .copy-small:hover {
            background: #e0e7ff;
        }

        .copied {
            display: block;

            margin-top: 9px;

            color: #16a34a;

            font-size: 13px;

            min-height: 16px;
        }


        /* =========================
           PRODUCTS CARD
        ========================= */

        .products-card {
            background: white;

            border-radius: 16px;

            padding: 25px;

            box-shadow:
                0 8px 30px rgba(0,0,0,.07);

            overflow: hidden;
        }

        .products-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 20px;
        }

        .products-header h2 {
            margin: 0;

            font-size: 21px;

            color: #111827;
        }

        .product-count {
            background: #eef2ff;

            color: #4f46e5;

            padding: 7px 13px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: bold;
        }


        /* =========================
           TABLE
        ========================= */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 750px;
        }

        th {
            background: #f8fafc;

            color: #475569;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: .4px;

            padding: 13px;

            border-bottom: 2px solid #e5e7eb;

            text-align: left;
        }

        td {
            padding: 14px 13px;

            border-bottom: 1px solid #edf0f3;

            vertical-align: middle;

            font-size: 14px;
        }

        tbody tr {
            transition: background .15s ease;
        }

        tbody tr:hover {
            background: #fafbff;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }


        /* =========================
           STT
        ========================= */

        .stt {
            width: 32px;
            height: 32px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background: #f3f4f6;

            color: #374151;

            font-weight: bold;

            font-size: 13px;
        }


        /* =========================
           PRODUCT
        ========================= */

        .product-name {
            font-weight: 600;

            color: #111827;

            line-height: 1.5;

            max-width: 450px;
        }


        /* =========================
           COUNT
        ========================= */

        .count-badge {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-width: 36px;
            height: 30px;

            padding: 0 10px;

            background: #f3f4f6;

            border-radius: 7px;

            font-weight: bold;

            color: #374151;
        }


        /* =========================
           PAGE
        ========================= */

        .page-box {
            width: 100%;
        }

        textarea {
            width: 100%;

            height: 45px;

            resize: none;

            border: 1px solid #e5e7eb;

            border-radius: 7px;

            background: #f9fafb;

            padding: 11px;

            font-family:
                Consolas,
                monospace;

            font-size: 13px;

            color: #374151;

            outline: none;
        }

        textarea:focus {
            border-color: #6366f1;

            background: white;
        }


        /* =========================
           EMPTY
        ========================= */

        .empty {
            text-align: center;

            padding: 45px;

            color: #9ca3af;
        }


        /* =========================
           FOOTER
        ========================= */

        .footer {
            text-align: center;

            margin-top: 25px;

            color: #9ca3af;

            font-size: 13px;
        }


        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 700px) {

            .container {
                width: 94%;

                margin: 20px auto;
            }

            .header h1 {
                font-size: 27px;
            }

            .page-card,
            .products-card {
                padding: 18px;
            }

            .page-input-wrapper {
                flex-direction: column;
            }

            #pageList {
                width: 100%;
            }

            .copy-main {
                width: 100%;
            }

            .products-header {
                align-items: flex-start;

                gap: 10px;
            }

            .products-header h2 {
                font-size: 19px;
            }

            .product-name {
                max-width: 260px;
            }

            .success-card {
                padding: 15px;
            }

        }

    </style>

</head>


<body>


<div class="container">


    <!-- =========================
         HEADER
    ========================== -->

    <div class="header">

        <div class="header-icon">
            📦
        </div>

        <h1>
            Bill Sorter
        </h1>

        <p>
            Kết quả sắp xếp bill theo sản phẩm
        </p>

    </div>


    <!-- =========================
         SUCCESS
    ========================== -->

    <div class="success-card">

        <div class="success-icon">
            ✓
        </div>

        <div class="success-text">

            <strong>
                Đã sắp xếp thành công!
            </strong>

            <span>
                Thứ tự các bill đã được hệ thống xử lý.
            </span>

        </div>

    </div>


    <!-- =========================
         PAGE RESULT
    ========================== -->

    <div class="page-card">


        <div class="page-title">

            <div class="page-icon">
                📄
            </div>

            <div>

                <h2>
                    Thứ tự trang cần in
                </h2>

                <p>
                    Thứ tự đã được hệ thống sắp xếp
                </p>

            </div>

        </div>


        <div class="page-input-wrapper">

            <input
                type="text"
                id="pageList"
                value="{{ $pageList }}"
                readonly
            >


            <button
                class="copy-main"
                onclick="copyPages()"
            >
                📋 Sao chép
            </button>

        </div>


        <span
            id="copied"
            class="copied"
        ></span>


    </div>


    <!-- =========================
         PRODUCTS
    ========================== -->

    <div class="products-card">


        <div class="products-header">

            <h2>
                📋 Danh sách sản phẩm
            </h2>


            <span class="product-count">

                {{ count($groups) }} sản phẩm

            </span>

        </div>


        <div class="table-wrapper">

            <table>


                <thead>

                    <tr>

                        <th style="width:60px;">
                            #
                        </th>

                        <th>
                            Sản phẩm
                        </th>

                        <th style="width:100px;">
                            Số bill
                        </th>

                        <th style="width:38%;">
                            Trang
                        </th>

                        <th style="width:110px;">
                            Thao tác
                        </th>

                    </tr>

                </thead>


                <tbody>


                @forelse($groups as $product => $item)


                    <tr>


                        <!-- STT -->

                        <td>

                            <span class="stt">

                                {{ $loop->iteration }}

                            </span>

                        </td>


                        <!-- PRODUCT -->

                        <td>

                            <div class="product-name">

                                {{ $product }}

                            </div>

                        </td>


                        <!-- COUNT -->

                        <td>

                            <span class="count-badge">

                                {{ $item['count'] }}

                            </span>

                        </td>


                        <!-- PAGE -->

                        <td>

                            <div class="page-box">

                                <textarea
                                    id="page{{ $loop->index }}"
                                    readonly
                                >{{ $item['pages'] }}</textarea>

                            </div>

                        </td>


                        <!-- COPY -->

                        <td>

                            <button
                                class="copy-small"
                                onclick="
                                    copyPage(
                                        'page{{ $loop->index }}',
                                        this
                                    )
                                "
                            >

                                📋 Copy

                            </button>

                        </td>


                    </tr>


                @empty


                    <tr>

                        <td
                            colspan="5"
                            class="empty"
                        >

                            Không có sản phẩm nào.

                        </td>

                    </tr>


                @endforelse


                </tbody>


            </table>

        </div>


    </div>


    <!-- FOOTER -->

    <div class="footer">
    Powered by Phong.exe • Running on caffeine. ☕
    <br>
    <small>// Please don't Ctrl+C 😎</small>
</div>


</div>


<script>


/*
|--------------------------------------------------------------------------
| Copy toàn bộ trang
|--------------------------------------------------------------------------
*/

function copyPages()
{

    const input =
        document.getElementById(
            'pageList'
        );


    const copied =
        document.getElementById(
            'copied'
        );


    navigator.clipboard
        .writeText(input.value)

        .then(function ()
        {

            copied.innerText =
                '✓ Đã sao chép!';


            setTimeout(
                function ()
                {

                    copied.innerText = '';

                },
                2000
            );

        })

        .catch(function ()
        {

            input.select();

            document.execCommand(
                'copy'
            );

            copied.innerText =
                '✓ Đã sao chép!';


            setTimeout(
                function ()
                {

                    copied.innerText = '';

                },
                2000
            );

        });

}


/*
|--------------------------------------------------------------------------
| Copy từng nhóm sản phẩm
|--------------------------------------------------------------------------
*/

function copyPage(id, button)
{

    const textarea =
        document.getElementById(id);


    const oldText =
        button.innerHTML;


    navigator.clipboard
        .writeText(textarea.value)

        .then(function ()
        {

            button.innerHTML =
                '✓ Đã copy';


            button.style.background =
                '#dcfce7';

            button.style.color =
                '#15803d';


            setTimeout(
                function ()
                {

                    button.innerHTML =
                        oldText;

                    button.style.background =
                        '';

                    button.style.color =
                        '';

                },
                1500
            );

        });

}

</script>


</body>

</html>