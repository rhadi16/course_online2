$("#logout").on("click", function () {
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
});
// hapus materi
function hapusMateri(nama, url) {
	Swal.fire({
		title: 'Anda Yakin?',
		text: "Ingin menghapus Materi " + nama,
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

var menu_btn = document.querySelector("#menu-btn");
var sidebar = document.querySelector("#sidebar");
var container = document.querySelector(".my-container");
menu_btn.addEventListener("click", () => {
	sidebar.classList.toggle("active-nav");
	container.classList.toggle("active-cont");
});

// set datatable
$(document).ready(function () {
    $('#mapel').DataTable();
});
