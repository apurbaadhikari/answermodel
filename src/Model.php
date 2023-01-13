<?php 

namespace Apurba\AnswerModel;

abstract class Model {

    /**
     * Trains the model
     * @return boolean
     */
    abstract public function train(): bool;

    /**
     * Predicts the data
     * @return array
     * @param array
     */
    abstract public function predict(array $data);

    public function save($filename){
        $data = serialize($this);

        $file = fopen($filename, 'wb');
        fwrite($file, $data);

        fclose($file);

        return true;
    }

    public static function load($filename){
        $file = fopen($filename, 'rb');

        $data = unserialize(fread($file, filesize($filename)));
        return $data;


    }

    
}