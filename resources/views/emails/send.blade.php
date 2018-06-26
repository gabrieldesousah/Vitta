<!DOCTYPE html>
<html>
    <head>
      <!-- This is a simple example template that you can edit to create your own custom templates -->
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <!-- Facebook sharing information tags -->
      <meta property="og:title" content="*|MC:SUBJECT|*">
    
      <title>{{ $title }}</title>
	  
        

<style type="text/css">
		*{
			font-family:"Consolas";
			font-size:15px;
		}
		body{
			background:#F9FCFF;
		}
		.info{
			font-size:11px;
			color:#2F4F4F;
			margin:5px;
		}
		.left{
			float:left;
			font-size:11px;
		}
		.text-left{
			text-align:left;
		}
		.right{
			float:right;
			font-size:11px;
		}
		.center{
			margin:0 auto;
		}
		.button{
			-webkit-box-sizing:content-box;
			-moz-box-sizing:content-box;
			box-sizing:content-box;
			text-decoration:none;
			width:250px;
			height:40px;
			cursor:pointer;
			margin:0 auto;
			border:.5px solid rgb(38, 169, 245);
			-webkit-border-radius:40px;
			border-radius:35px;
			padding:10px;
			font:normal 15px/40px "Domine Font Family", Helvetica, sans-serif;
			color:rgb(255, 255, 255);
			text-align:center;
			-o-text-overflow:clip;
			text-overflow:clip;
			letter-spacing:1px;
			background:#0989d8;
		}
		a{
			color:#8BC53F;
			text-decoration:underline;
		}
		p{
			width:90%;
			text-align:justify;
			color:#2A689A;
			font-size:16px;
		}
		hr{
			margin-top:10px;
			margin-bottom:10px;
			width:90%;
			color:#ccc;
		}
		h1{
			color:#oooooo;
			margin:0;
			padding:0;
			font-size:25px;
		}
		h2{
			margin:0;
			padding:0;
			color:#000;
		}
		center{
			width:95%;
			margin:0 auto;
			margin-top:20px;
			padding-top:10px;
			max-width:700px;
		}
		.text-right{
			text-align:right;
		}
		.text-justify{
			text-align:justify;
		}
		.wrapper{
			padding:5px;
			background:#FFFFFF;
			border:1px solid #ccc;
		}
		#mailchimp{
			color:transparent;
		}
		#mailchimp a{
			color:transparent;
		}
</style></head>

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    <center>
      <div class="info">
      	<div class="left">Vittalecas</div>
        <div class="right">Clínica Vittá Goiânia</div>
      </div>
      <br>
      <div class="wrapper">
        <header>
            <br>
            <!-- // Begin Module: Standard Header Image \\ -->
            <img src="http://clinicavittagoiania.com.br/wp-content/uploads/bfi_thumb/clinica-vitta-logo-304b6uw9ib8o4cpifra22o.png" alt="Clínica Vittá Goiânia" style="max-width:300px;" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner="" mc:allowtext="">
        </header>
       
        <hr>
        
        <div class="header">
          <h1>{{ $title }}</h1>
        </div>                 
		<p style="font-size: 18px" class="text-justify">
O mês está chegando ao fim e é hora de fazer o balanço das Vittalecas... 
		</p>
		<p style="font-size: 18px" class="text-justify">
Com as vittalecas que acumulou até aqui, irá trocar por algum produto do catálogo agora ou aguardará para acumular mais? Inclusive, sabe com quantas vai virar o mês?
		</p>
		<p style="font-size: 18px" class="text-justify">
Não deixe de conferir sempre e, mais do que isso, de correr pelos propósitos que lhe rendem esses incríveis benefícios, Ainda mais agora no final do mês e que há uns desafios legais por aí, para aumentar as chances de acúmulos de Vittalecas!
		</p>
		<p style="font-size: 18px" class="text-justify">
Bem, dito isso, deixa eu correr aqui também, pois também não quero perder tempo e juntar muitas ainda esse mês 😊👋
		</p>
		<p class="text-justify">
		Acesse sua página para ver mais informações: <br>
		<br>
		<a href="https://clinicavittagoiania.com.br/vittalecas/">Home Vittalecas</a>
                  

@if(isset($user->fields->Foto))
  <div class="col-lg-4">
    <img src="{{ $user->fields->Foto[0]->url }}" style="width: 100px;"> <br>
  </div>
@endif

@if(isset($user->fields->Contratações[0]->Função))
    <b>Você trabalha como:</b> {{ $user->fields->Contratações[0]->Função }}
@endif

@if(isset($user->fields->Contratações[0]->Função))
    <b>no setor:</b> {{ $user->fields->Contratações[0]->Setor }}
@endif
    <br>
@if(isset($user->fields->EmailPessoal))
    <b>Seu email pessoal ainda é este:</b> {{ $user->fields->EmailPessoal }} ?
    <br>
@endif
@if(isset($user->fields->EmailCorporativo))
    <b>Não se esqueça do seu email corporativo:</b> {{ $user->fields->EmailCorporativo }}
    <br>
@endif

<br>

@if(isset($user->fields->ScoreAtual))
    <h2>Você possui {{ $user->fields->ScoreAtual }} Vittalecas</h2>
    <br>
@endif
                  </p>
<hr>
Para mais informações entre em contato com seu gestor
          </p>
        <br>
        <br>
        <br>
    	<img src="https://clinicavittagoiania.com.br/vittalecas/public/img/logo.png" alt="Clínica Vittá Goiânia" style="max-width:150px;" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner="" mc:allowtext="">
    </div>
    <br>
    <!--div class="wrapper social">
        <a href="https://www.facebook.com/dib.ufg/">Facebook</a>
        <a href="https://www.instagram.com/dibufg/">Instagram</a>
        <a href="https://inovacaonaborracha.com.br/">Site</a>
    </div-->
    
</body>
</html>