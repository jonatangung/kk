{{-- Sidebar/menu navigasi. Menu yang tampil menyesuaikan hak akses role user (App\Support\RolePermission) --}}
<?php
    $role = session('role');
    $canView = fn (string $resource) => \App\Support\RolePermission::boleh('view:' . $resource, $role);
    //----- navAktif: cek apakah URL saat ini cocok dengan salah satu pola menu
    //----- navClass: kembalikan class nav-link; menu aktif TANPA 'collapsed' (sesuai CSS .nav-link:not(.collapsed))
    $navAktif = function (array $pola): bool {
        foreach ($pola as $p) {
            if (request()->is($p)) {
                return true;
            }
        }
        return false;
    };
    $navClass = fn (array $pola) => 'nav-link' . ($navAktif($pola) ? '' : ' collapsed');
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="<?= $navClass(['home']) ?>" href="/home">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php if ($canView('pelanggan') || $canView('kendaraan') || $canView('mekanik') || $canView('jasa_servis') || $canView('supplier')) { ?>
        <li class="nav-heading">Menu Master Data</li>
        <?php } ?>

        <?php if ($canView('pelanggan')) { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['pelanggan', 'pelanggan/*', 'tplg', 'edit_pelanggan/*']) ?>" href="/pelanggan">
                <i class="bi bi-person"></i>
                <span>Data Pelanggan</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('kendaraan')) { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['kendaraan', 'kendaraan/*', 'tambah_kendaraan', 'tambah_kendaraan/*', 'edit_kendaraan/*']) ?>" href="/kendaraan">
                <i class="bi bi-car-front"></i>
                <span>Data Kendaraan</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('mekanik')) { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['mekanik', 'mekanik/*', 'tkry', 'edit_mekanik/*']) ?>" href="/mekanik">
                <i class="bi bi-tools"></i>
                <span>Data Mekanik</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('jasa_servis')) { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['jasa-servis', 'jasa-servis/*', 'tambah_jasa_servis', 'edit_jasa_servis/*']) ?>" href="/jasa-servis">
                <i class="bi bi-wrench-adjustable"></i>
                <span>Data Jasa Servis</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('supplier')) { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['supplier', 'supplier/*', 'tambah_supplier', 'edit_supplier/*']) ?>" href="/supplier">
                <i class="bi bi-truck"></i>
                <span>Data Supplier</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('servis') || $canView('pembayaran')) { ?>
        <li class="nav-heading">Menu Transaksi</li>
        <?php } ?>

        <?php if ($canView('servis')) { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['servis', 'servis/*', 'tambah_servis', 'edit_servis/*']) ?>" href="/servis">
                <i class="bi bi-cart-check"></i>
                <span>Transaksi Servis</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('pembayaran')) { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['pembayaran', 'pembayaran/*', 'edit_pembayaran/*']) ?>" href="/pembayaran">
                <i class="bi bi-cash-stack"></i>
                <span>Pembayaran</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('laporan_servis') || $canView('laporan_pendapatan')) { ?>
        <li class="nav-heading">Menu Laporan</li>
        <?php } ?>

        <?php if ($canView('laporan_servis')) { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['laporan-servis', 'laporan-servis/*']) ?>" href="/laporan-servis">
                <i class="bi bi-file-earmark-text"></i>
                <span>Laporan Servis</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('laporan_pendapatan')) { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['laporan-pendapatan', 'laporan-pendapatan/*']) ?>" href="/laporan-pendapatan">
                <i class="bi bi-bar-chart"></i>
                <span>Laporan Pendapatan</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('stok_barang')) { ?>
        <li class="nav-heading">Menu Inventaris</li>

        <li class="nav-item">
            <a class="<?= $navClass(['stok-barang', 'stok-barang/*', 'input_stok_barang']) ?>" href="/stok-barang">
                <i class="bi bi-box-seam"></i>
                <span>Stok Barang</span>
            </a>
        </li>
        <?php } ?>

        <?php if ($canView('pengguna')) { ?>
        <li class="nav-heading">Pengaturan</li>

        <li class="nav-item">
            <a class="<?= $navClass(['pengguna', 'pengguna/*', 'tambah_users', 'tambah_users/*', 'edit_users/*']) ?>" href="/pengguna">
                <i class="bi bi-people"></i>
                <span>Manajemen Pengguna</span>
            </a>
        </li>
        <?php } ?>

        <?php if (session('role') === 'admin') { ?>
        <li class="nav-item">
            <a class="<?= $navClass(['setting', 'setting/*']) ?>" href="/setting">
                <i class="bi bi-sliders"></i>
                <span>Setting</span>
            </a>
        </li>
        <?php } ?>

        <li class="nav-item">
            <a class="<?= $navClass(['profil']) ?>" href="/profil">
                <i class="bi bi-gear"></i>
                <span>Pengaturan Profil</span>
            </a>
        </li>

    </ul>
</aside>
