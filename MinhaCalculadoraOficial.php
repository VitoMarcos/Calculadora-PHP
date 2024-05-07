<?php
session_start();
/*
Professor: Eu, Vitor Marcos Giovanella Hansen, em nenhum momento entrei no grupo do blackboard com outro colega, na verdade eu não havia entrado em nenhum grupo, quando fui fazer isso, percebi que ja estava em uma dupla com um rapaz, que em nenhum momento entrou em contato comigo. Ele ainda utilizou a única tentativa de envio permitida pelo blackboard, me impedindo de fazer o envio para o senhor por aquela plataforma. Só para explicar então que fiz essa calculadora sem nenhumn auxílo de outra pessoa,e por esses motivos estou te enviando o link do git de uma forma diferente. Obrigado, passar bem.
*/

if (!isset($_SESSION['historico'])) {
    $_SESSION['historico'] = "";
}

// Função para calcular o resultado da operação
function calcularResultado($numero1, $numero2, $operacao)
{
    switch ($operacao) {
        case 'soma':
            return $numero1 + $numero2;
        case 'subtracao':
            return $numero1 - $numero2;
        case 'multiplicacao':
            return $numero1 * $numero2;
        case 'divisao':
            if ($numero2 != 0) {
                return $numero1 / $numero2;
            } else {
                return "Erro: Divisão por zero";
            }
        case 'fatoracao':
            return factorial($numero1);
        case 'potencia':
            return pow($numero1, $numero2);
        default:
            return "Operação inválida";
    }
}

// Função para calcular o fatorial de um número
function factorial($n)
{
    if ($n === 0) {
        return 1;
    }

    $i = $n;
    $calc = 1;
    while ($i > 1) {
        $calc *= $i;
        $i--;
    }
    return $calc;
}

// Adiciona a operação ao histórico
function adicionarAoHistorico($expressao, $resultado)
{
    $_SESSION['historico'] .= "$expressao = $resultado\n";
}


function limparHistorico()
{
    $_SESSION['historico'] = "";
}

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $numero2 = isset($_POST['numero2']) ? $_POST['numero2'] : null;
    
    $operacao = isset($_POST['operacao']) ? $_POST['operacao'] : null;

    // Calcula o resultado da operação apenas se todos os campos obrigatórios estiverem preenchidos
    if (isset($_POST['numero1'], $numero2, $operacao)) {
        $numero1 = $_POST['numero1'];

        
        $resultado = calcularResultado($numero1, $numero2, $operacao);

     
        adicionarAoHistorico("$numero1 $operacao $numero2", $resultado);
    }

    // Verifica se o botão para limpar o histórico foi pressionado
    if (isset($_POST['limpar_historico'])) {
      
        limparHistorico();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #050505;
            color: #FFFFFF;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .calculator {
            background-color: #1f1f1f;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            text-align: center;
            width: 300px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #121212;
            color: #FFFFFF;
            font-size: 18px;
            text-align: right;
        }

        input[type="button"] {
            width: 40px;
            height: 40px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            background-color: #333333;
            color: #FFFFFF;
            font-size: 18px;
            cursor: pointer;
        }

        input[type="button"]:hover {
            background-color: #555555;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .column {
            float: left;
            width: 25%;
        }

        .column.double {
            width: 50%;
        }

        .result {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .history {
            text-align: left;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">CALCULADORA PHP</h2>
    <div class="calculator">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" id="numero1" name="numero1" placeholder="Digite o primeiro número" required>
            <input type="text" id="numero2" name="numero2" placeholder="Digite o segundo número">
            <select id="operacao" name="operacao" required>
                <option value="soma">Soma (+)</option>
                <option value="subtracao">Subtração (-)</option>
                <option value="multiplicacao">Multiplicação (*)</option>
                <option value="divisao">Divisão (/)</option>
                <option value="fatoracao">Fatoração (!)</option>
                <option value="potencia">Potência (^)</option>
            </select>
            <br>
            <input type="submit" value="Calcular">
        </form>
        <div class="result">
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($resultado)) {
                echo "Resultado: $resultado";
            } ?>
        </div>
        <div class="history">
            <h3>Histórico</h3>
            <textarea rows="5" cols="30" readonly><?php echo $_SESSION['historico']; ?></textarea>
            <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="submit" name="limpar_historico" value="Limpar Histórico">
            </form>
        </div>
    </div>
</body>

</html>