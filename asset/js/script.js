$(document).ready(function () {
    function loadNumCart() {
        $.ajax({
            url: "cart_ajax.php",
            method: "get",
            data: {
                getcart: 'cart_item'
            },
            success: function (data) {
                $('.label-item-cart').html(data);
            }
        });
    };

    function loadTotalPrice() {
        $.ajax({
            url: "cart_ajax.php",
            method: "get",
            data: {
                getTotal: 'total'
            },
            success: function (data) {
                $('.total').html(data + ' IDR');
            }
        });
    };

    function loadData(data, target) {
        $.ajax({
            url: 'cart_ajax.php',
            method: 'get',
            data: {
                loadData: data
            },
            success: function (data) {
                $(target).html(data);
            }
        })
    }

    function notNumCart() {
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Kamu ingin menghapus semua is cart kamu!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak jadi!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'cart_ajax.php',
                    method: 'get',
                    data: {
                        delAll: 'deleteAll'
                    },
                    success: function (data) {
                        $('.message').html(data);
                        loadData('cart', '.data-cart')
                    }
                })
            }
        })
    }
    $('.tambah-cart').on('click', function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'cart_ajax.php',
            method: 'post',
            data: {
                id: id
            },
            success: function (data) {
                $('.message').html(data);
                loadNumCart();
            }
        });
    });
    loadNumCart();
    loadTotalPrice();
    $('#delete-all').on('click', function () {
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Kamu ingin menghapus semua is cart kamu!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak jadi!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'cart_ajax.php',
                    method: 'get',
                    data: {
                        delAll: 'deleteAll'
                    },
                    success: function (data) {
                        $('.message').html(data);
                        loadData('cart', '.data-cart')
                    }
                })
            }
        })
    })
    $('.delete-single').on('click', function (e) {
        e.preventDefault();
        let href = $(this).attr('href');
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Kamu ingin menghapus product di cart kamu!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak jadi!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    })
    $('.form-qty').on('change', function () {
        let $el = $(this).closest('tr');
        let price = $el.find('.price').html();
        let id = $el.find('.delete-single').data('id');
        let qty = $(this).val();
        $.ajax({
            url: 'cart_ajax.php',
            method: 'get',
            cache: false,
            dataType: 'json',
            data: {
                changeqty: 'cangeqty',
                id: id,
                price: price,
                qty: qty
            },
            success: function (data) {
                $el.find('.total-price').html(data.total_price + ' IDR');
                loadTotalPrice();
            }
        })
    })
    $('#placeorder').on('click', function (e) {
        e.preventDefault();
        if (!$('#nama').val() == '' && !$('#email').val() == '' && !$('#phone').val() == '' && !$('#address').val() == '') {
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Ingin melanjutkan pembayaran Check terlbeih dahulu!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak jadi!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'cart_ajax.php',
                        method: 'post',
                        data: $('form').serialize() + "&action=order",
                        success: function (data) {
                            $("#order").html(data);
                            loadNumCart();
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'question',
                title: 'Oops...',
                text: 'Terjadi kesalahan! Mohon Lengkapi Form'
            })
        }
    });
});