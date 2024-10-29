<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Container principal */
        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Barra lateral */
        .sidebar {
            background-color: #2c3e50;
            color: white;
            width: 250px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar-header {
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
        }

        .sidebar-menu {
            list-style-type: none;
            margin-top: 20px;
        }

        .sidebar-menu li {
            margin-bottom: 15px;
        }

        .sidebar-menu a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
        }

        .sidebar-menu a:hover {
            text-decoration: underline;
        }

        /* Área principal */
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .header p {
            color: #7f8c8d;
        }

        /* Cartões do dashboard */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card p {
            color: #7f8c8d;
        }

        /* Barra de progresso */
        .progress-bar {
            background-color: #ecf0f1;
            border-radius: 10px;
            height: 20px;
            width: 100%;
            margin-bottom: 10px;
        }

        .progress {
            background-color: #27ae60;
            height: 100%;
            border-radius: 10px;
        }

        /* Links */
        .card a {
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
        }

        .card a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            color: black;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Barra lateral -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Academia Fitness</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Treinos</a></li>
                <li><a href="#">Planos</a></li>
                <li><a href="#">Nutrição</a></li>
                <li><a href="#">Mensagens</a></li>
                <li><a href="#">Configurações</a></li>
                <li><a href="index.html">Sair</a></li>
            </ul>
        </aside>

        <!-- Área principal -->
        <main class="main-content">
            <header class="header">
                <?php 
                    require_once 'connection.php';
                    session_start();

                    // Verifica se o usuário está logado
                    if (!isset($_SESSION['id'])) {
                        echo "Usuário não autenticado!";
                        exit;
                    }

                    // Obtém o ID do usuário a partir da sessão
                    $id = $_SESSION['id'];
                    $conn = Connection::getConn();

                    // Consulta o nome do usuário no banco de dados
                    $sql = $conn->prepare("SELECT nome FROM usuarios WHERE id = :id");
                    $sql->bindParam(':id', $id, PDO::PARAM_INT);
                    $sql->execute();

                    $user = $sql->fetch(PDO::FETCH_ASSOC);
                    $nome_usuario = $user['nome'] ?? 'Usuário';
                ?>
               
                <h1>Bem-vindo(a), <?php echo htmlspecialchars($nome_usuario); ?></h1>
                <p>Vamos alcançar seus objetivos de fitness juntos!</p>
            </header>

            <!-- Seções de conteúdo -->
            <section class="dashboard">
                <div class="card">
                    <h3>Progresso Semanal</h3>
                    <div class="progress-bar">
                        <div class="progress" style="width: 70%;"></div>
                    </div>
                    <p>70% completado dos treinos desta semana.</p>
                </div>

                <div class="card">
                    <h3>Treino de Hoje</h3>
                    <ul>
                        <li>Supino Reto: 3x12</li>
                        <li>Agachamento Livre: 4x10</li>
                        <li>Desenvolvimento de Ombros: 3x12</li>
                        <li>Corrida: 20 minutos</li>
                    </ul>
                </div>

                <div class="card">
                    <h3>Planos Ativos</h3>
                    <p>Plano Premium - 6 meses</p>
                    <p>Válido até: 30/06/2024</p>
                </div>

                <div class="card">
                    <h3>Mensagens</h3>
                    <p>Você tem 3 novas mensagens.</p>
                    <a href="#">Ver mensagens</a>
                </div>
            </section>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Brayan R Campos - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
