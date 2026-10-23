// Inisialisasi DataTables untuk semua tabel .data-table di panel admin.
// Tabel .table-cards berubah jadi kartu di layar kecil lewat CSS (console.css),
// jadi ekstensi Responsive (yang menyembunyikan kolom) dimatikan untuk tabel itu.
$('document').ready(function () {
	$('.data-table').each(function () {
		var $t = $(this);
		var cards = $t.hasClass('table-cards');
		$t.DataTable({
			scrollCollapse: false,
			autoWidth: false,
			responsive: !cards,
			searching: true,
			ordering: true,
			order: [], // pertahankan urutan dari server (umumnya terbaru dulu)
			lengthChange: true,
			paging: true,
			info: true,
			pageLength: parseInt($t.data('page-length'), 10) || 10,
			dom: "<'dt-top'<'dt-length'l><'dt-search'f>><'dt-scroll't><'dt-bottom'<'dt-info'i><'dt-pages'p>>",
			columnDefs: [{
				targets: 'datatable-nosort',
				orderable: false,
			}],
			lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Semua']],
			language: {
				info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
				infoEmpty: 'Tidak ada data',
				infoFiltered: '(disaring dari _MAX_)',
				lengthMenu: 'Tampilkan _MENU_',
				search: '',
				searchPlaceholder: $t.data('search') || 'Cari data…',
				zeroRecords: '<div class="empty-state"><i class="bi bi-search"></i>Tidak ada data yang cocok dengan pencarian.</div>',
				emptyTable: '<div class="empty-state"><i class="bi bi-inbox"></i>' + ($t.data('empty') || 'Belum ada data.') + '</div>',
				paginate: {
					next: '<i class="bi bi-chevron-right"></i>',
					previous: '<i class="bi bi-chevron-left"></i>'
				}
			},
		});
	});
});
