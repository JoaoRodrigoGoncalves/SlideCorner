<?php
function adsUpdate($user){
  require('mysqli_connect.php');
  $search_logs = "SELECT * FROM user_tracking WHERE user='$user' AND post_id IS NOT NULL";
  $logs = @mysqli_query($dbcon, $search_logs);
  if ($logs) {
    if (mysqli_num_rows($logs) != 0) {
      $subjects_list = array();
      while ($logs_info = mysqli_fetch_array($logs, MYSQLI_ASSOC)) {
        $post_id = $logs_info['post_id'];
        $get_post = "SELECT cat FROM posts WHERE id=$post_id";
        $post = @mysqli_query($dbcon, $get_post);
        if ($post) {
          while ($post_info = mysqli_fetch_array($post, MYSQLI_ASSOC)) {
            $post_cat = $post_info['cat'];
            $get_name = "SELECT name FROM subject_list WHERE cat=$post_cat";
            $name = @mysqli_query($dbcon, $get_name);
            if($name){
              if(mysqli_num_rows($name) != 0){
                while($useName = mysqli_fetch_array($name, MYSQLI_ASSOC)){
                  $keyName = $useName['name'];
                  $subjects_list[] = $keyName; //cria uma nova aparição na array
                }
              }
            }else{
              return "Erro ao converter a categora em nome!";
              exit();
            }
          }
        }else{
          return "Erro ao receber informações sobre a publicação!";
          exit();
        }
      }
      $tmp = array_count_values($subjects_list); //conta as aparições na array
      while($post_info = mysqli_fetch_array($post, MYSQLI_ASSOC)){ //a mesma query que foi usada para converter a categoria em nome
        foreach ($post_info as $nome) {
          $vezes['' . $nome . ''] = $tmp['' . $nome . '']; //define uma array $vezes com o nome da disciplina em [] e associa-lhe o valor contado pelo codigo da linha 35
        }
      }
      $maiorDisciplina = max($vezes); //define o maior valor encontrado
      //Procura pela disciplina que contem o numero de 'acessos' encontrado na linha 41
      while ($subject = current($vezes)) {
        if ($subject == $maior) {
          $catDisciplina = key($vezes); //Nome da key na array
        }
        next($vezes);
      }
      //
      $updateAds = "UPDATE user_ads SET age=null, subject='$catDisciplina' WHERE user='$user'";
      $run_updateAds = @mysqli_query($dbcon, $updateAds);
      if($run_updateAds){
        // SUCESSO
      }else{
        return "Erro ao atualizar informações de publicidade!";
      }
    }else{
      $get_user = "SELECT * FROM user_ads WHERE user=$user";
      $run_user = @mysqli_query($dbcon, $get_user);
      if($run_user){
        if(mysqli_num_rows($run_user) != 0){
          $query = "INSERT INTO user_ads (user, age, subject) VALUES ('$user', null, null)";
        }else {
          $query = "UPDATE user_ads SET age=null, subject=null WHERE user='$user'";
        }
        $update_query = @mysqli_query($dbcon, $query);
      }else{
        return "Erro ao receber informações sobre o registo do utilizador!";
      }
    }
  }else {
    return "Erro ao receber informações de publicidade!";
  }
}
?>
