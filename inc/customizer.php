<?php
/**
 * Pengaturan Toko 30 di Customizer bawaan WordPress (tanpa Kirki).
 *
 * Warna teks/judul/link memakai pengaturan Theme Colors tema induk. Font judul &
 * font menu/judul widget & teks (demo: Roboto) ada di bagian Font.
 *
 * Nama theme mod sama dengan versi Kirki (velocity_judul_news, velocity_news)
 * supaya nilai yang sudah tersimpan tetap terbaca. Slider Kirki (repeater
 * slider_repeat) diganti slot gambar slider_image_1..N; data slider_repeat lama
 * tetap dipakai selama slot kosong. Latar website memakai pengaturan tema induk
 * (Customizer > Background), latar Kirki lama (background_themewebsite) tetap dicetak.
 *
 * @package justg
 */

defined('ABSPATH') || exit;

const VELOCITY_TOKO30_SLIDER_SLOT = 5;

add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_panel('panel_toko30', [
        'priority' => 10,
        'title'    => __('Velocity Toko 30', 'justg'),
    ]);

    // Warna
    $wp_customize->add_section('section_colorvelocity', [
        'panel'    => 'panel_toko30',
        'title'    => __('Warna', 'justg'),
        'priority' => 10,
    ]);
    $warna = [
        'velocity_toko30_warna_utama'    => [__('Warna Utama', 'justg'), __('Judul widget, tombol, harga, dan teks menu.', 'justg'), '#1e73be'],
        'velocity_toko30_warna_sekunder' => [__('Warna Sekunder', 'justg'), __('Tombol saat disorot dan halaman aktif.', 'justg'), '#333333'],
    ];
    foreach ($warna as $id => [$label, $ket, $bawaan]) {
        $wp_customize->add_setting($id, [
            'default'           => $bawaan,
            'sanitize_callback' => 'sanitize_hex_color',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, [
            'label'       => $label,
            'description' => $ket,
            'section'     => 'section_colorvelocity',
        ]));
    }

    // Font (Google Fonts)
    $wp_customize->add_section('section_font', [
        'panel'    => 'panel_toko30',
        'title'    => __('Font', 'justg'),
        'priority' => 15,
    ]);
    foreach (['velocity_toko30_font_judul' => [__('Font Menu & Judul Widget', 'justg'), 'Roboto'], 'velocity_toko30_font_teks' => [__('Font Teks', 'justg'), 'Roboto']] as $id => [$label, $bawaan]) {
        $wp_customize->add_setting($id, [
            'default'           => $bawaan,
            'sanitize_callback' => function ($v) use ($bawaan) {
                return array_key_exists($v, velocity_toko30_daftar_font()) ? $v : $bawaan;
            },
        ]);
        $wp_customize->add_control($id, [
            'label'   => $label,
            'section' => 'section_font',
            'type'    => 'select',
            'choices' => velocity_toko30_daftar_font(),
        ]);
    }

    // Slider beranda
    $wp_customize->add_section('section_slider', [
        'panel'       => 'panel_toko30',
        'title'       => __('Slider Home', 'justg'),
        'description' => __('Gambar slider di halaman ber-template Home. Slot kosong dilewati.', 'justg'),
        'priority'    => 20,
    ]);
    for ($i = 1; $i <= VELOCITY_TOKO30_SLIDER_SLOT; $i++) {
        $wp_customize->add_setting("slider_image_$i", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "slider_image_$i", [
            'label'   => sprintf(__('Slider %d', 'justg'), $i),
            'section' => 'section_slider',
        ]));
    }

    // Berita beranda
    $wp_customize->add_section('velocity_news_section', [
        'panel'    => 'panel_toko30',
        'title'    => __('Velocity Home News', 'justg'),
        'priority' => 30,
    ]);
    $wp_customize->add_setting('velocity_judul_news', [
        'default'           => 'Blog',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('velocity_judul_news', [
        'label'   => __('Judul', 'justg'),
        'section' => 'velocity_news_section',
        'type'    => 'text',
    ]);
    $wp_customize->add_setting('velocity_news', [
        'default'           => '',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('velocity_news', [
        'label'   => __('Pilih Kategori:', 'justg'),
        'section' => 'velocity_news_section',
        'type'    => 'select',
        'choices' => velocity_categories(),
    ]);
});

/**
 * Pilihan font Google (nama keluarga => label). Kosong = font bawaan tema induk.
 */
function velocity_toko30_daftar_font()
{
    $font = ['' => __('Bawaan tema', 'justg')];
    foreach (['Oswald', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Poppins', 'PT Sans', 'Source Sans 3', 'Nunito', 'Raleway', 'Playfair Display', 'Merriweather'] as $f) {
        $font[$f] = $f;
    }
    return $font;
}

/**
 * Font terpilih: [judul, teks].
 */
function velocity_toko30_font()
{
    $daftar = velocity_toko30_daftar_font();
    $judul = get_theme_mod('velocity_toko30_font_judul', 'Roboto');
    $teks = get_theme_mod('velocity_toko30_font_teks', 'Roboto');
    return [isset($daftar[$judul]) ? $judul : 'Roboto', isset($daftar[$teks]) ? $teks : 'Roboto'];
}

add_action('wp_enqueue_scripts', function () {
    $keluarga = array_unique(array_filter(velocity_toko30_font()));
    if (!$keluarga) {
        return;
    }
    $q = implode('&', array_map(function ($f) {
        return 'family=' . str_replace(' ', '+', $f) . ':wght@400;700';
    }, $keluarga));
    wp_enqueue_style('velocity-toko30-font', 'https://fonts.googleapis.com/css2?' . $q . '&display=swap', [], null);
});

/**
 * URL gambar slider beranda: slot Customizer, atau data slider Kirki lama.
 */
function velocity_toko30_slider()
{
    $gambar = [];
    for ($i = 1; $i <= VELOCITY_TOKO30_SLIDER_SLOT; $i++) {
        $url = get_theme_mod("slider_image_$i", '');
        if ($url) {
            $gambar[] = $url;
        }
    }
    if (!$gambar) {
        foreach ((array) get_theme_mod('slider_repeat', []) as $baris) {
            $url = is_array($baris) ? ($baris['imgslider'] ?? '') : '';
            // Kirki bisa menyimpan id lampiran, bukan URL.
            if (is_numeric($url)) {
                $url = wp_get_attachment_url((int) $url);
            }
            if ($url) {
                $gambar[] = $url;
            }
        }
    }
    return $gambar;
}

/**
 * CSS dari pengaturan di atas. Dicetak di akhir <head> seperti Kirki dulu, supaya
 * menang atas CSS Bootstrap tema induk.
 */
add_action('wp_head', function () {
    $utama = sanitize_hex_color(get_theme_mod('velocity_toko30_warna_utama', '#1e73be')) ?: '#1e73be';
    $sekunder = sanitize_hex_color(get_theme_mod('velocity_toko30_warna_sekunder', '#333333')) ?: '#333333';
    [$judul, $teks] = velocity_toko30_font();
    $css = ($teks ? 'body{font-family:"' . $teks . '",sans-serif;}' : '')
        . ($judul ? '#primary-menu>li>a,.widget-title,.footer-widget .widget-title{font-family:"' . $judul . '",sans-serif;}' : '')
        . ':root{--velocitytoko-color-main:' . $utama . ';--velocitytoko-color-secondary:' . $sekunder . ';}'
        . '.bg-colortheme,.page-item.active .page-link{background-color:' . $utama . ';border-color:' . $utama . ';}'
        . '.bg-colortheme:hover{background-color:' . $sekunder . ';border-color:' . $sekunder . ';}'
        . '#primary-menu>li>a:hover,#primary-menu>li.current-menu-item>a,#primary-menu>li.current-menu-ancestor>a{color:' . $utama . ';}';

    $latar = get_theme_mod('background_themewebsite');
    if (is_array($latar)) {
        $aturan = [];
        foreach (['background-color', 'background-image', 'background-repeat', 'background-position', 'background-size', 'background-attachment'] as $prop) {
            $nilai = trim((string) ($latar[$prop] ?? ''));
            if ($nilai === '') {
                continue;
            }
            $aturan[] = $prop . ':' . ($prop === 'background-image' ? 'url(' . esc_url($nilai) . ')' : esc_attr($nilai));
        }
        if ($aturan) {
            $css .= 'body{' . implode(';', $aturan) . ';}';
        }
    }
    echo '<style id="velocity-toko30-customizer">' . wp_strip_all_tags($css) . '</style>' . "\n";
}, 100);
