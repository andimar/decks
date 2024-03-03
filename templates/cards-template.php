<?php 
/*
Template Name: Cards Template
*/

$title     = $posts[0]->post_title;
$questions = strip_tags( $posts[0]->post_content );
$base_url  = ANDIMAR_CARDS_URI;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <title><?=$title?></title>
   
    <link rel="stylesheet" href="<?=$base_url?>styles.css?v<?=ANDIMAR_CARDS_VERSION?>">
    <script src="<?=$base_url?>templates/js/questions.js?v<?=ANDIMAR_CARDS_VERSION?>"></script>
    <script src="<?=$base_url?>templates/js/deck.js?v<?=ANDIMAR_CARDS_VERSION?>"></script>  
  
</head>
<body>
    <div class="card">
        
        <div id="deckCounter">1/10</div>
        <button id="shuffleButton">
            <img src="<?=$base_url?>shuffle_icon.svg" alt="Shuffle" />
            Rimescola
        </button>
        <div class="question-container">
            <p class="question string"></p>
        </div>
        <button id="nextButton">Continua</button>
    </div>
    <script>
        let cards = new Deck( new Questions(`<?=$questions?>`), '.card');
    </script> 
</body>
</html>