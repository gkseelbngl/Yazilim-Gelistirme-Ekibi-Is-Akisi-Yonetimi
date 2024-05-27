# Yazılım Geliştirme Ekibi İş Akışı Yönetimi

Bu proje, yazılım geliştirme ekibinizin iş akışını yönetmenize yardımcı olacak bir uygulamadır.

## Kurulum

### Gereksinimler

- [XAMPP](https://www.apachefriends.org/index.html)
- PHP 7.3 veya üzeri
- MySQL 5.7 veya üzeri

### Adım Adım Kurulum

1. **XAMPP'i İndirin ve Kurun**
   - XAMPP'i [buradan](https://www.apachefriends.org/index.html) indirin ve bilgisayarınıza kurun.

2. **Proje Dosyalarını İndirin**
   - Bu projeyi zip dosyası olarak [buradan](https://github.com/gkseelbngl/Yazilim-Gelistirme-Ekibi-Is-Akisi-Yonetimi) indirin veya Git kullanarak klonlayın:
     ```bash
     git clone https://github.com/gkseelbngl/Yazilim-Gelistirme-Ekibi-Is-Akisi-Yonetimi.git
     ```

3. **Proje Dosyalarını XAMPP'in `htdocs` Klasörüne Taşıyın**
   - İndirilen veya klonlanan proje dosyalarını XAMPP'in `htdocs` klasörüne taşıyın.
   - Örnek: `C:\xampp\htdocs\web_project2`

4. **Veritabanı Kurulumu**
   - XAMPP'i çalıştırın ve `Apache` ve `MySQL` servislerini başlatın.
   - Tarayıcınızı açın ve `http://localhost/phpmyadmin` adresine gidin.
   - Yeni bir veritabanı oluşturun:
     - Veritabanı adı: `project_db`
   - `database.sql` dosyasını phpMyAdmin kullanarak içe aktarın.
     - Sol taraftaki menüden `project_db` veritabanını seçin.
     - Üst menüdeki `İçe Aktar` sekmesine tıklayın.
     - `Dosya seç` butonuna tıklayarak proje dosyaları içindeki `database.sql` dosyasını seçin ve `Git` butonuna tıklayın.

5. **Veritabanı Bağlantı Ayarları**
   - `includes/db.php` dosyasını açın ve veritabanı bağlantı bilgilerini kontrol edin. Varsayılan ayarları kullanıyorsanız, değişiklik yapmanıza gerek yoktur:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "project_db";
     ```

6. **Projeyi Çalıştırın**
   - Tarayıcınızı açın ve `http://localhost/web_project2` adresine gidin.
   - Uygulama arayüzü karşınıza gelecektir.

### Kullanıcı Girişi ve Kayıt

- **Kayıt Olmak için:** Ana sayfada `Kayıt Ol` butonuna tıklayın ve gerekli bilgileri doldurarak kayıt olun.
- **Giriş Yapmak için:** Ana sayfada `Giriş Yap` butonuna tıklayın ve kullanıcı adı ve şifrenizle giriş yapın.

### Proje Yönetimi

- **Yeni Proje Ekleme:** `Projeleri Yönet` sayfasında `Yeni Proje Ekle` butonuna tıklayarak yeni bir proje ekleyin.
- **Proje Düzenleme ve Silme:** `Projeleri Yönet` sayfasında ilgili projenin yanında bulunan `Düzenle` ve `Sil` butonlarını kullanarak projeleri düzenleyin veya silin.

### Görev Yönetimi

- **Yeni Görev Ekleme:** `Görevleri Yönet` sayfasında `Yeni Görev Ekle` butonuna tıklayarak yeni bir görev ekleyin.
- **Görev Düzenleme ve Silme:** `Görevleri Yönet` sayfasında ilgili görevin yanında bulunan `Düzenle` ve `Sil` butonlarını kullanarak görevleri düzenleyin veya silin.

### Sorun Giderme

- **Veritabanı Bağlantı Hataları:** `includes/db.php` dosyasındaki veritabanı bağlantı ayarlarını kontrol edin.
- **Yüklenme Sorunları:** XAMPP kontrol panelinde `Apache` ve `MySQL` servislerinin çalıştığından emin olun.

## Videolu Anlatım

Bu projenin kodlarını ve nasıl çalıştığını anlatan YouTube videosu için [buraya tıklayın](https://www.youtube.com/your-video-link).

