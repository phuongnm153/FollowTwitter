<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Yêu cầu

Viết một tool tự động follow twitter account bởi hashtag nhập vào với yêu cầu chi tiết như dưới đây:

- Tạo một form cho nhập vào một hashtag bất kỳ.
- Viết một batch chạy một tiếng một lần, tìm tất cả các tweet chứa hashtag trên, đồng thời xử lý follow twitter account đã đăng tweet đó. (bắt buộc)
- Xử lý hiển thị tất cả twitter account đã follow được thông qua tool này.

Chương trình bằng ngôn ngữ PHP (Framework hoặc PHP thuần) không quá 4 tiếng
## Các bước thực hiện

- Phân tích yêu cầu:
   + Tìm các keyword trong yêu cầu: twitter, hashtag, search, follow, batch chạy một tiếng một lần
   + Do thông thạo Laravel, thời gian code chỉ 4 tiếng nên sẽ tìm kiếm thư viện sẵn có thay vì đọc docs api của twitter để viết từ đầu
    + Tìm kiếm với cụm keyword: "laravel follow twitter account by hashtag"

- Thực hiện:
  + Sử dụng thư viện thujohn/twitter https://github.com/thujohn/twitter
  + Sử dụng Task Scheduling của Laravel để cronjob https://laravel.com/docs/5.4/scheduling
## Quy trình cronjob
- Trên server, ta chỉ cần thêm dong lệnh sau vào file cron
 ```
 * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
 ```
 Nó sẽ gọi đến file app/Console/Kernel.php

## Mô tả hoạt động của project

- Hashtag sẽ được save vào 1 biến trong file .env
- Mỗi lần cronjob chạy sẽ chạy vào func schedule() trong file app/Console/Kernel.php
- Các user được tìm thấy với hashtag sẽ được lưu ID vào 1 file theo đường dẫn storage/app/public/userList.json 
- Sau đó sẽ tiến hành follow danh sách ID trong file này
- Các user đã follow được sẽ được gọi thông qua api

