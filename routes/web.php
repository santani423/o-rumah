<?php

use App\Http\Controllers\Front;
use App\Http\Controllers\PasswordChangesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminNavController;
use App\Http\Controllers\Admin\ManagementAdsController;
use App\Http\Controllers\Member\MemberNavController;
use App\Http\Controllers\Member\MemberToolController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MarchantsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdBalanceController;
use App\Http\Controllers\UserLelangPropertieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LinkeAdsController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\KprFileBankController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\BosterAdsController;
use App\Http\Controllers\TitipAdsController;
use App\Http\Controllers\Visitor\VisitorKprController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/kirim-email', [MailController::class, 'index']);
Route::get('/logout', [ProfileController::class, 'logout'])->name('auth.logout');
Route::get('/teslogin', [ProfileController::class, 'teslogin'])->name('teslogin');

Route::post('/auth/in/login', [AuthController::class, 'inLogin'])->name('auth.in.login');
Route::post('/auth/in/registrasi', [AuthController::class, 'inRegistrasi'])->name('auth.in.registrasi');
// Home and coming soon
Route::get('/', [Front\HomeController::class, 'index'])->name('home');
Route::get('/Referral/{code}', [Front\HomeController::class, 'Referral'])->name('referral');
Route::post('/qr-code/upload', [Front\HomeController::class, 'uploadQr'])->name('qr-code.upload');

Route::get('/coming-soon', [Front\HomeController::class, 'comingSoon'])->name('coming-soon');
Route::get('/about-as', [Front\HomeController::class, 'aboutAs'])->name('aboutAs');

// Regular routes
Route::get('/properti', [Front\HomeController::class, 'latest'])->name('latest');
Route::get('/lelang', [Front\HomeController::class, 'auction'])->name('auction');

Route::get('/ofoods', [Front\HomeController::class, 'ofoods'])->name('ofoods');
Route::get('/ofoods/listing', [Front\HomeController::class, 'ofoodsListing'])->name('ofoods.listing');
Route::get('/ofoods/kategori/{kategori}', [Front\HomeController::class, 'ofoodsByKategori'])->name('ofoods.by.kategori');



Route::get('/omerchant', [Front\HomeController::class, 'omerchant'])->name('omerchant');
Route::get('/omerchant/kategori/{kategori}', [Front\HomeController::class, 'omerchantByKategori'])->name('omerchant.by.kategori');
Route::get('/omerchant/listing', [Front\HomeController::class, 'omerchantListing'])->name('omerchant.listing');

Route::get('/lbh', [Front\HomeController::class, 'lawHelper'])->name('law-helper');
Route::get('/notaris', [Front\HomeController::class, 'notaris'])->name('notaris');
Route::get('/agen', [Front\HomeController::class, 'agent'])->name('agent');
Route::post('/agen/search', [Front\HomeController::class, 'agentSearch'])->name('agent.search.page');

// With parameter
Route::get('/user/{username}', [Front\HomeController::class, 'agentDetail'])->name('agent-detail');

Route::get('/properti/kpr/{slug}', [Front\HomeController::class, 'linkKpr'])->name('linkKpr');
Route::post('/properti/kpr', [Front\HomeController::class, 'linkKprStore'])->name('linkKpr.store');
Route::get('/properti/kpr/response/{uuid}', [VisitorKprController::class, 'linkKprInfo'])->name('visitor.linkKpr.store');
// Route::post('/visitor/properti/kpr', [VisitorKprController::class, 'linkKprStore'])->name('visitor.linkKpr.store');

Route::post('/properti/kpr/finish', [Front\HomeController::class, 'kprFormFinish'])->name('linkKpr.kprFormFinish');

Route::get('/properti/{slug}', [Front\HomeController::class, 'propertyDetail'])->name('property-detail');

Route::get('/auction/{slug}/{username}', [Front\HomeController::class, 'auctionDetail'])->name('auction-detail');
Route::get('/auction/link/{slug}/{username}', [Front\HomeController::class, 'linkAuction'])->name('auction-link');
Route::post('/auction/link', [Front\HomeController::class, 'linkLelangStore'])->name('auction-link.store');

Route::get('/ofood/{slug}', [Front\HomeController::class, 'ofoodDetail'])->name('ofood-detail');
Route::get('/omerchant/{slug}', [Front\HomeController::class, 'omerchantDetail'])->name('omerchant-detail');


Route::get('/properti/{slug}/ajukan-kpr', [Front\HomeController::class, 'kprRegistration'])->name('kpr-registration');

// After login routes
Route::middleware('auth')->group(function () {
    Route::prefix('listing')->name('listing.')->group(function () {
        Route::get('', [Front\ListingController::class, 'index'])->name('index');
        Route::get('/control-panel/property/view/{slug}', [Front\ListingController::class, 'viewProperty'])->name('control-panel.view.property');
        Route::get('/control-panel/property/edit/{slug}', [Front\ListingController::class, 'editPropertiTentangProperti'])->name('control-panel.properti.edit.tentang-properti');
        Route::get('/control-panel/addres/edit/{slug}', [Front\ListingController::class, 'editPropertiAddres'])->name('control-panel.properti.edit.addres');
        Route::get('/control-panel/addres/update/addres/{adsId}', [Front\ListingController::class, 'updatePropertiAddres'])->name('control-panel.properti.update.addres');
        Route::put('/control-panel/property/update/{slug}', [Front\ListingController::class, 'updatePropertiTentangProperti'])->name('control-panel.properti.update.tentang-properti');
        Route::put('/control-panel/property/update/media/utama/{ads_properties_id}', [Front\ListingController::class, 'setMediaUtama'])->name('control-panel.properti.set.media.utama');
        Route::put('/control-panel/property/update/media/update/{ads_properties_id}', [Front\ListingController::class, 'setMediaUpdate'])->name('control-panel.properti.set.media.update');

        Route::get('/control-panel/food/view/{slug}', [Front\ListingController::class, 'viewFood'])->name('control-panel.view.food');
        Route::post('/control-panel/food/{ads_id}/upload-images', [Front\ListingController::class, 'uploadImagesFood'])->name('control-panel.food.upload.images');
        Route::post('/media/{id}/update', [Front\ListingController::class, 'updateMedia'])->name('media.update');
        Route::get('/media/{id}/update/addres', [Front\ListingController::class, 'updateAddresFood'])->name('media.adres.food');
        Route::delete('/media/{id}', [Front\ListingController::class, 'deleteMedia'])->name('media.delete');

        Route::get('/control-panel/food/edit/{slug}', [Front\ListingController::class, 'editFood'])->name('control-panel.food.edit.tentang-food');
        Route::get('/control-panel/food/adres/edit/{slug}', [Front\ListingController::class, 'editAdresFood'])->name('control-panel.food.edit.addres');
        Route::get('/control-panel/food/adres/update/{slug}', [Front\ListingController::class, 'updateAddresFood'])->name('control-panel.food.update.addres');
        Route::put('/control-panel/food/update/{slug}', [Front\ListingController::class, 'updateFood'])->name('control-panel.food.update');
        Route::put('/control-panel/food/update/media/utama/{ofoods_id}', [Front\ListingController::class, 'setMediaUtamaFood'])->name('control-panel.food.set.media.utama');
        
        Route::get('/control-panel/marchant/view/{slug}', [Front\ListingController::class, 'viewmarchant'])->name('control-panel.marchant.view.tentang-marchant');
        Route::get('/control-panel/marchant/adres/edit/{slug}', [Front\ListingController::class, 'editAdresmarchant'])->name('control-panel.marchant.edit.addres');
        Route::get('/control-panel/marchant/adres/update/{slug}', [Front\ListingController::class, 'updateAddresMarchant'])->name('control-panel.Merchant.update.addres');
        Route::get('/control-panel/marchant/edit/{slug}', [Front\ListingController::class, 'editmarchant'])->name('control-panel.Merchant.edit');
        Route::put('/control-panel/marchant/update/{slug}', [Front\ListingController::class, 'updatemarchant'])->name('control-panel.Merchant.update');


        Route::get('/control-panel/wilayah-kerja', [Front\ListingController::class, 'wilayahKerja'])->name('control-panel.wilayah-kerja');
        Route::get('/control-panel/wilayah-kerja/create', [Front\ListingController::class, 'wilayahKerjaCreate'])->name('control-panel.wilayah-kerja.create');
        Route::get('/control-panel/wilayah-kerja/store', [Front\ListingController::class, 'wilayahKerjaStore'])->name('control-panel.wilayah-kerja.store');

        Route::get('/get-district', [Front\ListingController::class, 'getDistrict'])->name('getDistrict');
        Route::get('/create-listing', [Front\ListingController::class, 'create'])->name('create');
        Route::get('/ads-properties', [Front\ListingController::class, 'adsProperties'])->name('adsProperties');
        Route::get('/store-location', [Front\ListingController::class, 'storeLocation'])->name('storeLocation');
        Route::post('/store-ads', [Front\ListingController::class, 'storeAds'])->name('storeAds');

        Route::post('/handle-property-image', [Front\ListingController::class, 'handlePropertyImage'])->name('handlePropertyImage');

        Route::get('{id}/edit', [Front\ListingController::class, 'edit'])->name('edit');
        Route::get('{id}/edit-location', [Front\ListingController::class, 'editLocation'])->name('editLocation');
        Route::post('{id}/update-ads', [Front\ListingController::class, 'update'])->name('update');

        Route::put('/toggle', [Front\ListingController::class, 'toggle'])->name('toggle');

        Route::prefix('auction')->name('auction.')->group(function () {
            Route::get('', [Front\AuctionListingController::class, 'index'])->name('index');
            Route::put('{adsId}', [Front\AuctionListingController::class, 'update'])->name('update');
        });
    });

    Route::get('/profil', [Front\HomeController::class, 'profile'])->name('profile');
    Route::post('/profil', [Front\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password', [Front\HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('/properti-favorit', [Front\HomeController::class, 'wishlist'])->name('wishlist');
    Route::post('/wishlist', [Front\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist', [Front\WishlistController::class, 'destroy'])->name('wishlist.destroy');




    // administrator
    Route::controller(AdminNavController::class)->prefix('admin')->name('admin.')->group(function () {

        Route::get('/properti', 'properti')->name('nav.properti');
        Route::get('/lelang', 'lelang')->name('nav.lelang');
        Route::get('/lelang/create', 'lelangCreate')->name('nav.lelang.create');
        Route::get('/lelang/create-listing', 'lelangCreateListing')->name('nav.lelang.create-listing');
        Route::post('/lelang/store', 'lelangStore')->name('nav.lelang.store');
        Route::get('/o-food', 'oFood')->name('nav.o-food');
        Route::get('/o-merchant', 'oMerchant')->name('nav.o-merchant');

        Route::get('/bank', 'bank')->name('nav.bank');
        Route::get('/bank/add', 'bankAdd')->name('nav.bank.add');
        Route::post('/bank/store', 'bankStore')->name('nav.bank.store');
        Route::get('/bank/edit/{id}', 'bankEdit')->name('nav.bank.edit');
        Route::put('/bank/edit/{id}', 'bankUpdate')->name('nav.bank.update');

        Route::get('/typeProperti', 'typeProperti')->name('nav.typeProperti');

        Route::get('/ads/control-panel', 'adsControllPanel')->name('nav.ads.control-panel');
        Route::post('/ads/control-panel', 'adsControllPanelUpdatae')->name('nav.ads.control-panel.update');

        Route::get('/ads/control-booster', 'adsControllBooster')->name('nav.ads.control-booster');
        Route::put('/ads/control-booster/{id}', 'adsControllBoosterUpdatae')->name('nav.ads.control-booster.update');

        Route::get('/pengguna', 'pengguna')->name('nav.pengguna');
        Route::get('/pengguna/{id}', 'penggunaDetail')->name('nav.pengguna.detail');
        Route::get('/tipe-properti', 'tipeProperti')->name('nav.tipe-properti');
        Route::get('/districts', 'districts')->name('nav.districts');
        Route::get('/citie', 'citie')->name('nav.citie');
        Route::get('/provinces', 'provinces')->name('nav.provinces');

        Route::get('/banner', 'banner')->name('nav.banner');
        Route::get('/banner/create', 'bannerCreate')->name('nav.banner.create');
        Route::post('/banner/store', 'bannerStore')->name('nav.banner.store');
        Route::put('/banner/updated/{id}', 'bannerUpdate')->name('nav.banner.updated');
        Route::get('/banner/edit/{id}', 'bannerEdit')->name('nav.banner.edit');


        Route::get('/plans', 'plans')->name('nav.plans');
        Route::get('/website-ads-sections', 'websiteAdsSections')->name('nav.websiteAdsSections');
        Route::get('/settings', 'settings')->name('nav.settings');

        Route::get('/kategoriAds', 'kategoriAds')->name('nav.kategoriAds');
        Route::get('/subKategoriAds/{id}', 'subKategoriAds')->name('nav.subKategoriAds');
        Route::put('/subKategoriAds/{id}', 'updateSubKategoriAds')->name('nav.subKategoriAds.update');

        Route::get('/pengguna/list/{type}', 'pengguna')->name('nav.pengguna');
        Route::get('/pengguna/properti/{id}', 'penggunaProperti')->name('nav.pengguna.properti');
        Route::get('/pengguna/food/{id}', 'penggunafood')->name('nav.pengguna.food');
        Route::get('/pengguna/marchant/{id}', 'penggunamarchant')->name('nav.pengguna.marchant');
        Route::get('/pengguna/detail/{id}', 'penggunadetail')->name('nav.pengguna.detail');

        Route::get('/users/{id}', 'detialUser')->name('nav.pengguna.detail');
        Route::post('/users/{id}/toggle-active', 'toggleActive')->name('users.toggleActive');
        Route::put('/users/{id}/update-statistics', 'updateStatistics')->name('users.updateStatistics');

        Route::prefix('transaksi')->name('transaksi.')->group(function () {
            Route::get('/panding', 'transaksiPanding')->name('panding');
            Route::get('/approval', 'transaksiProcessing')->name('processing');
            Route::get('/success', 'transaksiSuccessDetail')->name('success');
            Route::get('/canceled', 'transaksiCanceledDetail')->name('canceled');
            Route::get('/approval/{transactionId}', 'transaksiProcessingDetail')->name('processing.detail');
        });
        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/lelang', 'pengajuanLelang')->name('lelang');
            Route::get('/lelang/{id}', 'pengajuanDetailLelang')->name('lelang.detail');


            Route::get('/kpr', 'pengajuanKpr')->name('kpr');
            Route::get('/kpr/{id}', 'pengajuanDetailKpr')->name('kpr.detail');
            Route::post('/kpr/setting/status/{id}', 'settingStatusKpr')->name('kpr.setting.status');
            Route::get('/kpr/upload/xlxs', 'uploadXlxs')->name('kpr.upload.xlxs');




            Route::get('/kpr/downloadKprFiles/{id}', 'downloadKprFiles')->name('kpr.downloadKprFiles');
        });
    });
    Route::controller(KprFileBankController::class)->group(function () {
        Route::post('/admin/kpr/file/bank', 'fileKprBank')->name('admin.kpr.file.bank');
    });
    Route::controller(ManagementAdsController::class)->group(function () {
        Route::post('/managementAds/set-actifity', 'setActifity')->name('managementAds.setActifity');
    });

    Route::controller(BosterAdsController::class)->group(function () {
        Route::post('/boosterAds', 'store')->name('boosterAds.store');
        Route::post('/boosterAds/listing', 'storeListing')->name('boosterAds.storeListing');
    });


    Route::controller(MemberNavController::class)->group(function () {
        Route::get('/member/plans', 'plans')->name('member.plans');

        Route::get('/member/properti/create', 'propertiCreate')->name('member.properti.create');
        Route::get('/member/properti/create/listing', 'propertiCreateListing')->name('member.properti.create.listing');
        Route::post('/member/properti/create/listing/store', 'propertiStoreListing')->name('member.properti.store.listing');
        Route::post('/member/properti/create/listing/store/upload', 'propertiStoreListingUpload')->name('member.properti.store.listing.upload');


        Route::get('/member/food', 'food')->name('member.food');
        Route::get('/member/food/create-listing', 'FoodCreateListing')->name('member.food.create-listing');
        Route::get('/member/food/store-listing', 'FoodStoreListing')->name('member.food.store-listing');
        Route::post('/member/food/store-listing', 'FoodStoreListingFood')->name('member.food.store.listing');

        Route::get('/member/merchants', 'merchants')->name('member.merchants');
        Route::get('/member/merchants/create-listing', 'merchantCreateListing')->name('member.merchants.create-listing');
        Route::get('/member/merchants/store-listing', 'merchantsStoreListing')->name('member.merchants.store-listing');
        Route::post('/member/merchants/store-listing', 'merchantsStoreListingMarchent')->name('member.merchants.store.listing');

        Route::get('/member/lelang', 'lelang')->name('member.lelang');
        Route::post('/member/lelang/store', 'lelangStore')->name('member.lelang.store');

        Route::get('/member/plans/list-bank/{slug}', 'listBank')->name('member.plans.listBank');
        Route::get('/member/plans/invoice/{transactionId}', 'invoice')->name('member.plans.invoice');
        Route::get('/member/payment-message/{slug}', 'paymentMessage')->name('member.plans.paymentMessage');
        Route::get('/member/transaksi', 'transaksi')->name('member.transaksi');

        // Route::get('/member/transaksi', 'transaksi')->name('member.transaksi');


        // member visitor
        Route::get('/member/pengajuan/kpr', 'pengajuanKpr')->name('member.pengajuan.kpr');
        Route::get('/member/pengajuan/lelang', 'pengajuanLelang')->name('member.pengajuan.lelang');

        // member agen 
        Route::get('/member/agen/pengajuan/kpr', 'agenListPengajuanKpr')->name('member.agen.kpr');



        // member faforite
        Route::get('/member/agen/favorit', 'favorit')->name('member.favorit');
        // member profile
        Route::get('/member/profile', 'profile')->name('member.profile');
        Route::get('/member/profile/edit', 'profileEdit')->name('member.profile.edit');
        Route::post('/member/profile', 'memberProfileStore')->name('member.profile.store');
    });

    Route::controller(TransaksiController::class)->group(function () {
        // member
        Route::post('/transaksi/uploadBuktiBayar', 'uploadBuktiBayar')->name('member.uploadBuktiBayar');

        // admin
        Route::post('/transaksi/approvalBuktiBayar', 'approvalBuktiBayar')->name('admin.approval.bukti.bayar');
        Route::post('/transaksi/canceled/buktiBayar', 'canceledbuktiBayar')->name('admin.canceled.bukti.bayar');
    });

    Route::post('/kirim-email/email/bank', [MailController::class, 'adminEmailBank'])->name('admin.email.bank');
    Route::get('/kirim-email/email/responseBackPengajuanKpr', [MailController::class, 'responseBackPengajuanKpr'])->name('admin.email.responseBackPengajuanKpr');

    Route::post('/kirim-email/email/bank/lelang', [MailController::class, 'adminEmailBankLelang'])->name('admin.email.bank.lelang');






    Route::controller(FoodController::class)->group(function () {
        // member
        Route::post('/member/food/store', 'foodStroe')->name('member.food.store');
    });
    Route::controller(MarchantsController::class)->group(function () {
        // member
        Route::post('/member/merchants/store', 'merchantsStroe')->name('member.merchants.store');
    });
    Route::controller(MemberToolController::class)->group(function () {
        // member
        Route::post('/member/tools/check-unique-title-ads', 'cekUniqueTitleAds')->name('member.tools.checkUniqueTitleAds');
        Route::post('/member/tools/food/se-active', 'foodSetActive')->name('member.tools.food.foodSetActive');
    });
    Route::controller(AdBalanceController::class)->group(function () {
        // member
        Route::post('/ad/balace/pin', 'poin')->name('ad.balach.poin');
    });
    Route::controller(UserLelangPropertieController::class)->group(function () {
        // member
        Route::post('/ad/takeAuction', 'takeAuction')->name('ad.take.auction');
    });
    Route::controller(LinkeAdsController::class)->group(function () {
        // member
        Route::post('/ad/like', 'like')->name('ad.like');
    });

    Route::post('/payments', [PaymentController::class, 'create'])->name('payments');
    Route::get('/payments', [PaymentController::class, 'create'])->name('payments');
    Route::post('/ads/toggle-status', [ToolController::class, 'toggleStatus'])->name('ads.toggleStatus');
});

Route::controller(ToolController::class)->group(function () {
    // member
    // Route::post('/tool/searchAds', 'searchAds')->name('tool.searchAds');

});
Route::get('/tool/selectKabupatenKota', [ToolController::class, 'selectKabupatenKota'])->name('tool.selectKabupatenKota');
Route::get('/tool/kecamatanSelect', [ToolController::class, 'kecamatanSelect'])->name('tool.kecamatanSelect');
Route::post('/tool/cekJudul', [ToolController::class, 'cekJudul'])->name('tool.cekJudul');
Route::get('/tool/getAdsListsWithDistance', [ToolController::class, 'adsListsWithDistance'])->name('tool.getAdsListsWithDistance');

Route::get('/tool/getAdsListsWithDistance/booster/home', [ToolController::class, 'adsListsWithDistanceBoosterHome'])->name('tool.getAdsListsWithDistance.booster.home');
Route::get('/tool/getAdsListsWithDistance/booster/sundul', [ToolController::class, 'adsListsWithDistanceBoosterSundul'])->name('tool.getAdsListsWithDistance.booster.sundul');
Route::get('/tool/getAdsListsWithDistance/booster/eksklusif', [ToolController::class, 'adsListsWithDistanceBoosterEksklusif'])->name('tool.getAdsListsWithDistance.booster.eksklusif');
Route::get('/tool/getFoodListsWithDistance', [ToolController::class, 'getFoodListsWithDistance'])->name('tool.getFoodListsWithDistance');
Route::get('/tool/getMarchantListsWithDistance', [ToolController::class, 'getMarchantListsWithDistance'])->name('tool.getMarchantListsWithDistance');
Route::get('/tool/tes', [ToolController::class, 'tes'])->name('tool.tes');
Route::post('/send-whatsapp', [WhatsAppController::class, 'send']);

Route::post('/tool/searchDistricts', [ToolController::class, 'searchDistricts'])->name('tool.searchDistricts');
Route::post('/cek-username', [ToolController::class, 'cekUsername'])->name('cek-username');



Route::post('/search-agent', [ToolController::class, 'searchAgnet'])->name('agent.search');
Route::get('/order', [ToolController::class, 'order'])->name('order');

Route::post('/save-titip-ads', [TitipAdsController::class, 'store'])->name('titip-ads.store');
Route::put('/update-titip-ads/{id}', [TitipAdsController::class, 'update'])->name('titip-ads.put');
Route::get('/titip-ads/list', [TitipAdsController::class, 'index'])->name('titip-ads.list');




Route::get('/forget-password', [PasswordController::class, 'forgetPassword'])->name('forget.password');
// Route::post('/forget-password-email', [MailController::class, 'forgetPassword'])->name('forget.passwrod.email');-----
Route::get('/forget-password-email', [MailController::class, 'forgetPassword'])->name('forget.passwrod.email');
Route::get('/password-change/{uuid}', [PasswordChangesController::class, 'show'])->name('passwrod.change');
Route::put('/password-change/{uuid}', [PasswordChangesController::class, 'update'])->name('password.change.update');
Route::get('/password-verifikasi-code', [PasswordChangesController::class, 'verifikasiCode'])->name('passwrod.verifikasi.code');
Route::post('/password-verifikasi-code', [PasswordChangesController::class, 'verifikasiCodeTes'])->name('verification.code');

Route::get('/simulator-kpr', [ToolController::class, 'simulatorKpr'])->name('simulatorKpr');
Route::get('/upload', function () {
    return view('upload');
});
Route::post('/upload', [ToolController::class, 'uploadPhoto'])->name('upload.photo');

Route::get('/testing/location', function () {
    return view('testing/location');
});
require __DIR__ . '/auth.php';
