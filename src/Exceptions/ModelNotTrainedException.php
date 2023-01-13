<?php 

namespace Apurba\AnswerModel\Exceptions;

use Exception;

class ModelNotTrainedException extends Exception{


    public function __toString()
    {
        return "The model hasn't been trained";
    }
} 