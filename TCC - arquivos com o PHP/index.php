<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEC</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Federo&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            background-image: linear-gradient(to right, #fd4463 10%, #0b76a8, #12bdeb);
            font-family: Poppins, Arial;
        }

        main {
            width: 360px;
            height: 420px;
            background-color: #e5e5e5;
            border-radius: 20px;
            padding: 15px;
            margin-top: 0px;
            margin-right: auto;
            margin-bottom: auto;
            margin-left: auto;
        }

        #circulo {
            background: white;
            border: 6px solid #e5e5e5;
            border-radius: 50%;
            width: 84px;
            height: 84px;
            margin-top: 50px;
            margin-right: auto;
            margin-bottom: -30px;
            margin-left: auto;
        }

        img {
            width: 180px;
            height: auto;
            /* Altura se ajusta automaticamente para manter a proporção */
            margin-top: -4px;
            margin-left: -48px;

        }

        h1 {
            text-align: center;
            width: 300px;
            margin-top: 20px;
            margin-right: auto;
            margin-bottom: 30px;
            margin-left: auto;
            font-weight: bold;
            font-size: 28px;
        }

        h2 {
            width: 270px;
            background-color: white;
            color: black;
            border-radius: 10px;
            padding: 15px;
            margin-top: auto;
            margin-right: auto;
            margin-bottom: 35px;
            margin-left: auto;
            text-align: center;
            font-weight: normal;
            /* Espessura*/
            font-size: 25px;
            /* Tamanho*/
        }

        a {
            text-decoration: none;
            /* Tira o sublinhado do link*/
        }

        h2:hover {
            /* Quando o cursor do mouse passa por cima do h2*/
            background-color: #c7c7c7;
        }
    </style>
</head>

<body>

    <div id="circulo">
        <img src="Imagens/logo_210.png" alt="">
    </div>

    <main>
        <h1> Escolha seu perfil</h1>

        <a href="login.php?tipo=professor">
            <h2>Professor</h2>
        </a> <!-- Link para página de login do professor -->
        <a href="login.php?tipo=inspetor">
            <h2>Inspetor</h2>
        </a> <!-- Link para página de login do inspetor -->
        <a href="login.php?tipo=administrador">
            <h2>Administrador</h2>
        </a> <!-- Link para página de login do administrador -->
    </main>

</body>
</html>