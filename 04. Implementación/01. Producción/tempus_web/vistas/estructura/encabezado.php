<?php  header('Content-Type: text/html; charset=ISO-8859-1'); ?>
	
	<head>
		<title>TEMPUS</title>
		
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
		
		<link href="../../css/EstiloPrincipal.css" type="text/css" rel="stylesheet"/>
		
		<link rel='stylesheet' type='text/css' href='../../css/datatables.min.css'/>
	    <link rel='stylesheet' type='text/css' href='../../js/Buttons-1.4.2/css/buttons.dataTables.min.css'/>
	    
		 
		<script type="text/javascript" src="../../js/datatables.min.js"></script>
	    <script type='text/javascript' src='../../js/Buttons-1.4.2/js/buttons.html5.min.js'></script>
	    <script type='text/javascript' src='../../js/Buttons-1.4.2/js/dataTables.buttons.min.js'></script>
	    <script type='text/javascript' src='../../js/pdfmake-0.1.32/pdfmake.min.js'></script>
	    <script type='text/javascript' src='../../js/pdfmake-0.1.32/vfs_fonts.js'></script>

	</head>
	<body>
		<header id="main-header">
			
			<a id="logo-header" href="">
                <span class="site-name">TEMPUS</span>
                <span class="site-desc">SIT UNPA-UARG</span>
            </a>
          
		</header>
		<nav>
    		<ul class="ul">
              <li><a href="../estructura/home.php">Home</a></li>
              
             
                  <li class="dropdown">
                    <a class="dropbtn">Cursada</a>
                    <div class="dropdown-content">
                      <a href="../cursadas/cursada_seleccionar.php">Importar</a>
                      <a href="../cursadas/cursada_crear.php">Crear</a>
                      <a href="../cursadas/cursada_buscar.php">Borrar / Modificar</a>
                      <a href="#">Informe</a>
                    </div>
                  </li>
              
              
              <li class="dropdown">
                <a class="dropbtn">Mesas de examen</a>
                <div class="dropdown-content">
                  <a href="../mesas/mesa_seleccionar.php">Importar</a>
                  <a href="../mesas/mesa_crear.php">Crear</a>
                  <a href="../mesas/mesa_buscar.php">Borrar / Modificar</a>
                  <a href="">Informe</a>
                </div>
              </li>
              
              <li class="dropdown">
                <a class="dropbtn">Aulas</a>
                <div class="dropdown-content">
                  <a href="">Borrar / Modificar</a>
                </div>
              </li>
              
            </ul>
		</nav>
