<?php
/**
 * Created by PhpStorm.
 * User: lorence
 * Date: 10/09/2018
 * Time: 16:19
 */
?>
<!DOCTYPE html>
<html lang="vn">
<head>
    <title>Xác Nhận Địa Chỉ Email</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">
    <style type="text/css">
        body {
            color: #333332;
        }
        .row {
            margin: auto;
        }
        img {
            width: 100px;
            height: 100px;
            margin-top: 40px;
        }
        p.title {
            font-family: 'Roboto', sans-serif;
            font-size: 24px;
            font-weight: 500;
            margin-top: 20px;
        }
        p.desc {
            font-family: 'Roboto', sans-serif;
            font-size: 18px;
            font-weight: 400;
            margin-top: 20px;
        }
        p > span {
            font-weight: 300;
        }
        hr {
            width: 20%;
        }
        a.btn {
            background-color: #479fd4;
            border-radius: 15px;
            color: white;
            padding: 10px 25px;
        }
        a.btn:hover {
            background-color: #479fd4;
            border-radius: 15px;
            padding: 10px 25px;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row" align="center">
        <img src="https://luisnguyen.com/images/level/Level03.png" alt="logo_millionaire">
        <p class="title"><span>Chào mừng đến với hệ thống của chúng tôi </span><br>EzEnglish System</p>
        <hr>
    </div>
    <div class="row" align="center">
        <p class="desc">Trước khi khám phá hệ thống EzEnglish. Vui lòng xác nhận địa chỉ email của bạn.</p>
        <p class="desc">Điều đó được xây dựng từ Effortless English, cho bạn thấy rất nhiều quy tắc để tránh học tiếng Anh theo nhiều cách không hiệu quả. Thực hiện theo phương pháp Hội thảo đào tạo tại Mỹ của Paul Gruber. Giúp bạn cải thiện phát âm như nói. Chứa rất nhiều cuộc trò chuyện và tách biệt từng cấp độ để giúp người học dễ dàng tiếp cận nó hơn.</p>
        <p class="desc">Chúng tôi sẽ gửi cho bạn email về các thay đổi, cập nhật trong EzEnglish và các thông báo khác. Chúng tôi sẽ gửi cho bạn email về các thay đổi, cập nhật trong EzEnglish và các thông báo khác. Bạn cũng có thể thiết lập nhận và không nhận thông báo trong phần cài đặt của Ứng dụng.</p>
        <p class="desc">Nếu bạn không tạo tài khoản trên EzEnglish. Vui lòng liên hệ với chúng tôi theo địa chỉ email <strong>support@luisnguyen.com</strong></p>
    </div>
    <div class="row" align="center">
        <a class="btn" href="https://ezenglish.luisnguyen.com/v1/english/mobile-app/mobile/verify/{{$verification_code}}">Xác nhận địa chỉ email</a>
    </div>
</div>

</body>
</html>