"use strict";

function preFillMP3Data(event) {
    // Parse the filename, assuming this format "C:/fakedir/Artiest - Track.mp3".
    var fileInput = event.target;
    var filename = fileInput.value;
    var startIndex = Math.max(filename.lastIndexOf("/"), filename.lastIndexOf("\\")) + 1;
    var name = filename.substring(startIndex, filename.lastIndexOf("."));
    var artiestTrack = name.split(/-/);
    var formId = fileInput.parentNode.id;
    $("#" + formId + " #artiest").val(artiestTrack[0].trim());
    $("#" + formId + " #track").val(artiestTrack[1].trim());
    event.preventDefault();
    return false;
}

var htmlElementNowPlaying = null;

function playPauseMP3(event, ref, mp3Present) {
    var htmlElement = event.target;
    // Only do something if an MP3 is available.
    if (mp3Present) {
        var mp3URL = "/_assets/mp3/graadmeter/" + ref + ".mp3";
        if (htmlElement !== htmlElementNowPlaying) {
            // Pause the currently playing track.
            if (htmlElementNowPlaying !== null && htmlElementNowPlaying.mp3) {
                htmlElementNowPlaying.mp3.pause();
                $(htmlElementNowPlaying).removeClass('graadmeter_mp3_playing');
            }
            htmlElementNowPlaying = htmlElement;
        }
        // Assign the MP3-URL to the htmlElement.
        if (!htmlElement.mp3) {
            htmlElement.mp3 = new Audio(mp3URL);
        }
        // Toggle play/pause.
        if (htmlElement.mp3.paused) {
            $(htmlElement).addClass('graadmeter_mp3_playing');
            htmlElement.mp3.play();
        } else {
            $(htmlElement).removeClass('graadmeter_mp3_playing');
            htmlElement.mp3.pause();
        }
    }
    event.preventDefault();
    return false;
}

function showMP3UploadDialog(ref) {
    // Show MP3 upload dialog.
    var htmlContent = '<form id="mp3Form"><label for="file">MP3 file</label><br /><input type="file" name="mp3File" id="mp3File" /></form>';
    $(htmlContent).dialog({
            title: "Upload MP3",
            beforeClose: function(event, ui) {
                reloadPage();
            },
            modal: true,
            buttons: [{
                text: "OK",
                click: function() {
                        uploadMP3File("mp3Form", ref);
                        $(this).dialog("close");
                    }
            }]
        });
}

function filterVotes(mustShowAllVotes) {
    var reload_location = window.location.href;
    var queryStringParam = 'showAllVotes=' + (mustShowAllVotes ? 'true' : 'false');
    var index = reload_location.search(/[\?&]showAllVotes=[^&]+/i);
    if (index >= 0) {
        reload_location = reload_location.replace(/showAllVotes=[^&]+/i, queryStringParam);
    } else {
        reload_location += (reload_location.search(/[\?&]/) ? '&' : '?') + queryStringParam;
    }
    window.location = reload_location;
}

function unlock() {
    if (confirm("Dit ontgrendelt de BEHEERomgeving voor het corrigeren van de huidige LIVE lijsten.\n\nDoorgaan?")) {
        $.post(ajaxurl, {
                action: 'graadmeter_unlock'
            },
            check_database_response_and_reload_page);
    }
}

function restore() {
    if (confirm("Dit kopieert de LIVE lijsten terug naar de BEHEERomgeving.\nEventuele wijzigingen gaan daarbij verloren.\n\nDoorgaan?")) {
        $.post(ajaxurl, {
                action: 'graadmeter_restore'
            },
            check_database_response_and_reload_page);
    }
}

function getBalloontip(targetId) {
    var result = null;
    $('.balloontip').each(function() {
        if (this.getAttribute('for') === targetId) {
            result = this;
            return false;
        }
    });
    return result;
}

function reloadPage() {
    setTimeout(function() {
        location.reload(true);
    }, 0);
}

function alertDialog(message, title, reloadAtClose) {
    if (message.indexOf("<") !== 0) {
        // It's probably not HTML-formatted.
        message = '<div>' + message.replace('\n', '<br/>') + '</div>';
    }
    // Show the database error in a modal dialog. Reload the page when closing the dialog.
    $(message).dialog({
            title: title,
            beforeClose: function(event, ui) {
                if (reloadAtClose) {
                    reloadPage();
                }
            },
            modal: true,
            buttons: [{
                text: "OK",
                click: function() {
                    $(this).dialog("close");
                }
            }]
        });
}

function check_database_response(response) {
    if (response !== "") {
        alertDialog(response, "ERROR", true);
    }
    return response === "";
}

function check_database_response_and_reload_page(response) {
    var success = check_database_response(response);
    if (success) {
        reloadPage();
    }
    return success;
}

// Function to make WordPress Ajax call for Editing.
function graadmeter_edit(lijst, td, value) {
    // Fill a map with the textContent of all cells of the table row.
    var data = {
        id: td.parentNode.getAttribute("id"),
        lijst: lijst
    };
    var children = td.parentNode.children;
    for (var i = 0, l = children.length; i < l; i++) {
        var child = children[i];
        var ref = child.getAttribute("ref");
        var val = child.textContent;
        if (Number(val) < 0) {
            // Getallen (positie, aantal_wk, etc.) zijn altijd positief.
            data[ref] = -Number(val);
        } else {
            data[ref] = val;
        }
    }
    // Use the newly entered value.
    if (Number(value) < 0) {
        value = -Number(value);
    }
    data[td.getAttribute("ref")] = value;
    // Update the record.
    $.post(ajaxurl, {
            action: 'graadmeter_edit',
            data: data
        },
        check_database_response_and_reload_page);
}

function move(id, naarLijst, insertAtIndex) {
    var data = {
        id: id,
        lijst: naarLijst,
        insertAtIndex: insertAtIndex
    };
    $.post(ajaxurl, {
            action: 'graadmeter_move',
            data: data
        },
        // Hack: pagina altijd verversen zodat de data uit de database wordt opgehaald en de nummering weer klopt.
        check_database_response_and_reload_page);
}

function deleteAllOldTips() {
    if (confirm("Dit verwijdert de tracks die afgelopen week in de Tip 10 stonden.\n\nDoorgaan?")) {
        $.post(ajaxurl, {
                action: 'graadmeter_deleteAllOldTips'
            },
            // Hack: pagina altijd verversen zodat de data uit de database wordt opgehaald en de nummering weer klopt.
            check_database_response_and_reload_page);
    }
}

function prepare() {
    if (confirm("Gegevens van de LIVE omgeving ophalen, 'posities vorige week' bijwerken en Exit-lijst wissen.\n\nDoorgaan?")) {
        // Ja? OK, let's go.
        $.post(ajaxurl, {
                action: 'graadmeter_prepare'
            },
            check_database_response_and_reload_page);
    }
}

function validateListLengths() {
    var doContinue = true;
    var top41_length = $('#top41').dataTable().fnGetData().length;
    if (doContinue && top41_length !== 41) {
        doContinue = confirm("LET OP:\nHet aantal tracks (" + top41_length + ") in de Top 41 klopt niet.\n\nToch publiceren?");
    }
    var tip10_length = $('#tip10').dataTable().fnGetData().length;
    if (doContinue && tip10_length !== 10) {
        doContinue = confirm("LET OP:\nHet aantal tracks (" + tip10_length + ") in de Tip 10 klopt niet.\n\nToch publiceren?");
    }
    var exit_length = $('#exit').dataTable().fnGetData().length;
    if (doContinue && exit_length <= 0) {
        doContinue = confirm("LET OP:\nDe Exit-lijst is leeg.\n\nToch doorgaan?");
    }
    return doContinue;
}

function validateIJsbrekers() {
    var tableRows = $('#top41').dataTable().fnGetData();
    var numIJsbrekers = 0;
    for (var i = 0; i < tableRows.length; i++) {
        var rowData = tableRows[i];
        // rowData[0] = positie
        // rowData[1] = positie_vw
        // rowData[2] = aantal_wk
        // rowData[3] = artiest
        // rowData[4] = track
        // rowData[5] = mp3
        // rowData[6] = ijsbreker
        if ((rowData[1] === "0" || rowData[1] === "nw") && rowData[6] === 'J') {
            numIJsbrekers++;
        }
    }
    if (numIJsbrekers < 1) {
        return confirm("LET OP:\nDe Top 41 bevat geen IJSBREKER.\n\nToch publiceren?");
    } else if (numIJsbrekers > 1) {
        return confirm("LET OP:\nDe Top 41 bevat " + numIJsbrekers + " IJSBREKERs.\n\nToch publiceren?");
    }
    return true;
}

function validateAantalWekenTop41() {
    var tableRows = $('#top41').dataTable().fnGetData();
    var numNewInTop41 = 0;
    for (var i = 0; i < tableRows.length; i++) {
        var rowData = tableRows[i];
        // rowData[0] = positie
        // rowData[1] = positie_vw
        // rowData[2] = aantal_wk
        if (rowData[2] === "0" || rowData[2] === "nw") {
            numNewInTop41++;
        }
    }
    if (numNewInTop41 === 1) {
        return confirm("LET OP:\nDe Top 41 bevat één track waarvan het 'Aantal weken' op 0 staat.\n\nToch doorgaan?");
    } else if (numNewInTop41 > 1) {
        return confirm("LET OP:\nDe Top 41 bevat " + numNewInTop41 + " tracks waarvan het 'Aantal weken' op 0 staat.\n\nToch doorgaan?");
    }
    return true;
}

function validateTracksStillInTip10() {
    var tableRows = $('#tip10').dataTable().fnGetData();
    var stillInTip10 = 0;
    for (var i = 0; i < tableRows.length; i++) {
        var rowData = tableRows[i];
        // rowData[0] = positie
        // rowData[1] = positie_vw
        if (rowData[1] !== "0" && rowData[1] !== "nw") {
            stillInTip10++;
        }
    }
    if (stillInTip10 === 1) {
        return confirm("LET OP:\nDe Tip 10 bevat één track die vorige week ook al in de Tip 10 stond.\n\nToch doorgaan?");
    } else if (stillInTip10 > 1) {
        return confirm("LET OP:\nDe Tip 10 bevat " + stillInTip10 + " tracks die vorige week ook al in de Tip 10 stonden.\n\nToch doorgaan?");
    }
    return true;
}

function publish() {
    if (confirm("Publiceren:\nJe gaat de nieuwe lijsten LIVE zetten en alle stemmen wissen.\n\nDoorgaan?")
                && validateListLengths() && validateIJsbrekers() && validateAantalWekenTop41() && validateTracksStillInTip10()) {
        // All good. Publiceren.
        $.post(ajaxurl, {
                action: 'graadmeter_publish'
            },
            check_database_response_and_reload_page);
    }
}

function updateLive() {
    if (confirm("Je gaat de LIVE omgeving bijwerken, maar laat de stemmen ongewijzigd.\n\nDoorgaan?")
                && validateListLengths() && validateIJsbrekers() && validateAantalWekenTop41()) {
        // All good. Publiceren.
        $.post(ajaxurl, {
                action: 'graadmeter_updateLive'
            },
            check_database_response_and_reload_page);
    }
}

function fillPosition(htmlInput, htmlTable) {
    // Bepaal positie in lijst en zet het nieuwe toegevoegde nummer als laatste in de lijst.
    var positie = Number(htmlInput.val());
    var maxPositie = htmlTable.dataTable().fnGetData().length + 1;
    if (positie === Number.NaN || positie === 0 || Math.abs(positie) > maxPositie) {
        htmlInput.val(maxPositie);
    } else if (positie < 0) {
        htmlInput.val(-positie);
    }
}

function uploadMP3File(formId, ref) {
    // Upload de geselecteerde MP3 file.
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../wp-content/plugins/pinguinradio-graadmeter/uploadMP3.php", false);
    xhr.onload = function() {
        if (xhr.status !== 200 || xhr.responseText !== "OK") {
            alert("Error " + xhr.status + " occurred while uploading MP3 file.\n" + xhr.responseText);
        }
    };
    var formData = new FormData(document.forms[formId]);
    formData.append("ref", ref);
    xhr.send(formData);
}

$(document).ready(function() {
    var showBalloonId = null;
    $('button')
        .mouseover(function(event) {
            var tPosX = event.pageX - 370;
            var tPosY = event.pageY + 15;
            showBalloonId = event.target.id;
            setTimeout(function() {
                var balloonTip = $(getBalloontip(showBalloonId));
                balloonTip.css({'position': 'absolute', 'top': tPosY + 'px', 'left': tPosX + 'px'});
                balloonTip.show(200);
            }, 1000);
        })
        .mouseout(function(event) {
            var balloonTip = getBalloontip(event.target.id);
            $(balloonTip).hide();
            showBalloonId = null;
        });

    $('#top41').dataTable( {
        bJQueryUI: true,
        bPaginate: false,
        bLengthChange: false,
        bFilter: false,
        bSort: false,
        bInfo: false,
        bAutoWidth: false,
        aoColumns: [
            { sClass: "read_only center" },
            { sClass: "center" },
            { sClass: "center" },
            { sWidth: "50%" },
            { sWidth: "50%" },
            { sClass: "center" },
            { sClass: "center" },
            { sClass: "read_only center" },
            { sClass: "read_only center" }
        ],
        aaSorting: [[ 0, 'asc' ]]
    });
    $('#exit').dataTable( {
        bJQueryUI: true,
        bPaginate: false,
        bLengthChange: false,
        bFilter: false,
        bSort: false,
        bInfo: false,
        bAutoWidth: false,
        aoColumns: [
            { sClass: "read_only center" },
            { sClass: "center" },
            { sClass: "center" },
            { sWidth: "50%" },
            { sWidth: "50%" },
            { sClass: "center" },
            { sClass: "center" }
        ],
        aaSorting: [[ 0, 'asc' ]]
    });
    $('#tip10').dataTable( {
        bJQueryUI: true,
        bPaginate: false,
        bLengthChange: false,
        bFilter: false,
        bSort: false,
        bInfo: false,
        bAutoWidth: false,
        aoColumns: [
            { sClass: "read_only center" },
            { sClass: "center" },
            { sWidth: "50%" },
            { sWidth: "50%" },
            { sClass: "center" },
            { sClass: "read_only center" },
            { sClass: "read_only center" }
        ],
        aaSorting: [[ 0, 'asc' ]]
    });
    $('#tips').dataTable( {
        bJQueryUI: true,
        bPaginate: false,
        bLengthChange: false,
        bFilter: false,
        bSort: false,
        bInfo: false,
        bAutoWidth: false,
        aoColumns: [
            { sClass: "read_only" },
            { sClass: "read_only" },
            { sClass: "read_only" },
            { sClass: "read_only", sWidth: "100%" }
        ],
        aaSorting: [[ 0, 'asc' ]]
    });

    if (isGraadmeterDataEditable) {
        // Toevoegen Add/Edit/Delete functionaliteit
        $('#top41').dataTable().makeEditable({
            sAddNewRowFormId: "formAddTop41",
            sAddNewRowButtonId: "btnAddTop41",
            fnOnAdding: function() {
                // Bepaal de positie in lijst en zet het nieuwe toegevoegde nummer als laatste in de lijst.
                fillPosition($("#formAddTop41 #positie"), $('#top41'));
                // Upload de geselecteerde MP3 file.
                uploadMP3File("formAddTop41", $("#formAddTop41 #ref").val());
                return true;
            },
            sAddURL: "admin-ajax.php",
            fnOnAdded: function() {
                // Ververs de opnieuw gesorteerde lijst.
                reloadPage();
            },
            sUpdateURL: function(value, settings) {
                graadmeter_edit('top41', this, value);
                return value;
            }
        });
        // Toevoegen Add/Edit/Delete functionaliteit voor exit-lijst
        $('#exit').dataTable().makeEditable({
            sUpdateURL: function(value, settings) {
                graadmeter_edit('exit', this, value);
                return value;
            }
        });
        // Toevoegen Add/Edit/Delete functionaliteit voor Tip 10
        $('#tip10').dataTable().makeEditable({
            sAddNewRowFormId: "formAddTip10",
            sAddNewRowButtonId: "btnAddTip10",
            fnOnAdding: function() {
                // Bepaal de positie in lijst en zet het nieuwe toegevoegde nummer als laatste in de lijst.
                fillPosition($("#formAddTip10 #positie"), $('#tip10'));
                // Upload de geselecteerde MP3 file.
                uploadMP3File("formAddTip10", $("#formAddTip10 #ref").val());
                return true;
            },
            sAddURL: "admin-ajax.php",
            fnOnAdded: function() {
                // Ververs de opnieuw gesorteerde lijst.
                reloadPage();
            },
            sUpdateURL: function(value, settings) {
                graadmeter_edit('tip10', this, value);
                return value;
            },
            sDeleteRowButtonId: "btnDeleteTip10",
            sDeleteURL: "admin-ajax.php",
            oDeleteParameters: {
                action: "graadmeter_delete",
                which_table : "tip10"
            },
            fnOnDeleted: function(status) {
                // Ververs de opnieuw gesorteerde lijst.
                reloadPage();
            }
        });

        // Add sorting (drag&drop) functionality.
        $("#top41 tbody, #tip10 tbody, #exit tbody").sortable({
            cursor: "move",
            connectWith: ".connectedSortable",
            update: function(event, ui) {
                // Sla de nieuwe trackposities op in de database.
                $.post(ajaxurl, {
                        action: 'graadmeter_sort',
                        data: $(this).sortable('toArray')
                    },
                    // Hack: pagina altijd verversen zodat de data uit de database wordt opgehaald en de nummering weer klopt.
                    check_database_response_and_reload_page);
            },
            receive: function(event, ui) {
                var fromLijst = ui.sender.closest('table').attr('lijst');
                var toLijst = ui.item.closest('table').attr('lijst');
                // Only moves from tip10 to top41 and from top41 to exit are expected; other combinations must be confirmed explicitly.
                if ((fromLijst === 'tip10' && toLijst === 'top41') || (fromLijst === 'top41' && toLijst === 'exit')
                        || confirm("Weet je zeker dat je deze track wilt verplaatsen van '" + fromLijst + "' naar '" + toLijst + "'?")) {
                    // NB: the record-id is stored in the TR-element.
                    var id = ui.item.attr('id');
                    var insertAtIndex = 0;
                    $.each($(this).find('tr'), function(index, tr) {
                        if (tr.id === id) {
                            return false;
                        }
                        insertAtIndex++;
                    });
                    move(id, toLijst, insertAtIndex);
                }
            }
        });

        // Enable or disable the Exit button.
        $('#top41 tr').live('click', function() {
            $('#btnExitTop41').attr('disabled', !$(this).hasClass('row_selected'));
        });
    } else {
        $('#graadmeter_edit_week,#formAddTop41,#formAddTip10').hide();
        $('#graadmeter_beheer')
            .css('opacity', 0.7)
            .click(function(event) {
                // Show the alert dialog, except if you clicked on an MP3-field. Adding/listening MP3 files is always allowed.
                // (I tried several css selectors like this $('#graadmeter_beheer *[ref!="mp3"]'), but I couldn't get it to work. Sorry!)
                if (event.target.tagName.toLowerCase() !== 'td' || event.target.getAttribute("ref") !== "mp3") {
                    alertDialog('<p>De gegevens zijn nog vergrendeld.'
                            + '<br />Klik op <button onclick="prepare();">Initialiseren voor de nieuwe week</button>'
                            + ' of op <button onclick="unlock();">Beheeromgeving ontgrendelen</button>.</p>', "INFO", false);
                    event.stopPropagation();
                    event.preventDefault();
                    return false;
                }
            });
    }
});