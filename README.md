# LandingPage-EPTSP

Project ini merupakan landing page sederhana untuk PTSP (khususnya Pengadilan). Tujuan landing page ini adalah untuk memudahkan masyarakat untuk mengetahui layanan apa saja (khususnya layanan elektronik) yang dimiliki satker. 

Project ini dibuat menggunakan framework _Codeigniter 4_, dan untuk viewnya menggunakan free template dari BootstrapMade.

Demo : http://e-ptsp.pnbangli.ozavo.my.id

## Feature

Selain fitur-fitur dasar, landing page ini juga menggunakan fitur text to speech dengen SpeechSynthesisAPI Javascript. Untuk fitur livechat nya menggunakan widget dari [tawk.to](https://www.tawk.to/). Silahkan daftar pada website tersebut, dan replace script widget tawk.to yang ada sebelum tutup body. 

## How to use?

1. Instal composer [disini](https://getcomposer.org/download/). (Skip langkah ini apabila pada system operasi sudah terinstall composer)
2. Download repo ini kemudian buka terminal dan arahkan ke repo hasil download dan ketikkan
   >composer install
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