function RealTimeUsers(){

    var _baseUrl = 'https://realtimeusers.bycontrast.co/';
    var _counters = document.getElementsByClassName("realtimeuserscounter");
    var _token = '';

    var _init = function(){
        _initElement();
        _setStyles();
        _initToken();
        _track();
        _startStatsLoop();
    };

    var _initElement = function() {
        var inner = '<span class="realtimeuserscounter__num">&mdash;</span>';

        Array.prototype.forEach.call(_counters, function(counter) {
          counter.innerHTML = inner;
        });
    };

    var _setStyles = function() {
        var css = '\
            .realtimeuserscounter--styled {\
              display: inline-block !important;\
              font-family: Monaco, Courier, "Courier New", monospace !important;\
            }\
            .realtimeuserscounter--styled .realtimeuserscounter__num {\
              display: inline-block !important;\
              padding: 0.35em 0.7em !important;\
              margin-bottom: 10px !important;\
              font-size: 22px !important;\
              background-color: #000 !important;\
              color: #fff !important;\
            }\
            .realtimeuserscounter--styled .realtimeuserscounter__attr {\
              display: block !important;\
              border: none !important;\
              padding: 0 !important;\
              background-color: transparent !important;\
              color: #666 !important;\
              font-size: 12px !important;\
            }\
            .realtimeuserscounter--styled .realtimeuserscounter__attr:hover,\
            .realtimeuserscounter--styled .realtimeuserscounter__attr:focus,\
            .realtimeuserscounter--styled .realtimeuserscounter__attr:active {\
              color: #333 !important;\
        }',
           head = document.head || document.getElementsByTagName('head')[0],
          style = document.createElement('style');

        style.type = 'text/css';

        if (style.styleSheet) {
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);
    };

    var _initToken = function(){
        var token = _getCookie('rtu_token');
        if(token !== ''){
            _token = token;
        }
    };

    var _getCookie = function(name) {
        name += "=";
        var cookies = document.cookie.split(';');
        for(var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0)==' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(name) == 0) {
                return cookie.substring(name.length,cookie.length);
            }
        }
        return "";
    };

    var _setCookie = function(name, value, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = name + "=" + value + "; " + expires;
    };

    var _track = function(){
		if(_counters.length > 0){
			var request = new XMLHttpRequest();
			request.open('POST', _getTrackUrl());
			request.onload = function() {
				if (request.status === 200) {
					_setCookie('rtu_token', JSON.parse(request.responseText).token, 1);
				}
				else if (request.status !== 200) {
					console.log('Request failed.  Returned status of ' + request.status + '.');
					console.log(request.responseText);
				}
			};
			request.send();
		}
    };

    var _getTrackUrl = function(){
        return encodeURI(_baseUrl + 'track/' + _getDomain() + '/' + _token);
    };

    var _getDomain = function(){
        return window.location.hostname;
    };

    var _startStatsLoop = function(){
        setTimeout(_stats, 3000);
    };

    var _stats = function(){
		if(_counters.length > 0){
			var request = new XMLHttpRequest();
			request.open('GET', _getStatsUrl());
			request.onload = function() {
				if (request.status === 200) {
					var data = JSON.parse(request.responseText);

					Array.prototype.forEach.call(_counters, function(counter) {
					  var counterNum = counter.getElementsByClassName("realtimeuserscounter__num")[0];
					  counterNum.innerHTML = (data.users == 0) ? 1 : data.users;
					});

				}
				else if (request.status !== 200) {
					console.log('Request failed.  Returned status of ' + request.status + '.');
					console.log(request.responseText);
				}
				setTimeout(_stats, 15000);
			};
			request.send();
		}
    };

    var _getStatsUrl = function(){
        return encodeURI(_baseUrl + 'stats/' + _getDomain());
    };

    _init();
}
var realtimeusers = new RealTimeUsers();