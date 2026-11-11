<?php defined('BASEPATH') OR exit('No direct script access allowed');


function user_login()
{
    $CI =& get_instance();
    return $CI->session->userdata('user');
}


function need_role($role)
{
    $u = user_login();
    if (!$u || $u['role'] !== $role) {
        $CI =& get_instance();
        $CI->session->set_flashdata('error', 'Silakan login dulu sebagai ' . $role . '.');
        redirect('login');
    }
}

function rupiah($n)
{
    return 'Rp ' . number_format((float)$n, 0, ',', '.');
}

function badge_status($s)
{
    $warna = array(
        'Menunggu Pembayaran' => 'warning',
        'Menunggu Verifikasi' => 'info',
        'Berhasil'            => 'success',
        'Dibatalkan'          => 'danger',
    );
    $c = isset($warna[$s]) ? $warna[$s] : 'secondary';
    return '<span class="badge bg-' . $c . '">' . htmlspecialchars($s) . '</span>';
}

function info_bayar()
{
    return array(
        'Transfer Bank' => array(
            'label'  => 'Transfer ke rekening',
            'nomor'  => 'BCA 1234567890',
            'atas'   => 'a.n. TiketKonser',
            'catatan' => 'Transfer sesuai total bayar, lalu upload bukti transfer.',
        ),
        'Alfamart' => array(
            'label'  => 'Kode pembayaran Alfamart',
            'nomor'  => '8801234567890',
            'atas'   => 'a.n. TiketKonser',
            'catatan' => 'Sebutkan kode ini ke kasir Alfamart, bayar sesuai total, lalu foto struknya.',
        ),
        'Indomaret' => array(
            'label'  => 'Kode pembayaran Indomaret',
            'nomor'  => '8809876543210',
            'atas'   => 'a.n. TiketKonser',
            'catatan' => 'Sebutkan kode ini ke kasir Indomaret, bayar sesuai total, lalu foto struknya.',
        ),
    );
}