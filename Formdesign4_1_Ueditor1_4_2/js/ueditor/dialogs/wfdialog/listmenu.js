
function fnSelect( combo ) {
	var iIndex = combo.selectedIndex ;
	oListText.selectedIndex	= iIndex ;
	var olistText	= document.getElementById( "listText" ) ;
	olistText.value	= oListText.value ;
}

function fnAdd() {
	var olistText	= document.getElementById( "listText" ) ;
	fnAddComboOption( oListText, olistText.value, olistText.value ) ;
	oListText.selectedIndex = oListText.options.length - 1 ;
	olistText.value	= '' ;
	olistText.focus() ;
}

function fnModify() {
	var iIndex = oListText.selectedIndex ;
	if ( iIndex < 0 ) return ;
	var olistText	= document.getElementById( "listText" ) ;
	oListText.options[ iIndex ].innerHTML	= fnHTMLEncode( olistText.value ) ;
	oListText.options[ iIndex ].value		= olistText.value ;
	olistText.value	= '' ;
	olistText.focus() ;
}

function fnMove( steps ) {
	fnChangeOptionPosition( oListText, steps ) ;
}

function fnDelete() {
	fnRemoveSelectedOptions( oListText ) ;
}

function fnSetSelectedValue() {
	var iIndex = oListText.selectedIndex ;
	if ( iIndex < 0 ) return ;
	var olistText = document.getElementById( "listSelValue" ) ;
	olistText.innerHTML = oListText.options[ iIndex ].value ;
}

// Moves the selected option by a number of steps (also negative)
function fnChangeOptionPosition( combo, steps ) {
	var iActualIndex = combo.selectedIndex ;
	if ( iActualIndex < 0 ){
		return ;
	}
	var iFinalIndex = iActualIndex + steps ;
	if ( iFinalIndex < 0 ){
		iFinalIndex = 0 ;
	}
	if ( iFinalIndex > ( combo.options.length - 1 ) ) {
		iFinalIndex = combo.options.length - 1 ;
	}
	if ( iActualIndex == iFinalIndex ) {
		return ;
	}
	var oOption = combo.options[ iActualIndex ] ;
	if(oOption.value=="") {
		var sText	= fnHTMLDecode( oOption.value ) ;
	} else {
		var sText	= fnHTMLDecode( oOption.innerHTML ) ;
	}
	combo.remove( iActualIndex ) ;
	oOption = fnAddComboOption( combo, sText, sText, null, iFinalIndex ) ;
	oOption.selected = true ;
}

// Remove all selected options from a SELECT object
function fnRemoveSelectedOptions( combo ) {
	// Save the selected index
	var iSelectedIndex = combo.selectedIndex ;
	var oOptions = combo.options ;
	// Remove all selected options
	for ( var i = oOptions.length - 1 ; i >= 0 ; i-- ) {
		if (oOptions[i].selected) combo.remove(i) ;
	}

	// Reset the selection based on the original selected index
	if ( combo.options.length > 0 ) {
		if ( iSelectedIndex >= combo.options.length ) iSelectedIndex = combo.options.length - 1 ;
		combo.selectedIndex = iSelectedIndex ;
	}
}

// Add a new option to a SELECT object (combo or list)
function fnAddComboOption( combo, optionText, optionValue, documentObject, index ) {
	var oOption ;
	if ( documentObject ) {
		oOption = documentObject.createElement("option") ;
	} else {
		oOption = document.createElement("option") ;
	}
	if ( index != null ) {
		combo.options.add( oOption, index ) ;
	} else {
		combo.options.add( oOption ) ;
	}
	oOption.innerHTML = optionText.length > 0 ? fnHTMLEncode( optionText ) : '&nbsp;' ;
	oOption.value     = optionValue ;
	return oOption ;
}

function fnHTMLEncode( text ) {
	if ( !text ) {
		return '' ;
	}
	text = text.replace( /&/g, '&amp;' ) ;
	text = text.replace( /</g, '&lt;' ) ;
	text = text.replace( />/g, '&gt;' ) ;
	return text ;
}


function fnHTMLDecode( text ) {
	if ( !text ) {
		return '' ;
	}
	text = text.replace( /&gt;/g, '>' ) ;
	text = text.replace( /&lt;/g, '<' ) ;
	text = text.replace( /&amp;/g, '&' ) ;
	return text ;
}

function fnSetAttribute( element, attName, attValue ) {
	if ( attValue == null || attValue.length == 0 ){
		element.removeAttribute( attName, 0 ) ;		
	} else {
		element.setAttribute( attName, attValue, 0 ) ;	
	}// 0 : Case Insensitive
}
