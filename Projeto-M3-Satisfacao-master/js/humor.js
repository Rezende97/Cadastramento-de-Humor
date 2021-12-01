function check(event) {

	// elemento
	const element = event.target;

	// filtra pelo radio
	if(element.type == 'radio') {

		var parent = document.getElementById("fields");					
		
		// index
		const index = element.dataset.select;

		// botão enviar humor
		const button = document.getElementById('submit');

		// card atual selecionado
		const card = document.getElementsByClassName('field')[index];

		// desabilita cards ao selecionar um deles
		enableOrDisableCards(true);

		// apresenta cursor
		// showOrRemoveCursor(card, 'run');
		showOrRemoveCursor(index, 'run');

		// desabilita botão de enviar humor
		disableButton(button, true);

		if (element.checked == true) {	

			// limpar texto do campo comentário
			clearComment();	

			// limpa background
			clearBackground(parent);

			// anima o card
			setAnimation(card);	

			// remove animação
			removeAnimation(card);
			
			// habilita cards
			window.setTimeout(function() {
				// habilita todos cards novamente
				enableOrDisableCards(false);	

				// configura cursor padrão
				showOrRemoveCursor(card, 'stop');

				// habilita botão 
				disableButton(button, false);					
			}, 1500);		
		}

	}

	
}

// limpar comentário após selecionar humor
function clearComment() {
	document.getElementById('comment').value = '';
}

// seta estado static para todos os cards, definindo uma cor padrão de fundo
function clearBackground(element) {
	for(var i = 0; i < element.children.length; i++){
	    element.children[i].classList.remove('selected');
	    element.children[i].classList.add('static');
	}
}

// habilita ou desabilita botão de enviar humor
function disableButton(button, status) {
	button.disabled = status;
}

function showOrRemoveCursor(index, command) {

	if(command == 'run') {
		Array.from(document.getElementsByClassName('field')).forEach(function(item, i) {
			if(i != index) {
				item.classList.add('cursor-waiting');
			}		
		});				
	} else if(command == 'stop'){
		Array.from(document.getElementsByClassName('field')).forEach(function(item, i) {
			item.classList.remove('cursor-waiting');		
		});				
	}			
}

// configura animação
function setAnimation(element) {
	element.classList.add("card-animation");
}

function removeAnimation(el) {
	window.setTimeout(function() {
		el.classList.remove("card-animation");
		el.classList.add("selected");
	}, 900);
}

// desabilita e ou habilita cards temporariament
function enableOrDisableCards(status) {
	Array.from(document.getElementsByClassName('radio_card')).forEach(function(item) {
		item.disabled = status;
	});
}

// habilitar campo de comentário
function enableComment() {

	field = document.getElementById('comment');

	if(field.disabled == true) {
		field.disabled = false;
	} else {
		field.disabled = true;
	}			
}

function clickHumor(event) {
	console.log(event.target);
	event.target.classList.add('cursor-waiting');
}

$('form#form-humor').on('submit', function (event) {

	event.preventDefault();

	// humor selecionado
	const value = $('input:radio[name=humor]:checked').val();

	// seleciona element checkbox
	const check_comment = document.getElementById('checkComment');

	// inicializa variável comentário
	text_comment = '';

	// testa condição do checkbox
	if(check_comment.checked) {
		// atribui valor do campo comentário
		text_comment = $('input#comment').val();
	}

	// faz requisição para criar humor
	jQuery.ajax({
		type: 'POST',
		url: 'register-humor.ajax.php',
		data: {humor: value, comment: text_comment},
		success: function(e) {

			const object = JSON.parse(e)

			// Mostra modal aqui
			if(object.response == 'register_success'){
				// usuário já registrado
				alert('humor registrado com sucess!');						
			}else if(object.response == 'already_register') {
				// usuário já registrado
				alert('humor já foi registrado no atual momento');
			} else if(object.response == 'time_over') {
				// tempo de registro do humor acabou
				alert('tempo de registro do humor já chegou ao fim');
			} else if (object.response == 'humor_not_selected') {
				// humor não selecionado
				alert('Falha, humor não foi selecionado');
			}
		}
	});
})		

document.getElementById('fields').addEventListener('click', check);		