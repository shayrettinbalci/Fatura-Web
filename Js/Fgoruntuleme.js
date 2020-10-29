$(document).ready( function() {

	//Görüntüleme table, ek açıklama
	var gtable = $('#goruntuleme_table').DataTable({
		columnDefs: [ {
			targets: 11,
			render: function ( data, type, row ) {
				return type === 'display' && data.length > 10 ?
				data.substr( 0, 10 ) +'…' :
				data;
			}
		} ],
		"aoColumns": [
		null,
		null,
		null,
		null,
		null,
		null,
		{ "sType": "date-tr" },
		null,
		null,
		null,
		null,
		null,
		null,
		null
		],
		dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
		"<'row'<'col-sm-12'tr>>" +
		"<'row'<'col-sm-5'i><'col-sm-7'p>><'clear'>",
		lengthMenu: 
		[ 25, 10, 50, 100 ],
		buttons:[
		{
			extend: 'excelHtml5',
			title: 'Fatura Tablosu',
			exportOptions: {
				columns: [ 0,1,2,3,4,5,6,7,8,9,10,11  ],
				orthogonal: {
                    display: ':null'
                }  
			}
		},
		{
			extend: 'print',
			title: 'Fatura Tablosu',
			text: 'Yazdır',
			exportOptions: {
				columns: [ 0,1,2,3,4,5,6,7,8,9,10,11  ],
				orthogonal: {
                    display: ':null'
                }  
			}
		},
		'pageLength',
		],
		scroolY: "500px",
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
	// gtable.columns.adjust().draw();
	//Ek açıklama modal
	$(document).on('click','#goruntuleme_table tbody tr .aciklamaClm', function () {
		var cell = gtable.cell(this).data();
		$('#generalModal').find('.modal-body').html(''+cell+'');
		$('#generalModal').find('.modal-footer').html('\
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>');
		$('#generalModal').modal('show');
	} );

	//Search draw when key-up
	$('#araTarihTutar').on('click', function() {
		gtable.draw();
	});

	//Individual search
	$('#goruntuleme_table tfoot tr .search').each( function (i) {
		$(this).html( '<input type="text" class="form-control" data-index="'+i+'" />' );
	} );
	$( gtable.table().container() ).on( 'keyup', 'tfoot input', function () {
		gtable
		.column( $(this).data('index') )
		.search( this.value )
		.draw();
	} );

	//Onay table, ek açıklama
	var otable = $('#onay_table').DataTable({
		columnDefs: [ 
		{
			targets: 11,
			render: function ( data, type, row ) {
				return type === 'display' && data.length > 10 ?
				data.substr( 0, 10 ) +'…' :
				data;
			}
		} ],
		"aoColumns": [
		null,
		null,
		null,
		null,
		null,
		null,
		null,
		{ "sType": "date-tr" },
		null,
		null,
		null,
		null,
		null,
		null,
		null,
		null,
		null,
		null
		],
		dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
		"<'row'<'col-sm-12'tr>>" +
		"<'row'<'col-sm-5'i><'col-sm-7'p>><'clear'>",		
		lengthMenu: 
		[ 25, 10, 50, 100 ],
		buttons:[
		{
			extend: 'excelHtml5',
			title: 'Fatura Tablosu',
			exportOptions: {
				columns: [ 0,1,2,3,4,5,6,7,8,9,10,11  ],
				orthogonal: {
                    display: ':null'
                }  
			}
		},
		{
			extend: 'print',
			title: 'Fatura Tablosu',
			text: 'Yazdır',
			exportOptions: {
				columns: [ 0,1,2,3,4,5,6,7,8,9,10,11  ],
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
	//Ek açıklama modal
	$(document).on('click','#onay_table tbody tr .aciklamaClm', function () {
		var cell = otable.cell(this).data();
		$('#generalModal').find('.modal-body').html(''+cell+'');
		$('#generalModal').find('.modal-footer').html('\
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>');
		$('#generalModal').modal('show');
	} );
	//PDF Upload submit
	$(document).on('change',"#onay_table tbody tr input[name='fileToUpload']",function(){
		$(this).parent().parent().submit();
	});

	//Fatura onay alert
	$(document).on('click','#onay_table tbody tr .FonayClm', function () {
		//Getting form text for deleting user
		var selectedRow = otable.row(this).node();
		var faturaNoVal = $(selectedRow).find('.faturaNo_input .form-control').val();
		var faturaNo = "<input type=\"hidden\" class=\"onayID\" value=\""+faturaNoVal+"\" name=\"faturaNoName\"></input>"
		var faturaID = $(selectedRow).find('.FonayClm form .onayID').prop('outerHTML');
		var kullaniciAdi = $(selectedRow).find('.FonayClm form .kullaniciAdi').prop('outerHTML');
		//Filling Modal
		$('#generalModal').find('.modal-header').html('<form action="SourcePHP/faturaS.php" method="post">'
			+faturaNo+faturaID+kullaniciAdi+'</form>'+
			'<button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>\
			');
		$('#generalModal').find('.modal-body').html('Faturayı onaylamak istiyor musunuz?');
		$('#generalModal').find('.modal-footer').html('\
			<button type="button" id="submit" class="btn btn-primary">Onayla</button>\
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>\
			');		
		$('#generalModal').modal('show');
	} );	

	//'input[type=text].sitebg'
	$(document).on('focusout', '.faturaNo_input input[type=text].form-control', function(){
		//$(this).val('sex');
	});

	//Fatura sil alert
	$(document).on('click','#onay_table tbody tr .FsilClm', function () {
		//Getting form text for deleting user
		var form = otable.cell(this).node();
		form = $(form).find('form').prop('outerHTML');
		//Filling Modal
		$('#generalModal').find('.modal-header').html(form+
			'<button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>');
		$('#generalModal').find('.modal-body').html('Faturayı silmek istiyor musunuz?');
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
		localStorage.setItem('Fgirme_Tab', $(e.target).attr('href'));
	});
	var Fgirme_Tab = localStorage.getItem('Fgirme_Tab');
	if(Fgirme_Tab){
		$('#pills-tab a[href="' + Fgirme_Tab + '"]').tab('show');
	}

	function cleanPrice(tutar){
		tutar = tutar.replace(/[.\s]/g,'');
		tutar = tutar.replace(/[,\s]/g,'.');
		return tutar;
	}
	$.fn.setCursorPosition = function (pos) {
		this.each(function (index, elem) {
			if (elem.setSelectionRange) {
				elem.setSelectionRange(pos, pos);
			} else if (elem.createTextRange) {
				var range = elem.createTextRange();
				range.collapse(true);
				range.moveEnd('character', pos);
				range.moveStart('character', pos);
				range.select();
			}
		});
		return this;
	};
	function getCursorPosition(el) {
		var start = 0, end = 0, normalizedValue, range,
		textInputRange, len, endRange;

		if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
			start = el.selectionStart;
			end = el.selectionEnd;
		} else {
			range = document.selection.createRange();

			if (range && range.parentElement() == el) {
				len = el.value.length;
				normalizedValue = el.value.replace(/\r\n/g, "\n");


				textInputRange = el.createTextRange();
				textInputRange.moveToBookmark(range.getBookmark());


				endRange = el.createTextRange();
				endRange.collapse(false);

				if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
					start = end = len;
				} else {
					start = -textInputRange.moveStart("character", -len);
					start += normalizedValue.slice(0, start).split("\n").length - 1;

					if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
						end = len;
					} else {
						end = -textInputRange.moveEnd("character", -len);
						end += normalizedValue.slice(0, end).split("\n").length - 1;
					}
				}
			}
		}

		return {
			start: start,
			end: end
		};
	}
	function setPriceCursorPos(input,Pos,keyupValue){
		if(!(Pos % 4)){
			if(keyupValue == 8){
				$(input).focus().setCursorPosition(Pos-1);
			} else{
				$(input).focus().setCursorPosition(Pos+1);
			}
		} else {
			$(input).focus().setCursorPosition(Pos);
		}
	}

	$('#minTutar').keyup( function(event){
		var key = event.which || event.keyCode;
		if ( key >= 37 && key <= 40) //arrow keys
		{
			event.preventDefault();
			return false;
		}

		var tutar = cleanPrice($(this).val());//make float format for currency format
		var formatObj = new Intl.NumberFormat('tr', { style: 'currency', currency: 'TRY' });
		var formatedPrice = formatObj.format(tutar).replace(/[₺\s]/g,'');
		var formatedFloat = cleanPrice(formatedPrice);//for NaN and default 0 value check
		var cursorPos = getCursorPosition(this);

		if(isNaN(formatedFloat)||formatedFloat==0){
			$(this).val('');
		} else{
			$(this).val(formatedPrice);
			//preventing cursor position reset
			setPriceCursorPos(this,cursorPos.start,key);
		}
	});

	$('#maxTutar').keyup( function(event){
		var key = event.which || event.keyCode;
		if ( key >= 37 && key <= 40) //arrow keys
		{
			event.preventDefault();
			return false;
		}
		var tutar = cleanPrice($(this).val());//make float format for currency format
		var formatObj = new Intl.NumberFormat('tr', { style: 'currency', currency: 'TRY' });
		var formatedPrice = formatObj.format(tutar).replace(/[₺\s]/g,'');
		var formatedFloat = cleanPrice(formatedPrice);//for NaN and default 0 value check
		var cursorPos = getCursorPosition(this);

		if(isNaN(formatedFloat)||formatedFloat==0){
			$(this).val('');
		} else{
			$(this).val(formatedPrice);
			//preventing cursor position reset
			setPriceCursorPos(this,cursorPos.start,key);
		}
	});		

	$.fn.dataTable.ext.search.push(
		function( settings, data, dataIndex ) {
			//Tutar varibles
			var minTutar = parseFloat( cleanPrice($('#minTutar').val()), 10 );
			var maxTutar = parseFloat( cleanPrice($('#maxTutar').val()), 10 );
			var tutar = parseFloat( cleanPrice(data[6] )) || 0;
			//Date varibles
			var baslangicTarih = $('#baslangicTarih').val();
			var bitisTarih = $('#bitisTarih').val();
			var tarih = data[5] || 0;

	
			//reversing date for number format
			// baslangicTarih = baslangicTarih.split("/").reverse().join("/");
			// bitisTarih = bitisTarih.split("/").reverse().join("/");
			tarih = tarih.split("/").reverse().join("-");		
			console.log(baslangicTarih);
			console.log(tarih);
			console.log('\n');
			//removing slashes
			baslangicTarih = Number(new Date(baslangicTarih));
			bitisTarih = Number(new Date(bitisTarih));
			tarih = Number(new Date(tarih));
	


			if(((isNaN(minTutar) && isNaN(maxTutar)) ||
				(isNaN(minTutar) && tutar <= maxTutar) ||
				(minTutar <= tutar && isNaN(maxTutar)) ||
				(minTutar <= tutar && tutar <= maxTutar))
				&&
				((isNaN(baslangicTarih) && isNaN(bitisTarih)) ||
					(isNaN(baslangicTarih) && tarih <= bitisTarih) ||
					(baslangicTarih <= tarih && isNaN(bitisTarih)) ||
					(baslangicTarih <= tarih && tarih <= bitisTarih))
				)
			{
				return true;
			}
			return false;
		}
		);

	$.extend( $.fn.dataTableExt.oSort, {
		"date-tr-pre": function ( a ) {
			var trDatea = a.split('/');
			return (trDatea[2] + trDatea[1] + trDatea[0]) * 1;
		},

		"date-tr-asc": function ( a, b ) {
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},

		"date-tr-desc": function ( a, b ) {
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		}
	} );
} );