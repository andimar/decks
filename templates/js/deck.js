class CardBody {

    constructor( container ) {

        this.title       = container.querySelector('.title');
        this.subtitle    = container.querySelector('.subtitle');
        this.description = container.querySelector('.description');
        this.question    = container.querySelector('.question');
        this.video       = container.querySelector('.video');

        this.init();
    }


    initField( fieldName ) { 

        if( this[ fieldName ] == null ) return false;

        this[ fieldName ].innerHTML = '';

        return true
    }

    initVideo() {

        if (!this.initField( 'video' )) return;
        
        this.video.style.display = 'none';
        
        let specialClasses = [ 'video-question' ];

        specialClasses.forEach( cls => this.removeClassToAll(cls) );

        this.video.innerHTML = '';
    }

    init() {

        this.initVideo();
        this.initField( 'title' );
        this.initField( 'question' );
        this.initField( 'subtitle' );
        this.initField( 'description' );
    }

    addClassToAll( cls ) {
        this.question.classList.add( cls );
        this.title.classList.add( cls );
        this.subtitle.classList.add( cls );
    }

    removeClassToAll( cls ) {
        
        this.question.classList.remove( cls );
        this.title.classList.remove( cls );
        this.subtitle.classList.remove( cls );
    }


    printFullQuestion( question ) {

        this.title.innerHTML       = question.titolo;
        this.subtitle.innerHTML    = question.sottotitolo;
        this.description.innerHTML = question.descrizione;
        this.question.innerHTML    = question.domanda;
        
        this.printVideo( question.video );
    }

    
    printVideoQuestion( question ) {

        this.title.innerHTML       = question.titolo;
        this.question.innerHTML    = question.domanda;
        this.subtitle.innerHTML    = question.sottotitolo;

        this.addClassToAll( 'video-question' );

        this.printVideo( question.video );        
    }


    printVideo( url ) {

        if( url == '' ) return;

        this.video.style.display = 'block';

        this.insertVideoElement( url );
    }

    
    insertVideoElement( url ) {

        this.video.insertAdjacentHTML('beforeend', `<video id="card_video"  preload="auto" controls><source src="${url}" type="video/mp4" ></source></video>`);
    }


}

class Deck {

    constructor( questions, cardSelector, 
                 nextButtonSelector = '#nextButton',
                 shuffleButtonSelector = '#shuffleButton',
                 deckCounterSelector = '#deckCounter' ) {

        this.container         = document.querySelector( cardSelector );
        this.nextButton        = this.container.querySelector( nextButtonSelector );
        this.shuffleButton     = this.container.querySelector( shuffleButtonSelector );        
        this.deckCounter       = this.container.querySelector( deckCounterSelector );
        this.questionElement   = this.container.querySelector( '.question' );

        this.cardBody = new CardBody( this.container.querySelector( '.question-container' ) );

        this.questions = questions;

        this.currentQuestionIndex = 0;

        this.nextButton.addEventListener('click', this.nextCard.bind(this) );
        this.shuffleButton.addEventListener('click', this.shuffle.bind(this) );

        this.printCard();
    }

    printCard() {
        
        this.deckCounter.textContent = `${this.currentQuestionIndex + 1} / ${this.questions.questions.length}`; 

        let question = this.questions.get( this.currentQuestionIndex );

        if(this.isString( question ) ) {
            
            this.questionElement.textContent = question;

        } else {
            
            this.printObjectQuestion( question ); 
        }
        
    }

    nextCard( evt ) {

        if(this.currentQuestionIndex < this.questions.questions.length - 1) {
            this.currentQuestionIndex++;
            this.printCard();
        }

    }

    shuffle() {

        this.questions.shuffle();
        this.currentQuestionIndex = 0;
        this.printCard();
    }


    isString( question ) {

        return typeof question === 'string';
    }

    printObjectQuestion( question ) {
        
        this.cardBody.init();        

        if( question.descrizione.replace(/[\t\s]*/g,'') == '<p></p>' && question.video != '') {

            this.cardBody.printVideoQuestion( question );

        } else {

            this.cardBody.printFullQuestion( question );
        }        
    }


}
