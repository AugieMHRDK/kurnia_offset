function uuidv4() {
	return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
		(c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
	);
}

function formatRupiah(angka, prefix){
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	split   		= number_string.split(','),
	sisa     		= split[0].length % 3,
	rupiah     		= split[0].substr(0, sisa),
	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}

	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
}

function createNotif(icon, title, text, showConfirmButton, timer) {
	if(title == "Success"){
		title = "sukses";
	}
	if(title == "Warning"){
		title = "Peringatan";
	}
	Swal.fire({
		position: 'center',
		icon: icon,
		title: title,
		text: text,
		showConfirmButton: showConfirmButton,
		timer: timer
	})
}

function scrollSmoothToBottom (id) {
	var div = document.getElementById(id);
	$('#' + id).animate({
		scrollTop: div.scrollHeight - div.clientHeight
	}, 500);
}

function now(mode) {
	var date = new Date();

	var year = date.getFullYear();
	var month = date.getMonth() + 1;
	var day = date.getDate();
	var hours = date.getHours();
	var minutes = date.getMinutes();
	var seconds = date.getSeconds();
	if(hours < 10){
		hours = '0'+hours;
	}
	if(minutes < 10){
		minutes = '0'+minutes;
	}
	if(seconds < 10){
		seconds = '0'+seconds;
	}
	if(mode == 'time'){
		return hours + ":" + minutes + ":" + seconds;
	}
	if(mode == 'date'){
		return day + "-" + month + "-" + year;
	}
}