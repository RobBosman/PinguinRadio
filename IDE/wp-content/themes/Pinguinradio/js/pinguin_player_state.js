"use strict";

var expireAfterMillis = 5000; // 5 seconds
var playerSettings = {
    playing: 'stop',
    muted: false,
    volume: 0.7
};

window.onload = restorePlayerSettings;
window.onunload = storePlayerState;
$(document).ready(function() {
    // Add some event handlers to the player.
    $('#jquery_jplayer_1')
        .bind($.jPlayer.event.ready, function(event) {
            // Apply the initial settings.
            $('#jquery_jplayer_1')
                .jPlayer("volume", playerSettings.volume)
                .jPlayer("option", "muted", playerSettings.muted)
                .jPlayer(playerSettings.playing);
        })
        .bind($.jPlayer.event.play + ' ' + $.jPlayer.event.playing, function(event) {
            monitorPlayerState(true, event.jPlayer.options);
        })
        .bind($.jPlayer.event.stop + ' ' + $.jPlayer.event.pause, function(event) {
            monitorPlayerState(false, event.jPlayer.options);
        })
        .bind($.jPlayer.event.volumechange, function(event) {
            monitorPlayerState(null, event.jPlayer.options);
        });
});

function monitorPlayerState(isPlaying, jPlayerOptions) {
    if (isPlaying !== null) {
        playerSettings.playing = (isPlaying ? 'play' : 'stop');
    }
    playerSettings.muted = jPlayerOptions.muted;
    playerSettings.volume = jPlayerOptions.volume;
};
function storePlayerState() {
    // Store the new settings in a cookie.
    var cookie = 'playing=' + (playerSettings.playing)
            + ';muted=' + playerSettings.muted
            + ';volume=' + playerSettings.volume;
    setCookie("pinguin_player_state", cookie, expireAfterMillis);
};
function restorePlayerSettings() {;
    // Read the cookie with stored settings.
    var cookie = getCookie("pinguin_player_state");
    if (cookie !== false) {
        // Parse the cookie data.
        var keyValues = cookie.split(';');
        for (var i = 0; i < keyValues.length; i++) {
            var keyValue = keyValues[i].split('=');
            if (keyValue[0] === 'playing') {
                playerSettings.playing = keyValue[1];
            } else if (keyValue[0] === 'muted') {
                playerSettings.muted = (keyValue[1] === 'true');
            } else if (keyValue[0] === 'volume') {
                playerSettings.volume = Number(keyValue[1]);
            }
        }
    }
};

function setCookie(name, value, expireAfterMillis) {
    var expires = "";
    if (expireAfterMillis) {
        var expireDate = new Date();
        expireDate.setTime(expireDate.getTime() + expireAfterMillis);
        expires = ";expires=" + expireDate.toGMTString();
    }
    document.cookie = name + "=" + escape(value) + expires + ";path=/";
};
function getCookie(name) {
    if (document.cookie.length > 0) {
        var startIndex = document.cookie.indexOf(name + "=");
        if (startIndex !== -1) {
            startIndex += name.length + 1;
            var endIndex = document.cookie.indexOf(";", startIndex);
            if (endIndex === -1) {
                endIndex = document.cookie.length;
            }
            return unescape(document.cookie.substring(startIndex, endIndex));
        }
    }
    return false;
};