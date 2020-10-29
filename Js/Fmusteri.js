$(document).ready( function () {


	var mtable = $('#musteri_table').DataTable({
		dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
		"<'row'<'col-sm-12'tr>>" +
		"<'row'<'col-sm-5'i><'col-sm-7'p>><'clear'>",		
		lengthMenu: 
		[ 25, 10, 50, 100 ],
		buttons:[
		{
			extend: 'excelHtml5',
			title: 'Müşteri Tablosu',
			exportOptions: {
				columns: [ 0,1,2 ],
				orthogonal: {
					display: ':null'
				}  
			}
		},
		{
			extend: 'print',
			title: 'Müşteri Tablosu',
			text: 'Yazdır',
			exportOptions: {
				columns: [ 0,1,2 ],
				orthogonal: {
					display: ':null'
				}  
			}
		},
		'pageLength'
		],
		language: {
			select: {
				rows: {
					_: "",
					0: "*Seçmek için kutuya tıklayın"
				}
			},
			search: "Ara:",
			lengthMenu: "_MENU_",
			zeroRecords: "Hiç kayıt bulunalamadı.",
			info: "_TOTAL_ kayıttan _START_ ile _END_ arasındakiler gösteriliyor",
			infoEmpty: "",
			infoFiltered: "(_MAX_ toplam kayıttan filtrelendi)",
			buttons: {
				pageLength: {
					_: "Sayfada %d"
				}
			},
			paginate: {
				first: "İlk",
				last: "Son",
				next: "İleri",
				previous: "Geri"
			}
		}
	});

	$(document).on('click','#musteri_table tbody tr .silClm', function () {
		//Getting form text for deleting user
		var form = mtable.cell(this).node();
		form = $(form).find('form').prop('outerHTML');
		//Filling Modal
		$('#generalModal').find('.modal-header').html(form+
			'<button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>');
		$('#generalModal').find('.modal-body').html('Müşteriyi silmek istiyor musunuz?');
		$('#generalModal').find('.modal-footer').html('\
			<button type="button" id="submit" class="btn btn-primary">Sil</button>\
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>\
			');		
		$('#generalModal').modal('show');
		
	} );
	$(document).on('click','#submit',function(e) {
		//Summit form inside modal
		$('#generalModal .modal-header').find('form').submit();
	});
	
	//active selected tab on page reflesh
	$('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
		localStorage.setItem('Fmusteri_Tab', $(e.target).attr('href'));
	});
	var Fmusteri_Tab = localStorage.getItem('Fmusteri_Tab');
	if(Fmusteri_Tab){
		$('#pills-tab a[href="' + Fmusteri_Tab + '"]').tab('show');
	}


});