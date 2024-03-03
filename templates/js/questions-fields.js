class Questions {

    constructor( json ) {

        this.questions = JSON.parse( json );

        this.shuffle();
    }

    get( index ) {
        return this.questions[ index ];
    }

    shuffle() {

        return this.questions.sort( () => Math.random() - 0.5 ); 
    }
}

