<?php
session_start();
require('../mysqli_connect.php');
require('../news.php');
require('../footer.php');
?>
<html lang="pt">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<title>Termos de uso | SlideCorner</title>
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<link rel="shortcut icon" href="../favicon.png">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
			<div class="container">
				<a class="navbar-brand" href="../">SlideCorner</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav">
						<?php include('../subjects.php'); ?>
					</ul>
					<ul class="navbar-nav ml-auto">
						<?php include('../user-status.php'); ?>
					</ul>
				</div>
			</div>
		</nav>
		<br><br><br>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-10">
					<div class="container">
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Termos de Uso do Website (<?php echo $_SERVER['SERVER_NAME']; ?>)</h4>
										<p class="card-text">
											A plataforma <?php echo $_SERVER['SERVER_NAME']; ?> é um serviço interativo oferecido por meio de página eletrônica na internet que permite a partilha de ficheiros entre utilizadores. O acesso a Plataforma <?php echo $_SERVER['SERVER_NAME']; ?> representa a aceitação expressa e irrestrita dos termos de uso abaixo descritos. Se você não concorda com os termos, por favor, não acesse nem utilize esta plataforma.<br><br>

O visitante poderá usar esta plataforma apenas para finalidades lícitas. Este espaço não poderá ser utilizado para publicar, enviar, distribuir ou divulgar conteúdos ou informação de caráter difamatório, obsceno ou ilícito, inclusive informações de propriedade exclusiva pertencentes a outras pessoas ou empresas, bem como marcas registradas ou informações protegidas por direitos autorais, sem a expressa autorização do detentor desses direitos. Ainda, o visitante não poderá usar a plataforma <?php echo $_SERVER['SERVER_NAME']; ?> para obter ou divulgar informações pessoais, inclusive endereços na Internet, sobre os usuários do site.<br><br>

O <?php echo $_SERVER['SERVER_NAME']; ?> empenha-se em manter a qualidade, atualidade e autenticidade das informações do site, mas seus criadores e colaboradores não se responsabilizam por eventuais falhas nos serviços ou inexatidão das informações oferecidas. O usuário não deve ter como pressuposto que tais serviços e informações são isentos de erros ou serão adequados aos seus objetivos particulares. Os criadores e colaboradores tampouco assumem o compromisso de atualizar as informações, e reservam-se o direito de alterar as condições de uso ou preços dos serviços e produtos oferecidos no site a qualquer momento.<br><br>

O acesso à plataforma é gratuito. O <?php echo $_SERVER['SERVER_NAME']; ?> poderá criar áreas de acesso exclusivo aos seus clientes ou para terceiros especialmente autorizados.<br><br>

Os criadores e colaboradores da plataforma poderão a seu exclusivo critério e em qualquer tempo, modificar ou desativar o site, bem como limitar, cancelar ou suspender seu uso ou o acesso. Também estes Termos de Uso poderão ser alterados a qualquer tempo. Visite regularmente esta página e consulte  os Termos então vigentes. Algumas disposições destes Termos podem ser substituídas por termos ou avisos legais expressos localizados em determinadas páginas deste site.<br><br><br>

Erros e falhas<br><br>

Os documentos, informações, imagens e gráficos publicados nesta plataforma podem conter imprecisões técnicas ou erros tipográficos. Em nenhuma hipótese o <?php echo $_SERVER['SERVER_NAME']; ?> e/ou seus respectivos fornecedores serão responsáveis por qualquer dano direto ou indireto decorrente da impossibilidade de uso, perda de dados ou lucros, resultante do acesso e desempenho do site, dos serviços oferecidos ou de informações disponíveis neste site. O acesso aos serviços, materiais, informações e facilidades contidas neste website não garante a sua qualidade.<br><br><br>

Limitação da responsabilidade<br><br>

Os materiais são fornecidos neste website sem nenhuma garantia explícita ou implícita de comercialização ou adequação a qualquer objetivo específico. Em nenhum caso o <?php echo $_SERVER['SERVER_NAME']; ?> ou os seus colaboradores serão responsabilizados por quaisquer danos, incluindo lucros cessantes, interrupção de negócio, ou perda de informação que resultem do uso ou da incapacidade de usar os materiais. O <?php echo $_SERVER['SERVER_NAME']; ?> não garante a precisão ou integridade das informações, textos, gráficos, links e outros itens dos materiais.<br><br>

O <?php echo $_SERVER['SERVER_NAME']; ?> não se responsabiliza pelo conteúdo dos artigos e informações aqui publicadas, uma vez que os textos são de fontes indiretas, estando sujeitas a erros.<br><br>

O <?php echo $_SERVER['SERVER_NAME']; ?> tampouco é responsável pela violação de direitos autorais decorrente de informações, documentos e materiais publicados nesta plataforma, compromentendo-se a retirá-los do ar assim que notificado da infração.<br><br><br>

Informações enviadas pelos usuários e colaboradores<br><br>

Qualquer material, informação, artigos ou outras comunicações que forem transmitidas, enviadas  ou publicadas neste site serão considerados informação não confidencial, e qualquer violação aos direitos dos seus criadores não será de responsabilidade do <?php echo $_SERVER['SERVER_NAME']; ?>.<br><br>

É terminantemente proibido transmitir, trocar ou publicar, através deste website, qualquer material de cunho obsceno, difamatório ou ilegal, bem como textos ou criações de terceiros sem a autorização do autor.<br><br>

O <?php echo $_SERVER['SERVER_NAME']; ?> reserva-se o direito de restringir o acesso às informações enviadas por terceiros aos seus usuários.<br><br>

O <?php echo $_SERVER['SERVER_NAME']; ?> poderá, mas não é obrigado, a monitorar, revistar e restringir o acesso a qualquer área no site onde usuários transmitem e trocam informações entre si, incluindo, mas não limitado a, salas de chat, centro de mensagens ou outros fóruns de debates, podendo retirar do ar ou retirar o acesso a qualquer destas informações ou comunicações.<br><br>

Porém, o <?php echo $_SERVER['SERVER_NAME']; ?> não é responsável pelo conteúdo de qualquer uma das informações trocadas entre os usuários, sejam elas lícitas ou ilícitas.<br><br><br>

Links para sites de terceiros<br><br>

Os sites apontados não estão sob o controle do <?php echo $_SERVER['SERVER_NAME']; ?> que não é responsável pelo conteúdo de qualquer outro website indicado ou acessado por meio do <?php echo $_SERVER['SERVER_NAME']; ?> reserva-se o direito de eliminar qualquer link ou direcionamento a outros sites ou serviços a qualquer momento. O <?php echo $_SERVER['SERVER_NAME']; ?> não endossa firmas ou produtos indicados, acessados ou divulgados através deste website, tampouco pelos anúncios aqui publicados, reservando-se o direito de publicar este alerta em suas páginas eletrônicas sempre que considerar necessário.<br><br><br>

Direitos autorais e propriedade intelectual<br><br>

Os documentos, conteúdos e criações contidos nesta plataforma pertencem aos seus criadores e colaboradores. A autoria dos conteúdos, material e imagens exibidos na plataforma é protegida por leis nacionais e internacionais. Não podem ser copiados, reproduzidos, modificados, publicados, atualizados, postados, transmitidos ou distribuídos de qualquer maneira sem autorização prévia e por escrito dos administradores do portal.<br><br>

As imagens contidas nesta plataforma são aqui incorporadas apenas para fins de visualização, e, salvo autorização expressa por escrito, não podem ser gravadas ou baixadas via download. A reprodução ou armazenamento de materiais recuperados a partir deste serviço sujeitará os infratores às penas da lei.<br><br>

O nome da plataforma, SlideCorner, seu logotipo, o nome de domínio para acesso na Internet, bem como todos os elementos característicos da tecnologia desenvolvida e aqui apresentada, sob a forma da articulação de bases de dados, constituem marcas registradas e propriedades intelectuais privadas e todos os direitos decorrentes de seu registro são assegurados por lei. Alguns direitos de uso podem ser cedidos de maneira formal, escrita, exclusivamente pelo administrador, em contrato ou licença especial, que pode ser cancelada a qualquer momento se não cumpridos os seus termos.<br><br>

As marcas registradas da plataforma só podem ser usadas publicamente com autorização expressa. O uso destas marcas registradas em publicidade e promoção de produtos deve ser adequadamente informado.<br><br><br>

Reclamações sobre violação de direitos autorais<br><br>

O <?php echo $_SERVER['SERVER_NAME']; ?> respeita a propriedade intelectual de outras pessoas ou empresas e solicitamos aos nossos membros que façam o mesmo. Toda e qualquer violação de direitos autorais deverá ser notificada ao administrador da plataforma e acompanhada dos documentos e informações que confirmam a autoria.

A notificação poderá ser enviada pelos e-mails constantes da plataforma para o seguinte endereço joaorvdc@hotmail.com
										</p>
									</div>
								</div>
							</div>
							<div class="col-md-1"></div>
						</div>
					</div>
				</div>
				<div class="col-md-2"><?php echo news(); ?></div>
			</div>
			<?php echo footer(); ?>
		</div>
	</body>
</html>
