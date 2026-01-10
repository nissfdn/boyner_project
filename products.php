<?php
session_start();
include "Config.php";

// WHERE şartlarını tutacak dizimiz
$where = [];

// --- 1. CİNSİYET (DÜZELTİLDİ) ---
// Artık checkbox kullandığımız için burası da dizi mantığıyla (IN) çalışmalı
if (!empty($_GET['gender'])) {
    // Güvenlik: Gelen veri dizi mi kontrol et, değilse diziye çevir
    $gelen_gender = is_array($_GET['gender']) ? $_GET['gender'] : [$_GET['gender']];
    
    // Her seçeneği temizle ve tırnak içine al
    $cinsiyetler = array_map(fn($g) => "'" . $mysqli->real_escape_string($g) . "'", $gelen_gender);
    
    // SQL'e ekle: gender IN ('Erkek Cocuk', 'Kiz Cocuk')
    $where[] = "gender IN (" . implode(",", $cinsiyetler) . ")";
}

// --- 2. MARKA ---
if (!empty($_GET['brand'])) {
    
    $brands = array_map(fn($b)=>"'".$mysqli->real_escape_string($b)."'", $_GET['brand']);
    $where[] = "brand IN (".implode(",", $brands).")";
}

// --- 3. KATEGORİ ---
if (!empty($_GET['category'])) {
    $cats = array_map(fn($c)=>"'".$mysqli->real_escape_string($c)."'", $_GET['category']);
    $where[] = "category IN (".implode(",", $cats).")";
}


// --- 4. FİYAT ---
if (!empty($_GET['min_price']) && !empty($_GET['max_price'])) {
    // Sayı olduklarından emin olmak için (int) eklemek iyi olur
    $min = (int)$_GET['min_price'];
    $max = (int)$_GET['max_price'];
    $where[] = "price BETWEEN $min AND $max";
}

// --- SORGUE OLUŞTURMA ---
$sql = "SELECT * FROM products";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY id DESC";

// --- SORGUE ÇALIŞTIRMA ---
$result = $mysqli->query($sql);

if (!$result) {
    die("Sorgu Hatası: " . $mysqli->error);
}

// Verileri çek
$products = $result->fetch_all(MYSQLI_ASSOC);
$total_products = $result->num_rows; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/boyner.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="navbar">
        <div class="container">
        <div class="topnav">
          <img src="https://boyner-stook-frontend.mncdn.com/web-ui/logo.svg" alt="logo">
          
          <div class="searchbar">
            <div>O</div>
            <input type="text" name="search" id="search" placeholder="Hadi gel aradığını hızlıca bulalım...">
          </div>
          
          <ul>
            <?php if (isset($_SESSION['username'])): ?>
        
        <a href="logout.php" title="Çıkış Yap">
            <i class="fa-solid fa-right-from-bracket" style="color: red;"></i>
        </a>
        
    <?php else: ?>
        
        <a href="#" onclick="document.getElementById('id01').style.display='block'" title="Giriş Yap">
            <i class="fa-regular fa-user"></i>
        </a>

    <?php endif; ?>
            <li ><i class="far fa-heart ince-yap"></i></li>
            <li><a href="summary.php">
    <li><i class="fas fa-shopping-bag"></i></li>
          </ul>
        </div>
        <div class="bottomnav">
          <a href="#">KADIN</a>
          <a href="#">ERKEK</a>
          <a href="#">AYAKKABI & ÇANTA</a>
          <a href="#">KOZMETİK</a>
          <a href="#">SAAT & AKSESUAR</a>
          <a href="#">SPOR & OUTDOOR</a>
          <a href="#">ÇOCUK</a>
          <a href="#">EV & YAŞAM & ELEKTRONİK</a>
          <a href="#" id="campains">KAMPANYALAR</a>
          <a href="#">HEDİYE</a>
          <a href="#">OUTLET</a>
          <a href="#">MARKALAR</a>
        </div>
      </div>
    </div>

   

    <div class="webView">
      <section class="layout_layout__7aKW_">
          <div class="container">
              <nav aria-label="breadcrumb" class="b-breadcrumb b-large layout_layoutBreadcrumbs__VnTCB" data-part="b-breadcrumb">
                  <ol class="b-breadcrumb__list">
                      <li class="b-breadcrumb__item b-breadcrumb__item--large" data-part="b-breadcrumb__item"><a class="b-breadcrumb__item-link" style="text-decoration:none" href=""><p class="b-typography b-typography--p14">Anasayfa</p></a></li>
                      <li class="b-breadcrumb__item b-breadcrumb__item--large" data-part="b-breadcrumb__item"><a class="b-breadcrumb__item-link" style="text-decoration:none" href="index.html"><p class="b-typography b-typography--p14">Çocuk</p></a></li>
                      <li class="b-breadcrumb__item b-breadcrumb__item--large" data-part="b-breadcrumb__item"><span class="b-breadcrumb__item-active"><p class="b-typography b-typography--p14">Çocuk Üst Giyim</p></span></li>
                  </ol>
              </nav>
              <div class="content">
                <!-- Filtreler -->
                
                <div class="filter_filtersContainer__spTgr">
    <form action="" method="GET" id="filtreFormu">

        <div class="b-scrollbar b-scrollbar--vertical b-scrollbar--small b-scrollbar--scrolling-hide filter_filtersContainerScrollbar__uOXKt">
            <div class="b-scrollbar__content">
                <div class="b-accordion b-accordion--transparent b-accordion--large">

                    <div class="b-panel b-panel--expanded b-panel--size-large">
                        <div class="b-panel__b-panel-header">
                            <div class="b-panel__b-panel-header__title">
                                <h2 class="b-typography b-typography--h4"><span>Cinsiyet</span></h2>
                            </div>
                            <i class="b-icon b-icon--minus-medium"></i>
                        </div>
                        <div class="b-panel__b-panel-content b-panel__b-panel-content--expanded">
                            <div class="b-panel__b-panel-content__inner">
                                <div class="b-scrollbar b-scrollbar--vertical b-scrollbar--small b-scrollbar--scrolling-hide">
                                    <div class="b-scrollbar__content">
                                        <label class="b-typography b-typography--p14 b-checkbox b-checkbox--large b-checkbox--align-center b-checkbox--filled">
                                            <input type="checkbox" name="gender[]" value="Erkek Cocuk" class="b-checkbox__input"
                                                <?= (isset($_GET['gender']) && is_array($_GET['gender']) && in_array("Erkek Cocuk", $_GET['gender'])) ? 'checked' : '' ?> />
                                            <div class="b-checkbox__box"><i class="b-icon b-icon--checkmark-medium b-checkbox__box__icon"></i></div>
                                            <div class="b-checkbox__label"><span>Erkek Çocuk</span></div>
                                        </label>
                                        
                                        <label class="b-typography b-typography--p14 b-checkbox b-checkbox--large b-checkbox--align-center b-checkbox--filled">
                                            <input type="checkbox" name="gender[]" value="Kiz Cocuk" class="b-checkbox__input"
                                                <?= (isset($_GET['gender']) && is_array($_GET['gender']) && in_array("Kiz Cocuk", $_GET['gender'])) ? 'checked' : '' ?> />
                                            <div class="b-checkbox__box"><i class="b-icon b-icon--checkmark-medium b-checkbox__box__icon"></i></div>
                                            <div class="b-checkbox__label"><span>Kız Çocuk</span></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="b-panel b-panel--expanded b-panel--size-large">
                        <div class="b-panel__b-panel-header">
                            <div class="b-panel__b-panel-header__title">
                                <h2 class="b-typography b-typography--h4"><span>Marka</span></h2>
                            </div>
                            <i class="b-icon b-icon--minus-medium"></i>
                        </div>
                        <div class="b-panel__b-panel-content b-panel__b-panel-content--expanded">
                            <div class="b-panel__b-panel-content__inner">
                                <div class="b-search-input b-search-input--small filter_filterItemsInput__OA7zw">
                                    <div class="b-search-input__wrapper"><input type="text" placeholder="Marka Ara" /></div>
                                </div>
                                <div class="b-scrollbar b-scrollbar--vertical b-scrollbar--small b-scrollbar--scrolling-hide filter_filterItemsCheckboxs__NPrqw">
                                    <div class="b-scrollbar__content">
                                        <?php 
                                        //manuel eklendi
                                        $markalar = ["U.S. Polo Assn.", "Gap", "Nike", "Mavi", "Barbie", "Jeep", "United Colors of Benetton", "Calvin Klein", "Mayoral", "Puma"];
                                        foreach($markalar as $marka): 
                                        ?>
                                        <label class="b-typography b-typography--p14 b-checkbox b-checkbox--large b-checkbox--align-center b-checkbox--filled filter_filterItemsCheckbox__iQpwl">
                                            <input type="checkbox" name="brand[]" value="<?= $marka ?>" class="b-checkbox__input"
                                                <?= (isset($_GET['brand']) && is_array($_GET['brand']) && in_array($marka, $_GET['brand'])) ? 'checked' : '' ?> />
                                            <div class="b-checkbox__box"><i class="b-icon b-icon--checkmark-medium b-checkbox__box__icon"></i></div>
                                            <div class="b-checkbox__label"><span><?= $marka ?></span></div>
                                        </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="b-panel b-panel--size-large">
                        <div class="b-panel__b-panel-header">
                            <div class="b-panel__b-panel-header__title">
                                <h2 class="b-typography b-typography--h4"><span>Ürün Çeşidi</span></h2>
                            </div>
                            <i class="b-icon b-icon--plus-bold"></i>
                        </div>
                        <div class="b-panel__b-panel-content">
                            <div class="b-panel__b-panel-content__inner">
                                <div class="b-scrollbar__content">
                                    <label class="b-typography b-typography--p14 b-checkbox filter_filterItemsCheckbox__iQpwl">
                                        <input type="checkbox" name="category[]" value="Sweatshirt" class="b-checkbox__input" <?= (isset($_GET['category']) && in_array("Sweatshirt", $_GET['category']??[]))?'checked':'' ?> />
                                        <div class="b-checkbox__box"><i class="b-icon b-icon--checkmark-medium b-checkbox__box__icon"></i></div>
                                        <div class="b-checkbox__label"><span>Sweatshirt</span></div>
                                    </label>
                                    </div>
                            </div>
                        </div>
                    </div>
                                    
                    

                    <div class="b-panel b-panel--size-large">
                        <div class="b-panel__b-panel-header">
                            <div class="b-panel__b-panel-header__title">
                                <h2 class="b-typography b-typography--h4"><span>Fiyat</span></h2>
                            </div>
                            <i class="b-icon b-icon--plus-bold"></i>
                        </div>
                        <div class="b-panel__b-panel-content">
                            <div class="b-panel__b-panel-content__inner">
                                <div class="b-range b-range--size-small" style="display: flex; gap: 10px; align-items: center;">
                                    <input type="number" name="min_price" placeholder="Min" value="<?= $_GET['min_price'] ?? '' ?>" style="width: 100%; padding: 5px; border: 1px solid #ccc;" />
                                    <span>-</span>
                                    <input type="number" name="max_price" placeholder="Max" value="<?= $_GET['max_price'] ?? '' ?>" style="width: 100%; padding: 5px; border: 1px solid #ccc;" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div> </div>
        </div>

        <div style="padding: 20px 0; display: flex; flex-direction: column; gap: 10px;">
            <button type="submit" style="background-color: #000; color: #fff; border: 1px solid #000; padding: 12px; font-weight: bold; cursor: pointer; width: 100%;">
                FİLTRELE
            </button>

            <button type="button" onclick="window.location.href=window.location.pathname" style="background-color: #fff; color: #000; border: 1px solid #ddd; padding: 12px; font-weight: bold; cursor: pointer; width: 100%;">
                SEÇİMLERİ TEMİZLE
            </button>
        </div>

    </form>
</div>
              

<!--urun listeleri-->

                  
                  <div class="b-grid b-grid--col b-grid--col-10">
                      <div class="head_headTitle__nWJBh">
                          <div class="head_headTitleText__JUQz_">
                              <h1 class="b-typography b-typography--h1">Çocuk Üst Giyim Modelleri</h1>
                              <p class="b-typography b-typography--p16 head_headTitleCount__E8gfq"><?= $total_products ?> ürün listeleniyor</p>

                          </div>
                      </div>
                      <div class="head_headItem__2mnPO"><div class=""><div class="b-carousel b-carousel--scroll"><div class="b-carousel__wrapper"><div class="scroll_slider" style="min-width:auto;width:100%"><div class="scroll_slider__wrapper"><div class="scroll_slider__wrapper__outer"><ul class="scroll_slider__wrapper__slides" style="display: flex; flex-direction: row; list-style-type: none; margin: 0px; padding: 0px; transition-duration: 500ms; transform: translate(0px);"><li style="padding-right:3px;padding-left:0px"><div class="b-carousel__item quick-filter_quickFilterItem__uWZH8 quick-filter_quickFilterItemFirst__Hvwqw"><a style="text-decoration:none" href="/cocuk-ust-giyim-x-c23896247?cinsiyet=erkek-cocuk"><h2 class="b-typography b-typography--h6">Erkek Çocuk</h2></a></div></li><li style="padding-right:3px;padding-left:3px"><div class="b-carousel__item quick-filter_quickFilterItem__uWZH8"><a style="text-decoration:none" href="/cocuk-ust-giyim-x-c23896247?cinsiyet=kiz-cocuk"><h2 class="b-typography b-typography--h6">Kız Çocuk</h2></a></div></li><li style="padding-right:3px;padding-left:3px"><div class="b-carousel__item quick-filter_quickFilterItem__uWZH8"><a style="text-decoration:none" href="/cocuk-ust-giyim-x-c23896247?cinsiyet=erkek-bebek"><h2 class="b-typography b-typography--h6">Erkek Bebek</h2></a></div></li><li style="padding-right:3px;padding-left:3px"><div class="b-carousel__item quick-filter_quickFilterItem__uWZH8"><a style="text-decoration:none" href="/cocuk-ust-giyim-x-c23896247?cinsiyet=kiz-bebek"><h2 class="b-typography b-typography--h6">Kız Bebek</h2></a></div></li><li style="padding-right:3px;padding-left:3px"><div class="b-carousel__item quick-filter_quickFilterItem__uWZH8"><a style="text-decoration:none" href="/cocuk-ust-giyim-x-c23896247?cinsiyet=unisex-bebek"><h2 class="b-typography b-typography--h6">Unisex Bebek</h2></a></div></li><li style="padding-right:3px;padding-left:3px"><div class="b-carousel__item quick-filter_quickFilterItem__uWZH8"><a style="text-decoration:none" href="/cocuk-ust-giyim-x-c23896247?cinsiyet=unisex-cocuk"><h2 class="b-typography b-typography--h6">Unisex Çocuk</h2></a></div></li><li style="padding-right:0px;padding-left:3px"><div class="b-carousel__item quick-filter_quickFilterItem__uWZH8"><a style="text-decoration:none" href="/cocuk-ust-giyim-x-c23896247?cinsiyet=erkek"><h2 class="b-typography b-typography--h6">Erkek</h2></a></div></li></ul></div></div></div></div></div></div></div>
                      <section class="styles_products__6uQxI" style="margin-left: 5px;margin-right: 5px;">
                          <div class="b-grid b-grid--row">
                            
                            <?php foreach ($products as $product): ?>
  <div class="product-container">
    <a href="shopping.php?id=<?= $product['id'] ?>">
      <div class="product-incontent">
        <div class="product-image">
          <img src="/boyner_project/images/<?= rawurlencode($product['image']) ?>" style="width:100%">

        </div>
        <div class="product-info">
          <p>
            <strong><?= $product['brand'] ?></strong>
            <?= $product['name'] ?>
          </p>
          <p>
            <strong><?= number_format($product['price'], 0, ',', '.') ?> TL</strong>
          </p>
          <p style="margin: 15px 0; font-size: 14px;">Kargo bedava</p>
        </div>
      </div>
    </a>
  </div>
<?php endforeach; ?>

                            
                          </div>
                      </section>
                  </div>
                  </div>
              </div>
          </div>
      </section>
  </div>
  <div class="footer">
    <div class="container">
      <div class="links">
        <h2>Popüler Aramalar</h2>
        <div class="cloud_links"><a target="_self" class="cloud-links_col__QUy9m" href="/nike-x-b4">Nike</a><a target="_self" class="cloud-links_col__QUy9m" href="/adidas-x-b3">Adidas</a><a target="_self" class="cloud-links_col__QUy9m" href="/skechers-x-b545">Skechers</a><a target="_self" class="cloud-links_col__QUy9m" href="/tommy-hilfiger-x-b543">Tommy Hilfiger</a><a target="_self" class="cloud-links_col__QUy9m" href="/discovery-expedition-x-b12156">Discovery Expedition</a><a target="_self" class="cloud-links_col__QUy9m" href="/f-by-fabrika-x-b223">F By Fabrika</a><a target="_self" class="cloud-links_col__QUy9m" href="/calvin-klein-jeans-x-b559">Calvin Klein Jeans</a><a target="_self" class="cloud-links_col__QUy9m" href="/tommy-jeans-x-b560">Tommy Jeans</a><a target="_self" class="cloud-links_col__QUy9m" href="/levis-x-b554">Levis</a><a target="_self" class="cloud-links_col__QUy9m" href="/puma-x-b5">Puma</a><a target="_self" class="cloud-links_col__QUy9m" href="/fabrika-x-b201">Fabrika</a><a target="_self" class="cloud-links_col__QUy9m" href="/sandalet-x-c1711">Çocuk Sandalet</a><a target="_self" class="cloud-links_col__QUy9m" href="/kampanya/ilkokul-ayakkabisi-x-c23896343">İlkokul Ayakkabısı</a><a target="_self" class="cloud-links_col__QUy9m" href="/kres-ayakkabilari-x-c12135192">Kreş Ayakkabıları</a><a target="_self" class="cloud-links_col__QUy9m" href="/yagmur-botu-x-c2767">Yağmur Botu</a><a target="_self" class="cloud-links_col__QUy9m" href="/cocuk-esofman-x-c300109">Eşofman</a><a target="_self" class="cloud-links_col__QUy9m" href="/mama-onlugu-x-c1602">Mama Önlüğü</a><a target="_self" class="cloud-links_col__QUy9m" href="/bebek-arabasi-x-c1793">Bebek Arabası</a></div>
      </div>
      <div class="world">
        <p>Çocuk modası, en az yetişkin giyim trendleri kadar çeşitli ve çarpıcı. Geçmişte çocuk giysileri benzer tasarımlara sahipken günümüzde çok farklı stiller çocuk modasının akışını tamamen değiştirdi. Renkli, spor, salaş ya da ilgi çekici; çocuklar için aradığınız stil nesneleri yüzlerce giyim, aksesuar, ayakkabı ve çanta seçenekleri ile Boyner’de! Çocuğunuzun ihtiyacına ve sevdiği tarza göre çocuk kategorilerini gezerek alışverişinizi tamamlayabilirsiniz. <br><br> Boyner’in çocuk kategorisinde yenidoğan bebek grubundan 14 yaşa kadar tüm yaş gruplarına özel çocuk giyim ve ayakkabı ihtiyaçlarını bulabilirsiniz. Çocuk giyiminde yer alan ürünler kız çocuk, erkek çocuk, kız bebek ve erkek bebek olmak üzere kendi içinde dört farklı kategoriye ayrılıyor. Bu kategoriler de kendi içlerinde bölümlere ayrılarak çocuğunuzun tüm ihtiyaçlarını karşılayabileceğiniz ürünlere ulaşmanızı sağlıyor. Bebek giyim kategorisinde salopet ve tulumlar, body ve t-shirt’ler, elbise, etek ve pantolonlar yelek ve süveter gibi bebeklerin ihtiyacı olan ürünler yer alıyor. Kız çocuğu ve erkek çocuğu giyim kategorisinde ise yine türlerine göre yüzlerce parça bulunuyor.</p>
      </div>
      <div class="marquee_marquee__BZMM1 footer-slider_footerSlider__iKZ_E"><div class="rfm-marquee-container " style="--pause-on-hover: paused; --pause-on-click: paused; --width: 100%; --transform: none;"><div class="rfm-marquee" style="--play: running; --direction: normal; --duration: 18.07265625s; --delay: 0s; --iteration-count: infinite; --min-width: auto;"><div class="rfm-initial-child-container"><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--receive-package-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">Kolay İade</h6></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--delivery2-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">1.999TL+ Alışverişlerinizde Ücretsiz Kargo</h6></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--creditcard-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">Tüm Kartlar İçin Taksitli Ödeme</h6></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--store-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">BOYNER Ürünlerinde Mağazada Değişim &amp; İade </h6></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><img alt="Online Öde, Mağazadan Teslim Al" loading="lazy" width="20" height="20" decoding="async" data-nimg="1" class="footer-slider_footerSliderItemIcon___V2N7" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2023/03/tikla-gel.png" style="color: transparent;"><h6 class="b-typography b-typography--h6">Online Öde, Mağazadan Teslim Al</h6><button class="b-button b-button--base b-button--medium b-button--text-style-heading footer-slider_footerSliderItemInfo__0NryY" type="button" aria-disabled="false" aria-busy="false"><i class="b-icon b-icon--info-light b-button__icon" style="font-size: 14px;"></i></button></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--quality-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">%100 Orijinal Ürün Garantisi</h6></div></div></div></div><div class="rfm-marquee" style="--play: running; --direction: normal; --duration: 18.07265625s; --delay: 0s; --iteration-count: infinite; --min-width: auto;"><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--receive-package-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">Kolay İade</h6></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--delivery2-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">1.999TL+ Alışverişlerinizde Ücretsiz Kargo</h6></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--creditcard-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">Tüm Kartlar İçin Taksitli Ödeme</h6></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--store-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">BOYNER Ürünlerinde Mağazada Değişim &amp; İade </h6></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><img alt="Online Öde, Mağazadan Teslim Al" loading="lazy" width="20" height="20" decoding="async" data-nimg="1" class="footer-slider_footerSliderItemIcon___V2N7" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2023/03/tikla-gel.png" style="color: transparent;"><h6 class="b-typography b-typography--h6">Online Öde, Mağazadan Teslim Al</h6><button class="b-button b-button--base b-button--medium b-button--text-style-heading footer-slider_footerSliderItemInfo__0NryY" type="button" aria-disabled="false" aria-busy="false"><i class="b-icon b-icon--info-light b-button__icon" style="font-size: 14px;"></i></button></div></div><div class="rfm-child" style="--transform: none;"><div class="footer-slider_footerSliderItem__2i_Sh"><i class="b-icon b-icon--quality-light footer-slider_footerSliderItemIcon___V2N7" style="font-size: 20px;"></i><h6 class="b-typography b-typography--h6">%100 Orijinal Ürün Garantisi</h6></div></div></div></div></div>
      <div class="footer-menus_footerMenu__gK6yj"><div class="b-grid b-grid--container"><div class="b-grid b-grid--row"><div class="b-grid b-grid--col b-grid--col-2 footer-menus_footerMenuItem__MyKdF"><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildTitle__fIHs1"><a style="text-decoration:none" href="/#"><h5 class="b-typography b-typography--h5">BOYNER</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a href="https://kurumsal.boyner.com.tr/satis" style="text-decoration:none"><p class="b-typography b-typography--p16">Kurumsal</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a href="https://kurumsal.boyner.com.tr/magazalarimiz" style="text-decoration:none"><p class="b-typography b-typography--p16">Mağazalar</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/content/servisler"><p class="b-typography b-typography--p16">Keşfet</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/content/magazaetkinlikleri"><p class="b-typography b-typography--p16">Mağaza Etkinlikleri</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a href="https://kurumsal.boyner.com.tr/toplum-cevre-insan" style="text-decoration:none"><p class="b-typography b-typography--p16">Sosyal Sorumluluk</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a href="https://kurumsal.boyner.com.tr/kariyer-firsatlari" style="text-decoration:none"><p class="b-typography b-typography--p16">Kariyer</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a href="https://kurumsal.boyner.com.tr/satis" style="text-decoration:none"><p class="b-typography b-typography--p16">Kurumsal Satış</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a href="https://kurumsal.boyner.com.tr/toplu-satis" style="text-decoration:none"><p class="b-typography b-typography--p16">Toplu Satış</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/satici"><p class="b-typography b-typography--p16">Satıcılar</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/content/bilgi-guvenligi-politikasi"><p class="b-typography b-typography--p16">Bilgi Güvenliği Politikası</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_"><a target="_blank" href="https://www.eticaret.gov.tr/siteprofil/C9BAB77ED30C4E8DBAB25E1F61E4DBE2/wwwboynercomtr" style="text-decoration:none" rel="noopener noreferrer"><span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%"><span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%"><img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%2772%27%20height=%2785%27/%3e"></span><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/etbis.png" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/etbis.png" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain"><noscript><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/etbis.png" loading="lazy" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/etbis.png"/></noscript></span></a></div><div class="footer-menus_footerMenuItemChild__XB_b_"><a target="_self" href="https://www.guvendamgasi.org.tr/view/uye/detay.php?Guid=f08c83c3-1416-11ef-badd-48df373f4850" style="text-decoration:none"><span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%"><span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%"><img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%2772%27%20height=%2772%27/%3e"></span><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/10/logo_1728900969.png" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/10/logo_1728900969.png" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain"><noscript><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/10/logo_1728900969.png" loading="lazy" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/10/logo_1728900969.png"/></noscript></span></a></div></div><div class="b-grid b-grid--col b-grid--col-2 footer-menus_footerMenuItem__MyKdF"><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildTitle__fIHs1"><a style="text-decoration:none" href="/#"><h5 class="b-typography b-typography--h5">KATEGORİLER</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kadin-x-c1"><p class="b-typography b-typography--p16">Kadın</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/erkek-x-c2"><p class="b-typography b-typography--p16">Erkek</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/cocuk-x-c3"><p class="b-typography b-typography--p16">Çocuk</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/spor-giyim-x-c5"><p class="b-typography b-typography--p16">Spor &amp; Outdoor</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kozmetik-x-c4"><p class="b-typography b-typography--p16">Kozmetik</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/ev-x-c6"><p class="b-typography b-typography--p16">Ev &amp; Yaşam &amp; Elektronik</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/erkek-ayakkabi-x-c20000111"><p class="b-typography b-typography--p16">Erkek Ayakkabı</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/erkek-parfum-x-c20050598"><p class="b-typography b-typography--p16">Erkek Parfüm</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/ayakkabi-x-c43235"><p class="b-typography b-typography--p16">Çocuk Ayakkabı</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kadin-parfum-x-c20050594"><p class="b-typography b-typography--p16">Kadın Parfüm</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kadin-canta-x-c1005"><p class="b-typography b-typography--p16">Kadın Çanta</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kadin-kosuantrenman-ayakkabisi-x-c3392730"><p class="b-typography b-typography--p16">Kadın Spor Ayakkabı</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/ayakkabi-canta-x-c343"><p class="b-typography b-typography--p16">Ayakkabı &amp; Çanta</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kadin-topuklu-ayakkabi-x-c20000256"><p class="b-typography b-typography--p16">Kadın Topuklu Ayakkabı</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/erkek-pantolon-x-c20000257"><p class="b-typography b-typography--p16">Erkek Pantolon</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/erkek-sneaker-x-c200402"><p class="b-typography b-typography--p16">Erkek Spor Ayakkabı</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/cocuk-sneaker-x-c19144851"><p class="b-typography b-typography--p16">Çocuk Spor Ayakkabı</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/erkek-mont-x-g3730-c23896554"><p class="b-typography b-typography--p16">Erkek Mont</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kadin-mont-x-g3731-c23896554"><p class="b-typography b-typography--p16">Kadın Mont</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/mont-x-c23896253"><p class="b-typography b-typography--p16">Çocuk Mont</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kadin-bot-x-g3731-c2763"><p class="b-typography b-typography--p16">Kadın Bot</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/bot-x-c1626"><p class="b-typography b-typography--p16">Çocuk Bot</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/trenckot-x-c23896565"><p class="b-typography b-typography--p16">Trençkot</p></a></div></div><div class="b-grid b-grid--col b-grid--col-2 footer-menus_footerMenuItem__MyKdF"><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildTitle__fIHs1"><a style="text-decoration:none" href="/#"><h5 class="b-typography b-typography--h5">MARKALAR</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/adidas-x-b3"><p class="b-typography b-typography--p16">Adidas</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/tommy-hilfiger-x-b543"><p class="b-typography b-typography--p16">Tommy Hilfiger</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/skechers-x-b545"><p class="b-typography b-typography--p16">Skechers</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/calvin-klein-jeans-x-b559"><p class="b-typography b-typography--p16">Calvin Klein</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/nike-x-b4"><p class="b-typography b-typography--p16">Nike</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/fabrika-x-b201"><p class="b-typography b-typography--p16">Fabrika</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/new-balance-x-b744"><p class="b-typography b-typography--p16">New Balance</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/converse-x-b772"><p class="b-typography b-typography--p16">Converse</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/guess-x-b202"><p class="b-typography b-typography--p16">Guess</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/helly-hansen-x-b595"><p class="b-typography b-typography--p16">Helly Hansen</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/asics-x-b621"><p class="b-typography b-typography--p16">Asics</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/puma-x-b5"><p class="b-typography b-typography--p16">Puma</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/vans-x-b6"><p class="b-typography b-typography--p16">Vans</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/mavi-x-b426"><p class="b-typography b-typography--p16">Mavi</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/ugg-x-b592"><p class="b-typography b-typography--p16">Ugg</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/harley-davidson-x-b642"><p class="b-typography b-typography--p16">Harley Davidson</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/caterpillar-x-b679"><p class="b-typography b-typography--p16">Caterpillar</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/markalar"><p class="b-typography b-typography--p16">Tüm Markalar</p></a></div></div><div class="b-grid b-grid--col b-grid--col-2 footer-menus_footerMenuItem__MyKdF"><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildTitle__fIHs1"><a style="text-decoration:none" href="/#"><h5 class="b-typography b-typography--h5">ÖZEL SAYFALAR</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kampanya/yilbasi-hediyeleri-x-c23894636"><p class="b-typography b-typography--p16">Yılbaşı</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kampanya/kelebek-indirimleri-x-c3548576"><p class="b-typography b-typography--p16">Kelebek</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kampanya/olay-kasim-x-c23897089"><p class="b-typography b-typography--p16">Black Friday</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kampanya/babalar-gunu-x-c3340256"><p class="b-typography b-typography--p16">Babalar Günü</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/sevgililer-gunu-x-c3391200"><p class="b-typography b-typography--p16">Sevgililer Günü</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/content/boyner-now"><p class="b-typography b-typography--p16">Boyner NOW</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/outlet-x-c3357225"><p class="b-typography b-typography--p16">Outlet</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/anneler-gunu-hediyeleri-x-c3340254"><p class="b-typography b-typography--p16">Anneler Günü</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kampanya/11-11-kasim-indirimleri-x-c19144056"><p class="b-typography b-typography--p16">11.11</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kampanya/okula-donus-x-c3546416"><p class="b-typography b-typography--p16">Okula Dönüş</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/hediye-x-c7"><p class="b-typography b-typography--p16">Hediye Önerileri</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/ogretmene-hediye-x-c19143694"><p class="b-typography b-typography--p16">Öğretmenler Günü</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/dogum-gunu-x-c12723618"><p class="b-typography b-typography--p16">Doğum Günü</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/ev-hediyesi-x-c12723614"><p class="b-typography b-typography--p16">Ev Hediyeleri</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/abiye-elbise-x-c7749783"><p class="b-typography b-typography--p16">Düğün &amp; Abiye Elbise</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kampanya/kargo-bedava-firsati-x-c23894431"><p class="b-typography b-typography--p16">Kargo Bedava</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/kis-parfumleri-x-c19144337"><p class="b-typography b-typography--p16">Kış Parfümleri</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildLinkTitle__8D1lz"><a style="text-decoration:none" href="/hediye-karti-x-c20036872"><h5 class="b-typography b-typography--h5">Hediye Kartları</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildLinkTitle__8D1lz"><a target="_blank" style="text-decoration:none" rel="noopener noreferrer" href="/mag"><h5 class="b-typography b-typography--h5">BOYNER MAG</h5></a></div></div><div class="b-grid b-grid--col b-grid--col-2 footer-menus_footerMenuItem__MyKdF"><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildTitle__fIHs1"><a style="text-decoration:none" href="/#"><h5 class="b-typography b-typography--h5">YARDIM</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/help"><p class="b-typography b-typography--p16">Bize Ulaşın</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/content/sikca-sorulan-sorular"><p class="b-typography b-typography--p16">İşlem Rehberi Ve Sıkça Sorulan Sorular</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/content/sikca-sorulan-sorular"><p class="b-typography b-typography--p16">Müşteri Hizmetleri</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildMenu__v_Qoz"><a style="text-decoration:none" href="/content/kampanya"><p class="b-typography b-typography--p16">Kampanyalar</p></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildLinkTitle__8D1lz"><a href="tel:4442967"><h5 class="b-typography b-typography--h5">444 29 67</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildLinkTitle__8D1lz"><a href="tel:08508002967"><h5 class="b-typography b-typography--h5">0850 800 29 67</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_"><div class="footer-menus_footerMenuItemChildEmpty__UfOwx"></div></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildLinkTitle__8D1lz"><a style="text-decoration:none" href="/content/kolay-iade"><h5 class="b-typography b-typography--h5">KOLAY İADE</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildLinkTitle__8D1lz"><a style="text-decoration:none" href="/customer/myorders"><h5 class="b-typography b-typography--h5">Sipariş Takibi</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildSocialMedia__dR1FH"><a target="_blank" href="https://www.facebook.com/boyneronline/" style="text-decoration:none" rel="noopener noreferrer"><i class="b-icon b-icon--facebook" style="font-size:24px"></i></a><a target="_blank" href="https://www.instagram.com/boyner/" style="text-decoration:none" rel="noopener noreferrer"><i class="b-icon b-icon--instagram" style="font-size:24px"></i></a><a target="_blank" href="https://www.youtube.com/user/BoynerMagazalari" style="text-decoration:none" rel="noopener noreferrer"><i class="b-icon b-icon--youtube-full" style="font-size:24px"></i></a><a target="_blank" href="https://twitter.com/boyneronline" style="text-decoration:none" rel="noopener noreferrer"><i class="b-icon b-icon--x-light" style="font-size:24px"></i></a></div></div><div class="b-grid b-grid--col b-grid--col-2 footer-menus_footerMenuItem__MyKdF"><div class="footer-menus_footerMenuItemChild__XB_b_ footer-menus_footerMenuItemChildTitle__fIHs1"><a style="text-decoration:none" href="/#"><h5 class="b-typography b-typography--h5">Mobil Uygulamalar</h5></a></div><div class="footer-menus_footerMenuItemChild__XB_b_"><a target="_blank" href="https://apps.apple.com/tr/app/boyner-online-al%C4%B1%C5%9Fveri%C5%9F/id610957461?l=tr" style="text-decoration:none" rel="noopener noreferrer"><span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%"><span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%"><img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%27121%27%20height=%2732%27/%3e"></span><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/appstore.png" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/appstore.png" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain"><noscript><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/appstore.png" loading="lazy" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/appstore.png"/></noscript></span></a></div><div class="footer-menus_footerMenuItemChild__XB_b_"><a target="_blank" href="https://play.google.com/store/apps/details?id=com.mobisoft.boyner&amp;hl=tr&amp;gl=US" style="text-decoration:none" rel="noopener noreferrer"><span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%"><span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%"><img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%27109%27%20height=%2732%27/%3e"></span><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/google-play.png" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/google-play.png" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain"><noscript><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/google-play.png" loading="lazy" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/google-play.png"/></noscript></span></a></div><div class="footer-menus_footerMenuItemChild__XB_b_"><a target="_blank" href="https://appgallery.huawei.com/app/C101710693" style="text-decoration:none" rel="noopener noreferrer"><span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%"><span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%"><img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%2793%27%20height=%2734%27/%3e"></span><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/app-gallery.png" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/app-gallery.png" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain"><noscript><img alt="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/app-gallery.png" loading="lazy" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/app-gallery.png"/></noscript></span></a></div></div></div></div></div>

      <div class="footer-bottom_footerBottom__fpW9_"><div class="b-grid b-grid--container footer-bottom_footerBottomContainerWrapper__N3tx5"><div class="b-grid b-grid--row b-grid--nogutter footer-bottom_footerBottomContainer__Z3kuT"><div class="b-grid b-grid--nogutter b-grid--col b-grid--col-6 b-grid--col-sm-12 b-grid--col-md-5 footer-bottom_footerBottomContainerBox__8d0Ua"><div class="footer-bottom_footerBottomContainerBoxLogo__cNIgu"><span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%"><span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%"><img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%27149%27%20height=%2726%27/%3e"></span><img alt="Boyner Group" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/boyner-group.webp" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain"><noscript><img alt="Boyner Group" loading="lazy" decoding="async" data-nimg="intrinsic" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit:contain" src="https://boyner-marketplace-ecom-cms-small-prod.mncdn.com/wp-content/uploads/2024/03/boyner-group.webp"/></noscript></span></div><p class="b-typography b-typography--p14 footer-bottom_footerBottomContainerBoxText__lDc1f">© 2025 Boyner Büyük Mağazacılık A.Ş.</p></div><div class="b-grid b-grid--nogutter b-grid--col b-grid--col-6 b-grid--col-sm-12 b-grid--col-md-6 b-grid--col-sm-0-offset footer-bottom_footerBottomContainerItems__eLiV4"><a class="footer-bottom_footerBottomContainerItemsText__Xizz9" style="text-decoration:none" href="/content/uyelik-sozlesmesi"><p class="b-typography b-typography--p14" style="color:var(--semantic-foreground-secondary)">Üyelik Sözleşmesi</p></a><a class="footer-bottom_footerBottomContainerItemsText__Xizz9" style="text-decoration:none" href="/content/gizlilik-kurallari-site-kullanim-sartlari"><p class="b-typography b-typography--p14" style="color:var(--semantic-foreground-secondary)">Site Kullanım ve Gizlilik Şartları</p></a><a class="footer-bottom_footerBottomContainerItemsText__Xizz9" style="text-decoration:none" href="/content/kisisel-verilerin-korunmasina-iliskin-aydinlatma-metni"><p class="b-typography b-typography--p14" style="color:var(--semantic-foreground-secondary)">KVKK Aydınlatma Metni</p></a></div></div></div></div>
    </div>
  </div>

 <script>
document.addEventListener("DOMContentLoaded", function() {
    // Başlıkları seç
    const headers = document.querySelectorAll(".b-panel__b-panel-header");

    headers.forEach(header => {
        header.addEventListener("click", function(e) {
            e.preventDefault(); // Sayfanın zıplamasını engelle

            // Paneli ve İçeriği Bul
            const panel = this.closest(".b-panel");
            const content = panel.querySelector(".b-panel__b-panel-content");
            const icon = this.querySelector("i");

            // Kontrol Et: Şu an görünür mü?
            // (getComputedStyle, CSS dosyasındaki durumu da kontrol eder)
            const isOpen = window.getComputedStyle(content).display === "block";

            if (isOpen) {
                // AÇIKSA -> KAPAT
                content.style.display = "none";
                
                // İkonu Artı (+) yap
                if(icon) {
                    icon.className = "b-icon b-icon--plus-bold";
                }
            } else {
                // KAPALIYSA -> AÇ (Zorla Stil Veriyoruz)
                content.style.display = "block";
                content.style.height = "auto";
                content.style.opacity = "1";
                content.style.visibility = "visible";
                
                // İkonu Eksi (-) yap
                if(icon) {
                    icon.className = "b-icon b-icon--minus-medium";
                }
            }
        });
    });
});
</script>
</body>
</html>
