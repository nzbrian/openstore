/*
copyright Brian Bannister 2004

This file is part of Open Store. http://openstore.org/

Open Store is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Open Store is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Open Store; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/
function getReference(id, thisDocument) {
	if (!thisDocument) {
    	thisDocument = window.document;
	}
	
    var result =  thisDocument[id]; 
    if(!result && thisDocument.all) { 
    	result = thisDocument.all[id]; 
    }
    if(!result && thisDocument.getElementById) { 
    	result = thisDocument.getElementById(id); 
    }
    for(var i = 0; !result && i < thisDocument.forms.length; i++) { 
		result = thisDocument.forms[i][id];
    }
	for(var j = 0; !result && j < thisDocument.anchors.length; j++) { 
		if(thisDocument.anchors[j].name == id) { 
			result = thisDocument.anchors[j]; 
		} 
    }
    return result;
}

function showDiv(thisDiv) {
    if( thisDiv.style ) { 
        thisDiv.style.visibility = 'visible';
    } else {
        thisDiv.visibility = 'show';
    }
    return true;
}

function hideDiv(thisDiv) {
    if( thisDiv.style ) { 
        thisDiv.style.visibility = 'hidden';
    } else {
        thisDiv.visibility = 'hide';
    }
    return true;
}

function changeBackgroundColour(field, colour) {
	var style = null;
	if( field.style ) { 
		style = field.style; 
	}
	else {
		style = field;	
	}
	style.bgColor = colour;
	style.background = colour;
	style.backgroundColor = colour;
	return true;
}

function checkInt(field, flag, compulsory) {
	changeBackgroundColour(field, '#FFFFFF');
	hideDiv(flag);
	
	var strng = trimString(field.value);
	var result = !strng.replace(/\d/g, '');
	
	if (result && compulsory) {
		result = checkCompulsoryString(field);	
	}
	
	if (!result) {
		changeBackgroundColour(field,'#FF6699');
		showDiv(flag);
	}
	return result;
}

function checkIntLessThan(field, flag, compulsory, lessThan) {
	var result = false;
	if (checkInt(field, flag, compulsory)) {
		var value = field.value;	
		if (value < lessThan) {
			result = true;	
		}
		else {
			changeBackgroundColour(field,'#FF6699');
			showDiv(flag);
		}
	}
	return result;
}

function checkFloat(field, flag, compulsory) {
	changeBackgroundColour(field, '#FFFFFF');
	hideDiv(flag);
	
	var strng = trimString(field.value);
	var result = !strng.replace(/[\.\d]/g, '');
	
	if (result && compulsory) {
		result = checkCompulsoryString(field);	
	}
	
	if (!result) {
		changeBackgroundColour(field,'#FF6699');
		showDiv(flag);
	}
	return result;
}

function checkEmail(field, flag, compulsory) {
	changeBackgroundColour(field, '#FFFFFF');
	hideDiv(flag);
	var result = !field.value.replace( /[^<>()[.,;:@\"\]\\\s]+(\.[^<>()[.,;:@\"\]\\\s]+)*@([a-zA-Z\-\d]+\.)+[a-zA-Z]{2,}/g, ''); 
	if (result && compulsory) {
		result = checkCompulsoryString(field);	
	}	
	if (!result) {
		changeBackgroundColour(field,'#FF6699');
		showDiv(flag);
	}
	return result;
}

function checkName(field, flag, compulsory) {
	return checkString(field, flag, compulsory);
}

function checkPhone(field, flag, compulsory) {
	changeBackgroundColour(field, '#FFFFFF');
	hideDiv(flag);
	
	var stripped = field.value.replace(/[\(\)\.\-\ \+]/g, '');
	var result = (!stripped || (!stripped.replace(/\d/g, '') && (stripped.length < 15) && (stripped.length > 5)));
	
	if (result && compulsory) {
		result = checkCompulsoryString(field);	
	}	
		
	if (!result) {
		changeBackgroundColour(field,'#FF6699');
		showDiv(flag);
	}
	return result;
}

function checkString(field, flag, compulsory) {
	changeBackgroundColour(field, '#FFFFFF');
	hideDiv(flag);
	var result = !(field.value.replace(/[\w\ \,\.\\\/]/g, ''));
	if (result && compulsory) {
		result = checkCompulsoryString(field);	
	}	
	if (!result) {
		changeBackgroundColour(field,'#FF6699');
		showDiv(flag);
	}
	return result;
}

function checkCompulsoryString(field) {
	return trimString(field.value);
}

function trimString(strng) {
	var result = strng.replace(/^\s+/g, '');
	return result.replace(/\s+$/g, '');
}

function checkCreditCard(field, cardType, flag, compulsory) {
	changeBackgroundColour(field, '#FFFFFF');
	hideDiv(flag);
	
	var cNumber = field.value.replace(/\ /g, "");
	var cLength = cNumber.length;
	
	var result;
	if (cardType == 'visa') {
		result = ((cNumber.substring(0,1) == '4') && ( (cLength == 16) || (cLength == 13) ));
	}
	else {
		var prefix = cNumber.substring(0,2);
		result = (prefix < 56) && (prefix > 50) && (cLength == 16)	
	}	
	result = result && luhnCheck(cNumber);
	
	if (result && compulsory) {
		result = checkCompulsoryString(field);	
	}	
	if (!result) {
		changeBackgroundColour(field,'#FF6699');
		showDiv(flag);
	}
	return result;
}

function luhnCheck(strng) {
	var result = false;
	
	var sum = 0; 
	var multiply = false; 
	var strLen = strng.length;
	
	for (var i = 0; i < strLen; i++) {
		var digit = strng.substring(strLen - i - 1, strLen - i);
		var product = parseInt(digit ,10);
		if (multiply) {
			product *= 2;	
		}
		if (product >= 10) {
		  product -= 9;
		}
		sum += product;
		multiply = !multiply;
	}
	if ((sum % 10) == 0) {
		result = true;
	}
	
	return result;
}

function submitForm(formName, document) {
    var form = getReference(formName, document);
    form.submit();
}
