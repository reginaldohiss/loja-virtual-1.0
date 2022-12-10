window.onload = function(){
	PagSeguroDirectPayment.setSessionId(sessionId);
}

function selectPg() {
	var pgCode = document.getElementById("pg_form").value;
	if(pgCode == 'CREDIT_CARD') {
		PagSeguroDirectPayment.getPaymentMethods({
			amount:valor,
			success:function(json){
				var cartoes = json.paymentMethods.CREDIT_CARD.options;
				var cDisponiveis = ['VISA', 'MASTERCARD', 'AMEX', 'HIPERCARD'];
				var html = '';

				for(var i in cDisponiveis) {
					if(cartoes[cDisponiveis[i]].status == "AVAILABLE") {
						html += '<img onclick="selecionarBandeira(this)" data-bandeira="'+cartoes[cDisponiveis[i]].name+'" src="https://stc.pagseguro.uol.com.br'+cartoes[cDisponiveis[i]].images.MEDIUM.path+'" border="0" />';
					}
				}

				document.getElementById("bandeiras").innerHTML = html;
				document.getElementById("cc").style.display = "block";

			},
			error:function(e){console.log(e)}
		});
	}
}

function selecionarBandeira(obj) {
	var bandeira = obj.getAttribute("data-bandeira");
	document.getElementById("bandeira").value = bandeira.toLowerCase();
	document.getElementById("bandeiras").innerHTML = obj.outerHTML;

	PagSeguroDirectPayment.getInstallments({
		amount:valor,
		brand:bandeira.toLowerCase(),
		success:function(json){
			var p = json.installments[bandeira.toLowerCase()];
			var options = '';

			for(var i in p) {
				if(p[i].interestFree == true) {
					var juros = "Sem Juros";
				} else {
					var juros = "Com Juros";
				}
				var frase = p[i].quantity+"x de R$ "+p[i].installmentAmount+" ("+juros+")";
				options += '<option value="'+p[i].quantity+';'+p[i].installmentAmount+';'+p[i].interestFree+'">'+frase+'</option>';
			}

			document.getElementById("parc").innerHTML = options;
			document.getElementById("cardinfo").style.display = "block";
		},
		error:function(e){console.log(e)}
	});

}

function pagar() {

	if(formOk == false) {
		var pgCode = document.getElementById("pg_form").value;
		document.getElementById("shash").value = PagSeguroDirectPayment.getSenderHash();

		if(pgCode == 'CREDIT_CARD') {
			var cartao = document.getElementById("cartao").value;
			var bandeira = document.getElementById("bandeira").value;
			var cvv = document.getElementById("cvv").value;
			var validade = document.getElementById("validade").value.split('/');

			PagSeguroDirectPayment.createCardToken({
				cardNumber:cartao,
				brand:bandeira,
				cvv:cvv,
				expirationMonth:validade[0],
				expirationYear:validade[1],
				success:function(json){
					var token = json.card.token;
					document.getElementById("ctoken").value = token;
					formOk = true;
					document.getElementById("form").submit();
				},
				error:function(e){console.log(e)}
			});

			return false;

		}
	}

	return true;

}









