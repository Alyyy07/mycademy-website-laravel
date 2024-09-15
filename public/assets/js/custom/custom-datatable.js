$('[data-kt-check="true"]').on("change", function () {
    var isChecked = $(this).prop("checked");
    $(this)
        .closest("table")
        .find(".form-check-input")
        .each(function () {
            $(this).prop("checked", isChecked);
        });
});

$('[data-kt-menu-trigger="click"]').on('click', function(e) {
    e.preventDefault();

    var $menu = $(this).next('.menu');

    // Buka dropdown yang diklik
    if (!$menu.hasClass('show')) {
        $(this).addClass('show menu-dropdown');

        // Hitung tinggi tombol "Actions"
        var buttonHeight = $(this).outerHeight();

        // Set posisi dropdown di bawah tombol "Actions" dalam elemen induk relatif
        $menu.css({
            display: 'block',  // Pastikan dropdown terlihat
            position: 'absolute',
            top: buttonHeight + 'px', // Posisi tepat di bawah tombol
            left: '0px', // Sesuaikan posisi horizontal relatif terhadap tombol
            zIndex: 107 // Sesuaikan z-index agar dropdown muncul di atas konten lain
        });

        // Tambahkan class show ke dropdown
        $menu.addClass('show');
    } else {
        // Jika sudah terbuka, tutup dropdown
        $(this).removeClass('show menu-dropdown');
        $menu.removeClass('show').prop('style', '');
    }
});

// Klik di luar dropdown untuk menutup semua dropdown
$(document).on('click', function(e) {
    if (!$(e.target).closest('[data-kt-menu-trigger="click"], .menu').length) {
        $('.menu').removeClass('show').prop('style', '');
        $('[data-kt-menu-trigger="click"]').removeClass('show menu-dropdown');
    }
});

$('[data-action="search"]').on(
    'input',
    debounce(function () {
        const tableId = $('table').attr('id');
        if (window.LaravelDataTables[tableId]) {
            window.LaravelDataTables[tableId].search($(this).val()).draw();
        } else {
            console.error(`DataTable dengan ID ${tableId} tidak ditemukan.`);
        }
    }, 1000)
);