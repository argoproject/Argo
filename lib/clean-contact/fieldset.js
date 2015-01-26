// Help fend off spam spiders
function clean_contact_form() {
	var send = document.getElementById('str_clean_contact_send').value;
	document.write('<a name="clean_contact"></a><form method="post" action="#clean_contact" name="clean_contact" id="clean_contact" onsubmit="return clean_contact_validate(this)">');
	document.write('<input type="hidden" name="clean_contact_token" value="cc" />');
	document.write('<fieldset class="CleanContact">');
	document.write('<label for="clean_contact_from_name">' + document.getElementById('str_clean_contact_name').value + '<em>*</em></label><input type="text" name="clean_contact_from_name" id="clean_contact_from_name" onchange="clean_contact_msg_clr()" />');
	document.write('<label for="clean_contact_from_email">' + document.getElementById('str_clean_contact_email').value + '<em>*</em></label><input type="text" name="clean_contact_from_email" id="clean_contact_from_email"  onchange="clean_contact_msg_clr()"  />');
	if ( document.getElementById('str_clean_contact_router') ) {
		var choices = document.getElementById('str_clean_contact_router').value.split("|");
		document.write('<label for="clean_contact_router">Reason for Contacting Us<em>*</em></label><select name="clean_contact_router">');
		for (var i = 0; i < choices.length; i++) {
			document.write('<option>'+choices[i]+'</option>');
		}
		document.write('</select>');
	}
	document.write('<label for="clean_contact_subject">' + document.getElementById('str_clean_contact_subject').value + '<em>*</em></label><input type="text" id="clean_contact_subject" name="clean_contact_subject"  onchange="clean_contact_msg_clr()"  />');
	document.write('<label for="clean_contact_body">' + document.getElementById('str_clean_contact_body').value +  '<em>*</em></label>');
	document.write('<textarea id="clean_contact_body" name="clean_contact_body"  onchange="clean_contact_msg_clr()" ></textarea><br />');
	document.write('<div id="clean_contact_msg"></div>');
	document.write('<input type="submit" id="clean_contact_send" value=" ' + send + ' " />');
	document.write('</fieldset>');
	document.write('</form>');
}

function clean_contact_validate() {
	var email  = /^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/;
	var error = document.getElementById('str_clean_contact_send').value + ': ';
	var str = 	/\w+/;

	var error = document.getElementById('str_clean_contact_error').value + ': ';
	if(document.getElementById('clean_contact_from_name').value == '') {
		clean_contact_msg(error + document.getElementById('str_clean_contact_name').value);
		return false;
	}
	if(!email.test(document.getElementById('clean_contact_from_email').value)) {
		clean_contact_msg(error + document.getElementById('str_clean_contact_email').value);
		return false;
	}
	if(document.getElementById('clean_contact_subject').value == '') {
		clean_contact_msg(error + document.getElementById('str_clean_contact_subject').value);
		return false;
	}

	if(document.getElementById('clean_contact_body').value == '') {
		clean_contact_msg(error + document.getElementById('str_clean_contact_body').value);
		return false;
	}
	return true;
}

function  clean_contact_msg_clr() {
	document.getElementById('clean_contact_msg').style.display = 'none';
}

function clean_contact_msg(msg) {
	em = document.getElementById('clean_contact_msg');
	em.innerHTML = msg;
	em.style.display = 'block';
}

function clean_contact_url(url) {
	window.location = url;
}
