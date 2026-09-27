Velocity Child Toko 30
=================
[toko30.velocitydeveloper.com](https://toko30.velocitydeveloper.com/)

Child Theme for the Velocity System WordPress theme.

### Required
Theme Velocity versi 2.7.0 keatas, [Download](https://github.com/VelocityDeveloper/velocity/releases)

### Required Plugins
**VD Store**, [Download](https://github.com/Velocity-Developer/vd-store/releases) — produk `store_product`,
kategori `store_product_cat`, merek `brand`. Sejak 1.1.0 tema tidak lagi memakai plugin Velocity Toko
maupun Kirki.

Integrasi VD Store ada di `inc/vd-store.php`, `css/vd-store.css`, dan template override di folder
`vd-store/` (arsip, kategori, merek, detail produk). Pencarian situs diarahkan ke arsip produk.

| Velocity Toko (≤1.0.x) | VD Store (1.1.0) |
|---|---|
| `[harga]` | `[wp_store_price]` |
| `[beli]` | `[wp_store_add_to_cart]` |
| `[cart]` | `[wp_store_cart]` |
| `[profile]` | ikon ke halaman Profil Saya VD Store (`velocity_toko30_profil()`) |
| `[kontak]` | kontak dari pengaturan VD Store (`velocity_toko30_kontak()`) |
| `[thumbnail]` | `[wp_store_thumbnail]` (label & diskon dari VD Store) |
| `[slider-produk]` | `[wp_store_gallery]` |
| `[detail-produk]` | `[wp_store_product_info]` |
| `[love]` | `[wp_store_add_to_wishlist]` |
| `[beli-lain]` | `velocity_toko30_beli_lain()` |
| `[share]` | `[velocity-sharepost]` (Velocity Addons) |
| filter kategori | `[wp_store_filters]` |

### Beranda
Template **Home Template** (`page-home.php`): header logo + kotak cari + ikon keranjang/profil, menu abu,
slider selebar kotak, lalu judul "nama situs-tagline" + 8 produk 4 kolom (tombol Detail + keranjang) berpaginasi
dan 3 artikel gaya baris; sidebar di KIRI. Arsip kategori/merek: filter VD Store di kiri.

### Widget
Shortcode untuk widget Teks (susunan demo, dibaca installer lewat `velocity_tema_widget_sidebar()` / `velocity_tema_widget_footer()`):

- Sidebar (kiri): `[toko30_kontak]`, `[toko30_kategori]`, `[toko30_bank]`, `[toko30_sosmed facebook="…" instagram="…" twitter="…" youtube="…"]`, `[toko30_testimoni]`
- Footer (4 kolom): `[toko30_cari]`, `[toko30_info_terbaru]`, `[toko30_ekspedisi]`, `[velocity-statistics]` (Velocity Addons)
- Lainnya: `[toko30_cari_produk]`, `[toko30_produk_terbaru jumlah="5"]`, `[toko30_best_seller jumlah="5"]`,
  `[toko30_kalender]`, `[kontak-inline style="false"]`

### Halaman
Halaman **Konfirmasi Pembayaran** = `[store_tracking]` (input nomor pesanan VD Store: tagihan, rekening, unggah bukti
transfer). Override tipis `vd-store/pages/tracking.php` membuat pencarian tetap di halaman tempat form dipasang.

### Customizer
Appearance > Customize > **Velocity Toko 30**: Warna (utama & sekunder), Slider Home (5 slot gambar),
Font (menu & judul widget, teks — Google Fonts; bawaan Roboto), Velocity Home News (judul & kategori artikel beranda).
Warna teks/judul/link: Theme Colors tema induk. Latar website: pengaturan Background tema induk.
Logo: Site Identity. Halaman beranda memakai template **Home Template**, halaman pricelist
template **Velocity Toko Pricelist**. Halaman Katalog & Profil Saya VD Store selalu tanpa sidebar.

### Usage
Simply download the zip and upload the zip (velocity-toko30.zip) under your WordPress dashboard at Appearance > Themes. Or extract and upload via FTP at wp-content/themes/.
