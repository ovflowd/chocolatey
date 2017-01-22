//------------------------------------------
// Invision Power Board v2.3
// ACP Specific JS File
// (c) 2007 Invision Power Services, Inc.
// By: Matt Mecham, Brandon Farber
// http://www.invisionboard.com
//------------------------------------------

//==========================================
// AJAX REFRESH
//==========================================

ajax_load_msg = '';

function ajax_refresh(url, text, addtotext) {
    /*--------------------------------------------*/
    // Main function to do on request
    // Must be defined first!!
    /*--------------------------------------------*/

    do_request_function = function () {
        //----------------------------------
        // Ignore unless we're ready to go
        //----------------------------------

        if (!xmlobj.readystate_ready_and_ok()) {
            // Could do a little loading graphic here?
            return;
        }

        //----------------------------------
        // INIT
        //----------------------------------

        var html = xmlobj.xmlhandler.responseText;

        eval(html);
    }

    //----------------------------------
    // LOAD XML
    //----------------------------------

    if (url) {
        xmlobj = new ajax_request();
        xmlobj.onreadystatechange(do_request_function);
        xmlobj.process(url);
    }

    if (text) {
        // Put it to the top
        if (addtotext) {
            document.getElementById('refreshbox').innerHTML = text + '<br />' + document.getElementById('refreshbox').innerHTML;
        }
        else {
            document.getElementById('refreshbox').innerHTML = text;
        }
    }
}

//==========================================
// POP UP YA WINDA
//==========================================

function pop_win(theUrl, winName, theWidth, theHeight) {
    if (winName == '') {
        winName = 'Preview';
    }
    if (theHeight == '') {
        theHeight = 400;
    }
    if (theWidth == '') {
        theWidth = 400;
    }

    window.open(ipb_var_base_url + '&' + theUrl, winName, 'width=' + theWidth + ',height=' + theHeight + ',resizable=yes,scrollbars=yes');
}

//==========================================
// Toggle div
//==========================================

function togglediv(did, show) {
    //-----------------------------------
    // Add?
    //-----------------------------------

    if (show) {
        my_show_div(my_getbyid(did));

    }
    else {
        my_hide_div(my_getbyid(did));
    }

    return false;

}


//==========================================
// Toggle menu categories
//==========================================

function togglemenucategory(fid, add) {
    saved = new Array();
    clean = new Array();

    //-----------------------------------
    // Get any saved info
    //-----------------------------------

    if (tmp = my_getcookie('acpcollapseprefs')) {
        saved = tmp.split(",");
    }

    //-----------------------------------
    // Remove bit if exists
    //-----------------------------------

    for (i = 0; i < saved.length; i++) {
        if (saved[i] != fid && saved[i] != "") {
            clean[clean.length] = saved[i];
        }
    }

    //-----------------------------------
    // Add?
    //-----------------------------------

    if (add) {
        clean[clean.length] = fid;
        my_show_div(my_getbyid('fo_' + fid));
        my_hide_div(my_getbyid('fc_' + fid));
    }
    else {
        my_show_div(my_getbyid('fc_' + fid));
        my_hide_div(my_getbyid('fo_' + fid));
    }

    my_setcookie('acpcollapseprefs', clean.join(','), 1);

    tmp = clean.join(',');
}

//==========================================
// Expand all (remove cookie)
//==========================================

function expandmenu() {
    my_setcookie('acpcollapseprefs', menu_ids, 1);
    window.location = window.location;
}

//==========================================
// Expand all (remove cookie)
//==========================================

function collapsemenu() {
    my_setcookie('acpcollapseprefs', '', 1);
    window.location = window.location;
}

//==========================================
// Change text editor size
//==========================================

function changefont() {
    var savearray = new Array();
    var idarray = new Array();
    var rootdoc = '';

    if (template_bit_ids) {
        idarray = template_bit_ids.split(",");
    }

    if (tmp = my_getcookie('acpeditorprefs')) {
        savearray = tmp.split(",");
    }

    try {
        if (document.getElementById('te-iframe')) {
            rootdoc = window.frames['te-iframe'].document;
        }
        else {
            rootdoc = document;
        }
    }
    catch (e) {
        //alert(e);
    }


    chosenfont = rootdoc.theform.fontchange.options[rootdoc.theform.fontchange.selectedIndex].value;
    chosensize = rootdoc.theform.sizechange.options[rootdoc.theform.sizechange.selectedIndex].value;
    chosenback = rootdoc.theform.backchange.options[rootdoc.theform.backchange.selectedIndex].value;
    fontcolor = rootdoc.theform.fontcolor.options[rootdoc.theform.fontcolor.selectedIndex].value;
    widthchange = rootdoc.theform.widthchange.options[rootdoc.theform.widthchange.selectedIndex].value;
    highchange = rootdoc.theform.highchange.options[rootdoc.theform.highchange.selectedIndex].value;

    if (idarray.length) {
        for (i = 0; i < idarray.length; i++) {
            id = idarray[i];

            itm = rootdoc.getElementById(id);

            if (chosenfont != '-') {
                itm.style.fontFamily = chosenfont;
                savearray[0] = chosenfont;
            }
            if (chosensize != '-') {
                itm.style.fontSize = chosensize;
                savearray[1] = chosensize;
            }
            if (chosenback != '-') {
                itm.style.backgroundColor = chosenback;
                savearray[2] = chosenback;
            }
            if (fontcolor != '-') {
                itm.style.color = fontcolor;
                savearray[3] = fontcolor;
            }
            if (widthchange != '-') {
                itm.style.width = widthchange;
                savearray[4] = widthchange;
            }
            if (highchange != '-') {
                itm.style.height = highchange;
                savearray[5] = highchange;
            }
        }
    }

    my_setcookie('acpeditorprefs', savearray.join(','), 1);
}

//==========================================
// Auto jump menu
//==========================================

function autojumpmenu(fobj) {
    urljump = fobj.options[fobj.selectedIndex].value;

    if (urljump != "" && urljump != "-") {
        window.location = urljump;
    }
}


//==========================================
// Check for no special chars
//==========================================

function no_specialchars(type) {
    var name;

    if (type == 'sets') {
        var field = document.theAdminForm.sname;
        name = 'Skin Set Title';
    }

    if (type == 'wrapper') {
        var field = document.theAdminForm.name;
        name = 'Wrapper Title';
    }

    if (type == 'csssheet') {
        var field = document.theAdminForm.name;
        name = 'StyleSheet Title';
    }

    if (type == 'templates') {
        var field = document.theAdminForm.skname;
        name = 'Template Set Name';
    }

    if (type == 'images') {
        var field = document.theAdminForm.setname;
        name = 'Image & Macro Set Title';
    }

    var valid = 'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890.()[]:;~+-_';
    var ok = 1;
    var temp;

    for (var i = 0; i < field.value.length; i++) {
        temp = "" + field.value.substring(i, i + 1);

        if (valid.indexOf(temp) == "-1") {
            ok = 0;
        }
    }

    if (ok == 0) {
        alert('Invalid entry for: ' + name + ', you can only use alphanumerics and the following special characters.\n. ( ) : ; ~ + - _');
        return false;
    }
    else {
        return true;
    }
}

//==========================================
// IPS Kernel method
//==========================================

function confirm_action(url, msg) {
    return maincheckdelete(url, msg);
}

//==========================================
// Backwards compatible check delete
//==========================================

function checkdelete(url) {
    return maincheckdelete(ipb_var_base_url + '&' + url);
}

//==========================================
// Main check delete
//==========================================

function maincheckdelete(url, msg) {
    if (!msg) {
        msg = 'PLEASE CONFIRM:\nOK to proceed?';
    }

    if (confirm(msg)) {
        document.location.href = url;
    }
    else {
        alert('OK, action cancelled!');
    }
}


