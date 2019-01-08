<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Estudando jCrop</title>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery.Jcrop.css" />
		<style type="text/css">
			body{
			margin:0 auto;
			padding:10px;
			}
			h1{
			font-size:20px;
			font-family:Arial;
			color:#666666;
			}
			input{
			margin-bottom:7px;
			}
		</style>
		<script type="text/javascript">
			function getCoords(){
			var api;
			$('#toCrop').Jcrop({
			minSize: [160,160],
			aspectRatio: 1,
			bgOpacity: 0.4,
			addClass: 'jcrop-light',
			onSelect: updateCoords,
			onChange: updateCoords,
			setSelect: [0,0,160,160]
			});
			}
			 
			function updateCoords(c){
			$('#x').val(c.x);
			$('#y').val(c.y);
			$('#w').val(c.w);
			$('#h').val(c.h);
			};
			 
			function _(element){
			if(document.getElementById(element))
			return document.getElementById(element);
			else
			return false;
			}
			 
			function submitForm(){
			if(_('arquivo').files[0]){//Se houver um arquivo, faremos alguns testes no mesmo
			var arquivo = _('arquivo').files[0];
			if(arquivo.type != 'image/png' && arquivo.type != 'image/jpeg')
			_('result').innerHTML = 'Por favor, selecione uma imagem do tipo JPEG ou PNG';
			else if(arquivo.size > 1024 * 2048)//2MB
			_('result').innerHTML = 'Por favor selecione uma image mo máximo 2MB de tamanho.';
			else{
			var x = _('x').value;
			var y = _('y').value;
			var w = _('w').value;
			var h = _('h').value;
			var formData = new FormData();
			formData.append('arquivo', arquivo);
			formData.append('x', x);
			formData.append('y', y);
			formData.append('w', w);
			formData.append('h', h);
			if(_('imgType')){
			var imgType = _('imgType').value;
			formData.append('imgType', imgType);
			}
			if(_('imgName')){
			var imgName = _('imgName').value;
			formData.append('imgName', imgName);
			}
			var request  = new XMLHttpRequest();
			if(_('toCrop'))
			var includeFile = 'cropFile.php';
			else
			var includeFile = 'recebeFile.php';
			request.open('post', includeFile, true);
			request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200)
			_('result').innerHTML = request.responseText;
			if(_('toCrop'))
			_('sendButton').value = 'Recortar';
			}
			request.send(formData);
			_('result').innerHTML = '<img src="5.gif" />';
			}
			}
			else
			_('result').innerHTML = 'Por favor, selecione uma imagem para ser enviada!';
			}
		</script>
	</head>
	<body>
		<h1>Selecione uma imagem para ser enviada</h1>
		<form>
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="file" id="arquivo" />
			<input onclick="submitForm();" type="button" id="sendButton" value="Enviar" />
		</form>
		<output id="result"></output>
	</body>
</html>