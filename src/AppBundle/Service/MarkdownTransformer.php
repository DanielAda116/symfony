<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12.10.2017
 * Time: 10:08
 */

namespace AppBundle\Service;


class MarkdownTransformer
{

    public function parse($str){
        return strtoupper($str);
    }
}