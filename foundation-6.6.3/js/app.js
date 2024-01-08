$(document).foundation();

$('[data-app-dashboard-toggle-shrink]').on('click', function(e) {
  e.preventDefault();
  $(this).parents('.app-dashboard').toggleClass('shrink-medium').toggleClass('shrink-large');
});

window.onload = page_load();

//Define Callout Variable
var CALLOUT_PRIMARY     = 'primary';
var CALLOUT_SECONDARY   = 'secondary';
var CALLOUT_SUCCESS     = 'success';
var CALLOUT_WARNING     = 'warning';
var CALLOUT_ALERT         = 'alert';

//Define Global variables
var SHOP_TYPE_GENERAL = '100';
var SHOP_TYPE_CSV_IMPORT = '200';
var SHOP_TYPE_SHOPIFY = '300';
var SHOP_TYPE_BILLBEE = '400';
var SHOP_TYPE_AMAZON = '500';
var SHOP_TYPE_WOOCOMMERCE = '600';

function page_load() {
	var session_hidden = document.getElementById('session_hidden');
	var btn_login = document.getElementById('btn_login');
	var btn_logout = document.getElementById('btn_logout');

	if (session_hidden.value == 1) {
		btn_logout.classList.remove("hide");
		btn_login.classList.add("hide");
	} else {
		btn_logout.classList.add("hide");
		btn_login.classList.remove("hide");
	}
}

//<!-- Auto-Load Javascripts -->
function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		window.onload = function() {
			if (oldonload) {
				oldonload();
			}
			func();
		} // end window.onload
	} // end if
} // end function addLoadEvent(func);

function utf8Encode(unicodeString) {
    if (typeof unicodeString != 'string') throw new TypeError('parameter unicodeString is not a string');
    const utf8String = unicodeString.replace(
        /[\u0080-\u07ff]/g,  // U+0080 - U+07FF => 2 bytes 110yyyyy, 10zzzzzz
        function(c) {
            var cc = c.charCodeAt(0);
            return String.fromCharCode(0xc0 | cc>>6, 0x80 | cc&0x3f); }
    ).replace(
        /[\u0800-\uffff]/g,  // U+0800 - U+FFFF => 3 bytes 1110xxxx, 10yyyyyy, 10zzzzzz
        function(c) {
            var cc = c.charCodeAt(0);
            return String.fromCharCode(0xe0 | cc>>12, 0x80 | cc>>6&0x3F, 0x80 | cc&0x3f); }
    );
    return utf8String;
}


/**
 * Decodes utf-8 encoded string back into multi-byte Unicode characters.
 *
 * Can be achieved JavaScript by decodeURIComponent(escape(str)),
 * but this approach may be useful in other languages.
 *
 * @param   {string} utf8String - UTF-8 string to be decoded back to Unicode.
 * @returns {string} Decoded Unicode string.
 */
function utf8Decode(utf8String) {
    if (typeof utf8String != 'string') throw new TypeError('parameter utf8String is not a string');
    // note: decode 3-byte chars first as decoded 2-byte strings could appear to be 3-byte char!
    const unicodeString = utf8String.replace(
        /[\u00e0-\u00ef][\u0080-\u00bf][\u0080-\u00bf]/g,  // 3-byte chars
        function(c) {  // (note parentheses for precedence)
            var cc = ((c.charCodeAt(0)&0x0f)<<12) | ((c.charCodeAt(1)&0x3f)<<6) | ( c.charCodeAt(2)&0x3f);
            return String.fromCharCode(cc); }
    ).replace(
        /[\u00c0-\u00df][\u0080-\u00bf]/g,                 // 2-byte chars
        function(c) {  // (note parentheses for precedence)
            var cc = (c.charCodeAt(0)&0x1f)<<6 | c.charCodeAt(1)&0x3f;
            return String.fromCharCode(cc); }
    );
    return unicodeString;
}

function GetAPIAccess() {
    var api_user = 'api_user=ad_0000101';
    var api_key = 'api_key=DB007SS012021DKBCCTVDQZYGH1JHN8';
    var ret_val = api_user + '&' + api_key;
    return ret_val;
}

function SELECT_Leeren(select_element) {
  // Die Optionen für das angegebenen SELECT-Element löschen
  var len = select_element.options.length;
  for (i = 0; i < len; i++) {
    select_element.options[i] = null;
  }
  select_element.options.length = 0;
  return;
}


function SELECT_Option(select_element, wert) {
  var len = select_element.options.length;
  for (i = 0; i < len; i++) {     
      if (select_element.options[i].value == wert) {
          select_element.selectedIndex = i;
          break;
      }
  }
  return;
}

function SELECT_Sort(select_element) { 
  console.log('SELECT_Sort()');
  var tmpAry = new Array();
  for (var i=0;i<select_element.options.length;i++) {
    tmpAry[i] = new Array();
    tmpAry[i][0] = select_element.options[i].text;
    tmpAry[i][1] = select_element.options[i].value;
  }

  tmpAry.sort();

  while (select_element.options.length > 0) {
    select_element.options[0] = null;
  }

  for (var i=0;i<tmpAry.length;i++) {
    var op = new Option(tmpAry[i][0], tmpAry[i][1]);
    select_element.options[i] = op;
  }

  return;
}

function CHECK_Option(check_element, wert) {
  if (wert == 1) {
    check_element.value = 1;
    check_element.checked = true;
  } else {
    check_element.value = 0;
    check_element.checked = false;
  }
    return;
}

function Checkbox_value_change(elem) {
    console.log('Checkbox_value_change()');
    //
    if (elem.value == 0) {
      elem.value = 1;
      elem.setAttribute('checked', 'checked');
    } else {
      elem.value = 0;
      elem.removeAttribute('checked');
    }
} // end Checkbox_value_change();

function Callout_Meldung(callout_element, type = 'primary', text = '', anzeigen = true, fadeOut_ms = 0) {
    var guid_id = guidGenerator();

    var div = document.createElement('div');

    div.className = type + ' callout';
    div.id = 'callout_meldung_' + guid_id;
    div.setAttribute('style', 'display: block');
    div.setAttribute('data-closable', 'slide-out-right');

    var innerHTML = '';
    innerHTML += '<button class="close-button" aria-label="Schliessen" type="button" data-close="">';
    innerHTML += '  <span aria-hidden="true">&times</span>';
    innerHTML += '</button>';
    innerHTML += '<strong>' + text + '</strong>';   

    div.innerHTML = innerHTML;

    if (callout_element != '') {
        callout_element.appendChild(div);
    } 

    if (fadeOut_ms > 0) {
        $('#callout_meldung_' + guid_id).delay(fadeOut_ms).fadeOut();
    }

    return;
} // end Callout_Meldung();

function guidGenerator() {
    var S4 = function() {
       return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    };
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}

function Helper_encodeURIComponentWithAmp(str){
    return encodeURIComponent(str.toString().replace(/&amp;/g, "&"));   
}

function Shop_Type_Description_JS(typ) {
    var ret = '';

    switch (typ) {
        case SHOP_TYPE_GENERAL: ret = 'GENERAL'; break;
        case SHOP_TYPE_CSV_IMPORT: ret = 'CSV IMPORT'; break;
        case SHOP_TYPE_SHOPIFY: ret = 'SHOPIFY'; break;
        case SHOP_TYPE_BILLBEE: ret = 'BILLBEE'; break;
        case SHOP_TYPE_AMAZON: ret = 'AMAZON'; break;
        case SHOP_TYPE_WOOCOMMERCE: ret = 'WOOCOMMERCE'; break;
        default: ret = '***';
    }
    return ret;
}




