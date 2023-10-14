var users_list_table = document.querySelector("#Users_list");

if (users_list_table) {
	document.addEventListener("DOMContentLoaded", function () {
		let table = new DataTable("#Users_list", {
			ordering: false,
			info: false,
			paging: false,
			dom: '<"top"i>rt<"bottom"flp><"clear">',
		});
	});
}
