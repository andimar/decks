<?php 
/*
Template Name: Cards Fields Template
*/

require('Questions.php');

$title     = $posts[0]->post_title;
$questions = new Questions( $posts[0] );

$base_url  = ANDIMAR_CARDS_URI;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?=$title?></title>
   
    <link rel="stylesheet" href="<?=$base_url?>styles.css?v<?=ANDIMAR_CARDS_VERSION?>">
    <script src="<?=$base_url?>templates/js/questions-fields.js?v<?=ANDIMAR_CARDS_VERSION?>"></script>
    <script src="<?=$base_url?>templates/js/deck.js?v<?=ANDIMAR_CARDS_VERSION?>"></script>  
    <script>
        document.addEventListener('dblclick', function(event) {
            event.preventDefault(); // Previene lo zoom su doppio click
        }, { passive: false });
    </script>
</head>
<body>
    <div class="card">
    
        <div id="deckCounter">1/10</div>
        <button id="shuffleButton">
            <img src="<?=$base_url?>shuffle_icon.svg" alt="Shuffle" />
            Rimescola
        </button>
        <div class="question-container">
            <h1 class="title"></h1>
            <h2 class="subtitle"></h2>
            <div class="video">
                
            </div> 
            <div class="description"></div>
            <div class="question"></div>
        </div>
        <button id="nextButton">Continua</button>
    </div>
    
    <script>
        
            let cards = new Deck( new Questions(`<?=$questions->toJson()?>`), '.card');
    </script> 
    
</body>
</html>

