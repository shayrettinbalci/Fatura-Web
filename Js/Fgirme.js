$(document).ready( function () {
	//all aciklama modal
	var ptable = $('#PDF_table').DataTable({
		columnDefs: [ {
			targets: 11,
			render: function ( data, type, row ) {
				return type === 'display' && data.length > 10 ?
				data.substr( 0, 10 ) +'…' :
				data;
			} 
		}],
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
				columns: [ 0,1,2,3,4,5,6,7,8,9,10,11 ],
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

	$(document).on('click','#PDF_table tbody tr .aciklamaClm', function () {
		var cell = ptable.cell(this).data();
		$('#generalModal').find('.modal-body').html(''+cell+'');
		$('#generalModal').find('.modal-footer').html('\
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>');
		$('#generalModal').modal('show');
	} );

	$(document).on('click','#PDF_table tbody tr .iptalClm1', function () {
		var selectedRow = ptable.row(this).node();
		var faturaID = $(selectedRow).find('.iptalClm1 form .Iptal_faturaID').prop('outerHTML');
		var kullaniciAdi = $(selectedRow).find('.iptalClm1 form .Iptal_kullaniciAdi').prop('outerHTML');

		$('#iptalModal').find('.modal-body').html('<form action="SourcePHP/faturaS.php" method="POST" id="iptalSubmitText" class="iptalSubmitAll">\
			<div class="form-group mx-auto">\
			<label for="AciklamaIptal">İptal Nedeni:</label>\
			<textarea type="text" cols="25" maxlength="50" id="AciklamaIptal" class="form-control" name="istek_iptal"/></textarea>'
			+faturaID+kullaniciAdi+
			'</div></form>');
		$('#iptalModal').modal('show');
	} );

	$(document).on('click','#iptalSubmit',function(e) {
		//Summit form inside modal
		$('#iptalModal .modal-body').find('form').submit();
	});

	var ontable = $('#onaylanmayan_table').DataTable({
		columnDefs: [ {
			targets: 10,
			render: function ( data, type, row ) {
				return type === 'display' && data.length > 10 ?
				data.substr( 0, 10 ) +'…' :
				data;
			}
		}],
		"aoColumns": [
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
				columns: [ 0,1,2,3,4,5,6,7,8,9,10 ],
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
				columns: [ 0,1,2,3,4,5,6,7,8,9,10 ],
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

	$(document).on('click','#onaylanmayan_table tbody tr .aciklamaClm', function () {
		var cell = ontable.cell(this).data();
		$('#generalModal').find('.modal-body').html(''+cell+'');
		$('#generalModal').find('.modal-footer').html('\
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>');
		$('#generalModal').modal('show');
	} );

	$(document).on('click','#onaylanmayan_table tbody tr .iptalClm2', function () {
		var selectedRow = ontable.row(this).node();
		var faturaID = $(selectedRow).find('.iptalClm2 form .Iptal_faturaID').prop('outerHTML');
		var kullaniciAdi = $(selectedRow).find('.iptalClm2 form .Iptal_kullaniciAdi').prop('outerHTML');

		$('#iptalModal').find('.modal-body').html('<form action="SourcePHP/faturaS.php" method="POST" id="iptalSubmitText" class="iptalSubmitAll">\
			<div class="form-group mx-auto">\
			<label for="AciklamaIptal">İptal Nedeni:</label>\
			<textarea type="text" cols="25" maxlength="50" id="AciklamaIptal" class="form-control" name="istek_iptal"/></textarea>'
			+faturaID+kullaniciAdi+
			'</div></form>');
		$('#iptalModal').modal('show');
	} );

	// $(document).on('focusout', '#iptalSubmitText textarea[type=text].form-control', function(){});

	$(document).on('click','#iptalSubmit',function(e) {
		//Summit form inside modal
		$('#iptalModal .modal-body').find('form').submit();
	});

	// $(document).on('click','#iptalSubmit',function(e) {
	// 	//Summit form inside modal
	// 	$(".iptalSubmitAll").trigger('submit'); 
	// });

	//active selected tab on page reflesh
	$('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
		localStorage.setItem('Fgoruntuleme_Tab', $(e.target).attr('href'));
	});
	var Fgoruntuleme_Tab = localStorage.getItem('Fgoruntuleme_Tab');
	if(Fgoruntuleme_Tab){
		$('#pills-tab a[href="' + Fgoruntuleme_Tab + '"]').tab('show');
	}
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
	function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
  	var a, b, i, val = this.value;
  	/*close any already open lists of autocompleted values*/
  	closeAllLists();
  	if (!val) { return false;}
  	currentFocus = -1;
  	/*create a DIV element that will contain the items (values):*/
  	a = document.createElement("DIV");
  	a.setAttribute("id", this.id + "autocomplete-list");
  	a.setAttribute("class", "autocomplete-items");
  	/*append the DIV element as a child of the autocomplete container:*/
  	this.parentNode.appendChild(a);
  	/*for each item in the array...*/
  	for (i = 0; i < arr.length; i++) {
  		/*check if the item starts with the same letters as the text field value:*/
  		if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
  			/*create a DIV element for each matching element:*/
  			b = document.createElement("DIV");
  			/*make the matching letters bold:*/
  			b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
  			b.innerHTML += arr[i].substr(val.length);
  			/*insert a input field that will hold the current array item's value:*/
  			b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
  			/*execute a function when someone clicks on the item value (DIV element):*/
  			b.addEventListener("click", function(e) {
  				/*insert the value for the autocomplete text field:*/
  				inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
  			a.appendChild(b);
  		}
  	}
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
  	var x = document.getElementById(this.id + "autocomplete-list");
  	if (x) x = x.getElementsByTagName("div");
  	if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
    } else if (e.keyCode == 13) {
    	/*If the ENTER key is pressed, prevent the form from being submitted,*/
    	e.preventDefault();
    	if (currentFocus > -1) {
    		/*and simulate a click on the "active" item:*/
    		if (x) x[currentFocus].click();
    	}
    }
});
  function addActive(x) {
  	/*a function to classify an item as "active":*/
  	if (!x) return false;
  	/*start by removing the "active" class on all items:*/
  	removeActive(x);
  	if (currentFocus >= x.length) currentFocus = 0;
  	if (currentFocus < 0) currentFocus = (x.length - 1);
  	/*add class "autocomplete-active":*/
  	x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
  	/*a function to remove the "active" class from all autocomplete items:*/
  	for (var i = 0; i < x.length; i++) {
  		x[i].classList.remove("autocomplete-active");
  	}
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
    	if (elmnt != x[i] && elmnt != inp) {
    		x[i].parentNode.removeChild(x[i]);
    	}
    }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
	closeAllLists(e.target);
});
}

} );

