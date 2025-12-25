<?php
session_start();

// Sepet verisini kontrol et, yoksa boş dizi ata
$sepetUrunleri = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Toplam tutarı hesapla
$genelToplam = 0;
$sepetAdeti = 0;

foreach ($sepetUrunleri as $urun) {
    // Ürün fiyatının sayısal olduğundan emin ol (Örn: 1739.90)
    $fiyat = floatval($urun['price']); 
    $adet = intval($urun['qty']);
    
    $genelToplam += ($fiyat * $adet);
    $sepetAdeti += $adet;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/boyner.css">
    <link rel="stylesheet" href="css/content.css">

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
            <li><a href="summary.php"><i class="fas fa-shopping-bag"></i></a></li>
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


    <div class="container" style="margin-top: 20px;">
      <h1>Sepetim</h1>
      <div class="b-grid b-grid--row">

        <div class="b-grid b-grid--col b-grid--col-8 b-grid--col-lg-8 b-grid--col-xl-7 b-grid--col-lg-0-offset b-grid--col-xl-1-offset">
    <div class="">
        <?php 
        // Sepet verisini çekiyoruz
        $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

        if (empty($cartItems)): 
        ?>
            <div style="padding:40px; text-align:center;">Sepetinizde ürün bulunmamaktadır.</div>
        <?php else: ?>
            
            <?php foreach ($cartItems as $product_id => $urun): 
                // Senin addtocart.php'deki 'qty' verisi burada kullanılıyor
                $adet = isset($urun['qty']) ? $urun['qty'] : 1;
                $fiyat = isset($urun['price']) ? $urun['price'] : 0;
                $toplamFiyat = $fiyat * $adet;
            ?>
            <div class="cart-merchant-items_cartMerchantItemsItem__E9sX_">
                
                <div class="cart-cargo-info_cartCargoInfo__Nzj3k">
                    <p class="b-typography b-typography--p14 cart-cargo-info_cartCargoInfoMerchantName__BnnBZ" style="color: var(--semantic-foreground-secondary);">
                        Satıcı: <a href="#" style="text-decoration: underline;">BOYNER</a>
                    </p>
                    <div class="cart-cargo-info_cartCargoInfoStatus__LKBn9">
                        <div class="cart-cargo-info_cartCargoInfoStatusCheckMarkIcon__7yfqf">
                            <i class="b-icon b-icon--checkmark-medium" style="color: var(--semantic-background-primary); font-size: 8px;"></i>
                        </div>
                        <h6 class="b-typography b-typography--h7">Kargo Bedava</h6>
                    </div>
                </div>

                <div class="cart-merchant-items_cartMerchantItemsItemCard__MYN2x">
                    <div class="cart-product-desktop_cartProduct__q59ul">
                        
                        <div class="product-image_productImage__k6kQq cart-product-desktop_cartProductImage__iaTzI">
                            <a class="product-image_productImageWrapper__Whoo_" href="#" style="text-decoration: none;">
                                <div class="image_image__YRRyU image_imageProduct__5GHr7">
                                    <span style="box-sizing: border-box; display: block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: absolute; inset: 0px;">
                                        <img alt="<?= htmlspecialchars($urun['name']) ?>" 
                                             src="images/<?= htmlspecialchars($urun['image']) ?>"
                                             decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%; object-fit: cover;">
                                    </span>
                                </div>
                            </a>
                        </div>

                        <div class="cart-product-desktop_cartProductDetail__OpOLd">
                            <div class="cart-product-desktop_cartProductDetailBox__qClDi cart-product-desktop_cartProductDetailItem__LnYFZ">
                                <div class="product-info_productInfo__Tox6W product-info_productInfoLarge__1AM91 cart-product-desktop_cartProductDetailBoxItem__PFBxR">
                                    <div class="product-info_productInfoBox__QZUMo">
                                        <div class="product-info_productInfoBoxTextWrapper__7XZCM">
                                            <a class="product-info_productInfoBoxTextWrapperTitle__CpqOs" href="#" style="text-decoration: none;">
                                                <p class="b-typography b-typography--p16 b-typography--ellipsis b-typography--ellipsis-lines" style="-webkit-line-clamp: 2;">
                                                    <b><?= htmlspecialchars($urun['brand']) ?></b> <?= htmlspecialchars($urun['name']) ?>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <p class="b-typography b-typography--p12 product-cargo_productCargo__fqPnu cart-product-desktop_cartProductDetailBoxItem__PFBxR">
                                    <i class="b-icon b-icon--fast-delivery1-light" style="font-size: 16px;"></i>
                                    <span>Hızlı Teslimat</span>
                                </p>
                            </div>

                            <div class="product-counter_productCounterWrapper__mHw67">
    <div class="product-counter_productCounter__1M5DI">
        <button onclick="updateCart('<?= $product_id ?>', 'decrease')" class="b-button b-button--base b-button--medium b-button--text-style-heading product-counter_productCounterButton__eJIBf" type="button">
            <i class="b-icon b-icon--minus-medium"></i>
        </button>
        
        <input id="qty-<?= $product_id ?>" type="number" class="product-counter_productCounterInput__s8rq2" value="<?= $adet ?>" readonly>
        
        <button onclick="updateCart('<?= $product_id ?>', 'increase')" class="b-button b-button--base b-button--medium b-button--text-style-heading product-counter_productCounterButton__eJIBf" type="button">
            <i class="b-icon b-icon--plus-bold"></i>
        </button>
    </div>
</div>

<div class="price_priceLeft__VRQGR cart-product-desktop_cartProductDetailItem__LnYFZ cart-product-desktop_cartProductDetailItemPrice__x5fVm">
    <h5 id="total-<?= $product_id ?>" class="b-typography b-typography--h5 price_priceMain__DrVVQ b-typography--ellipsis" style="-webkit-line-clamp: 1;">
        <?= number_format($toplamFiyat, 2, ',', '.') ?> TL
    </h5>
</div>

                            <div class="favorite_favorite__eM4RC">
                                <a href="remove_cart.php?id=<?= $product_id ?>" class="b-button" style="color:red; font-size:12px; text-decoration:none;">
                                    <i class="fas fa-trash"></i> Sil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
    </div>
            
    
            <div class="bnpl-banner_bnplBanner__LfoHD">
                <div role="button" class="bnpl-banner-desktop_bnplBannerCart__8rbtO">
                    <div class="bnpl-banner-desktop_bnplBannerCartContent__uL0JF">
                        <div class="bnpl-banner-desktop_bnplBannerCartImage__w_RoP">
                            <span style="box-sizing: border-box; display: inline-block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative; max-width: 100%;">
                                <span style="box-sizing: border-box; display: block; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; max-width: 100%;">
                                    <img alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%2735%27%20height=%2735%27/%3e" style="display: block; max-width: 100%; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px;">
                                </span>
                                <img alt="hopi" src="https://boyner-stook-frontend.mncdn.com//public/ui/hopilogo.png" decoding="async" data-nimg="intrinsic" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%; object-fit: contain;">
                                <noscript></noscript>
                            </span>
                        </div>
                        <p class="bnpl-banner-desktop_bnplBannerCartText__3Y9k7">Harcamaya Hazır Limit'inle Şimdi Al, 184.47 TL'den başlayan taksitlerle öde</p>
                    </div>
                    <button class="b-button b-button--secondary b-button--xsmall b-button--text-style-heading bnpl-banner-desktop_bnplBannerCartButton__ENq9_" type="button" aria-disabled="false" aria-busy="false" aria-label="LİMİTİNİ ÖĞREN" style="width: 122px; height: 40px;">
                        <span class="b-typography b-typography--h7 b-typography--ellipsis" style="-webkit-line-clamp: 1;">LİMİTİNİ ÖĞREN</span>
                    </button>
                </div>
            </div>
    
            <div class="click-and-collect_clickAndCollect__RC5Xz">
                <div role="button" class="click-and-collect-banner_clickAndCollectBanner__Y7H9g">
                    <p class="b-typography b-typography--p14">
                        Sepetindeki ürünler mağazamızdan teslim almaya uygundur.
                        <button class="b-button b-button--underline b-button--small b-button--text-style-heading click-and-collect-banner_clickAndCollectBannerDetailButton__BMclc" type="button" aria-disabled="false" aria-busy="false" aria-label="Detaylar">
                            <span class="b-typography b-typography--h5 b-typography--ellipsis" style="-webkit-line-clamp: 1;">Detaylar</span>
                        </button>
                    </p>
                    <div class="click-and-collect-banner_clickAndCollectBannerImage__Sd7xO">
                        <span style="box-sizing: border-box; display: inline-block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative; max-width: 100%;">
                            <span style="box-sizing: border-box; display: block; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; max-width: 100%;">
                                <img alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%2732%27%20height=%2732%27/%3e" style="display: block; max-width: 100%; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px;">
                            </span>
                            <img alt="click-and-collect" src="https://boyner-stook-frontend.mncdn.com//public/svgs/click-and-collect.png" decoding="async" data-nimg="intrinsic" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%; object-fit: contain;">
                            <noscript></noscript>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="b-grid b-grid--col b-grid--col-4 b-grid--col-lg-4 b-grid--col-xl-3 b-grid--col-lg-0-offset">
            <div class="cart-order-summary_cartOrderSummary__DM8q3">
    <h3 class="b-typography b-typography--h3 cart-order-summary_cartOrderSummaryTitle__FIWHM">Sipariş Özeti</h3>
    
    <div>
        <div class="cart-order-summary_cartOrderSummaryItem__C7LLz">
            <div class="cart-order-summary_cartOrderSummaryItemLabel__EgNuJ">
                <p class="b-typography b-typography--p14" style="color: var(--semantic-foreground-primary);">Sepet Tutarı</p>
            </div>
            <div class="cart-order-summary_cartOrderSummaryItemValue__BGvvb">
                <p id="grand-total-1" class="b-typography b-typography--p14" style="color: var(--semantic-foreground-primary);">
                    <?= number_format($genelToplam, 2, ',', '.') ?> TL
                </p>
            </div>
        </div>
        </div>

    <div class="b-divider b-divider--variant-fullbleed b-divider--size-xsmall cart-order-summary_cartOrderSummaryDivider__gfSEM" aria-orientation="horizontal" aria-hidden="true"></div>
    
    <div class="cart-order-summary_cartOrderSummaryTotalPriceWrapper__6a5zR">
        <h6 class="b-typography b-typography--h6">Toplam</h6>
        <h4 id="grand-total-2" class="b-typography b-typography--h4">
            <?= number_format($genelToplam, 2, ',', '.') ?> TL
        </h4>
    </div>

    <button class="b-button b-button--primary b-button--large b-button--fluid b-button--icon-position-right b-button--text-style-heading" type="button">
        <span class="b-typography b-typography--h5 b-typography--ellipsis">SEPETİ ONAYLA</span>
        <i class="b-icon b-icon--arrow2-right-light b-button__icon"></i>
    </button>
</div>
    
            <div class="hopi_hopiBanner__mc5Ka">
                <div role="button" class="hopi-banner_hopiBanner__4HJ_Q">
                    <div class="hopi-banner_hopiBannerHeader__zmzJl">
                        <div class="hopi-banner_hopiBannerHeaderContent__N0O_3">
                            <div class="hopi-banner_hopiBannerHeaderContentLogo__JB07Z">
                                <span style="box-sizing: border-box; display: inline-block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative; max-width: 100%;">
                                    <span style="box-sizing: border-box; display: block; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; max-width: 100%;">
                                        <img alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%2728%27%20height=%2728%27/%3e" style="display: block; max-width: 100%; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px;">
                                    </span>
                                    <img alt="hopi-logo" src="https://boyner-stook-frontend.mncdn.com//public/ui/hopilogo.png" decoding="async" data-nimg="intrinsic" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%; object-fit: contain;">
                                    <noscript></noscript>
                                </span>
                            </div>
                            <h5 class="b-typography b-typography--h5 hopi-banner_hopiBannerHeaderContentTitle__GMWF2"><strong>Hopi</strong>’ni Kullan</h5>
                        </div>
                        <i class="b-icon b-icon--arrow-forward-bold" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
    
            <div class="discount-code_discountCodeBanner__PYFzV">
                <div role="button" class="discount-code-banner_discountCodeBanner__u8pzm">
                    <div class="discount-code-banner_discountCodeBannerIconWrapper__Jashe">
                        <i class="b-icon b-icon--kupon-medium" style="font-size: 20px;"></i>
                    </div>
                    <div class="discount-code-banner_discountCodeBannerContent__JM1wQ">
                        <div class="discount-code-banner_discountCodeBannerContentTitleWrapper__ZSrXj">
                            <h5 class="b-typography b-typography--h5">İndirim Kodu/Kuponu Kullan</h5>
                            <i class="b-icon b-icon--arrow-forward-bold" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

<script>
function updateCart(productId, action) {
    // Fetch API kullanarak PHP'ye istek atıyoruz
    fetch('update_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id: productId,
            action: action
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // 1. Adet kutusunu güncelle
            document.getElementById('qty-' + productId).value = data.newQty;
            
            // 2. O ürünün toplam fiyatını güncelle
            document.getElementById('total-' + productId).innerText = data.newItemTotal;
            
            // 3. Genel toplamları güncelle (Hem yukarıdaki hem aşağıdaki)
            if(document.getElementById('grand-total-1')) {
                document.getElementById('grand-total-1').innerText = data.newGrandTotal;
            }
            if(document.getElementById('grand-total-2')) {
                document.getElementById('grand-total-2').innerText = data.newGrandTotal;
            }
        }
    })
    .catch((error) => {
        console.error('Hata:', error);
    });
}
</script>

</body>
</html>