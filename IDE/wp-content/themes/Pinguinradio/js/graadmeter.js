/*
Theme Name: Graadmeter 2013 Template
Theme URI: http://pinguinradio.com/graadmeter
Author: RoB
Version: 1.0
*/

function showHideVoteText(hasVoted) {
    if (hasVoted) {
        $('.graadmeter_niet_gestemd').hide();
        $('.graadmeter_wel_gestemd').show();
    } else {
        $('.graadmeter_niet_gestemd').show();
        $('.graadmeter_wel_gestemd').hide();
    }
};

function vote(form, url) {
    var data = {};
    var fieldValuePairs = $(form).serializeArray();
    for (var i = 0; i < fieldValuePairs.length; i++) {
        var fieldValuePair = fieldValuePairs[i];
        data[fieldValuePair.name] = fieldValuePair.value;
    }
    $.post(url, data, function(response) {
        if (response.indexOf('added_tip') >= 0) {
            if (response.indexOf('added_vote') >= 0) {
                alert("Bedankt voor je stem en je tip!");
                showHideVoteText(true);
            } else if (response.indexOf('updated_vote') >= 0) {
                alert("Bedankt voor je tip!\nJe eerder uitgebrachte stem is bijgewerkt.");
            } else {
                alert("Bedankt voor je tip!");
            }
            $('#tip').val('');
        } else {
            if (response.indexOf('added_vote') >= 0) {
                alert("Bedankt voor je stem!");
                showHideVoteText(true);
            } else if (response.indexOf('updated_vote') >= 0) {
                alert("Je eerder uitgebrachte stem is bijgewerkt.");
            } else if (response.indexOf('same_vote') >= 0) {
                alert("Wijzig eerst je eerder uitgebrachte stem en/of\nvul een tip in.");
            } else if (response.indexOf('no_vote') >= 0) {
                alert("Voer eerst je tip en/of stem in.");
            } else {
                // Do nothing; spambot request??
            }
        }
    });
};