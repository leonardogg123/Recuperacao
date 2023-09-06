<?php
require_once('classes/Crud.php');
require_once('conexao/conexao.php');

$database = new Database();
$db = $database->getConnection();
$crud = new Crud($db);

if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read();
            break;

        case'read':
            $rows = $crud->read();
            break;

    //case update
            case 'update' :
                if(isset($_POST['id'])){
                    $crud->update($_POST);
                }
                $rows = $crud->read();
                break;

    //case delete
    case 'delete':
        $crud->delete($_GET['id']);
        $rows = $crud->read();
        break;

    default:
    $rows = $crud->read();
    break;

    }
}else{
    $rows = $crud->read();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Tela do Zoologico</title>
</head>
<body>
  <style>
        form{
            max-width:500px;
            margin: 0 auto;
        }
         label{
            display: flex;
            margin-top:10px
         }
         input[type=text]{
            width:100%;
            padding: 12px 20px;
            margin: 8px 0;
            display:inline-block;
            border: 1px solid #ccc;
            border-radius:4px;
            box-sizing:border-box;
         }
         input[type=submit]{
            background-color:#4caf50;
            color:white;
            padding:12px 20px;
            border:none;
            border-radius:4px;
            cursor:pointer;
            float:right;
         }
         input[type=submit]:hover{
            background-color:#45a049;
         }
         table{
            border-collapse:collapse;
            width:100%;
            font-family:Arial, sans-serif;
            font-size:14px;
            color:#333;
         }
         th, td{
            text-align:left;
            padding:8px;
            border: 1px solid #ddd;
         }
        th{
           background-color:#f2f2f2;
           font-weight:bold; 
        }
        a{
            display:inline-block;
            padding:4px 8px;
            background-color: #007bff;
            color:#fff;
            text-decoration:none;
            border-radius:4px;
        }
        a:hover{
            background-color:#0069d9;
        }

        a.delete{
            background-color: #dc3545;
        }
        a.delete:hover{
            background-color:#c82333;
        }
    </style>
</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>

    <?php
        
    if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){
                $id = $_GET['id'];
                $result =$crud->readOne($id);

        if(!$result){
            echo "Registro não encontrado.";
            exit();
        }

        $especie = $result['especie'];
        $comportamento = $result['comportamento'];
        $locomocao = $result['locomocao'];
        $sexo = $result['sexo'];
        $ducha = $result['ducha'];
    
        
    ?>

       <form action="?action=update" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <label for="especie"> Especie </label>
            <input type="text" name="especie" value="<?php echo $especie ?>">

            <label for="comportamento"> Cadeia </label>
            <input type="text" name="comportamento" value="<?php echo $comportamento ?>">

            <label for="locomocao"> Locomoção </label>
            <input type="text" name="locomocao" value="<?php echo $locomocao ?>">

            <label for="sexo"> Sexo </label>
            <input type="text" name="sexo" value="<?php echo $sexo ?>">

            <label for="ducha"> Ducha  </label>
            <input type="text" name="ducha" value="<?php echo $ducha ?>">

            <input type="submit" value="Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">

        
        </form>

            <?php
        }else{
        
        
            
            ?>




    <form action="?action=create" method="POST"><!--Ele define que, quando o formulário for enviado, ele enviará os dados para a mesma página com o parâmetro action definido como 'create-->

        <label for="">Especie</label>
         <input type="text" name="especie"><!--deixa tu escrever-->

        <label for="">Comportamento</label>
        <input type="text" name="comportamento">

        <label for="">Locomoção</label>
         <input type="text" name="locomocao">

        <label for="">Sexo</label>
         <input type="text" name="sexo">

        <label for="">Ducha</label>
         <input type="text" name="ducha">

          <input type="submit" value="cadastrar" name="enviar">
          
    </form>
    <?php
        }
    
    ?>


    <table>
          <tr>
            <td>id</td>
            <td>especie</td>
            <td>comportamento</td>
            <td>locomocao</td>
            <td>sexo</td>
            <td>ducha</td>
            <td>ações</td>
        </tr>
    <?php
    if($rows->rowCount() == 0){
        echo "<tr>";
        echo "<td colspan='7'>Nenhum dado encontrado</td>";
        echo "</tr>";
    }else{
        while($row = $rows->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['especie'] . "</td>";
            echo "<td>" . $row['comportamento'] . "</td>";
            echo "<td>" . $row['locomocao'] . "</td>";
            echo "<td>" . $row['sexo'] . "</td>";
            echo "<td>" . $row['ducha'] . "</td>";
            echo "<td>";
            echo "<a href='?action=update&id=" . $row['id'] . "'>Update</a>";
            echo "<a href='?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que quer apagar esse registro?\")' class='delete'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
    }
?>

    
    </table>

</body>
</html>