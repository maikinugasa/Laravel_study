<!DOCTYPE html>
<html lang="ja">
<head>
<style>
p {
	text-align:center;
}
#title {
	font-size:20px;
	font-weight:bold;
	color:#888888;
	background:#EEEEEE;
	padding:10px 0 10px
}
#msg {
	margin:15px 0;
}
.button {
	display: inline-block;
	padding: 0.3em 1em;
	text-decoration: none;
	color: #67c5ff;
	border: solid 2px #67c5ff;
	border-radius: 3px;
	transition: .4s;
}
.button:hover {
	background: #67c5ff;
	color: white;
}
</style>
</head>
<body>
<p id="title">パスワード再設定</p>
<p id="msg">下記ボタンより、パスワード再設定の手続きを行ってください。</p>
<p>
<a href="{{$reset_url}}" class="button">パスワードリセット</a>
</p>
</body>
</html>
