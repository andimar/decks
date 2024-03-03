<?php 


class Questions {

    private $post;
    private $questions;

    function __construct( $post ) {

        $this->post = $post;    
        $this->questions = $this->extractQuestions();
        
    }
    

    function extractQuestions() {
        
        return $this->shortcodes( $this->escape( $this->getFieldsFromContent() ) );
    }


    /**
     * extract raw data from text
     * 
     * @return array
     */
    function getFieldsFromContent() {

        $rows = array_filter( explode("\r", $this->post->post_content), fn ( $row ) => trim($row) != '' ); 

        $rows = array_map( function( $row ) { 

            $pattern = '@<a href=\"(.*?)\".*?>.*?<\/a>(.*)$@';
            $video = '';
            
            if( preg_match( $pattern, $row, $matches ) ) {

                [ $all, $video, $row ] = $matches;
            }

            return [
                'video'       => $video,
                'titolo'      => trim( explode( '-', $row )[0] ),
                'sottotitolo' => trim( explode( '-', $row )[1] ),
                'descrizione' => trim( explode( '-', $row )[2] ),
                'domanda'     => count( explode( '-', $row ) ) > 3 ? trim( explode( '-', $row )[3] ) : '',
            ];

        }, $rows);
        
        return array_values($rows);
    }

    /**
     *
     * @return array
     */
    function getFieldsFromCustomFields() {

        $rows = get_field('custom_cards', $this->post->ID);

        return $rows;
    }


    function get() {
        return $this->questions;
    }
    
    function toJson() {

        
        return str_replace('\n','', json_encode( 
                (array) $this->questions,
                JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS |
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE 
        ));
    }


    protected function escape( $questions ) {

        return array_map( fn($question) => [

            'video'       => trim( str_replace( '"', '\"', $question['video']) ),
            'titolo'      => trim( str_replace( '"', '\"', $question['titolo']) ),
            'sottotitolo' => trim( str_replace( '"', '\"', $question['sottotitolo']) ),
            'descrizione' => '<p>' . trim( str_replace( '"', '\"', $question['descrizione']) ) . '</p>',
            'domanda'     => '<p>' .trim( str_replace( '"', '\"', $question['domanda']) ) . '</p>',

        ], $questions );

    }


    protected function shortcodes( $questions ) {

        return array_reduce( array_keys( $questions ), function( $result, $key ) use ($questions) {

            $result[ $key ] = $this->replaceShortcodes( $questions[ $key ] );

            return $result;
        
        },[]);
    }

    protected function replaceShortcodes( $text ) {

        return str_replace([ '[br]' ],[ '<br>' ], $text );

    }
}