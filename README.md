# LandingPage-EPTSP

Project ini merupakan landing page sederhana untuk PTSP (khususnya Pengadilan). Tujuan landing page ini adalah untuk memudahkan masyarakat untuk mengetahui layanan apa saja (khususnya layanan elektronik) yang dimiliki satker. 

Project ini dibuat menggunakan framework _Codeigniter 4_, dan untuk viewnya menggunakan free template dari BootstrapMade

## Feature

Selain fitur-fitur dasar, landing page ini juga menggunakan fitur text to speech dengen SpeechSynthesisAPI Javascript. Untuk fitur livechat nya menggunakan widget dari [tawk.to](https://www.tawk.to/). Silahkan daftar pada website tersebut, dan replace script widget tawk.to yang ada sebelum tutup body. 

## How to use?

1. Download Codeigniter 4 [disini](https://codeigniter.com/download).
2. Download repo ini kemudian timpa folder codeigniter4 yang telah didownload tadi dengan repo ini
3. Copy file env dan rename menjadi .env
4. Ubah base url menjadi
   ```html
    http://domain_anda.go.id/nama_folder_root/public/
    ```
5. Untuk development, silahkan copykan folder project ke local web server(htdocs (XAMPP), www(laragon), etc), dan rubah environment serta baseurl pada file .env menjadi
   ```html
   CI_ENVIRONMENT = development

   app.baseURL = 'http://localhost/eptsp/public/'
   ```
6. Project ini Non CMS, oleh karena itu silahkan melakukan kustomisasi pada script di folder app>Views



Feel free to contact me :

**Telegram** : @Okawiadnyana