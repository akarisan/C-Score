var myajax;
function execute(container,accessurl,paramet,method) {
	myajax = new Ajax.PeriodicalUpdater(
		container,
		accessurl,
		{
			"method": method,
			"parameters": paramet,
			frequency: 60, // 1分ごとに実行
			onSuccess: function(request) {
				// 成功時の処理を記述
				// alert('成功しました');
				// jsonの値を処理する場合↓↓
				//  var json;
				//  eval("json="+request.responseText);
				
				// ↓IEでもキャッシュを読み込まずに毎回リモート接続を実行するためのコード(パラメータの書き換え)
				var str = myajax.options.parameters;
				var hash = str.parseQuery();
				hash["ajax_request_id"] = Math.random();
				hash = $H(hash);
				myajax.options.parameters = hash.toQueryString();
			},
			onComplete: function(request) {
				// 完了時の処理を記述
				// alert('読み込みが完了しました');
				// jsonの値を処理する場合↓↓
				//  var json;
				//  eval("json="+request.responseText);
			},
			onFailure: function(request) {
				document.getElementById('display').innerHTML = "読み込み失敗";
			},
			onException: function (request) {
				document.getElementById('display').innerHTML = "読み込み中エラー";
			}
		}); 
};

function executeA(container,accessurl,paramet,method) {
	myajax = new Ajax.PeriodicalUpdater(
		container,
		accessurl,
		{
			"method": method,
			"parameters": paramet,
			frequency: 5, // 1時間ごとに実行
			onSuccess: function(request) {
				// 成功時の処理を記述
				// alert('成功しました');
				// jsonの値を処理する場合↓↓
				//  var json;
				//  eval("json="+request.responseText);
				
				// ↓IEでもキャッシュを読み込まずに毎回リモート接続を実行するためのコード(パラメータの書き換え)
				var str = myajax.options.parameters;
				var hash = str.parseQuery();
				hash["ajax_request_id"] = Math.random();
				hash = $H(hash);
				myajax.options.parameters = hash.toQueryString();
			},
			onComplete: function(request) {
                document.getElementById('display').innerHTML = "更新しました";
			},
			onFailure: function(request) {
				document.getElementById('display').innerHTML = "読み込み失敗";
			},
			onException: function (request) {
				document.getElementById('display').innerHTML = "読み込み中エラー";
			}
		}); 
};