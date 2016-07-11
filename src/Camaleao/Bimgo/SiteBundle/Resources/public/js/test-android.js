function testeEstados() {

	$.ajax({
		dataType: "json",
		type: 'POST',
		url: 'newestado',
		data: {"jsonObject":{"estado":{"nome":"Clevao","uf":"CC"}}},
		success: function(response) {
			console.log(response);		   
		}
	});
}
