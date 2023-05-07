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

var menu_btn = document.querySelector("#menu-btn");
var sidebar = document.querySelector("#sidebar");
var container = document.querySelector(".my-container");
menu_btn.addEventListener("click", () => {
	sidebar.classList.toggle("active-nav");
	container.classList.toggle("active-cont");
});
