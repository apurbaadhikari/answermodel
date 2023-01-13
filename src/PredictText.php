<?php 

namespace Apurba\AnswerModel;

use Apurba\AnswerModel\Exceptions\ModelNotTrainedException;
use Phpml\Classification\NaiveBayes;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;


class PredictText extends Model{

    private array $features, $label;

    private NaiveBayes $model;
    private TokenCountVectorizer $vectorizer;

    public function __construct(array $data){

        $this->label = [];
        $this->features = [];
        foreach ($data as $key => $value){
            array_push($this->features, [$key]);
            array_push($this->label, $value);
        }   

        
        
    }


    public function train(): bool{
        // Bayes Code
        if (gettype($this->features[0][0]) == 'string'){
            $data = $this->transform($this->features);
        }else {
            $data = $this->features;
        }
        $this->model = new NaiveBayes();

        $this->model->train($data, $this->label);

        return true;
    }


    public function predict(array $data){

        if (!isset($this->model)){
            throw new ModelNotTrainedException();
        }

        if (gettype($data[0]) == 'string'){
            $data = $this->transform($data);
        }

        return $this->model->predict($data);

    }

    public function transform(array $sentences){

        
        // $normalizer = new Normalizer(Normalizer::NORM_L1);
        $data = [];
        foreach($sentences as $sentence){
            if (gettype($sentence) == 'array') {
                array_push($data, strtolower($sentence[0]));
            }else {
                array_push($data, strtolower($sentence));
            }
            
        }
        if (!isset($this->vectorizer)){
            $this->vectorizer = new TokenCountVectorizer(new WordTokenizer());
            $this->vectorizer->fit($data);

        }

       $this->vectorizer->transform($data);

        return $data;
    }
}
