<!doctype html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bill-Sorter-Tool</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #f5f7ff,
                    #eef2ff
                );

            color: #1f2937;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        .header h1 {
            margin: 0 0 10px;
            font-size: 34px;
            color: #111827;
        }

        .header p {
            margin: 0;
            color: #6b7280;
            font-size: 16px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);

            transition: transform .2s ease,
                        box-shadow .2s ease;
        }

        .card:hover {
            transform: translateY(-3px);

            box-shadow:
                0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            font-size: 22px;
            font-weight: bold;
        }

        .tiktok-icon {
            background: #111827;
            color: white;
        }

        .shopee-icon {
            background: #fff1f2;
            color: #ee4d2d;
        }

        .merge-icon {
            background: #eef2ff;
            color: #4f46e5;
        }

        .card h2 {
            margin: 0;
            font-size: 21px;
        }

        .description {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 22px;
        }

        .upload-box {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 15px;

            transition: border-color .2s,
                        background .2s;
        }

        .upload-box:hover {
            border-color: #6366f1;
            background: #f9fafb;
        }

        input[type="file"] {
            width: 100%;
            font-size: 14px;
        }

        .file-name {
            margin-top: 10px;
            font-size: 13px;
            color: #6b7280;
            word-break: break-all;
        }

        .btn {
            width: 100%;
            padding: 12px 18px;

            border: none;
            border-radius: 9px;

            color: white;
            font-size: 15px;
            font-weight: bold;

            cursor: pointer;

            transition: .2s;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: .92;
        }

        .btn-tiktok {
            background: #111827;
        }

        .btn-shopee {
            background: #ee4d2d;
        }

        .btn-merge {
            background: #4f46e5;
        }

        .merge-card {
            margin-top: 25px;
        }

        .merge-card .description {
            margin-bottom: 18px;
        }

        .merge-form {
            display: grid;
            grid-template-columns: 1fr 180px;
            gap: 15px;
            align-items: center;
        }

        .merge-upload {
            margin: 0;
        }

        .file-list {
            margin-top: 15px;
            display: none;
        }

        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 9px 12px;
            margin-bottom: 6px;

            background: #f9fafb;
            border-radius: 7px;

            font-size: 13px;
        }

        .file-size {
            color: #9ca3af;
            margin-left: 10px;
            white-space: nowrap;
        }

        .footer {
            text-align: center;
            margin-top: 35px;
            color: #9ca3af;
            font-size: 13px;
        }

        @media (max-width: 700px) {

            .container {
                width: 94%;
                margin: 25px auto;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .merge-form {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 28px;
            }

        }

    </style>

</head>


<body>


<div class="container">


    <!-- HEADER -->

    <div class="header">

        <h1>📦 Bill Sorter</h1>

        <p>
            Sắp xếp và xử lý bill TikTok Shop & Shopee
        </p>

    </div>


    <!-- TIKTOK + SHOPEE -->

    <div class="cards">


        <!-- TIKTOK -->

        <div class="card">

            <div class="card-header">

                <div class="icon tiktok-icon">
                    ♪
                </div>

                <h2>Bill TikTok</h2>

            </div>

            <div class="description">

                Upload file PDF bill TikTok để hệ thống
                tự động đọc và sắp xếp.

            </div>


            <form
                action="{{ route('upload') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="upload-box">

                    <input
                        type="file"
                        name="pdf"
                        accept=".pdf,application/pdf"
                        required
                        onchange="showFile(this, 'tiktok-file')"
                    >

                    <div
                        class="file-name"
                        id="tiktok-file"
                    >
                        Chưa chọn file
                    </div>

                </div>


                <button
                    type="submit"
                    class="btn btn-tiktok"
                >
                    Upload Bill TikTok
                </button>

            </form>

        </div>


        <!-- SHOPEE -->

        <div class="card">

            <div class="card-header">

                <div class="icon shopee-icon">
                    🛍
                </div>

                <h2>Bill Shopee</h2>

            </div>

            <div class="description">

                Upload file PDF bill Shopee để hệ thống
                tự động nhận diện và sắp xếp sản phẩm.

            </div>


            <form
                action="{{ route('shopee.upload') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="upload-box">

                    <input
                        type="file"
                        name="pdf"
                        accept=".pdf,application/pdf"
                        required
                        onchange="showFile(this, 'shopee-file')"
                    >

                    <div
                        class="file-name"
                        id="shopee-file"
                    >
                        Chưa chọn file
                    </div>

                </div>


                <button
                    type="submit"
                    class="btn btn-shopee"
                >
                    Upload Bill Shopee
                </button>

            </form>

        </div>


    </div>


    <!-- GHÉP PDF -->

    <div class="card merge-card">


        <div class="card-header">

            <div class="icon merge-icon">
                📄
            </div>

            <h2>Ghép nhiều file PDF</h2>

        </div>


        <div class="description">

            Có nhiều file bill TikTok hoặc Shopee?
            Chọn nhiều file cùng lúc để ghép thành một
            file PDF duy nhất.

        </div>


        <form
            action="{{ route('pdf.merge.process') }}"
            method="POST"
            enctype="multipart/form-data"
            id="mergeForm"
        >

            @csrf


            <div class="merge-form">


                <div
                    class="upload-box merge-upload"
                >

                    <input
                        type="file"
                        name="pdfs[]"
                        id="mergeFiles"
                        accept=".pdf,application/pdf"
                        multiple
                        required
                    >

                    <div
                        class="file-name"
                        id="mergeInfo"
                    >
                        Chưa chọn file
                    </div>

                </div>


                <button
                    type="submit"
                    class="btn btn-merge"
                    id="mergeButton"
                >
                    Ghép PDF
                </button>


            </div>


            <div
                class="file-list"
                id="fileList"
            ></div>


        </form>


    </div>


    <div class="footer">
    Powered by Phong.exe • Running on caffeine. ☕
    <br>
    <small>// Please don't Ctrl+C 😎</small>
</div>


</div>


<script>


/*
|--------------------------------------------------------------------------
| Hiển thị tên file TikTok / Shopee
|--------------------------------------------------------------------------
*/

function showFile(input, targetId)
{
    const target =
        document.getElementById(targetId);

    if (!input.files.length) {

        target.innerText =
            'Chưa chọn file';

        return;
    }

    const file =
        input.files[0];

    target.innerText =
        file.name +
        ' (' +
        formatSize(file.size) +
        ')';
}


/*
|--------------------------------------------------------------------------
| Ghép PDF
|--------------------------------------------------------------------------
*/

const mergeFiles =
    document.getElementById('mergeFiles');

const fileList =
    document.getElementById('fileList');

const mergeInfo =
    document.getElementById('mergeInfo');

const mergeButton =
    document.getElementById('mergeButton');


mergeFiles.addEventListener(
    'change',
    function ()
    {

        fileList.innerHTML = '';

        const files =
            Array.from(this.files);


        if (files.length === 0) {

            mergeInfo.innerText =
                'Chưa chọn file';

            fileList.style.display =
                'none';

            mergeButton.disabled =
                true;

            return;
        }


        mergeInfo.innerText =
            files.length +
            ' file PDF đã chọn';


        fileList.style.display =
            'block';


        files.forEach(
            function (file, index)
            {

                const div =
                    document.createElement('div');

                div.className =
                    'file-item';


                div.innerHTML = `

                    <span>
                        ${index + 1}.
                        ${escapeHtml(file.name)}
                    </span>

                    <span class="file-size">
                        ${formatSize(file.size)}
                    </span>

                `;


                fileList.appendChild(div);

            }
        );


        mergeButton.disabled =
            files.length < 2;

    }
);


/*
|--------------------------------------------------------------------------
| Khi submit
|--------------------------------------------------------------------------
*/

document
    .getElementById('mergeForm')
    .addEventListener(
        'submit',
        function ()
        {

            mergeButton.disabled =
                true;

            mergeButton.innerText =
                'Đang ghép...';

        }
    );


/*
|--------------------------------------------------------------------------
| Format dung lượng
|--------------------------------------------------------------------------
*/

function formatSize(bytes)
{

    if (bytes < 1024)
        return bytes + ' B';

    if (bytes < 1024 * 1024)
        return (bytes / 1024).toFixed(1) + ' KB';

    return (
        bytes / 1024 / 1024
    ).toFixed(2) + ' MB';

}


/*
|--------------------------------------------------------------------------
| Escape tên file
|--------------------------------------------------------------------------
*/

function escapeHtml(text)
{

    const div =
        document.createElement('div');

    div.textContent =
        text;

    return div.innerHTML;

}

</script>


</body>

</html>