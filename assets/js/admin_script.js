// detail mapel guru
function selectGuru(id_mapels) {
	var id_mapel = $('#id_mapel'+id_mapels).val();
	var csrfName = $('#csrf').attr('name');
	var csrfHash = $('#csrf').val();
	console.log(csrfName + ' ' + csrfHash);
	$('#detail-guru'+id_mapels).text('');
	$(document).ready(function() {
		$.ajax({
			url: base_url,
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				mapel: id_mapel
			},
			dataType: 'json',
			success: function(rsp) {
				var len = rsp.data.length;
				if (len > 0) {
					rsp.data.map((gr) => {
						$('#detail-guru'+id_mapels).append(`
						<option value="${gr.id}">${gr.nama}</option>
						`);
					});
				} else {
					$('#detail-guru'+id_mapels).append('<option selected value="0">Pilih Guru</option>');
				}
				$('#csrf').val(rsp.valC);
				$('#csrf'+id_mapels).val(rsp.valC);
			},
			error: function(error) {
				console.log(error);
			}
		});
	})
}
// hapus kelas
function hapusKelas(nama, url) {
	Swal.fire({
		title: 'Anda Yakin?',
		text: "Ingin menghapus Kelas " + nama,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Ya'
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = url;
		}
	});
}
// hapus jadwal
function hapusJadwal(nama, url) {
	Swal.fire({
		title: 'Anda Yakin?',
		text: "Ingin menghapus Jadwal " + nama,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Ya'
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = url;
		}
	});
}
// hapus siswa
function hapusSiswa(nama, url) {
	Swal.fire({
		title: 'Anda Yakin?',
		text: "Ingin menghapus Siswa " + nama,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Ya'
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = url;
		}
	});
}
// hapus mapel
function hapusMapel(nama, url) {
	Swal.fire({
		title: 'Anda Yakin?',
		text: "Ingin menghapus Mata Pelajaran " + nama,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Ya'
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = url;
		}
	});
}
// set datatable
$(document).ready(function () {
    $('#mapel').DataTable();
});
// logout
function logout(url) {
	Swal.fire({
		title: "Anda Yakin?",
		text: "Ingin Logout?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#d33",
		cancelButtonColor: "#3085d6",
		confirmButtonText: "Ya",
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = url;
		}
	});
}
// hapus guru
function hapusGuru(nama, url) {
	Swal.fire({
		title: 'Anda Yakin?',
		text: "Ingin menghapus data guru " + nama,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Ya'
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = url;
		}
	});
}
// // mark pada saat search data
// function search(nips, namas, departs, searched) {
// 	let nip = document.getElementById(nips).innerHTML;
// 	let nama = document.getElementById(namas).innerHTML;
// 	let depart = document.getElementById(departs).innerHTML;

// 	let re = new RegExp(searched, "g"); // search for all instances

// 	let newNip = nip.replace(
// 		re,
// 		`<span class="text-bg-warning">${searched}</span>`
// 	);
// 	let newNama = nama.replace(
// 		re,
// 		`<span class="text-bg-warning">${searched}</span>`
// 	);
// 	let newDepart = depart.replace(
// 		re,
// 		`<span class="text-bg-warning">${searched}</span>`
// 	);

// 	document.getElementById(nips).innerHTML = newNip;
// 	document.getElementById(namas).innerHTML = newNama;
// 	document.getElementById(departs).innerHTML = newDepart;
// }
// // format number pada input text
// document.querySelectorAll("#gapok").forEach(
// 	(inp) =>
// 		new Cleave(inp, {
// 			numeral: true,
// 			numeralDecimalMark: "thousand",
// 			delimiter: ".",
// 		})
// );

document.addEventListener("DOMContentLoaded", function (event) {
	const showNavbar = (toggleId, navId, bodyId, headerId) => {
		const toggle = document.getElementById(toggleId),
			nav = document.getElementById(navId),
			bodypd = document.getElementById(bodyId),
			headerpd = document.getElementById(headerId);

		// Validate that all variables exist
		if (toggle && nav && bodypd && headerpd) {
			toggle.addEventListener("click", () => {
				// show navbar
				nav.classList.toggle("shows");
				// change icon
				toggle.classList.toggle("bx-x");
				// add padding to body
				bodypd.classList.toggle("body-pd");
				// add padding to header
				headerpd.classList.toggle("body-pd");
			});
		}
	};

	showNavbar("header-toggle", "nav-bar", "body-pd", "header");

	/*===== LINK ACTIVE =====*/
	// const linkColor = document.querySelectorAll(".nav_link");

	// function colorLink() {
	// 	if (linkColor) {
	// 		linkColor.forEach((l) => l.classList.remove("active"));
	// 		this.classList.add("active");
	// 	}
	// }
	// linkColor.forEach((l) => l.addEventListener("click", colorLink));

	// Your code to run since DOM is loaded and ready
});
