class Questions {

    constructor( text ) {

        this.questions = this.getQuestions( text );

        this.shuffle();
    }

    get( index ) {
        return this.questions[ index ];
    }

    getQuestions( text ) {

        return text.split( '\n' ).map( i=> i.trim() ).filter( i => i != '' );
    }

    shuffle() {

        return this.questions.sort( () => Math.random() - 0.5 ); 
    }
}

